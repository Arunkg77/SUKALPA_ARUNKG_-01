<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chatbox";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $message);
    $stmt->execute();
    $stmt->close();
} else {
    $sql = "SELECT * FROM messages ORDER BY timestamp DESC";
    $result = $conn->query($sql);

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
}

$conn->close();
?>
