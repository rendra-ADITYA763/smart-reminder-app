<?php
header('Content-Type: application/json');

// Get coordinates from request or use default (Jakarta)
$lat = isset($_GET['lat']) ? $_GET['lat'] : '-6.2088';
$lon = isset($_GET['lon']) ? $_GET['lon'] : '106.8456';

$apiUrl = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone=auto";

// Fetch data from external API
$response = file_get_contents($apiUrl);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch weather data']);
} else {
    echo $response;
}
?>
