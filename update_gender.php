<?php
// Database connection settings from the memory
$host = '192.168.10.157';
$dbname = 'kemenkopmk_db';
$username = 'sipd';
$password = 's1n3rgh1@';

// Initialize log file
$logFile = 'gender_update_log.txt';
file_put_contents($logFile, "Gender Update Log - " . date('Y-m-d H:i:s') . "\n\n");

// Function to log messages
function logMessage($message, $logFile) {
    file_put_contents($logFile, $message . "\n", FILE_APPEND);
    echo $message . "<br>";
}

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    logMessage("Connected to database successfully", $logFile);
    
    // Get all employees
    $stmt = $conn->query("SELECT id, nip FROM pegawai WHERE deleted_at IS NULL");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $totalEmployees = count($employees);
    logMessage("Found {$totalEmployees} employees to process", $logFile);
    
    $updated = 0;
    $skipped = 0;
    $errors = [];
    
    // Process each employee
    foreach ($employees as $employee) {
        try {
            $nip = $employee['nip'];
            
            // Skip if NIP is empty or null
            if (empty($nip)) {
                logMessage("Skipping employee ID {$employee['id']} - NIP is empty or null", $logFile);
                $skipped++;
                continue;
            }
            
            // Check if NIP has at least 4 characters
            if (strlen($nip) >= 4) {
                // Get the 4th character from the right
                $genderChar = substr($nip, -4, 1);
                
                // Determine gender (1 for male, 2 for female)
                $gender = ($genderChar == '1') ? 'L' : 'P';
                
                // Update the employee record with explicit commit
                $conn->beginTransaction();
                $updateStmt = $conn->prepare("UPDATE pegawai SET jenis_kelamin = ? WHERE id = ?");
                $result = $updateStmt->execute([$gender, $employee['id']]);
                
                if ($result) {
                    $conn->commit();
                    $updated++;
                    logMessage("Updated employee ID {$employee['id']} (NIP: {$nip}) with gender: {$gender}", $logFile);
                } else {
                    $conn->rollBack();
                    $errorMsg = "Failed to update employee ID {$employee['id']} - database error";
                    $errors[] = $errorMsg;
                    logMessage("ERROR: " . $errorMsg, $logFile);
                }
            } else {
                $errorMsg = "Employee ID {$employee['id']} has an invalid NIP format: {$nip}";
                $errors[] = $errorMsg;
                logMessage("ERROR: " . $errorMsg, $logFile);
            }
        } catch (Exception $e) {
            if (isset($conn) && $conn->inTransaction()) {
                $conn->rollBack();
            }
            $errorMsg = "Error updating employee ID {$employee['id']}: " . $e->getMessage();
            $errors[] = $errorMsg;
            logMessage("ERROR: " . $errorMsg, $logFile);
        }
    }
    
    // Verify the updates
    $verifyStmt = $conn->query("SELECT COUNT(*) as count FROM pegawai WHERE jenis_kelamin IN ('L', 'P') AND deleted_at IS NULL");
    $verifyResult = $verifyStmt->fetch(PDO::FETCH_ASSOC);
    $verifiedCount = $verifyResult['count'];
    
    // Display summary
    logMessage("\n--- Update Summary ---", $logFile);
    logMessage("Total employees: {$totalEmployees}", $logFile);
    logMessage("Total records updated: {$updated}", $logFile);
    logMessage("Total records skipped: {$skipped}", $logFile);
    logMessage("Total errors: " . count($errors), $logFile);
    logMessage("Verified records with gender set: {$verifiedCount}", $logFile);
    
    if (count($errors) > 0) {
        logMessage("\n--- Error Details ---", $logFile);
        foreach ($errors as $index => $error) {
            logMessage(($index + 1) . ". {$error}", $logFile);
        }
    }
    
} catch(PDOException $e) {
    $errorMsg = "Connection failed: " . $e->getMessage();
    logMessage("CRITICAL ERROR: " . $errorMsg, $logFile);
    echo "Connection failed: " . $e->getMessage();
}

// Add HTML for better display in browser
echo "<hr>";
echo "<p>Log file saved to: <strong>{$logFile}</strong></p>";
echo "<p><a href='gender_update_log.txt' target='_blank'>View Log File</a></p>";
?>
