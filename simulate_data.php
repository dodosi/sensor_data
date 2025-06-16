<?php
// simulate_data.php

$host = 'localhost';
$db   = 'cmu_ur';
$user = 'root'; // replace with your DB username
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a random float between min and max with 1 decimal place
function rand_float($min, $max) {
    return round($min + mt_rand() / mt_getrandmax() * ($max - $min), 1);
}

// Generate random arrays for temperature and humidity sensors (3 readings each)
function random_array($min, $max) {
    return [rand_float($min, $max), rand_float($min, $max), rand_float($min, $max)];
}

$data = [
    "node_id" => "ENV_001",
    "timestamp" => gmdate("Y-m-d\TH:i:s\Z"), // UTC ISO8601 format
    "temperature" => [
        "aht20" => random_array(24.0, 27.0),
        "sht31" => random_array(24.0, 27.0),
        "bme280" => random_array(24.0, 27.0),
        "htu21" => random_array(24.0, 27.0),
    ],
    "humidity" => [
        "aht20" => random_array(60.0, 70.0),
        "sht31" => random_array(60.0, 70.0),
        "bme280" => random_array(60.0, 70.0),
        "htu21" => random_array(60.0, 70.0),
    ],
    "pressure" => [rand_float(1010, 1020), rand_float(1010, 1020), rand_float(1010, 1020)],
    "wind" => [
        "speed" => rand_float(0, 10),
        "direction" => rand_float(0, 360)
    ],
    "rain" => [
        "intensity" => rand_float(0, 5),
        "volume" => rand_float(0, 50)
    ]
];

// Prepare statement
$stmt = $conn->prepare("INSERT INTO sensor_readings (node_id, timestamp, data) VALUES (?, ?, ?)");

$json_data = json_encode($data);
$node_id = $data["node_id"];
$timestamp = date("Y-m-d H:i:s", strtotime($data["timestamp"]));

$stmt->bind_param("sss", $node_id, $timestamp, $json_data);

if ($stmt->execute()) {
    echo "New sensor data inserted successfully.\n";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
<script>
  // Refresh the page every 60,000 milliseconds (1 minute)
  setTimeout(function() {
    location.reload();
  }, 1000);
</script>