<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container detail-container">
    <h1 class="detail-title text-center">Pengumuman APEL PEGAWAI Kemenko PMK</h1>
    <div class="detail-meta text-center">
        <div class="detail-category">PMK lainnya</div>
        <div class="detail-date">2024-03-25 08:57:52</div>
    </div>
    <div class="detail-image text-center">
        <img src="<?= base_url('images/detail_pem.png') ?>" alt="Detail Image" class="img-fluid rounded">
    </div>
    <div class="detail-content">
        <p><strong>Assalamu’alaikum, w.w, Selamat Pagi. Salam Sejahtera untuk kita semua, Bapak/Ibu dan seluruh pegawai di lingkungan Kemenko PMK, Yang kami hormati,</strong></p>
        <p>Kami mengundang kepada seluruh pegawai Kemenko PMK untuk menghadiri APEL PEGAWAI secara luring pada:</p>
        <div class="detail-info">
            <p><strong>Hari/Tgl:</strong> Senin, 15-7-2024<br>
            <strong>Waktu:</strong> pukul 08.00 WIB. Sd. Selesai<br>
            <strong>Tempat:</strong> halaman depan Kemenko PMK<br>
            <strong>Pembina:</strong> Sekretariat DJSN<br>
            <strong>Petugas:</strong> Ketua DJSN<br>
            <strong>Pakaian:</strong> Putih Hitam</p>
        </div>
        <p>Disamping tetap harus melakukan Finger Print sebagai daftar hadir juga dapat mengisi daftar hadir mengikuti UPACARA/APEL PEGAWAI yang akan kami jadikan dasar penilaian kedisiplinan pegawai. Atas kehadiran bapak/ibu kami mengucapkan terima kasih.</p>
        <p>Demikian informasi ini kami sampaikan, atas perhatian Bapak/Ibu, kami mengucapkan terima kasih.</p>
        <p><strong>Kepala Biro Umum dan SDM</strong></p>
    </div>
</div>

<style>
    body {
        font-family: 'Nunito', sans-serif;
        background-color: #f8f9fa;
        background: linear-gradient(to bottom right, #ffffff, #e0f7fa);
    }

    .detail-container {
        background-color: transparent;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .detail-title {
        font-size: 2.5em;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .detail-meta {
        font-size: 0.9em;
        color: #777;
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .detail-category,
    .detail-date {
        font-size: 0.9em;
        color: #777;
    }

    .detail-image img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .detail-content {
        font-size: 1.2em;
        line-height: 1.6;
        color: #333;
        text-align: left;
    }

    .detail-content p {
        margin-bottom: 1em;
    }

    .detail-content p strong {
        font-weight: bold;
    }

    .detail-info {
        background-color: #e8f4f8;
        padding: 10px 20px;
        border-left: 5px solid #32C2B8;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    @media (max-width: 991.98px) {
        .detail-meta {
            text-align: center;
        }

        .detail-info {
            padding: 10px;
        }
    }
</style>

<?= $this->endSection() ?>
