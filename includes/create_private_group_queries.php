<?php
    /*   Anke de Frey u24611400 */

    //creates a group booking - inserts the booking record, then the
    //group_bookings record. returns the new Booking_ID, or null on failure.
    function createGroupBooking($conn, $packageId, $bookingDate, $startDate, $endDate, $guestLimit, $agencyId){
        //Step 1: create the booking record
        $sqlBooking = "INSERT INTO bookings (Package_ID, Booking_Date, Start_Date, End_Date, Booking_Type) VALUES (?, ?, ?, ?, 'Group')";
        $stmtBooking = $conn->prepare($sqlBooking);
        if(!$stmtBooking){
            return null;
        }

        $stmtBooking->bind_param("isss", $packageId, $bookingDate, $startDate, $endDate);
        if(!$stmtBooking->execute()){
            $stmtBooking->close();
            return null;
        }

        $bookingId = $stmtBooking->insert_id;
        $stmtBooking->close();

        //Step 2: create the group_bookings record
        $sqlGroup = "INSERT INTO group_bookings (Booking_ID, Guest_Limit, Guest_Count, Agency_ID) VALUES (?, ?, 1, ?)";
        $stmtGroup = $conn->prepare($sqlGroup);
        if(!$stmtGroup){
            return null;
        }

        $stmtGroup->bind_param("iii", $bookingId, $guestLimit, $agencyId);
        if(!$stmtGroup->execute()){
            $stmtGroup->close();
            return null;
        }
        $stmtGroup->close();

        return $bookingId;
    }
?>
