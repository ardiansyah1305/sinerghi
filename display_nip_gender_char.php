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
    
    // Get all employees with non-empty NIPs
    $stmt = $conn->query("SELECT id, nip, nama, jenis_kelamin FROM pegawai WHERE nip IS NOT NULL AND nip != '' AND deleted_at IS NULL ORDER BY id");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // HTML header
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>NIP Gender Character Analysis</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            tr:nth-child(even) { background-color: #f9f9f9; }
            .highlight { background-color: #ffffcc; font-weight: bold; }
        </style>
    </head>
    <body>
        <h1>NIP Gender Character Analysis</h1>
        <p>Displaying the 4th character from the right of each NIP, which determines gender:</p>
        <table>
            <tr>
                <th>ID</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>4th Char from Right</th>
                <th>Gender Value</th>
                <th>Current DB Value</th>
            </tr>";
    
    $maleCount = 0;
    $femaleCount = 0;
    $mismatchCount = 0;
    
    // Process and display each employee
    foreach ($employees as $employee) {
        $nip = $employee['nip'];
        $genderChar = '';
        $genderValue = '';
        $rowClass = '';
        
        // Get the 4th character from the right if NIP has at least 4 characters
        if (strlen($nip) >= 4) {
            $genderChar = substr($nip, -4, 1);
            $genderValue = ($genderChar == '1') ? 'L' : 'P';
            
            // Count genders
            if ($genderValue == 'L') {
                $maleCount++;
            } else {
                $femaleCount++;
            }
            
            // Check for mismatches with database
            if ($genderValue != $employee['jenis_kelamin']) {
                $rowClass = 'highlight';
                $mismatchCount++;
            }
        }
        
        echo "<tr class='{$rowClass}'>
            <td>{$employee['id']}</td>
            <td>{$nip}</td>
            <td>{$employee['nama']}</td>
            <td>{$genderChar}</td>
            <td>{$genderValue}</td>
            <td>{$employee['jenis_kelamin']}</td>
        </tr>";
    }
    
    // Close table and add summary
    echo "</table>
        <h2>Summary</h2>
        <p>Total Employees: " . count($employees) . "</p>
        <p>Male (based on NIP): {$maleCount}</p>
        <p>Female (based on NIP): {$femaleCount}</p>
        <p>Mismatches with Database: {$mismatchCount}</p>
    </body>
    </html>";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
