<?php
include 'db_connection.php';

// List of your 13 node IDs
$nodes = [
    "ENV_001",    "ENV_002",    "ENV_003",    "ENV_004",    "ENV_005",
    "ENV_006",    "ENV_007",    "ENV_008",    "ENV_009",    "ENV_010",   
     "ENV_011",    "ENV_012",    "ENV_013"
];


// Random float generator
function rand_float($min, $max) {
    return round($min + mt_rand() / mt_getrandmax() * ($max - $min), 1);
}

function random_array($min, $max) {
    return [rand_float($min, $max), rand_float($min, $max), rand_float($min, $max)];
}

$stmt = $conn->prepare("INSERT INTO sensor_readings (node_id, timestamp, data) VALUES (?, ?, ?)");

foreach ($nodes as $node_id) {
    $data = [
        "node_id" => $node_id,
        "timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
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

    $json_data = json_encode($data);
    $timestamp = date("Y-m-d H:i:s", strtotime($data["timestamp"]));
    $stmt->bind_param("sss", $node_id, $timestamp, $json_data);

    if ($stmt->execute()) {
        echo "Inserted for $node_id<br>";
    } else {
        echo "Error for $node_id: " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();
?>

<script>
// Optional: Reload page every second for simulation
setTimeout(function() {
  location.reload();
}, 1000);
</script>
