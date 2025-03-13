<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<p>Latitude: <span id="userLat">-</span></p>
<p>Longitude: <span id="userLng">-</span></p>
<p>Akurasi: <span id="userAccuracy">-</span></p>

<div id="map" style="height: 500px;"></div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
$(document).ready(function() {
    var map = L.map('map').setView([-6.1722320, 106.8220720], 15);
    var userMarker = null;
    var userAccuracyCircle = null;

    // Custom icons
    var officeIcon = L.divIcon({
        className: 'custom-div-icon',
        html: "<div style='background-color:#4838D1; padding:5px; border-radius:50%'><i class='bi bi-building text-white'></i></div>",
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    var userIcon = L.divIcon({
        className: 'custom-div-icon',
        html: "<div style='background-color:#c00; padding:5px; border-radius:50%'><i class='bi bi-person-fill text-white'></i></div>",
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ' OpenStreetMap'
    }).addTo(map);

    <?php foreach ($officeLocations as $office): ?>
    L.marker([<?= $office['latitude'] ?>, <?= $office['longitude'] ?>], {
        icon: officeIcon
    })
    .addTo(map)
    .bindPopup('<?= $office['name'] ?>');

    L.circle([<?= $office['latitude'] ?>, <?= $office['longitude'] ?>], {
        radius: <?= $office['radius'] ?>,
        color: '#4838D1',
        fillColor: '#4838D1',
        fillOpacity: 0.1
    }).addTo(map);
    <?php endforeach; ?>

    function updateUserLocation(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        
        // Update text
        $('#userLat').text(lat.toFixed(6));
        $('#userLng').text(lng.toFixed(6));
        $('#userAccuracy').text(accuracy.toFixed(1) + ' meter');
        
        if (userMarker) map.removeLayer(userMarker);
        if (userAccuracyCircle) map.removeLayer(userAccuracyCircle);

        userMarker = L.marker([lat, lng], {
            icon: userIcon
        }).addTo(map);

        userAccuracyCircle = L.circle([lat, lng], {
            radius: accuracy,
            color: '#c00',
            fillColor: '#c00',
            fillOpacity: 0.1
        }).addTo(map);

        map.setView([lat, lng], 17);
    }

    function handleLocationError(error) {
        alert("Error: " + error.message);
    }

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(updateUserLocation, handleLocationError, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 10000
        });

        navigator.geolocation.watchPosition(updateUserLocation, handleLocationError, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 10000
        });
    } else {
        alert("Browser Anda tidak mendukung geolocation.");
    }
});
</script>
<?= $this->endSection() ?>
