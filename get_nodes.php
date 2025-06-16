<?php
include 'db_connection.php';

$sql = "SELECT DISTINCT node_id FROM sensor_readings ORDER BY node_id ASC";
$result = $conn->query($sql);

$nodes = [];
while ($row = $result->fetch_assoc()) {
    $nodes[] = $row['node_id'];
}

echo json_encode($nodes);
$conn->close();
?>
