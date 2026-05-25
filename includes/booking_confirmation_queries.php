<?php
    /* Anke de Frey u24611400 */

    //returns one booking joined with its package details, or null
    function getBookingConfirmation($conn, $bookingId){
        $sql = "SELECT b.*, p.Name AS package_name, p.Price, p.Duration,
                    (p.Price
                        + COALESCE((SELECT SUM(fl.Price) FROM package_flights pf JOIN flights fl ON fl.Flight_ID = pf.Flight_ID WHERE pf.Package_ID = p.Package_ID), 0)
                        + COALESCE((SELECT SUM(ac.Price_PN) FROM package_accommodations pa JOIN accommodations ac ON ac.Accommodation_ID = pa.Accommodation_ID WHERE pa.Package_ID = p.Package_ID), 0) * p.Duration) AS full_price
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
