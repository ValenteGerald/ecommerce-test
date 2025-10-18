<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Load .env
$env = parse_ini_file(__DIR__ . '/../.env');
$token = $env['INVOLVE_API_TOKEN'];

// Involve Asia API endpoint
$url = "https://api.involve.asia/publisher/products/category-list"; // correct category endpoint

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "Accept: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute request
$response = curl_exec($ch);
curl_close($ch);

// Return the API response directly
echo $response;
?>
