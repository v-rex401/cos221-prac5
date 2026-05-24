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

    //adds one guest to a group booking. returns true on success.
    function addGuestToGroup($conn, $bookingId){
        $sql = "UPDATE group_bookings SET Guest_Count = Guest_Count + 1 WHERE Booking_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookingId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    //returns one package row by id, or null
    function getPackageRow($conn, $packageId){
        $sql = "SELECT * FROM packages WHERE Package_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $package = $result->fetch_assoc();
        $stmt->close();

        return $package;
    }
?>
