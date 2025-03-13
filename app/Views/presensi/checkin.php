<?php
$this->extend('layout/template');
$this->section('content');
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">Check In</h5>
                    <div class="mb-4">
                        <i class="bi bi-box-arrow-in-right text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <p class="card-text mb-4">Jam Masuk Kerja</p>
                    <div class="current-time mb-4 h3">
                        <?= date('H:i:s') ?>
                    </div>
                    <button class="btn btn-primary btn-lg px-4" onclick="checkIn()">
                        Check In
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">Check Out</h5>
                    <div class="mb-4">
                        <i class="bi bi-box-arrow-right text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <p class="card-text mb-4">Jam Pulang Kerja</p>
                    <div class="current-time mb-4 h3">
                        <?= date('H:i:s') ?>
                    </div>
                    <button class="btn btn-danger btn-lg px-4" onclick="checkOut()">
                        Check Out
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateTime() {
    const timeElements = document.querySelectorAll('.current-time');
    timeElements.forEach(el => {
        el.textContent = new Date().toLocaleTimeString('id-ID');
    });
}

setInterval(updateTime, 1000);

function checkIn() {
    fetch('<?= site_url('presensi/checkin') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Check In berhasil dicatat!'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan saat mencatat Check In'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan pada sistem'
        });
    });
}

function checkOut() {
    fetch('<?= site_url('presensi/checkout') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Check Out berhasil dicatat!'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan saat mencatat Check Out'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan pada sistem'
        });
    });
}
</script>

<?php $this->endSection(); ?>
