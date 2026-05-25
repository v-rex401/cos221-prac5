<?php
    /*   Anke de Frey u24611400 */

    //generates a sharing code that is not already used by another group.
    function generateUniqueSharingCode($conn){
        //no easily-confused characters (no 0/O, 1/I)
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $charCount = strlen($chars);

        do {
            $code = '';
            for($i = 0; $i < 8; $i++){
                $code .= $chars[random_int(0, $charCount - 1)];
            }

            //make sure this code isn't already taken
            $check = $conn->prepare("SELECT Booking_ID FROM group_bookings WHERE Sharing_Code = ?");
            $check->bind_param("s", $code);
            $check->execute();
            $check->store_result();
            $taken = $check->num_rows > 0;
            $check->close();
        } while($taken);

        return $code;
    }

    //creates a group booking - inserts the booking record, generates a unique
    //sharing code, then inserts the group_bookings record.
    //returns ['booking_id' => int, 'sharing_code' => string], or null on failure.
    function createGroupBooking($conn, $packageId, $bookingDate, $startDate, $endDate, $guestLimit, $agencyId){
        //Step 1: create the booking record
        $sqlBooking = "INSERT INTO bookings (Package_ID, Booking_Date, Start_Date, End_Date, Booking_Type)
                       VALUES (?, ?, ?, ?, 'Group')";
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

        //Step 2: generate a unique sharing code for this group
        $sharingCode = generateUniqueSharingCode($conn);

        //Step 3: create the group_bookings record (with the package, dates and code)
        $sqlGroup = "INSERT INTO group_bookings
                        (Booking_ID, Package_ID, Start_Date, End_Date, Sharing_Code, Guest_Limit, Guest_Count, Agency_ID)
                     VALUES (?, ?, ?, ?, ?, ?, 1, ?)";
        $stmtGroup = $conn->prepare($sqlGroup);
        if(!$stmtGroup){
            return null;
        }

        $stmtGroup->bind_param("iisssii", $bookingId, $packageId, $startDate, $endDate, $sharingCode, $guestLimit, $agencyId);
        if(!$stmtGroup->execute()){
            $stmtGroup->close();
            return null;
        }
        $stmtGroup->close();

        return ['booking_id' => $bookingId, 'sharing_code' => $sharingCode];
    }
?>
