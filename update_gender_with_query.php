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
    
    echo "<h1>Gender Update Query</h1>";
    
    // Generate the SQL query for updating male employees (4th character from right = 1)
    $maleQuery = "UPDATE pegawai SET jenis_kelamin = '1' 
                 WHERE nip IS NOT NULL 
                 AND LENGTH(nip) >= 4 
                 AND SUBSTRING(nip, LENGTH(nip) - 3, 1) = '1'
                 AND deleted_at IS NULL";
    
    // Generate the SQL query for updating female employees (4th character from right != 1)
    $femaleQuery = "UPDATE pegawai SET jenis_kelamin = '2' 
                   WHERE nip IS NOT NULL 
                   AND LENGTH(nip) >= 4 
                   AND SUBSTRING(nip, LENGTH(nip) - 3, 1) != '1'
                   AND deleted_at IS NULL";
    
    // Display the queries
    echo "<h2>SQL Query for Male Employees (jenis_kelamin = '1'):</h2>";
    echo "<pre>{$maleQuery};</pre>";
    
    echo "<h2>SQL Query for Female Employees (jenis_kelamin = '2'):</h2>";
    echo "<pre>{$femaleQuery};</pre>";
    
    // Execute the queries
    echo "<h2>Executing Queries...</h2>";
    
    $conn->beginTransaction();
    
    // Update male employees
    $maleStmt = $conn->prepare($maleQuery);
    $maleStmt->execute();
    $maleCount = $maleStmt->rowCount();
    
    // Update female employees
    $femaleStmt = $conn->prepare($femaleQuery);
    $femaleStmt->execute();
    $femaleCount = $femaleStmt->rowCount();
    
    $conn->commit();
    
    echo "<p>Updated {$maleCount} male employees (jenis_kelamin = '1')</p>";
    echo "<p>Updated {$femaleCount} female employees (jenis_kelamin = '2')</p>";
    echo "<p>Total updated: " . ($maleCount + $femaleCount) . " employees</p>";
    
    // Display a sample of updated employees
    $sampleQuery = "SELECT id, nip, nama, jenis_kelamin, 
                   SUBSTRING(nip, LENGTH(nip) - 3, 1) AS gender_char 
                   FROM pegawai 
                   WHERE nip IS NOT NULL AND LENGTH(nip) >= 4 AND deleted_at IS NULL 
                   ORDER BY id LIMIT 20";
    
    $sampleStmt = $conn->query($sampleQuery);
    $samples = $sampleStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Sample of Updated Employees:</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>NIP</th><th>Nama</th><th>Gender Char</th><th>Jenis Kelamin</th></tr>";
    
    foreach ($samples as $sample) {
        echo "<tr>";
        echo "<td>{$sample['id']}</td>";
        echo "<td>{$sample['nip']}</td>";
        echo "<td>{$sample['nama']}</td>";
        echo "<td>{$sample['gender_char']}</td>";
        echo "<td>{$sample['jenis_kelamin']} (" . ($sample['jenis_kelamin'] == '1' ? 'Laki-laki' : 'Perempuan') . ")</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch(PDOException $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    echo "Error: " . $e->getMessage();
}
?>
