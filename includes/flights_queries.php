<?php
    /*  Anke de Frey u24611400 */

    //returns every flight
    function getAllFlights($conn){
        $sql = "SELECT Flight_ID, Airline, Departure_Loc, Arrival_Loc, Time_Dept, Time_Arrive, Price FROM flights";
        $result = $conn->query($sql);

        $flights = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $flights[] = $row;
            }
        }
        return $flights;
    }
?>
