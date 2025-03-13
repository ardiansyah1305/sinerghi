<?php

$host = '192.168.10.157';
$dbname = 'kemenkopmk_db';
$username = 'sipd';
$password = 's1n3rgh1@';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Successfully connected to the database\n";

    // Get users table structure
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nUsers table structure:\n";
    foreach ($columns as $column) {
        echo str_pad($column['Field'], 20) . " | " . 
             str_pad($column['Type'], 15) . " | " . 
             str_pad($column['Null'], 5) . " | " . 
             str_pad($column['Key'], 5) . " | " . 
             $column['Default'] . "\n";
    }

    // Get sample user data (first 5 rows)
    $stmt = $pdo->query("SELECT * FROM users LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nSample user data (first 5 rows):\n";
    if (count($users) > 0) {
        // Print column headers
        echo implode(" | ", array_keys($users[0])) . "\n";
        echo str_repeat("-", 100) . "\n";
        
        // Print data rows
        foreach ($users as $user) {
            echo implode(" | ", array_map(function($value) {
                return substr((string)$value, 0, 30);
            }, $user)) . "\n";
        }
    } else {
        echo "No users found in the table\n";
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
