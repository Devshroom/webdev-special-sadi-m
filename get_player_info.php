<?php
// Database credentials
$servername = "185.207.226.14";
$username = "pzdtck_brodefer_db";
$password = "*n2G-6e_HbgK9!W8"; // No password as per your setup
$dbname = "pzdtck_brodefer_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get player ID from GET request
$playerId = $_GET['id'];

// Retrieve player information
$sql = "SELECT username, id, cps FROM players WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $playerId);
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc();

if ($player) {
    echo json_encode($player);
} else {
    echo json_encode(['username' => 'Unknown', 'id' => 'Unknown', 'cps' => 0]);
}

// Close connection
$conn->close();
?>
