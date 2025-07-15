<?php include(APPPATH . 'views/frontend/header.php'); ?>


	<!-- signin -->
	<div class="signin">
		<div class="container">
			<div class="row g-0 d-flex align-items-center">
				<div class="col-lg-6 d-none d-lg-block">
					<div class="col-item">
						<img src="<?= base_url(); ?>assets/frontend/images/signin-img-1.png" class="w-100 p-60px" alt="SignIn Image">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="col-item">
						<div class="card">
							<div class="card-body">
                            <form id="form_register" class="form-border" method="post" action="<?= base_url(); ?>booking/login">
							        <h4 class="m-0px mb-30px text-center">Sign into your account</h4>
							        <div class="form-group mb-20px">
							            <label class="mb-5px">Email</label>
							            <input type="text" class="form-control" name="username" required placeholder="Your email">
							        </div>
							        <div class="form-group mb-20px">
							            <label class="mb-5px">Password</label>
							            <input type="password" class="form-control" name="password" required  placeholder="Your password">
							        </div>
							        <div class="form-group mb-20px d-grid">
							            <button type="submit" class="theme-btn theme-border-radius theme-btn-primary">Login</button>
							        </div>
                                    <?php $successMessage = $this->session->flashdata('successmessage');  
                                            $warningmessage = $this->session->flashdata('warningmessage');                    
                                                if (isset($successMessage)) { echo '<div id="alertmessage" class="col-md-12 d-flex justify-content-center">
                                        <div class="alert alert-success p-10px pl-15px pr-15px theme-border-radius text-center">
                                            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                            '. $successMessage.'
                                        </div>
                                    </div>'; } 
                                                if (isset($warningmessage)) { echo '<div id="alertmessage" class="col-md-12 d-flex justify-content-center">
                                        <div class="alert alert-danger p-10px pl-15px pr-15px theme-border-radius text-center">
                                            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                            '. $warningmessage.'
                                        </div>
                                    </div>'; }    
                                    ?>
							        <p class="m-0px">Don't have an account? | <a href="<?= base_url(); ?>booking/signup">Register here</a></p>
							    </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include(APPPATH . 'views/frontend/footer.php'); ?>
