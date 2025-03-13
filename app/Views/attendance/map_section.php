<!-- Map Section -->
<div class="col-md-12 mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div id="map"></div>
            <div id="nearest-office" class="mt-3 p-3 bg-light rounded">
                Mendapatkan lokasi...
            </div>
        </div>
    </div>
</div>

<!-- Add Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="<?= base_url('js/attendance-map.js') ?>"></script>

<!-- Initialize office locations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
