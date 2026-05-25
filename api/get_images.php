<?php
header('Content-Type: application/json');

$query     = $_GET['query'] ?? '';
$pexelsKey = "e2Xsrlja3B2PSS75BMF7OrFDQNcsFMsuVJJi9sQYmUVzvEsjahAie3Mo";

if (empty($query)) {
    echo json_encode([]);
    exit;
}

$url = "https://api.pexels.com/v1/search?"
    . "query=" . urlencode($query . ' travel')
    . "&per_page=10";

$context  = stream_context_create(['http' => ['header' => "Authorization: " . $pexelsKey]]);
$response = file_get_contents($url, false, $context);
$data     = json_decode($response, true);

$urls = array_map(fn($p) => $p['src']['large'], $data['photos'] ?? []);
echo json_encode($urls);
