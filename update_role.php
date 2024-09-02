<?php
// Database connection details
$servername = "185.207.226.14";
$username = "pzdtck_brodefer_db";
$password = "*n2G-6e_HbgK9!W8"; // No password as per your setup
$dbname = "pzdtck_brodefer_db"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data sent via POST
$data = json_decode(file_get_contents('php://input'), true);
$playerId = $data['id'];
$roleId = $data['role_id'];

// SQL query to update the player's role
$sql = "UPDATE players SET role_id = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $roleId, $playerId);

$response = array();

// Execute the query and check for success
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

// Output the JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
