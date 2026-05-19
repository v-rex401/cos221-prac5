<?php


function getDestinations($conn, $data) {
    //Get the things from data 
    $stmt = $conn->prepare('SELECT * FROM destinations'); 
    $stmt->execute(); 
    $results = []; 
    
    $stmt->close(); 
    $conn->close(); 
 }


 function setPackage($conn, $data){
    $stmt = $conn->prepare('INSERT IGNORE INTO packages (Agency_ID, Name, Price, Description, Duration)
    VALUES (?,?,?,?,?)'); 
      $stmt->bind_param('isisi', 
      $data['agency_id'],
      $data['packageName'],
      $data['price'],
      $data['duration'],
      $data['description']
    ); 
    $stmt->execute(); 

    //Then get the id from the table and then add to other tables 
 }

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $body = json_decode(file_get_contents('php://input'), true);
    require_once __DIR__ . '/../../includes/database.php';

    if ($body['type'] === 'setPackage') {
        echo json_encode(setPackage($conn, $body['data']));
    }
    exit;
}
 ?>