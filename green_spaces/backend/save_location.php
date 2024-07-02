<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "green_spaces";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = isset($_POST["latitude"]) ? $_POST["latitude"] : null;
    $longitude = isset($_POST["longitude"]) ? $_POST["longitude"] : null;
    $description = isset($_POST["description"]) ? $_POST["description"] : null;

    if ($latitude !== null && $longitude !== null && $description !== null) {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('error' => 'Failed to connect to the database'));
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO locations (latitude, longitude, description) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("dds", $latitude, $longitude, $description);
            if ($stmt->execute()) {
                echo "Location saved successfully!";
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(array('error' => 'Error: ' . $stmt->error));
            }
            $stmt->close();
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('error' => 'Error preparing statement: ' . $conn->error));
        }

        $conn->close();
    } else {
        http_response_code(400); // Bad Request
        echo "Error: Missing required fields!";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Error: Invalid request method!";
}
?>
