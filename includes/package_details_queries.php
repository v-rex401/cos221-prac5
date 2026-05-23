<?php
    /* Anke de Frey u24611400 */

    //returns the user's most recent booking for a package, or null
    function getLatestUserBooking($conn, $userID, $packageId){
        $sql = "SELECT Booking_ID FROM bookings
                WHERE User_ID = ? AND Package_ID = ?
                ORDER BY Booking_Date DESC LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userID, $packageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $stmt->close();

        return $booking;
    }
?>
