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

// Get username from POST request
$username = $_POST['username'];

// Insert player into the database with default role 'waiting'
$sql = "INSERT INTO players (username, cps, role_id) VALUES (?, 0, (SELECT id FROM roles WHERE role = 'waiting'))";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    $playerId = $stmt->insert_id;
    echo json_encode(['success' => true, 'id' => $playerId]);
} else {
    echo json_encode(['success' => false]);
}

// Close connection
$conn->close();
?>
