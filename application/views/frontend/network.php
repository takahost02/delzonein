<?php include(APPPATH . 'views/frontend/header.php');
$data = sitedata();
?>

<section class="theme-bg-light py-60px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-wrap section-title-center">
                    <h4 class="section-title">
                        <i class="mdi mdi-map-marker-radius section-title-icon theme-border-radius theme-bg-primary"></i>
                        Our Service Network
                    </h4>
                    <p class="section-content">We are proudly operating in major cities and regions, ensuring top-notch vehicle service accessibility and seamless bookings across a growing network.</p>
                </div>
            </div>
        </div>

        <div class="row mt-30px">
            <?php if (!empty($networkList)) { foreach ($networkList as $net) { ?>
                <div class="col-md-4 mb-30px">
                    <div class="col-item p-25px theme-bg-white theme-border-radius h-100">
                        <h5 class="theme-text-primary mb-10px"><i class="mdi mdi-city"></i> <?= output($net['city_name']); ?></h5>
                        <p class="mb-0"><strong>State:</strong> <?= output($net['state']); ?></p>
                        <p class="mb-0"><strong>Zone:</strong> <?= output($net['zone']); ?></p>
                        <p class="mb-0"><strong>Service Centers:</strong> <?= output($net['center_count']); ?></p>
                    </div>
                </div>
            <?php } } else { ?>
                <div class="col-lg-12">
                    <div class="alert alert-warning theme-border-radius">No network data available at the moment. Please check back later.</div>
                </div>
            <?php } ?>
        </div>

        <!-- Optional Map -->
        <div class="row mt-40px">
            <div class="col-lg-12">
                <div class="section-wrap section-title-center">
                    <h5 class="mb-20px">Coverage Map</h5>
                    <div id="coverage-map" style="height: 500px;" class="theme-border-radius"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('coverage-map').setView([22.9734, 78.6569], 5); // Centered on India
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);

    <?php if (!empty($networkList)) {
        foreach ($networkList as $net) {
            if (!empty($net['latitude']) && !empty($net['longitude'])) { ?>
                L.marker([<?= $net['latitude']; ?>, <?= $net['longitude']; ?>])
                    .addTo(map)
                    .bindPopup("<strong><?= addslashes($net['city_name']); ?></strong><br><?= addslashes($net['zone']); ?>");
    <?php } } } ?>
});
</script>

<?php include(APPPATH . 'views/frontend/footer.php'); ?>
