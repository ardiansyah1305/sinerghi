<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class PenugasanConfig extends BaseConfig
{
    /**
     * Konfigurasi Periode Pengajuan
     */
    public $tanggalMulaiPengajuan = 20;    // Tanggal mulai pengajuan setiap bulan
    public $tanggalAkhirPengajuan = 30;    // Tanggal berakhir pengajuan setiap bulan
    public $batasPerpanjangan = 2;         // Jumlah hari perpanjangan jika jatuh di weekend

    /**
     * Daftar Jenis Alokasi yang Valid
     */
    public $jenisAlokasiValid = ['WFO', 'WFH'];
}
