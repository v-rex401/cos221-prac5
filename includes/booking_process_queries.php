<?php
    /*  Anke de Frey u24611400 */

    //inserts a new booking record.
    //returns ['success' => true, 'booking_id' => int] on success,
    //or ['success' => false, 'error' => string] on failure.
    function createBooking($conn, $packageId, $bookingDate, $startDate, $endDate, $bookingType, $userID){
        $sql = "INSERT INTO bookings (Package_ID, Booking_Date, Start_Date, End_Date, Booking_Type, User_ID)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if(!$stmt){
            return ['success' => false, 'error' => 'Database error: ' . $conn->error];
        }

        $stmt->bind_param("issssi", $packageId, $bookingDate, $startDate, $endDate, $bookingType, $userID);

        if($stmt->execute()){
            $bookingId = $stmt->insert_id;
            $stmt->close();
            return ['success' => true, 'booking_id' => $bookingId];
        }

        $stmt->close();
        return ['success' => false, 'error' => 'Failed to create booking. Please try again.'];
    }

    //stores the entered name + cellphone for each traveller on a booking.
    function saveBookingTravellerDetails($conn, $bookingId, $names, $cells){
        if(!is_array($names)){
            return;
        }

        $sql = "INSERT INTO booking_traveller_details (Booking_ID, Name, Cell) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if(!$stmt){
            return;
        }

        $count = count($names);
        for($i = 0; $i < $count; $i++){
            $name = sanitise($names[$i]);

            if(is_array($cells) && isset($cells[$i])){
                $cell = sanitise($cells[$i]);
            } else {
                $cell = '';
            }

            if($name !== ''){
                $stmt->bind_param("iss", $bookingId, $name, $cell);
                $stmt->execute();
            }
        }
        $stmt->close();
    }
?>
