// Initialize map and variables
let map = null;
let currentMarker = null;
let officeMarkers = [];
let currentLocation = null;

function initMap() {
    // Initialize map
    map = L.map('map').setView([-6.2088, 106.8456], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: ' OpenStreetMap contributors'
    }).addTo(map);

    // Add office markers if available
    if (window.officeLocations) {
        window.officeLocations.forEach(office => {
            addOfficeMarker(
                office.latitude,
                office.longitude,
                office.name,
                office.radius
            );
        });
    }

    // Start watching location
    watchCurrentLocation();
}

function addOfficeMarker(lat, lng, name, radius) {
    const marker = L.marker([lat, lng]).addTo(map);
    marker.bindPopup(name);
    
    const circle = L.circle([lat, lng], {
        radius: radius,
        color: '#3388ff',
        fillColor: '#3388ff',
        fillOpacity: 0.1
    }).addTo(map);

    officeMarkers.push({marker, circle, lat, lng, radius, name});
}

function updateCurrentLocation(position) {
    const {latitude, longitude} = position.coords;
    currentLocation = {latitude, longitude};

    if (currentMarker) {
        currentMarker.setLatLng([latitude, longitude]);
    } else {
        currentMarker = L.marker([latitude, longitude]).addTo(map);
        currentMarker.bindPopup('Lokasi Anda');
        map.setView([latitude, longitude], 15);
    }

    // Update nearest office information
    let nearestOffice = null;
    let shortestDistance = Infinity;

    officeMarkers.forEach(office => {
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
        const distanceText = shortestDistance < 1000 ? 
            `${Math.round(shortestDistance)} meter` : 
            `${(shortestDistance / 1000).toFixed(2)} km`;

        document.getElementById('locationStatus').innerHTML = 
            `<strong>Kantor Terdekat:</strong> ${nearestOffice.name}<br>` +
            `<strong>Jarak:</strong> ${distanceText}<br>` +
            `<strong>Status:</strong> <span class="badge ${inRadius ? 'bg-success' : 'bg-danger'}">${inRadius ? 'Dalam Radius' : 'Di Luar Radius'}</span>`;
    }
}

function watchCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(
            updateCurrentLocation,
            error => {
                console.error('Geolocation error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error Lokasi',
                    text: 'Tidak dapat mengakses lokasi Anda. Pastikan GPS aktif dan izin lokasi diberikan.'
                });
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            }
        );
    }
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371e3; // Earth's radius in meters
    const φ1 = lat1 * Math.PI/180;
    const φ2 = lat2 * Math.PI/180;
    const Δφ = (lat2-lat1) * Math.PI/180;
    const Δλ = (lon2-lon1) * Math.PI/180;

    const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
            Math.cos(φ1) * Math.cos(φ2) *
            Math.sin(Δλ/2) * Math.sin(Δλ/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

    return R * c; // Distance in meters
}

// Clean up when page is unloaded
window.addEventListener('unload', () => {
    if (navigator.geolocation) {
        navigator.geolocation.clearWatch();
    }
});

// Initialize map when document is ready
document.addEventListener('DOMContentLoaded', initMap);
