<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    .carousel-control-prev,
    .carousel-control-next {
        top: 50%;
        /* Tombol berada di tengah secara vertikal */
        transform: translateY(-50%);
        /* Untuk menyelaraskan posisi */
        z-index: 10;
        /* Pastikan tombol di atas konten lainnya */
    }

    .carousel-control-prev {
        left: 10px;
        /* Atur jarak dari tepi kiri */
    }

    .carousel-control-next {
        right: 10px;
        /* Atur jarak dari tepi kanan */
    }

    /* Mengatur tinggi card */
    .container-custom {
        margin-top: 55px;
        margin-bottom: 65px;
    }

    .text-center-custom {
        margin-bottom: 50px;
    }

    .card {
        border: none;
        width: 100%;
    }

    .card-img-top {
        height: 300px;
        object-fit: cover;
    }

    .card-date {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .list-group-item {
        border: none;
        background-color: #fff;
    }

    .image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    .small {
        font-weight: normal;
    }

    .text-custome {
        margin-left: 0;
    }

    /* Mengatur margin kolom kanan agar lebih ke kanan */
    .col-lg-4.offset-lg-2 {
        margin-left: auto;
    }

    .calendar-container {
        width: 100%;
        margin: 20px auto;
        padding: 0 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        font-family: Arial, sans-serif;
    }

    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 0;
        margin: 0;
        width: 100%;
        background-color: #fff;
    }

    .month-year {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    #yearSelector {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 4px;
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .calendar-header .month-year {
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .calendar-header .nav i {
        font-size: 24px;
        cursor: pointer;
    }

    .calendar-body {
        padding: 20px;
    }

    .calendar-table {
        width: 100%;
        border-collapse: collapse;
    }

    .calendar-months {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
    }

    .calendar-months span {
        margin: 0 2px;
        cursor: pointer;
        flex: 1;
        text-align: center;
        padding: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .calendar-months span.active {
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
    }

    .calendar-months span:hover {
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
    }

    .calendar-table th,
    .calendar-table td {
        border: 0.5px solid #efefef;
        width: 14.28%;
        height: 100px;
        vertical-align: top;
        position: relative;
    }

    .calendar-table th {
        background-color: #fff;
        /* Warna latar belakang terang */
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        /* Ukuran teks */
        line-height: 1.2;
        /* Tinggi baris lebih kecil */
        padding: 4px 0;
        /* Padding vertikal lebih kecil */
        border-bottom: 2px solid #ddd;
        /* Garis bawah untuk pemisah */
    }

    .calendar-table td {
        border: 0.5px solid #efefef;
        width: 14.28%;
        height: 150px;
        vertical-align: top;
        position: relative;
        text-align: left;
        flex-direction: column-reverse;
        /* Membalikkan urutan isi, acara tampil dari bawah ke atas */
        padding: 5px;
        /* Memberikan ruang di dalam sel */
        font-size: 14px;
    }

    .calendar-table td .date {
        position: absolute;
        top: 5px;
        left: 5px;
        font-size: 12px;
        color: #000;
    }

    .calendar-table td .event {
        margin-top: 5px;
        /* Jarak antar event */
        font-size: 12px;
        /* Ukuran teks event */
        padding: 2px 5px;
        /* Padding di dalam event */
        border-radius: 4px;
        /* Membulatkan sudut event */
        white-space: nowrap;
        /* Tidak memotong teks ke baris berikutnya */
        overflow: hidden;
        /* Menyembunyikan teks yang terlalu panjang */
        text-overflow: ellipsis;
        /* Tambahkan elipsis jika teks terlalu panjang */
        display: flex;
        align-items: center;
        /* Vertikal rata tengah */
    }

    .calendar-table td .event .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        /* Membuat dot menjadi lingkaran */
        margin-right: 5px;
    }

    .calendar-table td .event.red .dot {
        background-color: #ff4d4d;
        /* Warna merah */
    }

    .calendar-table td .event.green .dot {
        background-color: #4caf50;
        /* Warna hijau */
    }

    .calendar-table td .event.blue .dot {
        background-color: #2196f3;
        /* Warna biru */
    }

    .calendar-table td .event.purple .dot {
        background-color: #9c27b0;
        /* Warna ungu */
    }

    .calendar-table td .event.more {
        color: #007bff;
        /* Warna teks untuk "lebih banyak" */
        cursor: pointer;
    }

    .event-bar {
        position: relative;
        top: 85px;
        display: block;
        /* padding: 5px; */
        /* border-radius: 4px; */
        /* background-color: #f0f0f0; */
        /* margin-bottom: 5px; */
        cursor: pointer;
        font-size: 12px;
        z-index: 1;
        /*transition: transform 0.2s, box-shadow 0.2s;*/
        overflow: hidden;
    }

    .more-events {
        position: relative;
        top: 85px;
    }

    /* Tampilan saat hover pada event */
    .event-bar:hover {
        transform: scale(1.02);
    }

    .calendar-table {
        table-layout: fixed;
    }
    
    .calendar-table th {
        text-align: center;
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 14px;
        padding: 10px;
    }
    
    .calendar-table td {
        height: 100px;
        vertical-align: top;
        padding: 8px;
        position: relative;
    }
    
    .date-number {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 5px;
        position: absolute;
        top: 5px;
        left: 8px;
    }
    
    .other-month {
        color: #adb5bd;
        background-color: #f8f9fa;
    }
    
    .today {
        background-color: #e8f4ff;
    }
    
    .event-container {
        margin-top: 25px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        overflow: hidden;
    }
    
    .event-item {
        font-size: 12px;
        padding: 3px 6px;
        border-radius: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .event-item:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    
    .event-holiday {
        background-color: #ffebee;
        color: #d32f2f;
        border-left: 3px solid #d32f2f;
    }
    
    .event-office {
        background-color: #e3f2fd;
        color: #1976d2;
        border-left: 3px solid #1976d2;
    }
    
    .event-meeting {
        background-color: #e8f5e9;
        color: #388e3c;
        border-left: 3px solid #388e3c;
    }
    
    .event-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    
    @media (max-width: 768px) {
        .calendar-table td {
            height: 60px;
            font-size: 11px;
            padding: 4px;
        }
        
        .date-number {
            font-size: 11px;
            top: 2px;
            left: 4px;
        }
        
        .event-container {
            margin-top: 20px;
        }
        
        .event-item {
            font-size: 9px;
            padding: 2px 3px;
            margin-bottom: 1px;
        }
        
        .calendar-header h4 {
            font-size: 1.2rem;
        }
        
        .calendar-legend {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .legend-item {
            margin-bottom: 5px;
        }
    }
</style>

<!-- Tambahkan CSS Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<section class="slider_section full-width-section">
    <div id="main_slider" class="carousel slide banner-main animate__animated animate__fadeIn" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($sliders as $index => $slider): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <img class="img-fluid d-block w-100" src="<?= base_url('img/' . $slider['image']); ?>"
                        alt="Slide Image">
                    <div class="carousel-caption d-none d-md-block">
                        <!-- Animasi pada caption bisa ditambahkan di sini -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#main_slider" data-bs-slide="prev">
            <span class='carousel-control-prev-icon' aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#main_slider" data-bs-slide="next">
            <span class='carousel-control-next-icon' aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<div class="container container-custom">
    <h2 class="animate__animated animate__fadeInDown animate__delay-1s text-center text-center-custom">PENGUMUMAN</h2>
    <div id="announcementCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($cards        as $index => $announcement): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($announcement['title']); ?></h5>
                            <p class="card-description"><?= substr(esc($announcement['description']), 0, 150); ?><?= strlen($announcement['description']) > 150 ? '...' : ''; ?></p>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#eventModal" data-announcement-id="<?= $announcement['id']; ?>">Detail</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#announcementCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#announcementCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Bootstrap Modal for Announcement Details -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="eventDescription"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for event details -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Detail Acara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="event-date mb-3">
                    <strong>Tanggal:</strong> <span id="eventDate"></span>
                </div>
                <div class="event-title mb-3">
                    <strong>Judul:</strong> <span id="eventTitle"></span>
                </div>
                <div class="event-description">
                    <strong>Deskripsi:</strong>
                    <p id="eventDescription"></p>
                </div>
                <div class="event-type mt-3">
                    <span class="badge" id="eventTypeBadge"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventModal = document.getElementById('eventModal');
        const eventDescription = document.getElementById('eventDescription');
        const announcementButtons = document.querySelectorAll('button[data-announcement-id]');

        announcementButtons.forEach(button => {
            button.addEventListener('click', function() {
                const announcementId = this.getAttribute('data-announcement-id');
                // Fetch announcement details using AJAX or predefined data
                fetchAnnouncementDetails(announcementId);
            });
        });

        function fetchAnnouncementDetails(id) {
            // Simulate fetching data (replace with actual AJAX call)
            const announcement = <?= json_encode($cards); ?>.find(a => a.id == id);
            if (announcement) {
                eventDescription.innerHTML = `<strong>${announcement.title}</strong><br>${announcement.description}`;
            }
        }
    });
</script>

<div class="container">
    <div class="position-relative">

        <!-- Slideshow -->
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <?php
                $counter = 0;
                $isActive = true; // Menandai slide pertama sebagai aktif
                foreach ($cards as $index => $ps1):
                    // Mulai slide baru setiap 3 kartu
                    if ($counter % 3 == 0): ?>
                        <div class="carousel-item <?= $isActive ? 'active' : '' ?> p-5">
                            <div class="row">
                                <?php
                                $isActive = false; // Setelah slide pertama, set ke false
                    endif; ?>
                            <div class="col">
                                <div class="card h-100 shadow" style="width: 300px; height: 50px">
                                    <img class="img-fluid" alt="Foto" src="<?= base_url('img/' . esc($ps1['image'])) ?>">
                                    <h5 class="card-title m-2"><?= $ps1['title']; ?></h5>
                                    <p class="card-date m-2"><?= esc($ps1['translated_date']); ?></p>
                                    <p class="card-description m-2"><?= substr($ps1['description'], 0, 100); ?></p>
                                    <a href="<?= site_url('dashboard/detail_pengumuman/' . $ps1['id']); ?>"
                                        class="read-more m-2">Lihat Selengkapnya</a>

                                </div>
                            </div>
                            <?php
                            $counter++;
                            // Tutup slide saat sudah mencapai 5 kartu atau data habis
                            if ($counter % 3 == 0 || $index == count($cards) - 1): ?>

                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>

        <!-- Tombol Next -->
        <button id="b-prev" class="btn btn-primary position-absolute end-0 top-50 translate-middle-y rounded-circle"
            style="width: 40px; height: 40px;" data-bs-target="#carouselExample" data-bs-slide="next">
            <i class="bi bi-arrow-right"></i>
        </button>
        <!-- Tombol Previous -->
        <button id="b-next" class="btn btn-primary position-absolute start-0 top-50 translate-middle-y rounded-circle"
            style="width: 40px; height: 40px;" data-bs-target="#carouselExample" data-bs-slide="prev">
            <i class="bi bi-arrow-left"></i>
        </button>

    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4 fw-bold">Kalender Kegiatan & Hari Libur</h4>
                    
                    <div class="calendar-container">
                        <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                            <button id="prevMonth" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <h5 id="currentMonthYear" class="mb-0 fw-bold"></h5>
                            <button id="nextMonth" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered calendar-table">
                                <thead>
                                    <tr>
                                        <th>Minggu</th>
                                        <th>Senin</th>
                                        <th>Selasa</th>
                                        <th>Rabu</th>
                                        <th>Kamis</th>
                                        <th>Jumat</th>
                                        <th>Sabtu</th>
                                    </tr>
                                </thead>
                                <tbody id="calendarBody">
                                    <!-- Calendar will be generated here -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <div class="event-dot bg-danger me-2"></div>
                                    <span>Hari Libur Nasional</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="event-dot bg-primary me-2"></div>
                                    <span>Kegiatan Kantor</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="event-dot bg-success me-2"></div>
                                    <span>Rapat Penting</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script for the new calendar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calendar data from controller
        const calendarEvents = <?= $calenders ?>;
        
        // Current date
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        
        // DOM elements
        const calendarBody = document.getElementById('calendarBody');
        const currentMonthYear = document.getElementById('currentMonthYear');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        
        // Indonesian month names
        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        // Generate calendar
        function generateCalendar(month, year) {
            // Clear previous calendar
            calendarBody.innerHTML = '';
            
            // Update header
            currentMonthYear.textContent = `${monthNames[month]} ${year}`;
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            // Get previous month's last days
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            
            let date = 1;
            let nextMonthDate = 1;
            
            // Create calendar rows
            for (let i = 0; i < 6; i++) {
                // Create a row
                const row = document.createElement('tr');
                
                // Create cells for each day of the week
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');
                    
                    // Fill in previous month's days
                    if (i === 0 && j < firstDay) {
                        const prevDate = prevMonthLastDay - (firstDay - j - 1);
                        cell.innerHTML = `<div class="date-number text-muted">${prevDate}</div>`;
                        cell.classList.add('other-month');
                    } 
                    // Fill in current month's days
                    else if (date <= daysInMonth) {
                        cell.innerHTML = `<div class="date-number">${date}</div>`;
                        
                        // Check if it's today
                        if (date === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) {
                            cell.classList.add('today');
                        }
                        
                        // Check for events on this date
                        const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                        
                        // Create event container
                        const eventContainer = document.createElement('div');
                        eventContainer.className = 'event-container';
                        
                        // Add events if any
                        if (calendarEvents[formattedDate]) {
                            calendarEvents[formattedDate].forEach(event => {
                                const eventItem = document.createElement('div');
                                
                                // Determine event type based on title or type
                                if (event.type === 'holiday') {
                                    eventItem.className = 'event-item event-holiday';
                                } else if (event.title.toLowerCase().includes('libur') || event.title.toLowerCase().includes('nasional')) {
                                    eventItem.className = 'event-item event-holiday';
                                } else if (event.title.toLowerCase().includes('rapat')) {
                                    eventItem.className = 'event-item event-meeting';
                                } else {
                                    eventItem.className = 'event-item event-office';
                                }
                                
                                eventItem.textContent = event.title;
                                
                                // Store event data as attributes for the modal
                                eventItem.dataset.date = formattedDate;
                                eventItem.dataset.title = event.title;
                                eventItem.dataset.description = event.description || 'Tidak ada deskripsi';
                                eventItem.dataset.type = event.type || 'event';
                                
                                // Add click event to show modal with details
                                eventItem.addEventListener('click', function() {
                                    // Format the date for display
                                    const dateParts = this.dataset.date.split('-');
                                    const displayDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                                    
                                    // Set modal content
                                    document.getElementById('eventDate').textContent = displayDate;
                                    document.getElementById('eventTitle').textContent = this.dataset.title;
                                    document.getElementById('eventDescription').textContent = this.dataset.description;
                                    
                                    // Set badge color based on event type
                                    const typeBadge = document.getElementById('eventTypeBadge');
                                    if (this.dataset.type === 'holiday' || this.classList.contains('event-holiday')) {
                                        typeBadge.className = 'badge bg-danger';
                                        typeBadge.textContent = 'Hari Libur';
                                    } else if (this.classList.contains('event-meeting')) {
                                        typeBadge.className = 'badge bg-success';
                                        typeBadge.textContent = 'Rapat';
                                    } else {
                                        typeBadge.className = 'badge bg-primary';
                                        typeBadge.textContent = 'Kegiatan Kantor';
                                    }
                                    
                                    // Show the modal
                                    const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
                                    modal.show();
                                });
                                
                                eventContainer.appendChild(eventItem);
                            });
                        }
                        
                        cell.appendChild(eventContainer);
                        date++;
                    } 
                    // Fill in next month's days
                    else {
                        cell.innerHTML = `<div class="date-number text-muted">${nextMonthDate}</div>`;
                        cell.classList.add('other-month');
                        nextMonthDate++;
                    }
                    
                    row.appendChild(cell);
                }
                
                calendarBody.appendChild(row);
                
                // Stop if we've gone through all days of the month
                if (date > daysInMonth) {
                    break;
                }
            }
        }
        
        // Initialize calendar
        generateCalendar(currentMonth, currentYear);
        
        // Event listeners for navigation
        prevMonthBtn.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });
    });
</script>

<!-- Menambahkan FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

<!-- Menambahkan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script untuk Popup -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popupBackground = document.getElementById('popupBackground');
        const popup = document.getElementById('popup');
        const closePopupButton = document.getElementById('closePopupButton');

        function showPopup() {
            popupBackground.style.display = 'block';
            popup.style.display = 'block';
        }

        function hidePopup() {
            popupBackground.style.display = 'none';
            popup.style.display = 'none';
        }

        closePopupButton.addEventListener('click', hidePopup);
        popupBackground.addEventListener('click', hidePopup);

        // Menampilkan popup saat halaman dimuat
        showPopup();
    });
</script>

<!-- Pop-up yang berisi carousel gambar -->
<div class="popup-background" id="popupBackground"></div>
<div class="popup" id="popup">
    <span class="close-btn" id="closePopup">&times;</span>
    <div class="popup-content animate__animated animate__bounceIn">
        <div id="popupCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($popups as $index => $popup): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                        <img src="<?= base_url('img/' . $popup['image']); ?>" alt="Popup Image" class="d-block w-100">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#popupCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#popupCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <button id="closePopupButton" class="btn btn-primary floating-button">Tutup</button>
    </div>
</div>

</div>
</div>
<?= $this->endSection(); ?>