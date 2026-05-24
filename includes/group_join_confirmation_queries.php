<?php
    /* Anke de Frey u24611400 */

    //returns one group booking joined with its package details, or null
    function getGroupConfirmation($conn, $groupId){
        $sql = "SELECT g.*, p.package_name, p.Price, p.Duration
                FROM group_bookings g
                JOIN packages p ON g.Package_ID = p.Package_ID
                WHERE g.Booking_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $groupId);
        $stmt->execute();
        $result = $stmt->get_result();
        $group = $result->fetch_assoc();
        $stmt->close();

        return $group;
    }
?>
