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

// Get the sort role and search IDs from the query parameters
$sortRole = isset($_GET['sort_role']) ? $_GET['sort_role'] : 'all';
$searchIds = isset($_GET['search_ids']) ? $_GET['search_ids'] : '';

// SQL query to fetch IDs, usernames, and role names from the players and roles tables
$sql = "SELECT players.id, players.username, roles.role 
        FROM players 
        JOIN roles ON players.role_id = roles.id 
        WHERE 1=1"; // Always true to simplify appending conditions

// Add filtering by IDs if search IDs are provided
if (!empty($searchIds)) {
    $ids = array_map('intval', explode(',', $searchIds));
    $idsList = implode(',', $ids);
    $sql .= " AND players.id IN ($idsList)";
}

// Add sorting based on the selected category
if ($sortRole === 'active') {
    $sql .= " AND roles.role IN ('player1', 'player2')";
} elseif ($sortRole === 'waiting') {
    $sql .= " AND roles.role = 'waiting'";
}

$sql .= " ORDER BY players.id"; // Sort by player ID as a secondary sort criterion

$result = $conn->query($sql);

$players = array();

// Fetch the result as an associative array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $players[] = $row;
    }
}

// Output the JSON data
header('Content-Type: application/json');
echo json_encode($players);

// Close the connection
$conn->close();
?>
