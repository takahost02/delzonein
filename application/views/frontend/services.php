<?php include(APPPATH . 'views/frontend/header.php'); 
$data = sitedata();
?>

<!-- Service Banner -->
<section class="slider">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-12">
                <div class="slider-form text-center p-40px">
                    <h1 class="text-white fs-60px mb-20px">Premium Vehicle Rental Services</h1>
                    <p class="text-white fs-18px mb-0px">Comfortable. Affordable. Reliable. Your journey starts here.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="theme-bg-white py-50px">
    <div class="container">
        <div class="section-wrap section-title-center mb-40px">
            <h4 class="section-title">
                <i class="mdi mdi-star-circle section-title-icon theme-border-radius theme-bg-primary"></i> Why Choose Us
            </h4>
            <p class="section-content">We provide a seamless experience from booking to destination.</p>
        </div>
        <div class="row text-center">
            <div class="col-md-4 mb-30px">
                <div class="col-item p-30px theme-border-radius theme-bg-light">
                    <i class="mdi mdi-car fs-40px theme-text-primary mb-15px"></i>
                    <h5>Wide Fleet Selection</h5>
                    <p>Choose from economy to luxury vehicles tailored to your needs.</p>
                </div>
            </div>
            <div class="col-md-4 mb-30px">
                <div class="col-item p-30px theme-border-radius theme-bg-light">
                    <i class="mdi mdi-clock-fast fs-40px theme-text-primary mb-15px"></i>
                    <h5>Flexible Booking</h5>
                    <p>Hourly, daily, or custom rentals. Plan your trip your way.</p>
                </div>
            </div>
            <div class="col-md-4 mb-30px">
                <div class="col-item p-30px theme-border-radius theme-bg-light">
                    <i class="mdi mdi-shield-check fs-40px theme-text-primary mb-15px"></i>
                    <h5>Safety First</h5>
                    <p>All vehicles are sanitized and regularly maintained for your safety.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fleet Showcase -->
<section class="listings theme-bg-white py-50px">
    <div class="container">
        <div class="section-wrap section-title-center mb-40px">
            <h4 class="section-title">
                <i class="mdi mdi-car-multiple section-title-icon theme-border-radius theme-bg-primary"></i> Our Fleet
            </h4>
            <p class="section-content">Explore our popular rides and find what suits you best.</p>
        </div>
        <div class="items-carousel custom-slick-carousel hover-slick-btn1 slick-dots-primary-default" data-item="4">
            <?php if (!empty($vechiclelist)) foreach ($vechiclelist as $vl) { ?>
                <div>
                    <div class="col-item">
                        <div class="listings-wrap theme-border-radius">
                            <div class="listing-img">
                                <?php if ($vl['v_file'] && file_exists(FCPATH . 'assets/uploads/' . $vl['v_file'])) { ?>
                                    <img class="img-fluid" src="<?= base_url(); ?>assets/uploads/<?= $vl['v_file']; ?>" alt="Vehicle">
                                <?php } else { ?>
                                    <img class="img-fluid" src="<?= base_url(); ?>uploads/noimage.png" alt="Vehicle">
                                <?php } ?>
                            </div>
                            <div class="listing-content">
                                <div class="listing-price">
                                    <h4>Price from <span><?= $data['s_price_prefix'] . output(intval($vl['v_defaultcost'])); ?> | <span><?= output($vl['v_default_billing_type']); ?></span></h4>
                                </div>
                                <h4 class="listing-name"><a href="#"><?= output($vl['v_name']); ?></a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="theme-bg-light py-50px">
    <div class="container">
        <div class="section-wrap section-title-center mb-40px">
            <h4 class="section-title"><i class="mdi mdi-comment-quote section-title-icon theme-border-radius theme-bg-primary"></i> What Our Customers Say</h4>
            <p class="section-content">Real stories from our happy customers.</p>
        </div>
        <div class="row">
            <div class="col-md-6 mb-30px">
                <div class="col-item p-20px theme-border-radius theme-bg-white">
                    <p>"Booking was super smooth, and the car was clean and ready. Definitely recommending to friends!"</p>
                    <h6 class="m-0px mt-10px">- Ramesh Patel</h6>
                </div>
            </div>
            <div class="col-md-6 mb-30px">
                <div class="col-item p-20px theme-border-radius theme-bg-white">
                    <p>"Excellent customer support and a fantastic variety of cars. Will book again."</p>
                    <h6 class="m-0px mt-10px">- Anita Sharma</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section theme-bg-primary text-white text-center py-50px">
    <div class="container">
        <h4 class="fs-35px mb-15px">Ready to Ride?</h4>
        <p class="mb-20px">Book your next trip with us and experience the comfort of premium travel.</p>
        <a href="<?= base_url('booking'); ?>" class="theme-btn theme-border-radius theme-btn-light">Book Now</a>
    </div>
</section>

<?php include(APPPATH . 'views/frontend/footer.php'); ?>
