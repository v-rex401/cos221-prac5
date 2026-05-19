<?php
 require_once __DIR__ . '/database.php';

populateAccomodation($conn); 
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

//* Helper Function 
 function convertToMySQLDateTime($isoTime) {
    // Parse ISO 8601 format
    $datetime = new DateTime($isoTime);
    // Convert to MySQL format (YYYY-MM-DD HH:MM:SS)
    return $datetime->format('Y-m-d H:i:s');
}

 function populateDestinations($conn, $data) {
    //Get the things from data 
    $stmt = $conn->prepare('INSERT IGNORE INTO destinations (Name, Country) VALUES (?,?) '); 
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
    $stmt = $conn->prepare('INSERT IGNORE INTO flights (Airline, Departure_Loc, Arrival_Loc, Time_Dept, Time_Arrive, Price) 
        VALUES (?,?,?,?,?,?)'); 
    foreach ($data['data'] as $flight){

    if (empty($flight['departure']['scheduled']) || empty($flight['arrival']['scheduled'])) {
        continue;
    }
        $airline = $flight['airline']['name']; 
        $departureLoc = $flight['departure']['airport']; 
        $arrivalLoc = $flight['arrival']['airport']; 
        $deptTime = convertToMySQLDateTime($flight['departure']['scheduled']); 
        $arrTime = convertToMySQLDateTime($flight['arrival']['scheduled']); 
        $price = 1000; //TODO: This should be decided by the agency 


         if ($arrTime <= $deptTime) {
        continue;
    }
        if ($airline === "empty" || $airline == NULL){
            $airline = "unknown"; 
        }
        echo  "$airline, $departureLoc, $arrivalLoc, $deptTime, $arrTime, $price";
        echo "<br>" ; 
        

        $stmt->bind_param('sssssi', 
        $airline, $departureLoc, $arrivalLoc, $deptTime, $arrTime, $price
        ); 
        // In your populateDatabase.php around line 64
        $stmt->execute();
    }
    $stmt->close(); 

 }

 function populateAccomodation($conn){
    $url = "https://tourism.api.opendatahub.com/v1/Accommodation"; 
    //Fetch from the API 
    $response = file_get_contents($url); 
    $data = json_decode($response, true); 
    $stmt = $conn->prepare('INSERT IGNORE INTO accommodations (Name, Type, Price_PN, Image) VALUES (?,?,?,?)'); 
     foreach ($data['Items'] as $item){
        if (isset($item['AccoDetail']['en']['Name'])) {
            $name = $item['AccoDetail']['en']['Name'];
        } else {
            $name = null;
        }

        if (isset($item['AccoType']['Id'])) {
            $type = $item['AccoType']['Id'];
        } else {
            $type = null;
        }

        $price = 1000;

        if (isset($item['ImageGallery'][0]['ImageUrl'])) {
            $image = $item['ImageGallery'][0]['ImageUrl'];
        } else {
            $image = null;
        }

        $stmt->bind_param('ssis', 
        $name, $type, $price, $image); 

        $stmt->execute(); 

     }
     $stmt->close(); 
 }

 
?> 
