<?php if (isset($jadwal)): ?>
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Lokasi Anda</h5>
                <div id="map" style="height: 400px; border-radius: 8px;"></div>
                <div class="mt-3 p-3 bg-light rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Koordinat Anda:</strong>
                            <div id="current-coordinates">Mendapatkan lokasi...</div>
                        </div>
                        <div class="col-md-6">
                            <strong>Lokasi Kantor Terdekat:</strong>
                            <div id="nearest-office">Menghitung...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    let map, currentMarker, officeMarkers = [], currentLocation = null;

    function initMap() {
        // Initialize map centered at Jakarta
        map = L.map('map').setView([-6.2088, 106.8456], 13);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add office locations
        <?php if (isset($officeLocations)): ?>
        <?php foreach ($officeLocations as $office): ?>
        addOfficeMarker(
            <?= $office['latitude'] ?>, 
            <?= $office['longitude'] ?>, 
            "<?= $office['name'] ?>",
            <?= $office['radius'] ?>
        );
        <?php endforeach; ?>
        <?php endif; ?>

        // Start watching current location
        watchCurrentLocation();
    }

    function addOfficeMarker(lat, lng, name, radius) {
        // Add marker for office
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(name);
        
        // Add radius circle
        const circle = L.circle([lat, lng], {
            radius: radius,
            color: '#007bff',
            fillColor: '#007bff',
            fillOpacity: 0.1
        }).addTo(map);

        officeMarkers.push({marker, circle, lat, lng, radius, name});
    }

    function updateCurrentLocation(position) {
        const {latitude, longitude} = position.coords;
        currentLocation = {latitude, longitude};
        
        // Update coordinates display
        document.getElementById('current-coordinates').innerHTML = 
            `Latitude: ${latitude.toFixed(6)}<br>Longitude: ${longitude.toFixed(6)}`;

        // Update or create current location marker
        if (currentMarker) {
            currentMarker.setLatLng([latitude, longitude]);
        } else {
            currentMarker = L.marker([latitude, longitude]).addTo(map);
            currentMarker.bindPopup('Lokasi Anda');
            map.setView([latitude, longitude], 15);
        }

        // Find nearest office
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
            document.getElementById('nearest-office').innerHTML = 
                `${nearestOffice.name}<br>` +
                `Jarak: ${Math.round(shortestDistance)} meter<br>` +
                `<span class="badge ${inRadius ? 'bg-success' : 'bg-danger'}">${inRadius ? 'Dalam Radius' : 'Di Luar Radius'}</span>`;
        }
    }

    function watchCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(
                updateCurrentLocation,
                error => {
                    console.error('Geolocation error:', error);
                    document.getElementById('current-coordinates').innerHTML = 
                        'Error: Tidak dapat mengakses lokasi';
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            document.getElementById('current-coordinates').innerHTML = 
                'Error: Browser tidak mendukung geolocation';
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

    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', initMap);
    </script>
<?php endif; ?>
