<?php
// includes/agency_stats_queries.php
// Handles all stat queries for the agency analytics page

function getAgencyStats($conn, $agency_id)
{
    // --- Total packages ---
    $stmt = $conn->prepare('SELECT COUNT(*) as total FROM packages WHERE Agency_ID = ?');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $totalPackages = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();

    // --- Total bookings across all agency packages ---
    $stmt = $conn->prepare('
        SELECT COUNT(*) as total 
        FROM bookings b
        JOIN packages p ON b.Package_ID = p.Package_ID
        WHERE p.Agency_ID = ?
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $totalBookings = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();

    // --- Total revenue (price * bookings per package) ---
    $stmt = $conn->prepare('
        SELECT COALESCE(SUM(p.Price), 0) as revenue
        FROM bookings b
        JOIN packages p ON b.Package_ID = p.Package_ID
        WHERE p.Agency_ID = ?
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $totalRevenue = $stmt->get_result()->fetch_assoc()['revenue'];
    $stmt->close();

    // --- Average rating ---
    $stmt = $conn->prepare('
        SELECT COALESCE(ROUND(AVG(r.Rating), 1), 0) as avg_rating,
               COUNT(r.Review_ID) as total_reviews
        FROM reviews r
        JOIN bookings b ON r.Booking_ID = b.Booking_ID
        JOIN packages p ON b.Package_ID = p.Package_ID
        WHERE p.Agency_ID = ?
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $ratingRow = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // --- Most popular package ---
    $stmt = $conn->prepare('
        SELECT p.Name, COUNT(b.Booking_ID) as booking_count
        FROM packages p
        LEFT JOIN bookings b ON p.Package_ID = b.Package_ID
        WHERE p.Agency_ID = ?
        GROUP BY p.Package_ID
        ORDER BY booking_count DESC
        LIMIT 1
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $topPackage = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // --- Upcoming departures ---
    $stmt = $conn->prepare('
        SELECT COUNT(*) as upcoming
        FROM packages
        WHERE Agency_ID = ? AND Departure_Date >= CURDATE()
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $upcoming = $stmt->get_result()->fetch_assoc()['upcoming'];
    $stmt->close();

    // --- Average package price ---
    $stmt = $conn->prepare('
        SELECT COALESCE(ROUND(AVG(Price), 2), 0) as avg_price
        FROM packages WHERE Agency_ID = ?
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $avgPrice = $stmt->get_result()->fetch_assoc()['avg_price'];
    $stmt->close();

    return [
        'total_packages'  => (int)$totalPackages,
        'total_bookings'  => (int)$totalBookings,
        'total_revenue'   => (float)$totalRevenue,
        'avg_rating'      => (float)$ratingRow['avg_rating'],
        'total_reviews'   => (int)$ratingRow['total_reviews'],
        'top_package'     => $topPackage['Name'] ?? 'N/A',
        'upcoming'        => (int)$upcoming,
        'avg_price'       => (float)$avgPrice,
    ];
}

function getBookingsPerPackage($conn, $agency_id)
{
    $stmt = $conn->prepare('
        SELECT p.Name, COUNT(b.Booking_ID) as bookings
        FROM packages p
        LEFT JOIN bookings b ON p.Package_ID = b.Package_ID
        WHERE p.Agency_ID = ?
        GROUP BY p.Package_ID
        ORDER BY bookings DESC
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    return $rows;
}

function getRatingsBreakdown($conn, $agency_id)
{
    // Returns count of each star rating (1–5) across all agency packages
    $stmt = $conn->prepare('
        SELECT r.Rating, COUNT(*) as count
        FROM reviews r
        JOIN bookings b ON r.Booking_ID = b.Booking_ID
        JOIN packages p ON b.Package_ID = p.Package_ID
        WHERE p.Agency_ID = ?
        GROUP BY r.Rating
        ORDER BY r.Rating ASC
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fill in zeros for missing star ratings
    $breakdown = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    while ($row = $result->fetch_assoc()) {
        $breakdown[(int)$row['Rating']] = (int)$row['count'];
    }
    $stmt->close();
    return $breakdown;
}

function getSoloVsGroup($conn, $agency_id)
{
    $stmt = $conn->prepare('
        SELECT 
            SUM(CASE WHEN sb.Booking_ID IS NOT NULL THEN 1 ELSE 0 END) as solo,
            SUM(CASE WHEN gb.Booking_ID IS NOT NULL THEN 1 ELSE 0 END) as grp
        FROM bookings b
        JOIN packages p ON b.Package_ID = p.Package_ID
        LEFT JOIN solo_bookings sb ON b.Booking_ID = sb.Booking_ID
        LEFT JOIN group_bookings gb ON b.Booking_ID = gb.Booking_ID
        WHERE p.Agency_ID = ?
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return [
        'solo'  => (int)($row['solo'] ?? 0),
        'group' => (int)($row['grp']  ?? 0),
    ];
}

function getRecentReviews($conn, $agency_id, $limit = 5)
{
    $stmt = $conn->prepare('
        SELECT r.Rating, r.Comment, r.Date, u.Name as reviewer, p.Name as package_name
        FROM reviews r
        JOIN bookings b ON r.Booking_ID = b.Booking_ID
        JOIN packages p ON b.Package_ID = p.Package_ID
        JOIN users u ON r.User_ID = u.User_ID
        WHERE p.Agency_ID = ?
        ORDER BY r.Date DESC
        LIMIT ?
    ');
    $stmt->bind_param('ii', $agency_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    return $rows;
}

// ---- Handle AJAX calls ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $body = json_decode(file_get_contents('php://input'), true);
    require_once __DIR__ . '/database.php';

    $agency_id = $body['agency_id'] ?? null;
    if (!$agency_id) {
        echo json_encode(['error' => 'No agency_id provided']);
        exit;
    }

    switch ($body['type']) {
        case 'getStats':
            echo json_encode(getAgencyStats($conn, $agency_id));
            break;
        case 'getBookingsPerPackage':
            echo json_encode(getBookingsPerPackage($conn, $agency_id));
            break;
        case 'getRatingsBreakdown':
            echo json_encode(getRatingsBreakdown($conn, $agency_id));
            break;
        case 'getSoloVsGroup':
            echo json_encode(getSoloVsGroup($conn, $agency_id));
            break;
        case 'getRecentReviews':
            echo json_encode(getRecentReviews($conn, $agency_id));
            break;
    }
    exit;
}
