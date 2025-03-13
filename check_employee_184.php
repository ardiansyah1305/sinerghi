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
    
    echo "<h1>Checking Employee ID 184 (NIP: 199205132023211019)</h1>";
    
    // Check basic employee data
    $stmt = $conn->prepare("SELECT * FROM pegawai WHERE id = 184");
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h2>Basic Employee Data:</h2>";
    echo "<pre>";
    print_r($employee);
    echo "</pre>";
    
    // Check unit_kerja data
    if ($employee && isset($employee['unit_kerja_id'])) {
        $stmt = $conn->prepare("SELECT * FROM unit_kerja WHERE id = ?");
        $stmt->execute([$employee['unit_kerja_id']]);
        $unitKerja = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h2>Unit Kerja Data:</h2>";
        echo "<pre>";
        print_r($unitKerja);
        echo "</pre>";
        
        // Check parent unit if exists
        if ($unitKerja && isset($unitKerja['parent_id']) && $unitKerja['parent_id']) {
            $stmt = $conn->prepare("SELECT * FROM unit_kerja WHERE id = ?");
            $stmt->execute([$unitKerja['parent_id']]);
            $parentUnit = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo "<h2>Parent Unit Data:</h2>";
            echo "<pre>";
            print_r($parentUnit);
            echo "</pre>";
        } else {
            echo "<p>No parent unit found or parent_id is NULL</p>";
        }
    }
    
    // Check jabatan data
    if ($employee && isset($employee['jabatan_id'])) {
        $stmt = $conn->prepare("SELECT * FROM jabatan WHERE id = ?");
        $stmt->execute([$employee['jabatan_id']]);
        $jabatan = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h2>Jabatan Data:</h2>";
        echo "<pre>";
        print_r($jabatan);
        echo "</pre>";
    }
    
    // Check status_pegawai data
    if ($employee && isset($employee['status_pegawai'])) {
        $stmt = $conn->prepare("SELECT * FROM status_pegawai WHERE kode = ?");
        $stmt->execute([$employee['status_pegawai']]);
        $statusPegawai = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h2>Status Pegawai Data:</h2>";
        echo "<pre>";
        print_r($statusPegawai);
        echo "</pre>";
    }
    
    // Check status_pernikahan data
    if ($employee && isset($employee['status_pernikahan'])) {
        $stmt = $conn->prepare("SELECT * FROM status_pernikahan WHERE kode = ?");
        $stmt->execute([$employee['status_pernikahan']]);
        $statusPernikahan = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h2>Status Pernikahan Data:</h2>";
        echo "<pre>";
        print_r($statusPernikahan);
        echo "</pre>";
    }
    
    // Check jenjang_pangkat data
    if ($employee && isset($employee['pangkat'])) {
        $stmt = $conn->prepare("SELECT * FROM jenjang_pangkat WHERE kode = ?");
        $stmt->execute([$employee['pangkat']]);
        $jenjangPangkat = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h2>Jenjang Pangkat Data:</h2>";
        echo "<pre>";
        print_r($jenjangPangkat);
        echo "</pre>";
    }
    
    // Check agama data
    if ($employee && isset($employee['agama'])) {
        $stmt = $conn->prepare("SELECT * FROM agama WHERE kode = ?");
        $stmt->execute([$employee['agama']]);
        $agama = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h2>Agama Data:</h2>";
        echo "<pre>";
        print_r($agama);
        echo "</pre>";
    }
    
    // Now let's fix the getDetailedPegawai method by modifying the query to handle NULL values
    echo "<h2>Proposed Fix:</h2>";
    echo "<p>The issue is likely with the LEFT JOIN on parent_unit. Let's modify the PegawaiModel.php file to handle NULL values properly.</p>";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
