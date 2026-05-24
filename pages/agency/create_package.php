<?php
    //create and edit packages
    //edit? still not sure if we should implement edit
    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/agency_dashboard_queries.php'; 
?>

<!DOCTYPE html> 
<html lang="en"> 
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agency Dashboard</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/createPackage.css"> 
    </head>

    <body> 
        <div class="outsideDiv"> 
            <div class="formContainer"> 
                <a href="agency_dashboard.php">Go Back</a>
                <div> 
                <label for="packageName">Package Name</label> 
                <input type="text" id="packageName" name="packageName"> 
                </div> 

                <div> 
                <label for="destination">Destination</label> 
                <select id="destination" name="destination"> </select> 
                </div> 

                <div> 
                <label for="maxGuests">Max Number of Travellers</label> 
                <input type="number" id="maxGuests" name="maxGuests" step="1" min="1"> 
                </div>

                <div> 
                <label for="days">Number of Days</label> 
                <input type="number" id="days" name="days"  step="1" min="1">
                </div> 

                <div> 
                    <label for="accomodation">Accomodation</label> 
                    <select id="accommodation" name="accomodation"> </select>
                </div> 

                <div> 
                    <label for="departureDate">Departure Date</label> 
                    <input type="date" id="depDate" name="departureDate">
                </div> 

                <div> 
                    <label for="arrivalDate">Arrival Date</label>  
                    <input type="date" id="arrDate" name = "arrivalDate"> 
                </div> 

                <div> 
                    <label for="description">Description</label> 
                    <input type="text" id="description" name="description"> 
                </div> 
<div> <label for="flights">Available Flights</label>
    <select id="flights" name="flights"> </select>
     </div>
                <div> 
                    <label for="price"> Price </label> 
                    <input type="text" id="price" name="price"> 
                </div> 

                <div> 
                    <label for="agencyId"> Agency ID </label> 
                    <input type="text" id="agencyId" name="agencyId">
                </div> 

                <div> <button id="createButton">Create </button> </div> 
            </div> 
        </div>
        <script src = "../../js/createPackage.js"> </script> 
    </body> 



</html> 