
	<!-- footer -->
	<div id="footer" class="footer theme-bg-secondary">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-4">
							<div class="col-item">
								<h4 class="m-0px mb-30px pb-10px text-white theme-border-bottom-1px">About Company</h4>
								<p class="footer-brand-content"><?php echo (isset($content)) ? $content['about_us'] : ''; ?></p>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="col-item">
								<h4 class="m-0px mb-30px pb-10px text-white theme-border-bottom-1px">Contact Info</h4>
								<div class="footer-company-details">
									<p><i class="mdi mdi-map-marker"></i> <?php echo (isset($content)) ? $content['contact_address'] : ''; ?></p>
									<p><i class="mdi mdi-phone"></i> <?php echo (isset($content)) ? $content['phone'] : ''; ?></p>
									<p><i class="mdi mdi-email-open"></i> <?php echo (isset($content)) ? $content['email'] : ''; ?></p>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="col-item">
								<h4 class="m-0px mb-30px pb-10px text-white theme-border-bottom-1px">Social Networks</h4>
								<ul class="list-item list-item-inline-flex list-item-right-spacing social-icons">
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
	<!-- footer -->

	<!-- sub footer -->
	<div id="sub-footer" class="sub-footer theme-bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="row d-flex align-items-center">
						<div class="col-lg-6">
							<div class="sub-footer-item sub-footer-left">
								<p class="m-0px">Copyright &copy; <?php echo date('Y') ?> - <?= $data['s_companyname']; ?>
                </p>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="sub-footer-item sub-footer-right">
								<ul class="list-item list-item-inline-flex list-item-right-spacing list-item-divider">
                <li><a href="#" data-toggle="modal" data-target="#termsModal" id="terms-link">Terms &amp; Conditions</a></li>
                <li><a href="#" data-toggle="modal" data-target="#privacyModal" id="privacy-link">Privacy Policy</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  
  <div class="backtotop">
        <a href="#body-id" class="theme-btn theme-btn-white theme-border-1px easing-click">
            <i class="mdi mdi-arrow-up fs-20px"></i>
        </a>
    </div>
	<!-- backtotop -->


	<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="terms-content">
        <!-- Terms content will go here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Privacy Policy -->
<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body" id="privacy-content">
        <!-- Privacy content will be injected here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

	<script src="<?= base_url(); ?>assets/frontend/plugins/jquery/jquery.min.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

	<script src="<?= base_url(); ?>assets/frontend/plugins/datatables/js/dataTables.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/datatables/js/dataTables.bootstrap5.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/datatables/js/dataTables.responsive.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/datatables/js/responsive.bootstrap5.js"></script>

	<script src="<?= base_url(); ?>assets/frontend/plugins/datepicker/js/datepicker.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/select2/select2.min.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/select2/select2.full.min.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/slick/slick/slick.min.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/plugins/jquery-easing/jquery.easing.min.js"></script>
	
	<script src="<?= base_url(); ?>assets/frontend/js/main.js"></script>
	<script src="<?= base_url(); ?>assets/frontend/js/custom-slick.js"></script>

	<script>
		$('#terms-link').click(function(event) {
			event.preventDefault();
        var term = `<?php echo $content['terms']; ?>`;
        var terms = term.replace(/["']/g, '');
        $('#terms-content').html(terms); 
        $('#termsModal').modal('show');  
     });

     $('#privacy-link').click(function(event) {
     	event.preventDefault();
        var priv = `<?php echo $content['privacy_policy']; ?>`;
        var privacy = priv.replace(/["']/g, '');
        $('#privacy-content').html(privacy); 
        $('#privacyModal').modal('show');    
     });
	</script>

</body>
</html>