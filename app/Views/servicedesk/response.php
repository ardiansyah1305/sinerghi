<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    /* Container untuk kedua card */
    .content-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .content-left,
    .content-right {
        flex: 1 1 45%;
        min-width: 300px;
    }

    .chat-box {
        display: flex;
        flex-direction: column;
        height: 300px;
        overflow-y: auto;
        margin-bottom: 10px;
    }

    .chat-message {
        margin-bottom: 10px;
    }

    .chat-message .user {
        font-weight: bold;
        color: #007bff;
    }

    .chat-message .message {
        margin-left: 20px;
        background-color: #f1f1f1;
        padding: 8px 12px;
        border-radius: 5px;
    }

    .chat-input-container {
        display: flex;
        justify-content: space-between;
    }

    .chat-input {
        width: 80%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .chat-send-btn {
        width: 18%;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .chat-send-btn:hover {
        background-color: #0056b3;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    @media (max-width: 576px) {
        .content-container {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid">
    <div class="row pt-3">
        <div class="col-12">
            <h3 class="text-left"><a href="<?= base_url('/servicedesk') ?>"><i class="fas fa-angle-left"></i></a>&nbsp;&nbsp;Serivedesk</h3>
            <hr>
        </div>
    </div>
    <div class="content-container">

        <div class="content-left">
            <div class="card border-primary shadow mb-1">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Info Tiket</h5>
                    <hr>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Kode Tiket</strong></td>
                                <td><strong>:</strong></td>
                                <td><?= $tiket['kode_tiket']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Pemohon</strong></td>
                                <td><strong>:</strong></td>
                                <td><?= $data_pegawai['nama_pegawai']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Unit Kerja</strong></td>
                                <td><strong>:</strong></td>
                                <td><?= $data_pegawai['unit_kerja']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Layanan</strong></td>
                                <td><strong>:</strong></td>
                                <td><?= $data_pegawai['jenis_layanan']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Deskripsi Permohonan</strong></td>
                                <td><strong>:</strong></td>
                                <td><?= $tiket['deskripsi']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Lampiran</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    <?php if ($tiket['lampiran']): ?>
                                        <a href="<?= base_url('uploads/tiket/' . $tiket['lampiran']); ?>" target="_blank">Lihat Lampiran</a>
                                    <?php else: ?>
                                        Tidak ada lampiran
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td><strong>:</strong></td>
                                <td>
                                    <?php
                                    $status_tiket = $tiket['status'];
                                    if ($status_tiket == 0) :
                                    ?>
                                        <span class="badge-status badge-baru">Baru</span>
                                    <?php elseif ($status_tiket == 1) : ?>
                                        <span class="badge-status badge-diproses">Diproses</span>
                                    <?php elseif ($status_tiket == 2) : ?>
                                        <span class="badge-status badge-selesai">Selesai</span>
                                    <?php elseif ($status_tiket == 3) : ?>
                                        <span class="badge-status badge-dibatalkan">Dibatalkan</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Dibuat</strong></td>
                                <td><strong>:</strong></td>
                                <td><?= $tiket['tanggal_status_terkini']; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-danger" id="btnBatalPermohonan">Batal Permohonan</button>
                        <button type="button" class="btn btn-primary" id="btnSelesaikanTiket">Selesaikan Tiket</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-right">
            <div class="card border-primary shadow mb-1">
                <div class="card-body">
                    <!-- Chat Box -->
                    <div class="chat-box" id="chatMessages">
                        <!-- Pesan-pesan chat akan muncul di sini -->
                        <?php foreach ($messages as $message): ?>
                            <div class="chat-message">
                                <div class="user"><?= esc($message['nama_pegawai']); ?>:</div>
                                <div class="message"><?= esc($message['deskripsi']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Input untuk kirim pesan -->
                    <div class="chat-input-container">
                        <input type="text" class="chat-input" id="deskripsi" placeholder="Tulis pesan...">
                        <button class="chat-send-btn" id="sendMessageBtn">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Fields untuk tiket dan pegawai ID -->
<input type="hidden" id="id_tiket" value="<?= $tiket['id']; ?>">
<input type="hidden" id="kode_tiket" value="<?= $tiket['kode_tiket']; ?>">
<input type="hidden" id="id_pegawai" value="<?= $data_pegawai['id_pegawai']; ?>">

<!-- JavaScript untuk interaksi -->
<script>
    document.getElementById('sendMessageBtn').addEventListener('click', function() {
        const deskripsi = document.getElementById('deskripsi').value; // Ambil pesan dari input
        const tiketId = document.getElementById('id_tiket').value;  // Ambil id_tiket
        const kodeTiket = document.getElementById('kode_tiket').value; // Ambil kode_tiket
        const pegawaiId = document.getElementById('id_pegawai').value; // Ambil id_pegawai

        // Validasi jika pesan tidak kosong
        if (deskripsi.trim() !== '') {
            // Kirim pesan ke server menggunakan AJAX
            $.ajax({
                url: '<?= base_url('/servicedesk/sendMessage') ?>',
                type: 'POST',
                data: {
                    id_tiket: tiketId, // Kirim id_tiket
                    id_pegawai: pegawaiId, // Kirim id_pegawai
                    kode_tiket: kodeTiket, // Kirim kode_tiket
                    deskripsi: deskripsi // Kirim pesan ke server
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        // Tambahkan pesan baru ke dalam chat
                        const messageContainer = document.createElement('div');
                        messageContainer.classList.add('chat-message');
                        messageContainer.innerHTML = `<div class="user">Anda:</div><div class="message">${deskripsi}</div>`;
                        document.getElementById('chatMessages').appendChild(messageContainer);
                        document.getElementById('deskripsi').value = ''; // Kosongkan input setelah pesan dikirim
                        document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight; // Scroll ke bawah
                    } else {
                        alert('Terjadi kesalahan: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengirim pesan.');
                }
            });
        } else {
            alert('Pesan tidak boleh kosong!');
        }
    });

    // Jika pengguna menekan Enter, kirim pesan
    document.getElementById('deskripsi').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('sendMessageBtn').click();
        }
    });
</script>

<?= $this->endSection(); ?>