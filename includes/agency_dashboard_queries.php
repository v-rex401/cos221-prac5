<?php
function getAgencyPackages($conn, $agency_id) {
    $stmt = $conn->prepare('SELECT * FROM packages WHERE User_ID = ? ORDER BY Name');
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
function getAccommodations($conn) {
    $stmt = $conn->prepare('SELECT Accommodation_ID, Name FROM accommodations ORDER BY Name');
    $stmt->execute();
    $result = $stmt->get_result();
    $accommodations = [];
    while ($row = $result->fetch_assoc()) {
        $accommodations[] = $row;
    }
    $stmt->close();
    return $accommodations;
}

function getDestinations($conn) {
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


 function setPackage($conn, $data){
    $stmt = $conn->prepare('INSERT IGNORE INTO packages (Agency_ID, Name, Price, Description, Duration)
    VALUES (?,?,?,?,?)'); 
      $stmt->bind_param('isdsi', 
      $data['agency_id'],
      $data['packageName'],
      $data['price'],
      $data['description'], 
      $data['duration']
    ); 
    $stmt->execute(); 

    $package_id = $conn->insert_id;

$stmt2 = $conn->prepare('INSERT INTO package_destinations (Package_ID, Destination_ID) VALUES (?, ?)');
$stmt2->bind_param('ii', $package_id, $data['destination']);
$stmt2->execute();
$stmt2->close();

$stmt3 = $conn->prepare('INSERT INTO package_accommodations (Package_ID, Accommodation_ID) VALUES (?, ?)');
$stmt3->bind_param('ii', $package_id, $data['accommodation']);
$stmt3->execute();
$stmt3->close();

    //send sucesss to js 
    if ($package_id){
        return ['success' => true, 'package_id' => $package_id, 'message' => 'Package created successfully']; 
    } else {
        return ['success' => false, 'message' => 'Failed to create package']; 
    }

 }

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $body = json_decode(file_get_contents('php://input'), true);
    require_once __DIR__ . '/database.php';

    if ($body['type'] === 'setPackage') {
        echo json_encode(setPackage($conn, $body['data']));
    } else if ($body['type'] === 'getDestinations') {
    echo json_encode(getDestinations($conn));
}else if ($body['type'] === 'getAccommodations') {
    echo json_encode(getAccommodations($conn));
}else if ($body['type'] === 'getAgencyPackages') {
    echo json_encode(getAgencyPackages($conn, $body['agency_id']));
}
    exit;
}
 ?>