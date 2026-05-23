<?php
    /* Anke de Frey u24611400 */

    //returns the booking row if it belongs to this user and package, else null
    function getOwnedBooking($conn, $bookingID, $userID, $packageID){
        $sql = "SELECT b.Booking_ID FROM bookings
                WHERE Booking_ID = ? AND User_ID = ? AND Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $bookingID, $userID, $packageID);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $stmt->close();

        return $booking;
    }
?>
