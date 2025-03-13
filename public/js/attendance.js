// Shared variables
window.attendanceVars = {
    map: null,
    currentMarker: null,
    officeMarkers: [],
    currentLocation: null
};

// Debug function
function logDebug(message, data = null) {
    const timestamp = new Date().toISOString();
    console.log(`[${timestamp}] ${message}`);
    if (data) {
        console.log('Data:', data);
    }
}

// Function to update button states based on location
async function updateButtonStates() {
    console.log('[' + new Date().toISOString() + '] Updating button states');
    
    if (!navigator.geolocation) {
        console.error('Geolocation is not supported');
        return;
    }

    try {
        const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        });

        // Update UI based on location
        const { latitude, longitude } = position.coords;
        updateLocationDisplay(position);
        
    } catch (error) {
        console.error('Error getting location:', error);
        let errorMessage;
        
        switch (error.code) {
            case error.PERMISSION_DENIED:
                errorMessage = 'Akses lokasi ditolak. Mohon izinkan akses lokasi di pengaturan browser Anda.';
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage = 'Informasi lokasi tidak tersedia. Pastikan GPS Anda aktif dan berada di area dengan sinyal GPS yang baik.';
                break;
            case error.TIMEOUT:
                errorMessage = 'Waktu permintaan lokasi habis. Silakan coba lagi atau pastikan koneksi internet Anda stabil.';
                break;
            default:
                errorMessage = 'Terjadi kesalahan saat mengakses lokasi. Silakan refresh halaman atau coba beberapa saat lagi.';
        }

        // Jangan nonaktifkan tombol, biarkan user bisa mencoba lagi
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: errorMessage,
            showConfirmButton: true,
            confirmButtonText: 'Coba Lagi',
            showCancelButton: true,
            cancelButtonText: 'Tutup'
        }).then((result) => {
            if (result.isConfirmed) {
                updateButtonStates(); // Mencoba lagi jika user klik "Coba Lagi"
            }
        });
    }
}

// Disable check-in/out buttons
function disableButtons() {
    const checkInButton = document.getElementById('checkInButton');
    const checkOutButton = document.getElementById('checkOutButton');
    
    if (checkInButton) checkInButton.disabled = true;
    if (checkOutButton) checkOutButton.disabled = true;
}

// Update location display
function updateLocationDisplay(position) {
    const { latitude, longitude } = position.coords;
    document.getElementById('current-coordinates').innerHTML = 
        `Latitude: ${latitude.toFixed(6)}<br>Longitude: ${longitude.toFixed(6)}`;
}

// Check-in function
async function checkIn() {
    try {
        const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        });

        const { latitude, longitude } = position.coords;
        
        const response = await fetch(window.checkInUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({ latitude, longitude })
        });

        const result = await response.json();
        
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Check-in berhasil dicatat'
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(result.message || 'Check-in gagal');
        }
    } catch (error) {
        console.error('Check-in error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Terjadi kesalahan saat check-in'
        });
    }
}

// Check-out function
async function checkOut() {
    try {
        const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        });

        const { latitude, longitude } = position.coords;
        
        const response = await fetch(window.checkOutUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({ latitude, longitude })
        });

        const result = await response.json();
        
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Check-out berhasil dicatat'
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(result.message || 'Check-out gagal');
        }
    } catch (error) {
        console.error('Check-out error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Terjadi kesalahan saat check-out'
        });
    }
}

// Make functions available globally
window.checkIn = checkIn;
window.checkOut = checkOut;

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    updateButtonStates();
});

// Function to update time display
function updateTime() {
    const timeElements = document.querySelectorAll('.current-time');
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });
    
    timeElements.forEach(el => {
        el.textContent = timeString;
    });
}

// Start time updates
setInterval(updateTime, 1000);

// Function to update current location
function updateCurrentLocation(position) {
    const {latitude, longitude} = position.coords;
    window.attendanceVars.currentLocation = {latitude, longitude};
    
    // Update coordinates display
    document.getElementById('current-coordinates').innerHTML = 
        `Latitude: ${latitude.toFixed(6)}<br>Longitude: ${longitude.toFixed(6)}`;

    // Update or create current location marker
    if (window.attendanceVars.currentMarker) {
        window.attendanceVars.currentMarker.setLatLng([latitude, longitude]);
    } else if (window.attendanceVars.map) {
        window.attendanceVars.currentMarker = L.marker([latitude, longitude]).addTo(window.attendanceVars.map);
        window.attendanceVars.currentMarker.bindPopup('Lokasi Anda');
        window.attendanceVars.map.setView([latitude, longitude], 15);
    }

    // Update button states when location is available
    updateButtonStates();

    // Find nearest office
    if (window.attendanceVars.officeMarkers.length > 0) {
        let nearestOffice = null;
        let shortestDistance = Infinity;

        window.attendanceVars.officeMarkers.forEach(office => {
            const distance = calculateDistance(
                latitude, 
                longitude, 
                office.lat, 
                office.lng
            );

            if (distance < shortestDistance) {
                shortestDistance = distance;
                nearestOffice = office;
            }
        });

        if (nearestOffice) {
            const inRadius = shortestDistance <= nearestOffice.radius;
            document.getElementById('nearest-office').innerHTML = 
                `${nearestOffice.name}<br>` +
                `Jarak: ${Math.round(shortestDistance)} meter<br>` +
                `<span class="badge ${inRadius ? 'bg-success' : 'bg-danger'}">${inRadius ? 'Dalam Radius' : 'Di Luar Radius'}</span>`;
        }
    }
}

// Start location tracking
if (navigator.geolocation) {
    navigator.geolocation.watchPosition(updateCurrentLocation, 
        (error) => {
            logDebug('Geolocation error:', error);
            let errorMessage = 'Mohon izinkan akses lokasi';
            if (error.code === error.PERMISSION_DENIED) {
                errorMessage = 'Akses lokasi ditolak. Mohon izinkan akses lokasi di pengaturan browser Anda.';
            }
            Swal.fire({
                icon: 'error',
                title: 'Error Lokasi',
                text: errorMessage
            });
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
} else {
    logDebug('Geolocation is not supported');
    if (window.isWFO) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Browser Anda tidak mendukung geolokasi yang dibutuhkan untuk WFO'
        });
    }
}
