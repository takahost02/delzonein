<?php include(APPPATH . 'views/frontend/header.php');
$data = sitedata();
?>

<section class="join-section theme-bg-white">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6">
                <div class="col-item">
                    <div class="p-30px theme-bg-light theme-border-radius">
                        <h3 class="mb-20px theme-text-primary">Join Our Network</h3>
                        <p class="mb-20px">Become a part of our growing transportation platform. Whether you're a driver or fleet owner, we provide the tools and support to help you succeed.</p>

                        <?php
                        $success = $this->session->flashdata('successmessage');
                        $error = $this->session->flashdata('warningmessage');
                        if (!empty($success)) {
                            echo '<div class="alert alert-success theme-border-radius">' . $success . '</div>';
                        } elseif (!empty($error)) {
                            echo '<div class="alert alert-danger theme-border-radius">' . $error . '</div>';
                        }
                        ?>

                        <form method="post" action="<?= base_url('booking/submit'); ?>" class="mt-3">
                            <div class="row">
                                <div class="col-md-6 mb-15px">
                                    <label class="mb-5px">Full Name</label>
                                    <input type="text" name="name" class="form-control theme-border-radius" required>
                                </div>
                                <div class="col-md-6 mb-15px">
                                    <label class="mb-5px">Email</label>
                                    <input type="email" name="email" class="form-control theme-border-radius" required>
                                </div>
                                <div class="col-md-6 mb-15px">
                                    <label class="mb-5px">Phone</label>
                                    <input type="tel" name="phone" class="form-control theme-border-radius" required>
                                </div>
                                <div class="col-md-6 mb-15px">
                                    <label class="mb-5px">Join As</label>
                                    <select name="role" class="form-control theme-border-radius" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="driver">Driver</option>
                                        <option value="vehicle_owner">Vehicle Owner</option>
                                        <option value="lm_partner">LM Partner</option>
										<option value="frenchise">Frenchise</option>
										<option value="delivery_associate">Delivery Associate</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-15px">
                                    <label class="mb-5px">Message</label>
                                    <textarea name="message" class="form-control theme-border-radius" rows="4" placeholder="Tell us why you want to join..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid justify-content-end">
                                        <button type="submit" class="theme-btn theme-border-radius theme-btn-primary">Submit Application</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right-side content -->
            <div class="col-lg-6">
                <div class="col-item ml-40px">
                    <h4 class="theme-text-primary mb-25px"><?= $content['join_heading'] ?? 'Drive. Earn. Grow.' ?></h4>
                    <h1 class="text-white mb-30px fs-50px"><?= $content['join_subheading'] ?? 'Become Part of a Reliable Transport Network' ?></h1>
                    <p class="text-white"><?= $content['join_description'] ?? 'We are always looking for passionate and responsible individuals to help us move the world. With flexible hours, great earning potential, and a supportive platform – joining us is a smart move.' ?></p>
                    <a href="#contact_form" class="theme-btn theme-border-radius theme-btn-light mt-20px">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials or Benefits Section (Optional) -->
<section class="theme-bg-light mt-40px pt-40px pb-40px">
    <div class="container">
        <div class="section-wrap text-center mb-30px">
            <h4 class="section-title">
                <i class="mdi mdi-account-multiple-check theme-bg-primary theme-border-radius"></i> Why Join Us?
            </h4>
            <p class="section-content">Top reasons our drivers and fleet owners love being part of our ecosystem.</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-30px">
                <div class="p-20px theme-bg-white theme-border-radius text-center h-100">
                    <h5>Earn More</h5>
                    <p>Competitive earnings with regular bonuses for consistent service and peak hours.</p>
                </div>
            </div>
            <div class="col-md-4 mb-30px">
                <div class="p-20px theme-bg-white theme-border-radius text-center h-100">
                    <h5>Flexible Hours</h5>
                    <p>Work at your own pace. Choose your shifts and enjoy full flexibility.</p>
                </div>
            </div>
            <div class="col-md-4 mb-30px">
                <div class="p-20px theme-bg-white theme-border-radius text-center h-100">
                    <h5>Reliable Support</h5>
                    <p>24/7 support team and dedicated onboarding specialists to guide you at every step.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(APPPATH . 'views/frontend/footer.php'); ?>
