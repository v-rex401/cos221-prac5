<?php
    /* Anke de Frey u24611400 */

    //returns every restaurant, ordered by name
    function getAllRestaurants($conn){
        $sql = "SELECT Restaurant_ID, Name, Cuisine, Country, Image FROM restaurants ORDER BY Name";
        $result = $conn->query($sql);

        $restaurants = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $restaurants[] = $row;
            }
        }
        return $restaurants;
    }
?>
