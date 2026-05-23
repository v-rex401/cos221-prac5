<?php
    /* Anke de Frey u24611400 */

    //returns one booking joined with its package details, or null
    function getBookingConfirmation($conn, $bookingId){
        $sql = "SELECT b.*, p.package_name, p.Price, p.Duration
                FROM bookings b
                JOIN packages p ON b.Package_ID = p.Package_ID
                WHERE b.Booking_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $stmt->close();

        return $booking;
    }
?>
