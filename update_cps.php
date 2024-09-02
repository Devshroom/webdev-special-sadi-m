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

// Get player ID and CPS from POST request
$playerId = $_POST['id'];
$cps = $_POST['cps'];

// Start a transaction
$conn->begin_transaction();

try {
    // Update player CPS
    $sql = "UPDATE players SET cps = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $cps, $playerId);
    $stmt->execute();

    // Get the role_id for the player
    $sql = "SELECT role_id FROM players WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $player = $result->fetch_assoc();
    $role_id = $player['role_id'];

    // Fetch the role name from roles table
    $sql = "SELECT role FROM roles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $role = $result->fetch_assoc();
    $roleName = $role['role'];

    // Update role CPS
    if ($roleName) {
        $sql = "UPDATE roles SET cps = ? WHERE role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ds", $cps, $roleName);
        $stmt->execute();
    }

    // Commit the transaction
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'CPS updated successfully']);
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Close connection
$conn->close();
?>
