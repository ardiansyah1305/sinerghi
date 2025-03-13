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
    
    echo "<h1>Birthdate Update from NIP</h1>";
    
    // Get all employees with non-empty NIPs
    $stmt = $conn->query("SELECT id, nip, nama, tanggal_lahir FROM pegawai WHERE nip IS NOT NULL AND nip != '' AND deleted_at IS NULL");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $totalEmployees = count($employees);
    $updated = 0;
    $skipped = 0;
    $errors = [];
    
    // Generate the SQL query template for updating birthdate
    $updateQuery = "UPDATE pegawai SET tanggal_lahir = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    
    // Process each employee
    foreach ($employees as $employee) {
        try {
            $nip = $employee['nip'];
            
            // Skip if NIP is less than 8 characters
            if (strlen($nip) < 8) {
                $errors[] = "Employee ID {$employee['id']} (NIP: {$nip}) - NIP too short, needs at least 8 characters";
                $skipped++;
                continue;
            }
            
            // Extract date components from NIP
            $year = substr($nip, 0, 4);
            $month = substr($nip, 4, 2);
            $day = substr($nip, 6, 2);
            
            // Validate date components
            if (!is_numeric($year) || !is_numeric($month) || !is_numeric($day)) {
                $errors[] = "Employee ID {$employee['id']} (NIP: {$nip}) - Invalid date components: Year={$year}, Month={$month}, Day={$day}";
                $skipped++;
                continue;
            }
            
            // Validate month (1-12)
            if ($month < 1 || $month > 12) {
                $errors[] = "Employee ID {$employee['id']} (NIP: {$nip}) - Invalid month: {$month}";
                $skipped++;
                continue;
            }
            
            // Validate day (1-31)
            if ($day < 1 || $day > 31) {
                $errors[] = "Employee ID {$employee['id']} (NIP: {$nip}) - Invalid day: {$day}";
                $skipped++;
                continue;
            }
            
            // Format date as YYYY-MM-DD
            $birthdate = "{$year}-{$month}-{$day}";
            
            // Validate if it's a valid date
            $dateObj = DateTime::createFromFormat('Y-m-d', $birthdate);
            if (!$dateObj || $dateObj->format('Y-m-d') !== $birthdate) {
                $errors[] = "Employee ID {$employee['id']} (NIP: {$nip}) - Invalid date: {$birthdate}";
                $skipped++;
                continue;
            }
            
            // Update the employee record
            $updateStmt->execute([$birthdate, $employee['id']]);
            $updated++;
            
            echo "<p>Updated employee ID {$employee['id']} (NIP: {$nip}, Name: {$employee['nama']}) - Birthdate: {$birthdate}</p>";
        } catch (Exception $e) {
            $errors[] = "Error updating employee ID {$employee['id']} (NIP: {$nip}): " . $e->getMessage();
            $skipped++;
        }
    }
    
    // Display summary
    echo "<h2>Update Summary</h2>";
    echo "<p>Total employees processed: {$totalEmployees}</p>";
    echo "<p>Successfully updated: {$updated}</p>";
    echo "<p>Skipped: {$skipped}</p>";
    
    // Generate the SQL query for reference
    $sqlQuery = "UPDATE pegawai 
                SET tanggal_lahir = CONCAT(
                    SUBSTRING(nip, 1, 4), '-',
                    SUBSTRING(nip, 5, 2), '-',
                    SUBSTRING(nip, 7, 2)
                )
                WHERE nip IS NOT NULL 
                AND LENGTH(nip) >= 8
                AND deleted_at IS NULL
                AND SUBSTRING(nip, 5, 2) BETWEEN '01' AND '12'
                AND SUBSTRING(nip, 7, 2) BETWEEN '01' AND '31'";
    
    echo "<h2>Equivalent SQL Query:</h2>";
    echo "<pre>{$sqlQuery};</pre>";
    
    // Display a sample of updated employees
    $sampleQuery = "SELECT id, nip, nama, tanggal_lahir FROM pegawai 
                   WHERE nip IS NOT NULL AND LENGTH(nip) >= 8 AND deleted_at IS NULL 
                   ORDER BY id LIMIT 20";
    
    $sampleStmt = $conn->query($sampleQuery);
    $samples = $sampleStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Sample of Updated Employees:</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>NIP</th><th>Nama</th><th>Tanggal Lahir</th></tr>";
    
    foreach ($samples as $sample) {
        echo "<tr>";
        echo "<td>{$sample['id']}</td>";
        echo "<td>{$sample['nip']}</td>";
        echo "<td>{$sample['nama']}</td>";
        echo "<td>{$sample['tanggal_lahir']}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Display errors if any
    if (count($errors) > 0) {
        echo "<h2>Errors:</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>{$error}</li>";
        }
        echo "</ul>";
    }
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
