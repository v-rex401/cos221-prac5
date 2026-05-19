<?php


function getDestinations($conn, $data) {
    //Get the things from data 
    $stmt = $conn->db->prepare('SELECT * FROM destinations'); 
    $stmt->execute(); 
    $results = []; 
    
    $stmt->close(); 
    $conn->close(); 
 }

 ?>