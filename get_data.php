<?php
include 'db_connection.php';

$nodeId = isset($_GET['node_id']) ? $conn->real_escape_string($_GET['node_id']) : '';

$query = "SELECT timestamp, data  FROM sensor_readings";
if (!empty($nodeId)) {
    $query .= " WHERE node_id = '$nodeId'";
}
$query .= " ORDER BY timestamp DESC LIMIT 20";
//echo $query;
$result = $conn->query($query);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
