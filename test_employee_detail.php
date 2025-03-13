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
    
    // Test the fixed query for employee ID 184
    $query = "
        SELECT 
            pegawai.*,
            jabatan.nama_jabatan,
            unit_kerja.nama_unit_kerja,
            parent_unit.nama_unit_kerja AS parent_unit_name,
            status_pegawai.nama_status AS status_pegawai_nama,
            IFNULL(status_pernikahan.status, '-') AS status_pernikahan_nama,
            IFNULL(jenjang_pangkat.nama_pangkat, '-') AS nama_pangkat,
            IFNULL(agama.nama_agama, '-') AS nama_agama
        FROM pegawai
        LEFT JOIN jabatan ON pegawai.jabatan_id = jabatan.id
        LEFT JOIN unit_kerja ON pegawai.unit_kerja_id = unit_kerja.id
        LEFT JOIN unit_kerja AS parent_unit ON unit_kerja.parent_id = parent_unit.id
        LEFT JOIN status_pegawai ON pegawai.status_pegawai = status_pegawai.kode
        LEFT JOIN status_pernikahan ON pegawai.status_pernikahan = status_pernikahan.kode
        LEFT JOIN jenjang_pangkat ON pegawai.pangkat = jenjang_pangkat.kode
        LEFT JOIN agama ON pegawai.agama = agama.kode
        WHERE pegawai.id = 184
    ";
    
    $stmt = $conn->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h1>Testing Fixed Query for Employee ID 184</h1>";
    
    if ($result) {
        echo "<div style='background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>";
        echo "<h3>✅ Query successful! Employee details retrieved.</h3>";
        echo "</div>";
        
        echo "<h2>Employee Details:</h2>";
        echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        echo "<tr><td>Name</td><td>{$result['nama']}</td></tr>";
        echo "<tr><td>NIP</td><td>{$result['nip']}</td></tr>";
        echo "<tr><td>Gender</td><td>" . ($result['jenis_kelamin'] == '1' ? 'Laki-laki' : 'Perempuan') . "</td></tr>";
        echo "<tr><td>Birth Date</td><td>{$result['tanggal_lahir']}</td></tr>";
        echo "<tr><td>Position</td><td>{$result['nama_jabatan']}</td></tr>";
        echo "<tr><td>Unit</td><td>{$result['nama_unit_kerja']}</td></tr>";
        echo "<tr><td>Parent Unit</td><td>{$result['parent_unit_name']}</td></tr>";
        echo "<tr><td>Employee Status</td><td>{$result['status_pegawai_nama']}</td></tr>";
        echo "<tr><td>Marital Status</td><td>{$result['status_pernikahan_nama']}</td></tr>";
        echo "<tr><td>Rank</td><td>{$result['nama_pangkat']}</td></tr>";
        echo "<tr><td>Religion</td><td>{$result['nama_agama']}</td></tr>";
        echo "</table>";
        
        echo "<h2>Raw Data:</h2>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } else {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
        echo "<h3>❌ Query failed! No employee found.</h3>";
        echo "</div>";
    }
    
} catch(PDOException $e) {
    echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h3>❌ Error: " . $e->getMessage() . "</h3>";
    echo "</div>";
}
?>
