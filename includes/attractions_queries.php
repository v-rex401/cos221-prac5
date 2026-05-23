<?php
    /* Anke de Frey u24611400 */

    //returns every tourist attraction, ordered by name
    function getAllAttractions($conn){
        $sql = "SELECT Attraction_ID, Name, Image FROM tourist_attractions ORDER BY Name";
        $result = $conn->query($sql);

        $attractions = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $attractions[] = $row;
            }
        }
        return $attractions;
    }
?>
