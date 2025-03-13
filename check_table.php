<?php
// Database connection settings
$host = '192.168.10.157';
$dbname = 'kemenkopmk_db';
$username = 'sipd';
$password = 's1n3rgh1@';

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to get table structure
    $stmt = $conn->query("DESCRIBE status_pernikahan");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Structure of status_pernikahan table:</h2>";
    echo "<pre>";
    print_r($columns);
    echo "</pre>";
    
    // Get sample data
    $dataStmt = $conn->query("SELECT * FROM status_pernikahan LIMIT 5");
    $sampleData = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Sample data from status_pernikahan table:</h2>";
    echo "<pre>";
    print_r($sampleData);
    echo "</pre>";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
