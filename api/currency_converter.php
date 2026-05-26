<?php
header('Content-Type: application/json');

$base     = $_GET['base'] ?? 'USD';
$cacheFile = __DIR__ . "/rates_cache_{$base}.json";

// Cache for 1 hour so you don't hammer the API
if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 3600) {
    echo file_get_contents($cacheFile);
    exit;
}

$url      = "https://api.exchangerate-api.com/v4/latest/{$base}";
$response = file_get_contents($url);

if (!$response) {
    echo json_encode(['error' => 'Failed to fetch rates']);
    exit;
}

file_put_contents($cacheFile, $response);
echo $response;
