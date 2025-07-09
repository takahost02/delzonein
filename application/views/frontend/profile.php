<?php include(APPPATH . 'views/frontend/header.php'); ?>
<div class="account">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="col-item">
					<div class="card author-wrap">
							
							<h4 class="author-name"> Hi, <?php if(isset($this->session->userdata['session_data_fr']['c_name'])) { echo ucfirst($this->session->userdata['session_data_fr']['c_name']); } ?>        </h4>
							<p class="author-email"><?php if(isset($this->session->userdata['session_data_fr']['c_email'])) { echo ucfirst($this->session->userdata['session_data_fr']['c_email']); } ?></p>
							<ul class="account-widgets-links">
                            <?php $isProfile = isset($_GET['profile']); ?>
                            <li class="<?= !$isProfile ? 'active' : ''; ?>">
									<a href="<?= base_url(); ?>booking/myaccount" class="theme-border-radius">
										<i class="mdi mdi-home"></i> Dashboard
									</a>
								</li>
								
								<li class="<?= $isProfile ? 'active' : ''; ?>">
									<a href="<?= base_url(); ?>booking/myaccount?profile" class="theme-border-radius">
										<i class="mdi mdi-account"></i> Profile
									</a>
								</li>
								<li><a href="<?= base_url(); ?>booking/logout" class="theme-border-radius"><i class="mdi mdi-logout"></i> Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="d-flex align-items-center justify-content-between mb-20px">
									<h4 class="m-0px">My Profile</h4>
									
								</div>
								<form name="contactForm" id="contact_form" method="post" method="post" action="<?php echo base_url() ?>booking/updateprofile">
									<div class="row">
										<div class="col-lg-6">
											<div class="mb-15px">
		                                    	<label>Name</label>
                                                <input type="text" name="c_name" id="c_name" class="form-control" placeholder="Enter name" value="<?php echo $customerdetails[0]['c_name']; ?>" />
                                                </div>
		                                </div>
		                                <div class="col-lg-6">
											<div class="mb-15px">
			                                    <label>Email</label>
                                                <input type="text" name="email_address" id="email_address" class="form-control" placeholder="Enter email" value="<?php echo htmlspecialchars($customerdetails[0]['c_email']); ?>" />
                                                </div>
		                                </div>
		                                <div class="col-lg-6">
											<div class="mb-15px">
		                                    	<label>Mobile</label>
                                                <input type="text" name="mobile_number" id="mobile_number" class="form-control" placeholder="Enter mobile number" value="<?php echo htmlspecialchars($customerdetails[0]['c_mobile']); ?>" />
                                                </div>
		                                </div>
		                                <div class="col-lg-6">
											<div class="mb-15px">
		                                    	<label>Address</label>
                                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter address" value="<?php echo htmlspecialchars($customerdetails[0]['c_address']); ?>" />
                                                </div>
		                                </div>

                                        <div class="col-lg-6">
											<div class="mb-15px">
		                                    	<label>New Password</label>
                                                <input type="password" name="user_password" id="user_password" class="form-control" placeholder="********" />
                                                </div>
		                                </div>

                                        <div class="col-lg-6">
											<div class="mb-15px">
		                                    	<label>Re-enter Password</label>
                                                <input type="password" name="user_password_re-enter" id="user_password_re-enter" class="form-control" placeholder="********" />
                                                </div>
		                                </div>
		                                <div class="col-lg-12">
		                                	<button type="submit" class="theme-btn theme-border-radius theme-btn-primary">
		                                		Update <i class="mdi mdi-check"></i>
		                                	</button>   
		                                </div>
                                        <br> <br>
                                        <?php $successMessage = $this->session->flashdata('successmessage');  
           $warningmessage = $this->session->flashdata('warningmessage');                    
            if (isset($successMessage)) { echo '<div id="alertmessage" class="col-md-12">
                <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button><span>
                         '. $successMessage.'
                        </span></div>
                </div>'; } 
            if (isset($warningmessage)) { echo '<div id="alertmessage" class="col-md-12">
                <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                         '. $warningmessage.'
                      </div>
                </div>'; }    
            ?>
	                                </div>
	                            </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include(APPPATH . 'views/frontend/footer.php'); ?>
