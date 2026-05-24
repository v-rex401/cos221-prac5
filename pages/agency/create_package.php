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
                <select id="destination" name="destination" multiple> </select>
            </div>

            <div>
                <label for="maxGuests">Max Number of Travellers</label>
                <input type="number" id="maxGuests" name="maxGuests" step="1" min="1">
            </div>

            <div>
                <label for="days">Number of Days</label>
                <input type="number" id="days" name="days" step="1" min="1">
            </div>

            <div>
                <label for="accommodation">Accomodation</label>
                <select id="accommodation" name="accomodation" multiple> </select>
            </div>

            <div>
                <label for="depDate">Departure Date</label>
                <input type="date" id="depDate" name="departureDate">
            </div>

            <div>
                <label for="arrDate">Arrival Date</label>
                <input type="date" id="arrDate" name="arrivalDate">
            </div>

            <div>
                <label for="description">Description</label>
                <input type="text" id="description" name="description">
            </div>
            <div> <label for="flights">Available Flights</label>
                <select id="flights" name="flights" multiple> </select>
            </div>
            <div>
                <label for="price"> Price </label>
                <input type="text" id="price" name="price">
            </div>

            <div> <button id="createButton">Create </button> </div>
        </div>
        <div class="previewSide">
            <!-- live preview goes here -->
            <h2 id="prev-name">Package Name</h2>
            <p id="prev-price">R0</p>
            <p id="prev-duration">0 days</p>
            <p id="prev-description">No description yet.</p>

            <h4>Destinations</h4>
            <ul id="prev-destinations"></ul>

            <h4>Accomodations</h4>
            <ul id="prev-accommodations"></ul>

            <h4>Flights</h4>
            <ul id="prev-flights"></ul>


            <hr>
            <p>Flights: <span id="prev-flight-cost">R0</span></p>
            <p>Accommodation: <span id="prev-accommodation-cost">R0</span></p>
            <hr>
            <p>Total: <span id="prev-total">R0</span></p>

        </div>
    </div>
    <script src="../../js/createPackage.js"> </script>
</body>



</html>