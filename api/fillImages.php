<?php
require_once __DIR__ . '/../includes/database.php';

$attractionImages = [
    'https://images.pexels.com/photos/1130281/pexels-photo-1130281.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/1480493/pexels-photo-1480493.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/7580501/pexels-photo-7580501.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/5778330/pexels-photo-5778330.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/1715546/pexels-photo-1715546.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/7580492/pexels-photo-7580492.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/8193051/pexels-photo-8193051.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/31091615/pexels-photo-31091615.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/27666775/pexels-photo-27666775.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/27666776/pexels-photo-27666776.jpeg?auto=compress&cs=tinysrgb&h=350',
];

$hotelImages = [
    'https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/258154/pexels-photo-258154.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/261102/pexels-photo-261102.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/2869215/pexels-photo-2869215.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/1134176/pexels-photo-1134176.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/3225531/pexels-photo-3225531.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/2096983/pexels-photo-2096983.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/1743229/pexels-photo-1743229.jpeg?auto=compress&cs=tinysrgb&h=350',
    'https://images.pexels.com/photos/594077/pexels-photo-594077.jpeg?auto=compress&cs=tinysrgb&h=350',
];

// Fill attractions
$result = $conn->query("SELECT Attraction_ID FROM tourist_attractions WHERE Image = '' OR Image IS NULL");
$stmt   = $conn->prepare("UPDATE tourist_attractions SET Image = ? WHERE Attraction_ID = ?");
while ($row = $result->fetch_assoc()) {
    $img = $attractionImages[array_rand($attractionImages)];
    $stmt->bind_param('si', $img, $row['Attraction_ID']);
    $stmt->execute();
}
$stmt->close();
echo "Attractions done!<br>";

// Fill accommodations
$result = $conn->query("SELECT Accommodation_ID FROM accommodations WHERE Image = '' OR Image IS NULL");
$stmt   = $conn->prepare("UPDATE accommodations SET Image = ? WHERE Accommodation_ID = ?");
while ($row = $result->fetch_assoc()) {
    $img = $hotelImages[array_rand($hotelImages)];
    $stmt->bind_param('si', $img, $row['Accommodation_ID']);
    $stmt->execute();
}
$stmt->close();
echo "Accommodations done!<br>";
