<?php include(APPPATH . 'views/frontend/header.php'); ?>

<!-- About Us Hero Section -->
<section class="theme-bg-primary text-white py-60px">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto text-center">
                <h1 class="fs-60px mb-20px">About Us</h1>
                <p class="fs-18px">Learn more about who we are, what drives us, and how we serve you better every day.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Content Section -->
<section class="py-60px theme-bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-30px">
                <img src="<?= base_url(); ?>assets/images/about/about-us.jpg" alt="About Us" class="img-fluid theme-border-radius">
            </div>
            <div class="col-lg-6">
                <h3 class="theme-text-primary mb-20px">Who We Are</h3>
                <p>We are a team of passionate professionals dedicated to simplifying your travel experiences. With years of experience in fleet and logistics management, we provide reliable, timely, and affordable transport solutions for every need—be it personal or corporate.</p>
                <p>Our commitment to safety, customer satisfaction, and seamless technology integration ensures a premium experience from booking to destination.</p>
            </div>
        </div>
    </div>
</section>

<!-- Mission and Vision Section -->
<section class="theme-bg-light py-60px">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-30px">
                <div class="p-30px theme-border-radius theme-bg-white h-100">
                    <h4 class="theme-text-primary mb-15px"><i class="mdi mdi-target"></i> Our Mission</h4>
                    <p>To redefine the transport experience by offering high-quality, safe, and technology-enabled services that put our customers first—every time.</p>
                </div>
            </div>
            <div class="col-lg-6 mb-30px">
                <div class="p-30px theme-border-radius theme-bg-white h-100">
                    <h4 class="theme-text-primary mb-15px"><i class="mdi mdi-eye"></i> Our Vision</h4>
                    <p>To be the most trusted and innovative mobility provider in the region, leading with integrity, efficiency, and sustainability.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-60px">
    <div class="container">
        <div class="row mb-40px">
            <div class="col-lg-8 m-auto text-center">
                <h4 class="section-title"><i class="mdi mdi-star-circle section-title-icon theme-bg-primary theme-border-radius"></i> Why Choose Us</h4>
                <p class="section-content">We go beyond just booking a ride. Here's why customers love us:</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-30px">
                <div class="p-20px theme-border-radius theme-bg-light h-100">
                    <i class="mdi mdi-car fs-40px theme-text-primary mb-10px"></i>
                    <h5>Wide Fleet Options</h5>
                    <p>From sedans to SUVs, we’ve got the right vehicle for every journey.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-30px">
                <div class="p-20px theme-border-radius theme-bg-light h-100">
                    <i class="mdi mdi-shield-check fs-40px theme-text-primary mb-10px"></i>
                    <h5>Safe & Verified</h5>
                    <p>Our drivers and vehicles undergo thorough safety checks and training.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-30px">
                <div class="p-20px theme-border-radius theme-bg-light h-100">
                    <i class="mdi mdi-clock-check fs-40px theme-text-primary mb-10px"></i>
                    <h5>On-Time Service</h5>
                    <p>Punctuality is our promise, ensuring timely pickups and drop-offs.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-30px">
                <div class="p-20px theme-border-radius theme-bg-light h-100">
                    <i class="mdi mdi-cellphone fs-40px theme-text-primary mb-10px"></i>
                    <h5>Easy Booking</h5>
                    <p>Our modern booking system ensures a hassle-free experience on any device.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info CTA -->
<section class="cta-section theme-bg-primary text-white text-center py-40px">
    <div class="container">
        <h4 class="fs-30px mb-15px">Have Questions or Need Help?</h4>
        <p class="mb-20px">Our team is here to assist you 24/7. Get in touch with us now.</p>
        <a href="tel:<?= $data['s_phone'] ?? '000-000-0000'; ?>" class="theme-btn theme-border-radius theme-btn-white">Call Now: <?= $data['s_phone'] ?? '000-000-0000'; ?></a>
    </div>
</section>

<?php include(APPPATH . 'views/frontend/footer.php'); ?>
