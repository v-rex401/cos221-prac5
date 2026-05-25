<?php
    /*  My Bookings page query helpers
        Anke de Frey u24611400 */

    //returns every booking made by a traveller, newest first,
    //joined with the package each booking is for
    function getUserBookings($conn, $userID){
        $sql = "SELECT b.Booking_ID, b.Booking_Date, b.Start_Date, b.End_Date, b.Booking_Type,
                    p.Package_ID, p.Name AS package_name, p.Price, p.Duration,
                    (p.Price
                        + COALESCE((SELECT SUM(fl.Price) FROM package_flights pf JOIN flights fl ON fl.Flight_ID = pf.Flight_ID WHERE pf.Package_ID = p.Package_ID), 0)
                        + COALESCE((SELECT SUM(ac.Price_PN) FROM package_accommodations pa JOIN accommodations ac ON ac.Accommodation_ID = pa.Accommodation_ID WHERE pa.Package_ID = p.Package_ID), 0) * p.Duration) AS full_price,
                    (SELECT Image_URL FROM package_images
                        WHERE Package_ID = p.Package_ID LIMIT 1) AS image_url
                FROM bookings b
                JOIN packages p ON b.Package_ID = p.Package_ID
                WHERE b.User_ID = ?
                ORDER BY b.Booking_Date DESC, b.Booking_ID DESC";

        $stmt = $conn->prepare($sql);
        if(!$stmt){
            return [];
        }

        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $bookings = [];
        while($row = $result->fetch_assoc()){
            $bookings[] = $row;
        }
        $stmt->close();

        return $bookings;
    }
?>
