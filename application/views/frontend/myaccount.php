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
                            <?php  $isProfile = isset($_GET['profile']); ?>
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
                <?php
                    if (is_countable($mybookings)) {
                        $totalBookings = count($mybookings);
                    } else {
                        $totalBookings = 0; 
                    }
                    $upcomingBookings = 0;
                    $completedTrips = 0;
                    $cancelledBookings = 0;
                    $currentDate = date('Y-m-d H:i:s');
                    if($totalBookings>0) {
                    foreach ($mybookings as $trip) {
                        if (isset($trip['t_start_date']) && $trip['t_start_date'] >= $currentDate) {
                            $upcomingBookings++;
                        }
                        if (isset($trip['t_trip_status']) && $trip['t_trip_status'] === 'Completed') {
                            $completedTrips++;
                        }
                        if (isset($trip['t_trip_status']) && $trip['t_trip_status'] === 'Trip Cancelled') {
                            $cancelledBookings++;
                        }
                    }
                    }

                ?>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-3">
							<div class="col-item">
								<div class="card">
									<div class="dashboard-col-box">
										<i class="mdi mdi-calendar-clock"></i>
									</div>
									<h3 class="dashboard-col-box-number"><?= $upcomingBookings; ?></h3>
									<p class="dashboard-col-box-name">Upcoming Bookings</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="col-item">
								<div class="card">
									<div class="dashboard-col-box">
										<i class="mdi mdi-calendar-check-outline"></i>
									</div>
									<h3 class="dashboard-col-box-number"><?= $completedTrips; ?></h3>
									<p class="dashboard-col-box-name">Completed Bookings</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="col-item">
								<div class="card">
									<div class="dashboard-col-box">
										<i class="mdi mdi-calendar"></i>
									</div>
									<h3 class="dashboard-col-box-number"><?= $totalBookings; ?></h3>
									<p class="dashboard-col-box-name">Total Bookings</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="col-item">
								<div class="card">
									<div class="dashboard-col-box">
										<i class="mdi mdi-calendar-remove"></i>
									</div>
									<h3 class="dashboard-col-box-number"><?= $cancelledBookings; ?></h3>
									<p class="dashboard-col-box-name">Cancel Bookings</p>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="card">
								<div class="d-flex align-items-center justify-content-between mb-20px">
									<h4 class="m-0px">My Orders</h4>
									
								</div>
								<div class="table-responsive-none">
									<table class="table table-striped nowrap datatable" style="width:100%">
										<thead>
											<tr>
								                <th>S.No</th>
								                <th>ID</th>
								                <th>Vehicle & Driver</th>
								                <th>Date</th>
								                <th>Trip Route</th>
								                <th>Status</th>
								                <th>Created</th>
								                <th>#</th>
								            </tr>
										</thead>
                                        
										<tbody>
                                        <?php
                                    $count=1; if(!empty($mybookings)) {  

                                        foreach($mybookings as $trip){
                                        ?>
											<tr>
                  <td><?php echo output($count++); ?></td>
                  <td><?php echo output($trip['t_bookingid']); ?></td>
                  <td>
                    <strong>Vehicle:</strong> <?php echo (isset($trip['t_vechicle_details']->v_name))?output($trip['t_vechicle_details']->v_name):'<span class="badge rounded-pill bg-warning">Yet to Assign</span>'; ?><br>
                    <strong>Driver:</strong> 
                    <?php echo isset($trip['t_driver_details']->d_name) ? $trip['t_driver_details']->d_name : '<span class="badge rounded-pill bg-warning">Yet to Assign</span>'; ?>
                  </td>
                  <td>
                    <strong>Start:</strong> <?php echo date(datetimeformat(), strtotime($trip['t_start_date'])); ?><br>
                    <strong>End:</strong> <?php echo date(datetimeformat(), strtotime($trip['t_end_date'])); ?>
                  </td>
                  <td>
                    <strong>From:</strong> <?php echo output($trip['t_trip_fromlocation']); ?><br>
                    <strong>To:</strong> <?php echo output($trip['t_trip_tolocation']); ?>
                  </td>
                  <td>
                    <span class="badge rounded-pill bg-success"><?php echo output($trip['t_trip_status']); ?></span><br>
                    <strong>Billing:</strong> <?php echo ($trip['t_billingtype']!='')?$trip['t_billingtype']:'N/A'; ?>
                  </td>
                  <td>
                    <?php echo date(datetimeformat(), strtotime($trip['t_created_date'])); ?>
                  </td>
                    <td>
                        <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>booking/canceltrip','<?php echo output($trip['t_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger">
                          <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                                            <?php  } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- account -->
       
        <script type="text/javascript">
    function confirmation(href_url, id) {
        $('#action').attr('action', href_url);
        $('.del_id').val(id);
        $("#myModal").modal('show');
    }
</script>

<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content" style="text-align: center;">
            <form id="action" method="post">
            <div class="modal-header flex-column">
            <input class="form-control del_id" type="hidden" name="del_id">                   
                <h4 class="modal-title w-100"><b>Are you sure?</b></h4>    
            </div>
            <div class="modal-body">
                <p>Do you really want to cancel the booking?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
    </div>
</div>  
<?php include(APPPATH . 'views/frontend/footer.php'); ?>
