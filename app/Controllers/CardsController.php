<?php

namespace App\Controllers;

use App\Models\CardsModel;

class CardsController extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $cardModel = new CardModel();

        // Ambil semua data dari database
        $announcements = $cardModel->findAll();

        // Terjemahkan tanggal pada setiap record
        foreach ($announcements as &$announcement) {
            $announcement['translated_date'] = $this->translateDate($announcement['created_at']);
        }

        // Kirim data ke view
        $data['announcements'] = $announcements;
        return view('cards_view', $data);
    }

    // Fungsi untuk menerjemahkan tanggal
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
