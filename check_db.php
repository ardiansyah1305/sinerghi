<?php
// Database connection
$db = new PDO('mysql:host=localhost;dbname=kemenkopmk_db', 'root', 's1n3rgh1@');

// Check usulan table structure
echo "Database structure check for usulan table:\n";
$stmt = $db->query('DESCRIBE usulan');
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . $row['Null'] . "\n";
}

// Check catatan_usulan table structure
echo "\nDatabase structure check for catatan_usulan table:\n";
$stmt = $db->query('DESCRIBE catatan_usulan');
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . $row['Null'] . "\n";
}
