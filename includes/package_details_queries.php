<?php
    /* Anke de Frey u24611400 */

    //returns the user's most recent booking for a package, or null.
    //includes End_Date so callers can tell if the trip is finished.
    function getLatestUserBooking($conn, $userID, $packageId){
        $sql = "SELECT Booking_ID, Start_Date, End_Date FROM bookings
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

    /*  Returns the set departure date(s) for a package.
        The agency sets a package's Departure_Date when creating it;
        a package with no date set is not bookable. */
    function getPackageDepartureDates($conn, $packageId){
        $sql = "SELECT Departure_Date FROM packages
                WHERE Package_ID = ? AND Departure_Date IS NOT NULL";

        $stmt = $conn->prepare($sql);
        if(!$stmt){
            return [];
        }

        $stmt->bind_param("i", $packageId);
        $stmt->execute();
        $result = $stmt->get_result();

        $dates = [];
        while($row = $result->fetch_assoc()){
            $dates[] = $row['Departure_Date'];
        }
        $stmt->close();

        return $dates;
    }
?>
