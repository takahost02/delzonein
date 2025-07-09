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
                            <form id="form_register" class="form-border" method="post" action="<?= base_url(); ?>booking/signup">
							        <h4 class="m-0px mb-30px text-center">Signup your account</h4>
							        <div class="form-group mb-20px">
										<label class="mb-5px">Name</label>
										<input type="text" class="form-control" name="c_name" required placeholder="Enter your full name">
									</div>
									<div class="form-group mb-20px">
										<label class="mb-5px">Mobile</label>
										<input type="text" class="form-control" name="c_mobile" required placeholder="Enter your mobile number">
									</div>
									<div class="form-group mb-20px">
										<label class="mb-5px">Email</label>
										<input type="email" class="form-control" name="c_email" required placeholder="Enter your email address">
									</div>
									<div class="form-group mb-20px">
										<label class="mb-5px">Password</label>
										<input type="password" class="form-control" name="c_pwd" required placeholder="Create a strong password">
									</div>
									<div class="form-group mb-20px">
										<label class="mb-5px">Address</label>
										<input type="text" class="form-control" name="c_address" required placeholder="Enter your residential address">
									</div>

							        <div class="form-group mb-20px d-grid">
							            <button type="submit" class="theme-btn theme-border-radius theme-btn-primary">Sign Up</button>
							        </div>
                                    <?php $successMessage = $this->session->flashdata('successmessage');  
                                          $warningmessage = $this->session->flashdata('warningmessage');                    
										  if (!empty($successMessage)) { 
											echo '<div id="alertmessage" class="col-md-12 d-flex justify-content-center">
                                        <div class="alert alert-danger p-10px pl-15px pr-15px theme-border-radius text-center">
                                            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                            '. $successMessage.'
                                        </div>
                                    </div>'; } 
									if (!empty($warningmessage)) { 
										echo '<div id="alertmessage" class="col-md-12 d-flex justify-content-center">
                                        <div class="alert alert-danger p-10px pl-15px pr-15px theme-border-radius text-center">
                                            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                            '. $warningmessage.'
                                        </div>
                                    </div>'; }    
                                    ?>
							        <p class="m-0px">Already have an account? | <a href="<?= base_url(); ?>booking/myaccount">Login</a></p>
							    </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include(APPPATH . 'views/frontend/footer.php'); ?>
