<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "green_spaces";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Failed to connect to the database'));
    exit();
}

$sql = "SELECT id, latitude, longitude, description FROM locations";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Failed to retrieve locations from the database'));
    exit();
}

$locations = array();
while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($locations);
?>
