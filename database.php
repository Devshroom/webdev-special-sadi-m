<?php
// Database connection settings
$servername = "185.207.226.14";
$username = "pzdtck_brodefer_db";
$password = "*n2G-6e_HbgK9!W8"; // No password as per your setup
$dbname = "pzdtck_brodefer_db";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query to fetch cps values for player1 and player2
    $stmt = $pdo->prepare("SELECT role, cps FROM roles WHERE role IN ('player1', 'player2')");
    $stmt->execute();

    // Fetch the results
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the output array
    $output = [];
    foreach ($roles as $role) {
        $output[$role['role']] = $role['cps'];
    }

    // Set the header to return JSON content
    header('Content-Type: application/json');

    // Encode the data to JSON and output it
    echo json_encode($output);

} catch (PDOException $e) {
    // In case of error, return a JSON error message
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
