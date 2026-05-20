<?php
require_once __DIR__ . '/../includes/database.php';

populateDestinations($conn);
populateAccomodation($conn);
populateFlights($conn);
die();

function convertToMySQLDateTime($isoTime) {
    $datetime = new DateTime($isoTime);
    return $datetime->format('Y-m-d H:i:s');
}

function populateDestinations($conn) {
    $url = "https://restcountries.com/v3.1/all?fields=name,capital,region";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $stmt = $conn->prepare('INSERT IGNORE INTO destinations (Name, Country) VALUES (?, ?)');

    for ($i = 0; $i < count($data); $i++) {
        $name    = $data[$i]['capital'][0];
        $country = $data[$i]['name']['common'];

        $stmt->bind_param('ss', $name, $country);
        $stmt->execute();

        echo "$name, $country <br>";
    }

    $stmt->close();
    echo "Done!";
}

function populateFlights($conn) {
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
            $skipped++; continue;
        }
        if (empty($flight['airline']['name']) || $flight['airline']['name'] === 'empty') {
            $skipped++; continue;
        }
        if (empty($flight['flight']['iata'])) {
            $skipped++; continue;
        }

        $airline      = $flight['airline']['name'];
        $departureLoc = $flight['departure']['airport'];
        $arrivalLoc   = $flight['arrival']['airport'];
        $deptTime     = convertToMySQLDateTime($flight['departure']['scheduled']);
        $arrTime      = convertToMySQLDateTime($flight['arrival']['scheduled']);
        $price        = 1000;

        if ($arrTime <= $deptTime) { $skipped++; continue; }

        $stmt->bind_param('sssssi',
            $airline, $departureLoc, $arrivalLoc, $deptTime, $arrTime, $price
        );
        $stmt->execute();
        $inserted++;
    }

    $stmt->close();
    echo "Flights done! Inserted: $inserted | Skipped: $skipped <br>";
}

function populateAccomodation($conn) {
    $check = $conn->query("SELECT COUNT(*) as total FROM accommodations");
    $row = $check->fetch_assoc();
    if ($row['total'] > 0) {
        echo "Accommodations already populated ({$row['total']} records). Skipping.<br>";
        return;
    }

    $url = "https://tourism.api.opendatahub.com/v1/Accommodation";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $stmt = $conn->prepare('INSERT IGNORE INTO accommodations (Name, Type, Price_PN, Image) VALUES (?,?,?,?)');

    $inserted = 0;
    $skipped = 0;

    foreach ($data['Items'] as $item) {
        $name  = $item['AccoDetail']['en']['Name'] ?? null;
        $type  = $item['AccoType']['Id']            ?? null;
        $price = 1000;
        $image = $item['ImageGallery'][0]['ImageUrl'] ?? null;

        if (empty($name)) { $skipped++; continue; }

        $stmt->bind_param('ssis', $name, $type, $price, $image);
        $stmt->execute();
        $inserted++;
    }

    $stmt->close();
    echo "Accommodations done! Inserted: $inserted | Skipped: $skipped <br>";
}
?>