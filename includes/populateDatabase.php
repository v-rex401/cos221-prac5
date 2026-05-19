<?php
 require_once __DIR__ . '/database.php';

populateFlights($conn); 
die(); 

 //Get the data from the js 
 $input = json_decode(file_get_contents('php://input'), true); 

 $type = $input['type']; 
 $data = $input['data']; 

 switch ($type){
    case 'destinations':
        populateDestinations($conn, $data); 
        break; 
    case 'attractions': 
        populateAttractions($conn, $data); 
        break; 
 }


 function populateDestinations($conn, $data) {
    //Get the things from data 
    $stmt = $conn->prepare('INSERT INTO destinations (Name, Country) VALUES (?,?) '); 
    foreach ($data as $c) {
        $stmt->bind_param('ss', $c['name'], $c['country']); 
        $stmt->execute(); 
    }
    $stmt->close(); 
    $conn->close(); 
 }


 function populateFlights($conn){
    $apikey = "37eef15d86e0a204669b06f6c69f769f"; 
    $url = "http://api.aviationstack.com/v1/flights?access_key=$apikey&limit=100"; 

    //Fetch from the API 
    $response = file_get_contents($url); 
    $data = json_decode($response, true); 
    
    foreach ($data['data'] as $flight){
        $airline = $flight['airline']['name']; 
        $departureLoc = $flight['departure']['airport']; 
        $arrivalLoc = $flight['arrival']['airport']; 
        $deptTime = $flight['departure']['scheduled']; 
        $arrTime = $flight['arrival']['scheduled']; 
        $price = 1000; //This should be decided by the agency 

        if ($airline == "empty"){
            $airline = "unknown"; 
        }
        echo  "$airline, $departureLoc, $arrivalLoc, $deptTime, $arrTime, $price";
        echo "<br>" ; 

        //TODO: INSERT INTO THE DATABASE 
        $stmt = $conn->prepare('INSERT INTO flights (Airline, Departure_Loc, Arrival_Loc, Time_Dept, Time_Arrive, Price) 
        VALUES (?,?,?,?,?,?)'); 

        $stmt->bind_param('sssddi', 
        $airline, $departureLoc, $arrivalLoc, $deptTime, $arrTime, $price
        ); 
        $stmt->execute();
    }
    $stmt->close(); 

 }

?> 