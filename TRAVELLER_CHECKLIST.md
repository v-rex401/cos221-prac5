# Traveller Section — Implementation Checklist

This is a working guide for building out the traveller side of Tripistry (Task 5 in the brief). It assumes the auth flow, DB connection, and base styles (`css/style.css`) are already in place.

## What the brief requires (traveller scope)

A logged-in traveller must be able to:

1. **Browse** destinations, flights, accommodations, tourist attractions and restaurants.
2. **Compare** travel packages across different agencies.
3. **Book** a selected package (solo or group).
4. **Leave reviews and ratings** for agencies and their packages.
5. **Sort and filter** packages by price, destination, duration, rating, etc.
6. View a **detailed package page** showing pricing, itinerary, images, agency info, and reviews.

## Files you already have (mostly empty stubs)

```
pages/traveller/
    traveller_dashboard.php    landing page after login
    search_packages.php        browse + filter + compare
    package_detail.php         single package view
    booking.php                book the selected package
    reviews.php                write / view reviews
api/
    search.php                 server-side endpoint used by JS for filtering
    external_api.php           Vashti's external API integration
```

Each page is gated by `redirectIfNotTraveller()` which now uses the new `redirectTo()` helper in `includes/session.php`. Don't remove the `require_once __DIR__ . '/../../includes/...'` lines at the top.

## Implementation order (do them in this sequence)

The pages depend on each other, so build them in this order, otherwise you'll be stubbing data into a vacuum.

### 1. `traveller_dashboard.php` — the landing page

**Purpose:** First page travellers see after login. Should give them a clear path into searching, plus a glance at their existing bookings and any new packages.

**Sections to build:**

- A welcome card showing the logged-in name (already available via `getCurrentUserID()`; pull the name from `users` table).
- A primary CTA button "Find a package" linking to `search_packages.php`.
- A "My recent bookings" list (top 3) — query `bookings` joined with `packages` for this user, ORDER BY `Booking_Date DESC LIMIT 3`. Each item links to the package detail page.
- Optional: a "Featured packages" strip — random 4 from `packages` JOIN `users` (the agency).

**Markup to use:**

Use the `.wrap` container, then `.page-head` for the heading + name, then `.card` blocks for the booking list items. Buttons use `.button-primary`. Avoid inventing new CSS classes here — the styling tokens in `style.css` cover everything.

### 2. `search_packages.php` — browse, filter, compare

**Purpose:** The workhorse page. Must support filtering (price, destination, duration, rating) and sorting, plus an explicit "compare up to N packages" mode.

**Markup plan:**

- `.wrap` container.
- `.page-head` with title "Browse packages".
- A `.filters` panel — CSS grid, 4–5 columns: search box, destination dropdown, max-price input, min-duration / max-duration, sort dropdown.
- A `.grid` of `.card`s, 3 columns desktop, 2 tablet, 1 mobile. Each card shows: image (from `package_images`), package name, agency name, price, average rating (stars), short description, and a "View" link plus a "Compare" checkbox.
- A floating "Compare (N)" button that becomes active when 2–4 cards are selected. Click → opens a side-by-side comparison view or routes to a comparison page (`compare_packages.php?ids=1,2,3`).

**CSS to add to `style.css`** (these aren't there yet — add them once, reuse everywhere):

```css
.filters { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 1%;
    background: var(--surface-card); border: 2px solid var(--border-accent);
    border-radius: var(--radius-lg); padding: 1.5%; margin-bottom: 2vh; }
.search, .control { width: 100%; padding: 10px 12px; border-radius: var(--radius-sm);
    border: 3px solid var(--border-accent-soft); background: var(--surface-input);
    color: #fff; box-sizing: border-box; outline: none; }
.grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2%; }
@media (max-width: 900px) { .grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .grid { grid-template-columns: 1fr; } }
.card img { width: 100%; height: 160px; object-fit: cover; border-radius: var(--radius-md); }
```

**Data flow:**

- Render the page server-side with sensible defaults (no filter applied).
- For interactive filtering, hit `api/search.php` via `fetch()` from `js/main.js` — POST the current filter state as JSON, get back JSON of packages. Re-render the `.grid` from the response.
- Keep one `renderCards(packages)` JS function — both the initial render and AJAX updates call it.

**SQL sketch for filtering:**

```sql
SELECT
    p.Package_ID, p.Name, p.Price, p.Duration_Days, p.Description,
    a.Name AS Agency_Name,
    COALESCE(AVG(r.Rating), 0) AS Avg_Rating,
    (SELECT pi.Image_URL FROM package_images pi WHERE pi.Package_ID = p.Package_ID LIMIT 1) AS Image
FROM packages p
JOIN users a              ON a.User_ID = p.Agency_ID
LEFT JOIN bookings b      ON b.Package_ID = p.Package_ID
LEFT JOIN reviews r       ON r.Booking_ID = b.Booking_ID
WHERE  (:destinationId IS NULL OR EXISTS (
        SELECT 1 FROM package_destinations pd
        WHERE pd.Package_ID = p.Package_ID AND pd.Destination_ID = :destinationId))
  AND  (:maxPrice IS NULL OR p.Price <= :maxPrice)
  AND  (:minDuration IS NULL OR p.Duration_Days >= :minDuration)
GROUP BY p.Package_ID
HAVING (:minRating IS NULL OR Avg_Rating >= :minRating)
ORDER BY {dynamic sort column};
```

Use prepared statements with `bind_param` like in `auth.php`. Validate the sort column against a whitelist before injecting it (never concatenate user input into ORDER BY).

### 3. `package_detail.php` — single package deep view

**Purpose:** Everything about one package. The URL is `package_detail.php?id=N`.

**Sections:**

- Hero image (first `package_images.Image_URL`).
- Title, agency name, price, duration, average rating.
- **Itinerary**: list destinations (`package_destinations` JOIN `destinations`), flights (`package_flights` JOIN `flights`), accommodations, attractions, restaurants. Render each as its own `.card`.
- **Agency info**: name, contact (from `users`).
- **Reviews**: list of approved reviews for this package, each showing reviewer name, rating, comment, date. Pull `reviews` JOIN `bookings` ON `booking.Package_ID = :id` JOIN `users`.
- A "Book this package" button → `booking.php?id=N`.
- A "Write a review" button (only visible if this user has a completed booking for this package).

**Gotcha:** sanitise the `id` parameter — `(int) $_GET['id']` is enough since the column is INT.

### 4. `booking.php` — book a package

**Purpose:** Take a selected package and turn it into a `bookings` row plus the right child row (`solo_bookings` or `group_bookings`). Also handle adding extra travellers via `booking_travelers` for the group case.

**Form fields:**

- Start date, end date (both required; CHECK constraint `End_Date > Start_Date` enforces this — pre-validate in JS too).
- Booking type radio: Solo / Group.
- Group case: number of additional travellers, then dynamic inputs for each (name, email). Use JS to render the right number of fields when the count changes.

**Insert flow (transactional):**

```php
$conn->begin_transaction();
try {
    // 1. INSERT INTO bookings (Package_ID, User_ID, Booking_Date, Start_Date, End_Date) ...
    $bookingId = $conn->insert_id;
    if ($type === 'Solo') {
        // INSERT INTO solo_bookings (Booking_ID) VALUES (?)
    } else {
        // INSERT INTO group_bookings (Booking_ID, Agency_ID) ...
        foreach ($travellers as $t) {
            // INSERT INTO booking_travelers (Booking_ID, User_ID) — but travellers may not exist as users
            // Decide: store guest travellers in a separate column on booking_travelers, or require existing users
        }
    }
    $conn->commit();
} catch (Throwable $e) {
    $conn->rollback();
    // surface error to UI
}
```

**Gotcha:** `booking_travelers` references `users(User_ID)` with `ON DELETE CASCADE`. If your additional travellers aren't existing users, you can't insert them there. Easiest fix: store the guest name+email on the `bookings` row (add a `Guest_Travellers TEXT` column) OR create a stub user row for each guest. Check the schema and pick the simpler option.

### 5. `reviews.php` — write / view reviews

**Purpose:** Two modes: (a) write a review for a specific booking, (b) browse the reviews this traveller has written.

**Write mode** (`reviews.php?booking_id=N`):
- Rating selector (1–5, use styled radios or a star widget).
- Comment textarea (validate length: 10–500 chars in JS).
- Submit → `INSERT INTO reviews (Booking_ID, User_ID, Rating, Comment, Review_Date) VALUES (?, ?, ?, ?, NOW())`.

**Browse mode** (`reviews.php`, no params):
- Query the traveller's own reviews, render as `.card`s with edit/delete buttons.

**Gotcha:** a traveller should only be able to review a booking they own and that has ended. Enforce both in SQL (`WHERE b.User_ID = ? AND b.End_Date < CURDATE()`) and in the PHP guard.

## API endpoint: `api/search.php`

This is the JSON endpoint the search page calls. Keep it focused — one input, one output.

```php
<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/database.php';

if (!isLoggedIn() || getCurrentUserType() !== 'Traveller') {
    http_response_code(401);
    echo json_encode(['error' => 'Not authorised']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? [];
// extract & sanitise: $destination, $maxPrice, $minDuration, $maxDuration, $minRating, $sort

// run prepared SELECT
// echo json_encode(['packages' => $rows]);
```

Always set `Content-Type: application/json` *before* any output. Always validate `$sort` against a whitelist:

```php
$allowedSorts = ['price_asc' => 'p.Price ASC', 'price_desc' => 'p.Price DESC',
                 'rating'    => 'Avg_Rating DESC', 'duration' => 'p.Duration_Days ASC'];
$sortSql = $allowedSorts[$sort] ?? 'p.Price ASC';
```

## CSS reminders

- All colours, radii, fonts are CSS variables in `style.css`. Use them — never hard-code hex codes in new files.
- Reusable components in `style.css`: `.wrap`, `.page-head`, `.card`, `.button-primary`, `.back-button`, `.status-message`, `.error-message`, `.success-message`, `.page-loader`.
- For the search filters and card grid you'll need to add the snippets above to `style.css` once.
- Create a `traveller.css` only if you need traveller-specific overrides — most of the time the shared styles are enough.

## JS organisation

`js/main.js` is currently used. Suggested structure:

- One IIFE or module per page (so they don't collide). Wrap each in `if (document.body.dataset.page === 'search') { ... }`, set `<body data-page="search">` in the page.
- Helper `fetchJSON(url, payload)` wrapping `fetch` with the right headers and error handling — reuse on every page.
- Re-render the grid by replacing `.grid.innerHTML` with templated strings. For maintainability, write a single `renderCard(pkg)` function returning a string.

## Common gotchas (worth pinning)

- **Spelling**: column is now `Type = 'Traveller'` (two Ls). Always use two Ls in PHP. The seed rows are migrated by `sql/fix_traveler_spelling.sql`.
- **Foreign keys**: every package-* join table has `ON DELETE CASCADE`. Deleting a package wipes its accommodations, flights, etc. Don't expose a delete-package button on the traveller side.
- **CHECK constraints** to remember when validating forms:
  - `CHK_Email_Format` — must contain `_@_._%` pattern
  - `CHK_Cell_Length` — `octet_length(Cell) >= 10`
  - `CHK_End_After_Start` on bookings — `End_Date > Start_Date`
  - `CHK_Booking_Before_Start` on bookings — `Booking_Date <= Start_Date`
- **Prepared statements only**. Never concatenate `$_GET` / `$_POST` into SQL. The pattern is in `auth.php`.
- **Sanitise output**. Wrap every echoed user-supplied string in `sanitise()` (defined in `validation.php`) or `htmlspecialchars()`.
- **Path issues**: includes from a page inside `pages/traveller/` need `__DIR__ . '/../../includes/...'`. From `pages/` it's `__DIR__ . '/../includes/...'`. From `handlers/` it's `__DIR__ . '/../includes/...'`. From `api/` it's `__DIR__ . '/../includes/...'`.

## Coordination with Vashti

She owns `api/external_api.php` (the third-party integration the brief requires). The traveller pages don't call it directly — but if her API returns supplementary destination info or flight pricing, decide together where it gets stitched in. Most likely:

- The package detail page shows live flight prices from her API alongside the agency's stored price.
- The search filters might let travellers narrow by a real-world weather / safety advisory pulled from her API.

Agree on the JSON shape she returns and freeze it before either of you wires the UI.

## Definition of "done" for the traveller side

Before declaring traveller work finished, walk through this:

- Log in as a traveller. Land on dashboard. See your bookings.
- Click "Find a package". See the search page with all packages.
- Apply each filter (destination, price, duration, rating). Verify the result count changes.
- Apply each sort. Verify the order changes.
- Select 2–3 packages for comparison. View the comparison.
- Open a package detail. See itinerary, images, agency info, reviews.
- Click "Book this package". Fill the form. Submit. See the new row in `bookings` (check phpMyAdmin).
- After the booking's end date passes (simulate with a SQL update), open "Write a review". Submit a 4-star review. Verify it appears on the package detail.
- Log out. Log back in as an agency. Verify the agency sees the new booking on their side (that's Vashti / agency-side work, but a good sanity check).

If all of those pass without console errors and without SQL errors in the PHP error log, you're done.
