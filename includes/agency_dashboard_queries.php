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
    ); 
    $stmt->execute(); 

    //Then get the id from the table and then add to other tables 
 }
 ?>