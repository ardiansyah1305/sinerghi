<?php

namespace App\Controllers;

use App\Models\OfficeLocationModel;
use App\Models\JadwalModel;
use App\Models\PresensiModel;

class AttendanceController extends BaseController
{
    protected $officeLocationModel;
    protected $jadwalModel;
    protected $presensiModel;
    protected $WFA_CHECKIN_LIMIT = '07:30:00';
    protected $WFA_CHECKOUT_LIMIT = '22:00:00';

    public function __construct()
    {
        $this->officeLocationModel = new OfficeLocationModel();
        $this->jadwalModel = new JadwalModel();
        $this->presensiModel = new PresensiModel();
    }

    public function index()
    {
        $pegawaiId = session()->get('pegawai_id');
        $today = date('Y-m-d');

        // Get today's schedule
        $jadwal = $this->jadwalModel->getTodaySchedule($pegawaiId);
        
        // Get today's attendance records
        $presensi = [];
        $checkIn = $this->presensiModel->where([
            'pegawai_id' => $pegawaiId,
            'DATE(waktu_presensi)' => $today,
            'tipe_presensi' => 'checkin'
        ])->first();
        
        $checkOut = $this->presensiModel->where([
            'pegawai_id' => $pegawaiId,
            'DATE(waktu_presensi)' => $today,
            'tipe_presensi' => 'checkout'
        ])->first();
        
        if ($checkIn || $checkOut) {
            $presensi = [
                'check_in' => $checkIn ? $checkIn['waktu_presensi'] : null,
                'check_out' => $checkOut ? $checkOut['waktu_presensi'] : null
            ];
        }

        // Get all office locations
        $officeLocations = $this->officeLocationModel->findAll();

        return view('attendance/index', [
            'jadwal' => $jadwal,
            'presensi' => $presensi,
            'officeLocations' => $officeLocations,
            'canCheckIn' => $jadwal && !$checkIn,
            'canCheckOut' => $jadwal && $checkIn && !$checkOut
        ]);
    }

    public function recordCheckIn()
    {
        try {
            $pegawaiId = session()->get('pegawai_id');
            
            // Get today's schedule
            $jadwal = $this->jadwalModel->getTodaySchedule($pegawaiId);
            if (!$jadwal) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak ada jadwal kerja untuk hari ini'
                ]);
            }

            // Check if already checked in
            if ($this->presensiModel->hasCheckedInToday($pegawaiId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Anda sudah melakukan check in hari ini'
                ]);
            }

            // For WFA, check time limit
            if ($jadwal['jenis_alokasi'] === 'wfa') {
                $currentTime = date('H:i:s');
                if ($currentTime > $this->WFA_CHECKIN_LIMIT) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Sudah melewati batas waktu check-in WFA (07:30)'
                    ]);
                }
            }

            // Record attendance
            $data = [
                'pegawai_id' => $pegawaiId,
                'waktu_presensi' => date('Y-m-d H:i:s'),
                'tipe_presensi' => 'checkin'
            ];

            // Add location data if provided
            $requestData = $this->request->getJSON(true);
            if (isset($requestData['latitude']) && isset($requestData['longitude'])) {
                $data['latitude'] = $requestData['latitude'];
                $data['longitude'] = $requestData['longitude'];
            }

            $this->presensiModel->insert($data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Check In berhasil dicatat'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[AttendanceController::recordCheckIn] Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada sistem'
            ]);
        }
    }

    public function recordCheckOut()
    {
        try {
            $pegawaiId = session()->get('pegawai_id');
            $today = date('Y-m-d');
            $currentTime = date('H:i:s');

            // Get today's schedule
            $jadwal = $this->jadwalModel->where([
                'pegawai_id' => $pegawaiId,
                'tanggal_kerja' => $today
            ])->first();

            if (!$jadwal) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak ada jadwal kerja untuk hari ini'
                ]);
            }

            // Check if already checked out
            if ($this->presensiModel->hasCheckedOutToday($pegawaiId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Anda sudah melakukan check out hari ini'
                ]);
            }

            // For WFA, check time limit
            if ($jadwal['jenis_alokasi'] === 'wfa') {
                if ($currentTime > $this->WFA_CHECKOUT_LIMIT) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Batas waktu check-out WFA adalah pukul 22:00'
                    ]);
                }
            }

            // Record attendance
            $data = [
                'pegawai_id' => $pegawaiId,
                'waktu_presensi' => date('Y-m-d H:i:s'),
                'tipe_presensi' => 'checkout'
            ];

            // Add location data if provided
            $requestData = $this->request->getJSON(true);
            if (isset($requestData['latitude']) && isset($requestData['longitude'])) {
                $data['latitude'] = $requestData['latitude'];
                $data['longitude'] = $requestData['longitude'];
            }

            $this->presensiModel->insert($data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Check Out berhasil dicatat'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[AttendanceController::recordCheckOut] Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada sistem'
            ]);
        }
    }
}
