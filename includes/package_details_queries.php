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

    /*  Returns the set departure dates for a package.

        TODO (backend): once the agency side has a scheduling table,
        query it here - e.g.
            SELECT Start_Date FROM package_schedules
            WHERE Package_ID = ? AND Start_Date >= CURDATE()
            ORDER BY Start_Date
        and return the date rows.

        Until then there are no set dates, so this returns an empty
        array and the booking popup shows an empty date selector. */
    function getPackageDepartureDates($conn, $packageId){
        return [];
    }
?>
