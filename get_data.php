<?php
$mysqli = new mysqli("localhost", "root", "", "cmu_ur");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$nodeId = isset($_GET['node_id']) ? $mysqli->real_escape_string($_GET['node_id']) : '';

$query = "SELECT timestamp, data  FROM sensor_readings";
if (!empty($nodeId)) {
    $query .= " WHERE node_id = '$nodeId'";
}
$query .= " ORDER BY timestamp DESC LIMIT 20";
//echo $query;
$result = $mysqli->query($query);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
