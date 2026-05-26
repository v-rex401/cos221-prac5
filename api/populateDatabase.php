<?php
require_once __DIR__ . '/../includes/database.php';

/* require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load(); */

$pexelsKey   = $_ENV['PEXELS_KEY'];
$geoapifyKey = $_ENV['GEOAPIFY_KEY'];


die();
populateImages($conn);
populateRestaurants($conn);
populateDestinations($conn);
populateAccomodation($conn);
populateAttractions($conn);
populateFlights($conn);




function convertToMySQLDateTime($isoTime)
{
    $datetime = new DateTime($isoTime);
    return $datetime->format('Y-m-d H:i:s');
}

function getDestinationsFromDB($conn)
{
    $result = $conn->query('SELECT Destination_ID, Name FROM destinations LIMIT 20');
    $destinations = [];
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
    return $destinations;
}
function populateRestaurants($conn) //TODO: cHECK THIS CODE IS CORRECT 
{
    $apiKey = $_ENV['GEOAPIFY_KEY'];
    $destinations = getDestinationsFromDB($conn);
    $stmt = $conn->prepare('INSERT INTO restaurants (Name, Cuisine, Image) VALUES (?, ?, ?)');

    $existing = [];
    $result = $conn->query('SELECT Name FROM restaurants');
    while ($row = $result->fetch_assoc()) {
        $existing[$row['Name']] = true;
    }

    foreach ($destinations as $dest) {
        $coords = getCoordinates($dest['Name'], $apiKey);
        if (!$coords) {
            echo "Could not find coordinates for {$dest['Name']}, skipping.<br>";
            continue;
        }

        $url = "https://api.geoapify.com/v2/places?"
            . "categories=catering.restaurant"
            . "&filter=circle:{$coords['lon']},{$coords['lat']},10000"
            . "&limit=10"
            . "&lang=en"
            . "&apiKey=" . $apiKey;

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $places = $data['features'] ?? [];

        foreach ($places as $place) {
            $name       = $place['properties']['name']       ?? null;  // name was pointing to categories
            $categories = $place['properties']['categories'] ?? [];    // categories was never being set

            if (empty($name) || !is_string($name)) continue;
            if (isset($existing[$name])) continue;

            $cuisine = 'Various';
            if (!empty($categories)) {
                $cat = end($categories);
                if (is_string($cat)) {
                    $parts = explode('.', $cat);
                    $label = end($parts);
                    if (!in_array($label, ['restaurant', 'catering', 'food'])) {
                        $cuisine = ucfirst(str_replace('_', ' ', $label));
                    }
                }
            }

            $image = '';
            $stmt->bind_param('sss', $name, $cuisine, $image);
            $stmt->execute();
            $existing[$name] = true;
        }

        echo "Restaurants done for {$dest['Name']}<br>";
        flush();
    }

    $stmt->close();
    echo "All restaurants populated!<br>";
}

function populateAttractions($conn)
{
    $apiKey = $_ENV['GEOAPIFY_KEY'];
    $destinations = getDestinationsFromDB($conn);
    $stmt = $conn->prepare('INSERT IGNORE INTO tourist_attractions (Name, Image) VALUES (?, ?)');

    foreach ($destinations as $dest) {
        $coords = getCoordinates($dest['Name'], $apiKey);
        if (!$coords) {
            echo "Could not find coordinates for {$dest['Name']}, skipping.<br>";
            continue;
        }

        $url = "https://api.geoapify.com/v2/places?"
            . "categories=tourism.attraction"
            . "&filter=circle:{$coords['lon']},{$coords['lat']},10000"
            . "&limit=10"
            . "&lang=en"
            . "&apiKey=" . $apiKey;

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $places = $data['features'] ?? [];

        foreach ($places as $place) {
            $name = $place['properties']['name'] ?? null;
            $image = '';
            if (empty($name)) continue;

            $stmt->bind_param('ss', $name, $image);
            $stmt->execute();
        }

        echo "Attractions done for {$dest['Name']}<br>";
        flush();
    }

    $stmt->close();
    echo "All attractions populated!<br>";
}

function getCoordinates($destinationName, $apiKey)
{
    $url = "https://api.geoapify.com/v1/geocode/search?"
        . "text=" . urlencode($destinationName)
        . "&limit=1"
        . "&apiKey=" . $apiKey;

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $feature = $data['features'][0] ?? null;
    if (!$feature) return null;

    return [
        'lat' => $feature['properties']['lat'],
        'lon' => $feature['properties']['lon'],
    ];
}










function populateDestinations($conn)
{
    $url = "https://restcountries.com/v3.1/all?fields=name,capital,region";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $stmt = $conn->prepare('INSERT IGNORE INTO destinations (Name, Country) VALUES (?, ?)');

    for ($i = 0; $i < count($data); $i++) {
        $name    = $data[$i]['capital'][0] ?? "Not Available";
        $country = $data[$i]['name']['common'] ?? "Not Available";

        $stmt->bind_param('ss', $name, $country);
        $stmt->execute();

        echo "$name, $country <br>";
    }

    $stmt->close();
    echo "Done!";
}

function populateFlights($conn)
{
    $check = $conn->query("SELECT COUNT(*) as total FROM flights");
    $row = $check->fetch_assoc();
    if ($row['total'] > 0) {
        echo "Flights already populated ({$row['total']} records). Skipping.<br>";
        return;
    }

    $apikey = $_ENV['AVIATIONSTACK_KEY'];
    $url = "http://api.aviationstack.com/v1/flights?access_key=$apikey&limit=100";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    $stmt = $conn->prepare('INSERT IGNORE INTO flights 
        (Airline, Departure_Loc, Arrival_Loc, Time_Dept, Time_Arrive, Price) 
        VALUES (?,?,?,?,?,?)');

    $inserted = 0;
    $skipped = 0;

    foreach ($data['data'] as $flight) {
        if (empty($flight['departure']['scheduled']) || empty($flight['arrival']['scheduled'])) {
            $skipped++;
            continue;
        }
        if (empty($flight['airline']['name']) || $flight['airline']['name'] === 'empty') {
            $skipped++;
            continue;
        }
        if (empty($flight['flight']['iata'])) {
            $skipped++;
            continue;
        }

        $airline      = $flight['airline']['name'];
        $departureLoc = $flight['departure']['airport'];
        $arrivalLoc   = $flight['arrival']['airport'];
        $deptTime     = convertToMySQLDateTime($flight['departure']['scheduled']);
        $arrTime      = convertToMySQLDateTime($flight['arrival']['scheduled']);
        $price        = 1000;

        if ($arrTime <= $deptTime) {
            $skipped++;
            continue;
        }

        $stmt->bind_param(
            'sssssi',
            $airline,
            $departureLoc,
            $arrivalLoc,
            $deptTime,
            $arrTime,
            $price
        );
        $stmt->execute();
        $inserted++;
    }

    $stmt->close();
    echo "Flights done! Inserted: $inserted | Skipped: $skipped <br>";
}

function populateAccomodation($conn)
{
    $existing = [];
    $result = $conn->query('SELECT Name FROM accommodations');
    while ($row = $result->fetch_assoc()) {
        $existing[$row['Name']] = true;
    }


    $stmt = $conn->prepare('INSERT IGNORE INTO accommodations (Name, Type, Price_PN, Image) VALUES (?,?,?,?)');

    $pageNumber = 1;
    $pageSize = 100; // max per page

    do {
        $url = "https://tourism.api.opendatahub.com/v1/Accommodation?pagenumber={$pageNumber}&pagesize={$pageSize}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $totalPages = $data['TotalPages'] ?? 1;

        foreach ($data['Items'] as $item) {
            $name  = $item['AccoDetail']['en']['Name'] ?? null;
            $type  = $item['AccoType']['Id']           ?? 'Unknown';
            $price = rand(500, 5000);
            $image = $item['ImageGallery'][0]['ImageUrl'] ?? '';

            if (empty($name)) {
                continue;
            }
            if (isset($existing[$name])) {
                continue;
            }

            $stmt->bind_param('ssds', $name, $type, $price, $image);
            $stmt->execute();
            $existing[$name] = true;
        }

        echo "Page {$pageNumber}/{$totalPages} done<br>";
        flush(); // shows progress in browser as it runs
        $pageNumber++;
    } while ($pageNumber <= $totalPages);

    $stmt->close();
    echo "Accommodations done!";
}

// ======================================= IMAGES ============================================================================
function getPexelsImage($query, $apiKey)
{
    $url = "https://api.pexels.com/v1/search?"
        . "query=" . urlencode($query)
        . "&per_page=1";

    $context  = stream_context_create(['http' => ['header' => "Authorization: " . $apiKey]]);
    $response = @file_get_contents($url, false, $context);

    if (!$response) return '';

    $data = json_decode($response, true);

    // Check if rate limited
    if (isset($data['error'])) {
        echo "Rate limited! Waiting 60 seconds...<br>";
        flush();
        sleep(60);
        return getPexelsImage($query, $apiKey); // retry
    }

    usleep(200000); // 0.2s delay between requests to stay under limit

    return $data['photos'][0]['src']['large'] ?? '';
}

function populateImages($conn)
{
    set_time_limit(0);
    $pexelsKey = $_ENV['PEXELS_KEY'];

    // ---- Restaurants ----
    $result = $conn->query("SELECT Restaurant_ID, Name FROM restaurants WHERE Image = '' OR Image IS NULL");
    $stmt   = $conn->prepare("UPDATE restaurants SET Image = ? WHERE Restaurant_ID = ?");
    while ($row = $result->fetch_assoc()) {
        $image = getPexelsImage($row['Name'] . ' restaurant', $pexelsKey);
        if (empty($image)) continue;
        $stmt->bind_param('si', $image, $row['Restaurant_ID']);
        $stmt->execute();
        echo "Restaurant image updated: {$row['Name']}<br>";
        flush();
    }
    $stmt->close();

    // ---- Destinations ----
    $result = $conn->query("SELECT Destination_ID, Name FROM destinations WHERE Image = '' OR Image IS NULL");
    $stmt   = $conn->prepare("UPDATE destinations SET Image = ? WHERE Destination_ID = ?");
    while ($row = $result->fetch_assoc()) {
        $image = getPexelsImage($row['Name'] . ' city', $pexelsKey);
        if (empty($image)) continue;
        $stmt->bind_param('si', $image, $row['Destination_ID']);
        $stmt->execute();
        echo "Destination image updated: {$row['Name']}<br>";
        flush();
    }
    $stmt->close();

    // ---- Accommodations ----
    $result = $conn->query("SELECT Accommodation_ID, Name FROM accommodations WHERE Image = '' OR Image IS NULL");
    $stmt   = $conn->prepare("UPDATE accommodations SET Image = ? WHERE Accommodation_ID = ?");
    while ($row = $result->fetch_assoc()) {
        $image = getPexelsImage($row['Name'] . ' hotel', $pexelsKey);
        if (empty($image)) continue;
        $stmt->bind_param('si', $image, $row['Accommodation_ID']);
        $stmt->execute();
        echo "Accommodation image updated: {$row['Name']}<br>";
        flush();
    }
    $stmt->close();

    // ---- Attractions ----
    $result = $conn->query("SELECT Attraction_ID, Name FROM tourist_attractions WHERE Image = '' OR Image IS NULL");
    $stmt   = $conn->prepare("UPDATE tourist_attractions SET Image = ? WHERE Attraction_ID = ?");
    while ($row = $result->fetch_assoc()) {
        $image = getPexelsImage($row['Name'] . ' landmark', $pexelsKey);
        if (empty($image)) continue;
        $stmt->bind_param('si', $image, $row['Attraction_ID']);
        $stmt->execute();
        echo "Attraction image updated: {$row['Name']}<br>";
        flush();
    }
    $stmt->close();

    echo "All images done!<br>";
}
