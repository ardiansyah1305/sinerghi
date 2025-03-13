<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'pegawai_id',
        'waktu_presensi',
        'tipe_presensi', // 'checkin' atau 'checkout'
        'longitude',
        'latitude'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Get today's attendance for a specific employee
    public function getTodayAttendance($pegawaiId)
    {
        $today = date('Y-m-d');
        return $this->where('pegawai_id', $pegawaiId)
                    ->where('DATE(waktu_presensi)', $today)
                    ->orderBy('waktu_presensi', 'DESC')
                    ->findAll();
    }

    // Check if employee has checked in today
    public function hasCheckedInToday($pegawaiId)
    {
        $today = date('Y-m-d');
        return $this->where([
            'pegawai_id' => $pegawaiId,
            'tipe_presensi' => 'checkin',
            'DATE(waktu_presensi)' => $today
        ])->countAllResults() > 0;
    }

    // Check if employee has checked out today
    public function hasCheckedOutToday($pegawaiId)
    {
        $today = date('Y-m-d');
        return $this->where([
            'pegawai_id' => $pegawaiId,
            'tipe_presensi' => 'checkout',
            'DATE(waktu_presensi)' => $today
        ])->countAllResults() > 0;
    }

    // Record attendance with location
    public function recordAttendance($pegawaiId, $type, $latitude = null, $longitude = null)
    {
        // For WFA, if location is not provided, try to get IP-based location
        if ($latitude === null || $longitude === null) {
            $ipLocation = $this->getIpBasedLocation();
            $latitude = $ipLocation['latitude'];
            $longitude = $ipLocation['longitude'];
        }

        return $this->insert([
            'pegawai_id' => $pegawaiId,
            'waktu_presensi' => date('Y-m-d H:i:s'),
            'tipe_presensi' => $type,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
    }

    // Get location based on IP address for WFA
    private function getIpBasedLocation()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // If localhost/development
        if ($ip === '127.0.0.1' || $ip === '::1') {
            // Default to Jakarta coordinates for development
            return [
                'latitude' => -6.2088,
                'longitude' => 106.8456
            ];
        }

        try {
            // Using ip-api.com (free, no API key required)
            $response = file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);

            if ($data && $data['status'] === 'success') {
                return [
                    'latitude' => $data['lat'],
                    'longitude' => $data['lon']
                ];
            }
        } catch (\Exception $e) {
            log_message('error', 'IP Geolocation failed: ' . $e->getMessage());
        }

        // Fallback to Jakarta coordinates if API fails
        return [
            'latitude' => -6.2088,
            'longitude' => 106.8456
        ];
    }
}
