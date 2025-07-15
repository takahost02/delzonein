<?php include(APPPATH . 'views/frontend/header.php'); 
$data = sitedata();
?>

<div class="theme-bg-white py-60px">
    <div class="container">
        <div class="row">
            <!-- Contact Form Section -->
            <div class="col-lg-6 mb-4">
                <div class="col-item">
                    <div class="p-30px theme-bg-light theme-border-radius">
                        <h4 class="theme-text-primary mb-20px">Get in Touch</h4>

                        <?php
                        $success = $this->session->flashdata('successmessage');
                        $error = $this->session->flashdata('warningmessage');
                        if (!empty($success)) {
                            echo '<div class="alert alert-success theme-border-radius">' . $success . '</div>';
                        } elseif (!empty($error)) {
                            echo '<div class="alert alert-danger theme-border-radius">' . $error . '</div>';
                        }
                        ?>

                        <form method="post" action="<?= base_url('contact/submit'); ?>" id="contactForm">
                            <div class="mb-15px">
                                <label class="mb-5px">Your Name</label>
                                <input type="text" name="name" class="form-control theme-border-radius" required>
                            </div>

                            <div class="mb-15px">
                                <label class="mb-5px">Email Address</label>
                                <input type="email" name="email" class="form-control theme-border-radius" required>
                            </div>

                            <div class="mb-15px">
                                <label class="mb-5px">Subject</label>
                                <input type="text" name="subject" class="form-control theme-border-radius" required>
                            </div>

                            <div class="mb-15px">
                                <label class="mb-5px">Your Message</label>
                                <textarea name="message" rows="5" class="form-control theme-border-radius" required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="theme-btn theme-btn-primary theme-border-radius">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info Section -->
            <div class="col-lg-6">
                <div class="col-item">
                    <div class="p-30px theme-bg-primary text-white theme-border-radius">
                        <h4 class="mb-20px">Contact Details</h4>

                        <p class="mb-10px"><strong>Address:</strong><br> <?= isset($data['s_address']) ? $data['s_address'] : 'Company Address Here'; ?></p>
                        <p class="mb-10px"><strong>Phone:</strong><br> <a href="tel:<?= $data['s_contact']; ?>" class="text-white"><?= $data['s_contact']; ?></a></p>
                        <p class="mb-10px"><strong>Email:</strong><br> <a href="mailto:<?= $data['s_email']; ?>" class="text-white"><?= $data['s_email']; ?></a></p>

                        <h5 class="mt-30px mb-15px">Follow Us</h5>
                        <div class="d-flex gap-2">
                            <?php if (!empty($data['s_facebook'])): ?>
                                <a href="<?= $data['s_facebook']; ?>" target="_blank" class="text-white"><i class="mdi mdi-facebook fs-24px"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($data['s_instagram'])): ?>
                                <a href="<?= $data['s_instagram']; ?>" target="_blank" class="text-white"><i class="mdi mdi-instagram fs-24px"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($data['s_twitter'])): ?>
                                <a href="<?= $data['s_twitter']; ?>" target="_blank" class="text-white"><i class="mdi mdi-twitter fs-24px"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

<!-- Leaflet Map -->
<div class="leaflet-map theme-bg-white">
    <div id="map" style="height: 400px;"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('map').setView([<?= $data['s_latitude'] ?? '28.6139'; ?>, <?= $data['s_longitude'] ?? '77.2090'; ?>], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    L.marker([<?= $data['s_latitude'] ?? '28.6139'; ?>, <?= $data['s_longitude'] ?? '77.2090'; ?>])
        .addTo(map)
        .bindPopup("<?= $data['s_site_name'] ?? 'Our Office Location'; ?>")
        .openPopup();
});
</script>

<?php include(APPPATH . 'views/frontend/footer.php'); ?>
