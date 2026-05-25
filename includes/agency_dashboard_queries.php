<?php
function getAgencyPackages($conn, $agency_id)
{
    $stmt = $conn->prepare('SELECT * FROM packages WHERE Agency_ID = ? ORDER BY Name');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $packages = [];
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
    $stmt->close();
    return $packages;
}

function getRestaurants($conn)
{
    $stmt = $conn->prepare('SELECT Restaurant_ID, Name FROM restaurants');
    $stmt->execute();
    $result = $stmt->get_result();
    $restaurants = [];
    while ($row = $result->fetch_assoc()) {
        $restaurants[] = $row;
    }
    $stmt->close();
    return $restaurants;
}

function getAttractions($conn)
{
    $stmt = $conn->prepare('SELECT Attraction_ID, Name FROM tourist_attractions');
    $stmt->execute();
    $result = $stmt->get_result();
    $attractions = [];
    while ($row = $result->fetch_assoc()) {
        $attractions[] = $row;
    }
    $stmt->close();
    return $attractions;
}

function getAccommodations($conn)
{
    $stmt = $conn->prepare('SELECT Accommodation_ID, Name, Price_PN FROM accommodations ORDER BY Name');
    $stmt->execute();
    $result = $stmt->get_result();
    $accommodations = [];
    while ($row = $result->fetch_assoc()) {
        $accommodations[] = $row;
    }
    $stmt->close();
    return $accommodations;
}

function getDestinations($conn)
{
    $stmt = $conn->prepare('SELECT Destination_ID, Name FROM destinations ORDER BY Name');
    $stmt->execute();
    $result = $stmt->get_result();
    $destinations = [];
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
    $stmt->close();
    return $destinations;
}

function getFlights($conn)
{
    $stmt = $conn->prepare('SELECT Flight_ID, Airline, Departure_Loc, Arrival_Loc, Price FROM flights');
    $stmt->execute();
    $result = $stmt->get_result();
    $flights = [];
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
    $stmt->close();
    return $flights;
}
function setPackage($conn, $data)
{
    $checkStmt = $conn->prepare('SELECT Package_ID FROM packages WHERE Name = ? AND Agency_ID = ?');
    $checkStmt->bind_param('si', $data['name'], $data['agency_id']);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        return ['success' => false, 'message' => 'A package with this name already exists'];
    }
    $checkStmt->close();


    //treat an empty departure date as NULL
    if (isset($data['departureDate']) && $data['departureDate'] !== '') {
        $departureDate = $data['departureDate'];
    } else {
        $departureDate = null;
    }

    $stmt = $conn->prepare('INSERT INTO packages (Agency_ID, Name, Price, Description, Duration, Capacity, Departure_Date)
    VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param(
        'isdsiis',
        $data['agency_id'],
        $data['name'],
        $data['price'],
        $data['description'],
        $data['duration'],
        $data['maxGuests'],
        $departureDate
    );
    $stmt->execute();

    $package_id = $conn->insert_id;

    //Insert into package_destinations
    $stmt2 = $conn->prepare('INSERT INTO package_destinations (Package_ID, Destination_ID) VALUES (?, ?)');
    foreach ($data['destinations'] as $destinationItem) {
        $stmt2->bind_param('ii', $package_id, $destinationItem);
        $stmt2->execute();
    }
    $stmt2->close();
    //Insert into package_accommodations
    $stmt3 = $conn->prepare('INSERT INTO package_accommodations (Package_ID, Accommodation_ID) VALUES (?, ?)');
    foreach ($data['accommodations'] as $item) {
        $stmt3->bind_param('ii', $package_id, $item);
        $stmt3->execute();
    }
    $stmt3->close();

    //Insert into package_flights
    $stmt4 = $conn->prepare('INSERT INTO package_flights (Package_ID, Flight_ID) VALUES (?, ?)');
    foreach ($data['flights'] as $item) {
        $stmt4->bind_param('ii', $package_id, $item);
        $stmt4->execute();
    }
    $stmt4->close();

    // Insert into package_restaurants
    $stmt5 = $conn->prepare('INSERT INTO package_restaurants (Package_ID, Restaurant_ID) VALUES (?, ?)');
    foreach ($data['restaurants'] as $item) {
        $stmt5->bind_param('ii', $package_id, $item);
        $stmt5->execute();
    }
    $stmt5->close();

    // Insert into package_attractions
    $stmt6 = $conn->prepare('INSERT INTO package_attractions (Package_ID, Attraction_ID) VALUES (?, ?)');
    foreach ($data['attractions'] as $item) {
        $stmt6->bind_param('ii', $package_id, $item);
        $stmt6->execute();
    }
    $stmt6->close();

    //Insert into package_images 
    if (!empty($data['image'])) {
        $imgStmt = $conn->prepare("INSERT INTO package_images (Package_ID, Image_URL) VALUES (?, ?)");
        $imgStmt->bind_param('is', $package_id, $data['image']);
        $imgStmt->execute();
        $imgStmt->close();
    }
    //send sucesss to js 
    if ($package_id) {
        return ['success' => true, 'package_id' => $package_id, 'message' => 'Package created successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to create package'];
    }
}



function deletePackage($conn, $package_id, $agency_id)
{
    $stmt = $conn->prepare('DELETE FROM packages WHERE Package_ID = ? AND Agency_ID = ?');
    $stmt->bind_param('ii', $package_id, $agency_id);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();

    if ($affected > 0) {
        return ['success' => true, 'message' => 'Package deleted'];
    } else {
        return ['success' => false, 'message' => 'Package not found or unauthorised'];
    }
}
function getPackage($conn, $package_id)
{
    $stmt = $conn->prepare('SELECT * FROM packages WHERE Package_ID = ?');
    $stmt->bind_param('i', $package_id);
    $stmt->execute();
    $pkg = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$pkg) return ['error' => 'not found'];

    // Fetch all related IDs from junction tables
    $maps = [
        'destinations'   => ['package_destinations',  'Destination_ID'],
        'accommodations' => ['package_accommodations', 'Accommodation_ID'],
        'flights'        => ['package_flights',        'Flight_ID'],
        'restaurants'    => ['package_restaurants',    'Restaurant_ID'],
        'attractions'    => ['package_attractions',    'Attraction_ID'],
    ];
    foreach ($maps as $key => [$table, $col]) {
        $s = $conn->prepare("SELECT $col FROM $table WHERE Package_ID = ?");
        $s->bind_param('i', $package_id);
        $s->execute();
        $rows = $s->get_result()->fetch_all(MYSQLI_ASSOC);
        $pkg[$key] = array_column($rows, $col);
        $s->close();
    }

    // Fetch image
    $s = $conn->prepare('SELECT Image_URL FROM package_images WHERE Package_ID = ? LIMIT 1');
    $s->bind_param('i', $package_id);
    $s->execute();
    $img = $s->get_result()->fetch_assoc();
    $pkg['image'] = $img['Image_URL'] ?? '';
    $s->close();

    return $pkg;
}

function updatePackage($conn, $package_id, $agency_id, $data)
{
    // Verify the agency owns this package
    $check = $conn->prepare('SELECT Package_ID FROM packages WHERE Package_ID = ? AND Agency_ID = ?');
    $check->bind_param('ii', $package_id, $agency_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        $check->close();
        return ['success' => false, 'message' => 'Package not found or unauthorised'];
    }
    $check->close();

    $departureDate = !empty($data['departureDate']) ? $data['departureDate'] : null;

    // Update main package row
    $stmt = $conn->prepare('UPDATE packages SET Name=?, Price=?, Description=?, Duration=?, Capacity=?, Departure_Date=? WHERE Package_ID=?');
    $stmt->bind_param(
        'sdsiisi',
        $data['name'],
        $data['price'],
        $data['description'],
        $data['duration'],
        $data['maxGuests'],
        $departureDate,
        $package_id
    );
    $stmt->execute();
    $stmt->close();

    // Delete and re-insert all junction table rows
    $tables = ['package_destinations', 'package_accommodations', 'package_flights', 'package_restaurants', 'package_attractions'];
    foreach ($tables as $t) {
        $d = $conn->prepare("DELETE FROM $t WHERE Package_ID = ?");
        $d->bind_param('i', $package_id);
        $d->execute();
        $d->close();
    }

    $maps = [
        'destinations'   => ['package_destinations',  'Destination_ID'],
        'accommodations' => ['package_accommodations', 'Accommodation_ID'],
        'flights'        => ['package_flights',        'Flight_ID'],
        'restaurants'    => ['package_restaurants',    'Restaurant_ID'],
        'attractions'    => ['package_attractions',    'Attraction_ID'],
    ];
    foreach ($maps as $key => [$table, $col]) {
        $s = $conn->prepare("INSERT IGNORE INTO $table (Package_ID, $col) VALUES (?, ?)");
        foreach (($data[$key] ?? []) as $fkId) {
            $fkId = intval($fkId);
            $s->bind_param('ii', $package_id, $fkId);
            $s->execute();
        }
        $s->close();
    }

    // Replace image
    $del = $conn->prepare('DELETE FROM package_images WHERE Package_ID = ?');
    $del->bind_param('i', $package_id);
    $del->execute();
    $del->close();

    if (!empty($data['image'])) {
        $imgStmt = $conn->prepare('INSERT INTO package_images (Package_ID, Image_URL) VALUES (?, ?)');
        $imgStmt->bind_param('is', $package_id, $data['image']);
        $imgStmt->execute();
        $imgStmt->close();
    }

    return ['success' => true, 'message' => 'Package updated successfully'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');
    $body = json_decode(file_get_contents('php://input'), true);
    require_once __DIR__ . '/database.php';

    if ($body['type'] === 'setPackage') {
        echo json_encode(setPackage($conn, $body['data']));
    } else if ($body['type'] === 'getDestinations') {
        echo json_encode(getDestinations($conn));
    } else if ($body['type'] === 'getAccommodations') {
        echo json_encode(getAccommodations($conn));
    } else if ($body['type'] === 'getAgencyPackages') {
        echo json_encode(getAgencyPackages($conn, $body['agency_id']));
    } else if ($body['type'] === 'getFlights') {
        echo json_encode(getFlights($conn));
    } else if ($body['type'] === 'deletePackage') {
        echo json_encode(deletePackage($conn, $body['package_id'], $body['agency_id']));
    } else if ($body['type'] === 'getAttractions') {
        echo json_encode(getAttractions($conn));
    } else if ($body['type'] === 'getRestaurants') {
        echo json_encode(getRestaurants($conn));
    } else if ($body['type'] === 'getPackage') {
        echo json_encode(getPackage($conn, $body['package_id']));
    } else if ($body['type'] === 'updatePackage') {
        echo json_encode(updatePackage($conn, $body['package_id'], $body['agency_id'], $body['data']));
    }
    exit;
}
