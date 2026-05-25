<?php
    /*  Anke de Frey u24611400 */

    //finds a group booking by its sharing code, or null
    function getGroupByCode($conn, $code){
        $sql = "SELECT * FROM group_bookings WHERE Sharing_Code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $group = $result->fetch_assoc();
        $stmt->close();

        return $group;
    }

    //returns true if a traveller is already a member of this group booking.
    function isTravellerInGroup($conn, $bookingId, $userID){
        $sql = "SELECT 1 FROM booking_travelers WHERE Booking_ID = ? AND User_ID = ?";
        $stmt = $conn->prepare($sql);
        if(!$stmt){
            return false;
        }

        $stmt->bind_param("ii", $bookingId, $userID);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    //adds a logged-in traveller to a group booking: records them as a member
    //in booking_travelers and bumps the guest count. returns true on success.
    function addGuestToGroup($conn, $bookingId, $userID){
        //record this traveller as a member of the group
        $sqlInsert = "INSERT INTO booking_travelers (Booking_ID, User_ID, Joined_Date)
                        VALUES (?, ?, CURDATE())";
        $stmtInsert = $conn->prepare($sqlInsert);
        if(!$stmtInsert){
            return false;
        }

        $stmtInsert->bind_param("ii", $bookingId, $userID);
        if(!$stmtInsert->execute()){
            $stmtInsert->close();
            return false;
        }
        $stmtInsert->close();

        //bump the guest count on the group
        $sqlUpdate = "UPDATE group_bookings SET Guest_Count = Guest_Count + 1 WHERE Booking_ID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        if(!$stmtUpdate){
            return false;
        }

        $stmtUpdate->bind_param("i", $bookingId);
        $success = $stmtUpdate->execute();
        $stmtUpdate->close();

        return $success;
    }

    //returns one package row by id, or null
    function getPackageRow($conn, $packageId){
        $sql = "SELECT p.*, p.Name AS package_name,
                    (p.Price
                        + COALESCE((SELECT SUM(fl.Price) FROM package_flights pf JOIN flights fl ON fl.Flight_ID = pf.Flight_ID WHERE pf.Package_ID = p.Package_ID), 0)
                        + COALESCE((SELECT SUM(ac.Price_PN) FROM package_accommodations pa JOIN accommodations ac ON ac.Accommodation_ID = pa.Accommodation_ID WHERE pa.Package_ID = p.Package_ID), 0) * p.Duration) AS full_price
                FROM packages p WHERE p.Package_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $package = $result->fetch_assoc();
        $stmt->close();

        return $package;
    }
?>
