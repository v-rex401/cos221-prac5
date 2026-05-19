<?php
 require_once __DIR__ . '/database.php';

 //Get the data from the js 
 $data = json_decode(file_get_contents('php://input'), true); 

 function populateDestinations() {
    //Get the things from data 
    $stmt = $conn->db->prepare('INSERT INTO destinations (Name, Country) VALUES (?,?) '); 
    foreach ($data as $c) {
        $stmt->bind_param('ss', $c['name'], $c['country']); 
        $stmt->execute(); 
    }
    $stmt->close(); 
    $conn->close(); 
 }

?> 