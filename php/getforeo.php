<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$url = "https://assets.foreo.com/files/static/2019-07/NEW-_US-_FEED_-_new_feed.xml?WexkDZQwFaxqIJE_Ik7XbzT70VeqoCsC";

// Use cURL to fetch XML
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

// Validate response
if (!$response || stripos($response, '<rss') === false) {
    echo json_encode(["error" => "Invalid or empty XML response."]);
    exit;
}

// Parse XML
$xml = @simplexml_load_string($response);
if ($xml === false) {
    echo json_encode(["error" => "Failed to parse XML feed."]);
    exit;
}

// Extract specific fields
$items = [];
foreach ($xml->channel->item as $item) {
    $items[] = [
        "id" => (string) $item->id,
        "price" => (string) $item->price,
        "link" => (string) $item->link,
        "image_url" => (string) $item->image_link,
        "sale_price" => (string) $item->sale_price,
        "description" => (string) $item->description,
        "availability" => (string) $item->availability
    ];
}

// Return clean JSON
echo json_encode(["products" => $items], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
