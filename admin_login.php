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

// Get the username and password from the POST request
$adminUsername = $_POST['username'];
$adminPassword = $_POST['password'];

// SQL query to check if the admin credentials are correct
$sql = "SELECT * FROM admins WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $adminUsername, $adminPassword);
$stmt->execute();
$result = $stmt->get_result();

$response = array();
if ($result->num_rows > 0) {
    // Successful login
    $response['success'] = true;
} else {
    // Failed login
    $response['success'] = false;
}

// Output the JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the connection
$stmt->close();
$conn->close();
?>
