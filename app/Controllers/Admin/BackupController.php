<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

/**
 * Class BackupController
 * Handles backup and restore functionality for the application
 */
class BackupController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
        helper(['security', 'form', 'url', 'auth', 'encrypt']);
    }

    /**
     * Display backup management page
     */
    public function index()
    {
        if (!session()->get('isAdmin')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $backupDir = WRITEPATH . 'backups';
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $backupFiles = [];
        $files = glob($backupDir . '/*.sql');
        
        if ($files) {
            foreach ($files as $file) {
                $backupFiles[] = [
                    'name' => basename($file),
                    'size' => $this->formatSize(filesize($file)),
                    'date' => date('Y-m-d H:i:s', filemtime($file))
                ];
            }
        }

        return view('admin/backup/index', [
            'backupFiles' => $backupFiles
        ]);
    }

    /**
     * Create a backup of the database
     */
    public function create()
    {
        if (!session()->get('isAdmin')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Anda tidak memiliki izin untuk melakukan backup.');
        }

        try {
            // Create backup directory if it doesn't exist
            $backupDir = WRITEPATH . 'backups';
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Create backup of relevant tables
            $tables = ['usulan', 'jadwal', 'pegawai', 'unit_kerja', 'users', 'roles'];
            $timestamp = date('Y-m-d_H-i-s');
            $backupFile = $backupDir . '/backup_' . $timestamp . '.sql';
            
            $output = '';
            foreach ($tables as $table) {
                // Get table structure
                $query = $this->db->query("SHOW CREATE TABLE {$table}");
                $row = $query->getRow();
                if (!$row) {
                    continue; // Skip if table doesn't exist
                }
                
                $createTableSql = $row->{'Create Table'};
                $output .= "DROP TABLE IF EXISTS `{$table}`;\n{$createTableSql};\n\n";
                
                // Get table data
                $query = $this->db->query("SELECT * FROM {$table}");
                $rows = $query->getResultArray();
                
                if (!empty($rows)) {
                    $output .= "INSERT INTO `{$table}` VALUES ";
                    $values = [];
                    
                    foreach ($rows as $row) {
                        $rowValues = [];
                        foreach ($row as $value) {
                            if ($value === null) {
                                $rowValues[] = 'NULL';
                            } else {
                                $rowValues[] = $this->db->escape($value);
                            }
                        }
                        $values[] = '(' . implode(', ', $rowValues) . ')';
                    }
                    
                    $output .= implode(",\n", $values) . ";\n\n";
                }
            }
            
            // Write backup to file
            file_put_contents($backupFile, $output);
            
            return redirect()->to(base_url('admin/backup'))->with('success', 'Backup berhasil dibuat: ' . basename($backupFile));
        } catch (\Exception $e) {
            log_message('error', 'Backup error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/backup'))->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }
    
    /**
     * Restore from a backup file
     */
    public function restore()
    {
        if (!session()->get('isAdmin')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Anda tidak memiliki izin untuk melakukan restore.');
        }
        
        $backupFile = $this->request->getPost('backup_file');
        if (empty($backupFile)) {
            return redirect()->to(base_url('admin/backup'))->with('error', 'File backup tidak ditemukan.');
        }
        
        try {
            // Validate backup file path to prevent directory traversal
            $backupDir = WRITEPATH . 'backups/';
            $fullPath = realpath($backupDir . basename($backupFile));
            
            if (!$fullPath || strpos($fullPath, $backupDir) !== 0 || !file_exists($fullPath)) {
                return redirect()->to(base_url('admin/backup'))->with('error', 'File backup tidak valid.');
            }
            
            // Execute SQL from backup file
            $sql = file_get_contents($fullPath);
            $queries = explode(';', $sql);
            
            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    $this->db->query($query);
                }
            }
            
            return redirect()->to(base_url('admin/backup'))->with('success', 'Restore berhasil dilakukan dari file: ' . basename($backupFile));
        } catch (\Exception $e) {
            log_message('error', 'Restore error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/backup'))->with('error', 'Gagal melakukan restore: ' . $e->getMessage());
        }
    }
    
    /**
     * Download a backup file
     */
    public function download($filename = null)
    {
        if (!session()->get('isAdmin')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Anda tidak memiliki izin untuk mengunduh backup.');
        }
        
        if (empty($filename)) {
            return redirect()->to(base_url('admin/backup'))->with('error', 'File backup tidak ditemukan.');
        }
        
        // Validate filename to prevent directory traversal
        $backupDir = WRITEPATH . 'backups/';
        $fullPath = realpath($backupDir . basename($filename));
        
        if (!$fullPath || strpos($fullPath, $backupDir) !== 0 || !file_exists($fullPath)) {
            return redirect()->to(base_url('admin/backup'))->with('error', 'File backup tidak valid.');
        }
        
        return $this->response->download($fullPath, null);
    }
    
    /**
     * Delete a backup file
     */
    public function delete()
    {
        if (!session()->get('isAdmin')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Anda tidak memiliki izin untuk menghapus backup.');
        }
        
        $backupFile = $this->request->getPost('backup_file');
        if (empty($backupFile)) {
            return redirect()->to(base_url('admin/backup'))->with('error', 'File backup tidak ditemukan.');
        }
        
        // Validate filename to prevent directory traversal
        $backupDir = WRITEPATH . 'backups/';
        $fullPath = realpath($backupDir . basename($backupFile));
        
        if (!$fullPath || strpos($fullPath, $backupDir) !== 0 || !file_exists($fullPath)) {
            return redirect()->to(base_url('admin/backup'))->with('error', 'File backup tidak valid.');
        }
        
        if (unlink($fullPath)) {
            return redirect()->to(base_url('admin/backup'))->with('success', 'File backup berhasil dihapus.');
        } else {
            return redirect()->to(base_url('admin/backup'))->with('error', 'Gagal menghapus file backup.');
        }
    }
    
    /**
     * Format file size
     */
    private function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
}
