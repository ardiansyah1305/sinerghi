<?php

// Database configuration
$host = '192.168.10.157';
$dbname = 'kemenkopmk_db';
$username = 'sipd';
$password = 's1n3rgh1@';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully\n";

    // Check if username_ldap column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'username_ldap'");
    $columnExists = $stmt->fetch();

    if (!$columnExists) {
        echo "Adding username_ldap column...\n";
        $pdo->exec("ALTER TABLE users ADD COLUMN username_ldap VARCHAR(255) NULL AFTER pegawai_id");
        $pdo->exec("CREATE INDEX idx_username_ldap ON users(username_ldap)");
        echo "Column added successfully\n";
    } else {
        echo "username_ldap column already exists\n";
    }

    // Update users with empty username_ldap
    $stmt = $pdo->query("SELECT u.*, p.nip, p.nama 
                         FROM users u 
                         LEFT JOIN pegawai p ON u.pegawai_id = p.id 
                         WHERE u.username_ldap IS NULL OR u.username_ldap = ''");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nFound " . count($users) . " users to update\n";

    // Update each user's username_ldap based on their name
    foreach ($users as $user) {
        if (!empty($user['nama'])) {
            // Get first part of the name (before any comma or dot)
            $nameParts = preg_split('/[,.]/', $user['nama']);
            $firstName = trim($nameParts[0]);
            
            // Convert to lowercase and replace spaces with dots
            $username = strtolower(str_replace(' ', '.', $firstName));
            // Remove any special characters
            $username = preg_replace('/[^a-z0-9.]/', '', $username);
            
            echo "Updating user {$user['nama']} (NIP: {$user['nip']}) with username_ldap: $username\n";
            
            $updateStmt = $pdo->prepare("UPDATE users SET username_ldap = ? WHERE id = ?");
            $updateStmt->execute([$username, $user['id']]);
        } else {
            echo "Skipping user ID {$user['id']} - no name found\n";
        }
    }

    echo "\nAll updates completed successfully\n";

    // Show all users
    echo "\nAll users:\n";
    $stmt = $pdo->query("SELECT u.*, p.nip, p.nama 
                         FROM users u 
                         LEFT JOIN pegawai p ON u.pegawai_id = p.id");
    $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($allUsers as $user) {
        echo "ID: {$user['id']}, Nama: {$user['nama']}, NIP: {$user['nip']}, Username LDAP: {$user['username_ldap']}\n";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
