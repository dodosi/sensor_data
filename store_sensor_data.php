<?php
header('Content-Type: application/json');

include 'db_connection.php';
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

// Get raw JSON input from Postman
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Validate
if (!$data || !isset($data["node_id"]) || !isset($data["timestamp"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON input"]);
    exit;
}

// Prepare fields
$node_id = trim($data["node_id"]);
$timestamp = date("Y-m-d H:i:s", strtotime($data["timestamp"]));
$json_data = mysqli_real_escape_string($conn, json_encode($data));

// Insert into database
$sql = "INSERT INTO sensor_readings (node_id, timestamp, data)
        VALUES ('$node_id', '$timestamp', '$json_data')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true, "message" => "Data stored"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
