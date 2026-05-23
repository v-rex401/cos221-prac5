<?php
    /* Anke de Frey u24611400 */

    //returns every accommodation, ordered by name
    function getAllAccommodations($conn){
        $sql = "SELECT Accommodation_ID, Name, Type, Price_PN, Image FROM accommodations ORDER BY Name";
        $result = $conn->query($sql);

        $accommodations = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $accommodations[] = $row;
            }
        }
        return $accommodations;
    }
?>
