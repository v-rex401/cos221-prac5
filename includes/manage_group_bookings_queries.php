<?php

//Get the group bookings 
function getGroupBookings($conn, $agency_id)
{
    $stmt = $conn->prepare('SELECT * FROM group_bookings WHERE Agency_ID = ?');
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $body = json_decode(file_get_contents('php://input'), true);
    require_once __DIR__ . '/database.php';

    if ($body['type'] === 'getGroupBookings') {
        echo json_encode(getGroupBookings($conn, $body['agency_id']));
    }
    exit;
}
