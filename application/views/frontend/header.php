<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php 
         $data = sitedata();
         $total_segments = $this->uri->total_segments(); 
         echo ucwords(str_replace('_', ' ', 'Booking')).' | '.output($data['s_companyname']) ?></title>

	<link rel="icon" type="image/x-icon" href="<?= base_url().'assets/uploads/'.$data['s_logo'] ?>">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/fonts/fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/fonts/material-design-icons/css/materialdesignicons.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/animate/css/animate.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/slick/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/slick/slick/slick-theme.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/datepicker/css/datepicker.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/datatables/css/dataTables.bootstrap5.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/plugins/datatables/css/responsive.bootstrap5.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/spacing.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/width-height.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/font-size.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/border-plus-outline.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/border-radius.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/custom-slick.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/custom-select2.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/custom-datepicker.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/frontend/css/responsive.css">

	<style>
		:root {
			--theme-color-primary: <?php echo $content['primary_color']; ?>;
			--theme-color-secondary: <?php echo $content['secondary_color']; ?>;
			--theme-text-color: #7a7a7a;
		}
		.slider {
			background-image: url(<?php echo base_url().'assets/uploads/'.$content['mainbg_img']; ?>);
		}
	</style>

</head>
<body id="body-id" class="body-class home-1">

	<!-- top header -->
	<div id="top-header" class="top-header theme-bg-secondary">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="row d-flex align-items-center">
						<div class="col-lg-6">
							<div class="top-header-item top-header-left">
								<ul class="list-item list-item-inline-flex list-item-block-md list-item-align-items-center list-item-right-spacing">
									<li><a href="#"><i class="mdi mdi-email-open-outline"></i> <?php echo (isset($content)) ? $content['email'] : ''; ?></a></li>
									<li><a href="#"><i class="mdi mdi-phone-in-talk"></i> <?php echo (isset($content)) ? $content['phone'] : ''; ?></a></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="top-header-item top-header-right">
								<ul class="list-item list-item-inline-flex list-item-left-spacing social-icons">
									<li><?php echo (isset($content['facebook_link']) && $content['facebook_link']!='') ? '<a target="_blank" href="'.$content['facebook_link'].'"><i class="mdi mdi-facebook"></i></a>' : ''; ?> </li>
									<li><?php echo (isset($content['twitter_link']) && $content['twitter_link']!='') ? '<a target="_blank" href="'.$content['twitter_link'].'"><i class="mdi mdi-twitter"></i></a>' : ''; ?>  </li>
                                    <li><?php echo (isset($content['instagram_link']) && $content['instagram_link']!='') ? '<a target="_blank" href="'.$content['instagram_link'].'"><i class="mdi mdi-instagram"></i></a>' : ''; ?>  </li>
                                    <li><?php echo (isset($content['linkedin_link']) && $content['linkedin_link']!='') ? '<a target="_blank" href="'.$content['linkedin_link'].'"><i class="mdi mdi-linkedin"></i></a>' : ''; ?> </li> 
                                    <li><?php echo (isset($content['youtube_link']) && $content['youtube_link']!='') ? '<a target="_blank" href="'.$content['youtube_link'].'"><i class="mdi mdi-youtube"></i></a>' : ''; ?>  </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- header -->
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url().'assets/uploads/'.$data['s_logo']; ?>" class="w-180px" alt="Logo">
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('about-us') ?>">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('network') ?>">Network</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('services') ?>">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('contact-us') ?>">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('join-us') ?>">Join Us</a>
                </li>
            </ul>

            <!-- Auth Button -->
            <div class="d-flex ms-lg-3 mt-3 mt-lg-0">
                <?php
                    $current_url = current_url();
                    $account_url = base_url('booking/myaccount');

                    if ($current_url === $account_url): ?>
                        <a href="<?= base_url(); ?>" class="btn btn-primary theme-border-radius">
                            Book Trip
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('booking/myaccount'); ?>" class="btn btn-primary theme-border-radius">
                            <?= isset($this->session->userdata['session_data_fr']['c_name']) ? 'Profile' : 'Sign In'; ?>
                        </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

	<!-- header -->