<?php

namespace App\Controllers;

use App\Models\SliderBerandaModel;
use App\Models\PopupBerandaModel;
use App\Models\CardBerandaModel;
use App\Models\CalenderModel;
use App\Models\HariLiburModel;
use \DateTime;

class DashboardController extends BaseController
{
    public function index()
{
    $sliderModel = new SliderBerandaModel();
    $popupModel = new PopupBerandaModel();
    $cardModel = new CardBerandaModel();
    $calenderModel = new CalenderModel();
    $hariLiburModel = new HariLiburModel();

    // Ambil 15 pengumuman terbaru
    $cards = $cardModel->getLatestAnnouncements(15);

    // Proses terjemahan tanggal pada setiap card
    foreach ($cards as &$card) {
        $card['translated_date'] = $this->translateDate($card['created_at']);
    }

    $calenders = $calenderModel->findAll();
    
    // Get holidays from hari_libur table
    $hariLibur = $hariLiburModel->findAll();
    
    $formattedEvents = [];

    // Process regular calendar events
    foreach ($calenders as $event) {
        $start = new DateTime($event['start']);
        $end = new DateTime($event['end']);
        $dates = [];
    
        // Buat daftar semua tanggal antara start dan end (termasuk)
        while ($start <= $end) {
            $dates[] = $start->format('Y-m-d');
            $start->modify('+1 day');
        }
    
        // Tambahkan acara ke dalam array $formattedEvents
        foreach ($dates as $date) {
            $formattedEvents[$date][] = [
                'date' => $date, // Tanggal dalam rentang acara
                'title' => $event['title'],
                'description' => $event['description'],
                'type' => 'event'
            ];
        }
    }
    
    // Add holidays to the formatted events
    foreach ($hariLibur as $libur) {
        $date = $libur['tanggal'];
        $formattedEvents[$date][] = [
            'date' => $date,
            'title' => $libur['tentang'],
            'description' => 'Hari Libur: ' . $libur['tentang'],
            'type' => 'holiday'
        ];
    }

    $data = [
        'sliders' => $sliderModel->findAll(),
        'popups' => $popupModel->findAll(),
        'cards' => $cards,
        'role' => session()->get('role_id'),
        'calenders' => json_encode($formattedEvents),
    ];
    
    return view('dashboard/dashboard', $data);
}

    public function detail_pengumuman($id)
    {
        $cardModel = new CardBerandaModel();
        $data['announcement'] = $cardModel->find($id);

        if (!$data['announcement']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Announcement with ID ' . $id . ' not found.');
        }

        // Terjemahkan tanggal pada detail pengumuman
        $data['announcement']['translated_date'] = $this->translateDate($data['announcement']['created_at']);

        return view('dashboard/detail_pengumuman', $data);
    }

	private function translateDate($date)
    {
        $hariInggris = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $hariIndonesia = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Format tanggal asli
        $tanggalAsli = date('l, d F Y', strtotime($date));

        // Terjemahkan hari dan bulan
        $tanggalTerjemahan = str_replace($hariInggris, $hariIndonesia, $tanggalAsli);
        $tanggalTerjemahan = str_replace($bulanInggris, $bulanIndonesia, $tanggalTerjemahan);

        return $tanggalTerjemahan;
    }
}
