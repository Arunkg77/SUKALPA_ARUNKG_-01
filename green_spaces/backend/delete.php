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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"])) {
        $location_id = intval($_POST["id"]);

        $stmt = $conn->prepare("DELETE FROM locations WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $location_id);
            if ($stmt->execute()) {
                echo "Location deleted successfully!";
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(array('error' => 'Error deleting location: ' . $stmt->error));
            }
            $stmt->close();
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('error' => 'Error preparing statement: ' . $conn->error));
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Location ID not provided!'));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Invalid request method!'));
}

$conn->close();
?>
