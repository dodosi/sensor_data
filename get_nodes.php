<?php
$host = 'localhost';
$db   = 'cmu_ur';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DISTINCT node_id FROM sensor_readings ORDER BY node_id ASC";
$result = $conn->query($sql);

$nodes = [];
while ($row = $result->fetch_assoc()) {
    $nodes[] = $row['node_id'];
}

echo json_encode($nodes);
$conn->close();
?>
