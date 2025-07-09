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
<nav class="navbar navbar-expand-lg p-0px">
		<div class="container">
			<a href="<?= base_url() ?>">
				<img src="<?= base_url().'assets/uploads/'.$data['s_logo']; ?>" class="w-180px" alt="Logo">
			</a>
			<div class="navbar-auth">
				<div class="list-item list-item-inline-flex list-item-align-items-center">
					<li class="list-item-li">
						<a href="<?= base_url(); ?>booking/myaccount" class="theme-btn theme-border-radius theme-btn-primary"><?php if(isset($this->session->userdata['session_data_fr']['c_name'])) { ?> Welcome , <?= ucfirst($this->session->userdata['session_data_fr']['c_name']); ?> <?php } else { echo 'Sign In'; } ?></a>
					</li>
				</div>
			</div>
		</div>
	</nav>
	<!-- header -->