<?php
require_once __DIR__ . '/../includes/database.php';

die();
populateDestinations($conn);
populateAttractions($conn);
populateAccomodation($conn);
populateFlights($conn);
populateRestaurants($conn);



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
function populateRestaurants($conn)
{
    $apiKey = "b20b4c07e70347b5a578846ba64e6d3c";
    $destinations = getDestinationsFromDB($conn);
    $stmt = $conn->prepare('INSERT IGNORE INTO restaurants (Name, Cuisine, Image) VALUES (?, ?, ?)');

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
            $name = $place['properties']['name'] ?? null;
            $cuisine = 'Various';
            $image = '';
            if (empty($name)) continue;

            $stmt->bind_param('sss', $name, $cuisine, $image);
            $stmt->execute();
        }

        echo "Restaurants done for {$dest['Name']}<br>";
        flush();
    }

    $stmt->close();
    echo "All restaurants populated!<br>";
}

function populateAttractions($conn)
{
    $apiKey = "b20b4c07e70347b5a578846ba64e6d3c";
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

    $apikey = "37eef15d86e0a204669b06f6c69f769f";
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
    $check = $conn->query("SELECT COUNT(*) as total FROM accommodations");
    $row = $check->fetch_assoc();
    if ($row['total'] > 0) {
        echo "Accommodations already populated ({$row['total']} records). Skipping.<br>";
        return;
    }

    $stmt = $conn->prepare('INSERT IGNORE INTO accommodations (Name, Type, Price_PN, Image) VALUES (?,?,?,?)');

    $inserted = 0;
    $skipped = 0;
    $pageNumber = 1;
    $pageSize = 100; // max per page

    do {
        $url = "https://tourism.api.opendatahub.com/v1/Accommodation?pagenumber={$pageNumber}&pagesize={$pageSize}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $totalPages = $data['TotalPages'] ?? 1;

        foreach ($data['Items'] as $item) {
            $name  = $item['AccoDetail']['en']['Name'] ?? null;
            $type  = $item['AccoType']['Id']           ?? null;
            $price = 1000;
            $image = $item['ImageGallery'][0]['ImageUrl'] ?? '';

            if (empty($name)) {
                $skipped++;
                continue;
            }

            $stmt->bind_param('ssis', $name, $type, $price, $image);
            $stmt->execute();
            $inserted++;
        }

        echo "Page {$pageNumber}/{$totalPages} done<br>";
        flush(); // shows progress in browser as it runs

        $pageNumber++;
    } while ($pageNumber <= $totalPages);

    $stmt->close();
    echo "Accommodations done! Inserted: $inserted | Skipped: $skipped<br>";
}
