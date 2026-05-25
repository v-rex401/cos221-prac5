<?php
require_once __DIR__ . '/../includes/database.php';

$url = "https://api.exchangerate-api.com/v4/latest/USD";
$response = file_get_contents($url);
$data = json_decode($response, true);
return $data;
