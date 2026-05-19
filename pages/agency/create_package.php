<?php
    //create and edit packages
    //edit? still not sure if we should implement edit
?>

<!DOCTYPE html> 
<html lang="en"> 
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agency Dashboard</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/dashboard.css"> 
    </head>

    <body> 
        <div class="outsideDiv"> 
            <div class="formContainer"> 
                <div> 
                <label for="packageName">Package Name</label> 
                <input type="text" id="packageName" name="packageName"> 
                </div> 

                <div> 
                <label for="destination">Destination</label> 
                <input type="select" id="destination" name="destination">
                </div> 

                <div> 
                <label for="maxGuests">Max Number of Travellers</label> 
                <input type="number" id="maxGuests" name="maxGuests" step="1" min="1"> 
                </div>

                <div> 
                <label for="minGuests">Min Number of Travellers</label> 
                <input type="number" id="minGuests" name="minGuests"  step="1" min="1">
                </div> 

                <div> 
                    <label for="accomodation">Accomodation</label> 
                    <input type="select" id="accomodation" name="accomodation"> 
                </div> 

                <div> 
                    <label for="transport">Transport</label> 
                    <input type="select" id="transport" name="transport"> 
                </div> 
            </div> 
        </div>
    </body> 



</html> 