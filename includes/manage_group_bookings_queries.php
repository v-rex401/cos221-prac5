<?php

function getGroupBookings($conn, $agency_id)
{
    $stmt = $conn->prepare('
        SELECT gb.Booking_ID, gb.Start_Date, gb.End_Date, 
               gb.Sharing_Code, gb.Guest_Limit, gb.Guest_Count,
               p.Name, p.Price, p.Duration
        FROM group_bookings gb
        JOIN packages p ON gb.Package_ID = p.Package_ID
        WHERE p.Agency_ID = ?
        ORDER BY gb.Start_Date DESC
    ');
    $stmt->bind_param('i', $agency_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    $stmt->close();
    return $bookings;
}

function getGroupBookingMembers($conn, $booking_id, $agency_id)
{
    // Verify this booking belongs to one of the agency's packages
    $check = $conn->prepare('
        SELECT gb.Booking_ID FROM group_bookings gb
        JOIN packages p ON gb.Package_ID = p.Package_ID
        WHERE gb.Booking_ID = ? AND p.Agency_ID = ?
    ');
    $check->bind_param('ii', $booking_id, $agency_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        $check->close();
        return ['success' => false, 'message' => 'Unauthorised'];
    }
    $check->close();

    $stmt = $conn->prepare('
        SELECT u.Name, u.Email, u.Cell, bt.Joined_Date
        FROM booking_travelers bt
        JOIN users u ON bt.User_ID = u.User_ID
        WHERE bt.Booking_ID = ?
        ORDER BY bt.Joined_Date ASC
    ');
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $members = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return ['success' => true, 'members' => $members];
}

function updateGroupBooking($conn, $booking_id, $agency_id, $start_date, $end_date, $guest_limit)
{
    // Verify ownership through packages
    $check = $conn->prepare('
        SELECT gb.Booking_ID FROM group_bookings gb
        JOIN packages p ON gb.Package_ID = p.Package_ID
        WHERE gb.Booking_ID = ? AND p.Agency_ID = ?
    ');
    $check->bind_param('ii', $booking_id, $agency_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        $check->close();
        return ['success' => false, 'message' => 'Unauthorised'];
    }
    $check->close();

    $stmt = $conn->prepare('
        UPDATE group_bookings 
        SET Start_Date = ?, End_Date = ?, Guest_Limit = ?
        WHERE Booking_ID = ?
    ');
    $stmt->bind_param('ssii', $start_date, $end_date, $guest_limit, $booking_id);
    $stmt->execute();
    $stmt->close();

    // Keep bookings table in sync
    $stmt2 = $conn->prepare('UPDATE bookings SET Start_Date = ?, End_Date = ? WHERE Booking_ID = ?');
    $stmt2->bind_param('ssi', $start_date, $end_date, $booking_id);
    $stmt2->execute();
    $stmt2->close();

    return ['success' => true];
}

function deleteGroupBooking($conn, $booking_id, $agency_id)
{
    // Verify ownership through packages
    $check = $conn->prepare('
        SELECT gb.Booking_ID FROM group_bookings gb
        JOIN packages p ON gb.Package_ID = p.Package_ID
        WHERE gb.Booking_ID = ? AND p.Agency_ID = ?
    ');
    $check->bind_param('ii', $booking_id, $agency_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        $check->close();
        return ['success' => false, 'message' => 'Unauthorised'];
    }
    $check->close();

    // Deleting from bookings cascades to group_bookings
    $stmt = $conn->prepare('DELETE FROM bookings WHERE Booking_ID = ?');
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $stmt->close();
    return ['success' => true];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $body = json_decode(file_get_contents('php://input'), true);
    require_once __DIR__ . '/database.php';

    if ($body['type'] === 'getGroupBookingMembers') {
        echo json_encode(getGroupBookingMembers($conn, $body['booking_id'], $body['agency_id']));
    } else if ($body['type'] === 'updateGroupBooking') {
        echo json_encode(updateGroupBooking(
            $conn,
            $body['booking_id'],
            $body['agency_id'],
            $body['start_date'],
            $body['end_date'],
            $body['guest_limit']
        ));
    } else if ($body['type'] === 'deleteGroupBooking') {
        echo json_encode(deleteGroupBooking($conn, $body['booking_id'], $body['agency_id']));
    }
    exit;
}
