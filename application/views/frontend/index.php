<?php include(APPPATH . 'views/frontend/header.php'); 
$data = sitedata();
?>
	<nav class="slider">
		<div class="container">
			<div class="row d-flex align-items-center">
				<div class="col-lg-12">
					<div class="slider-form">
						<div class="row d-flex align-items-center">
							<div class="col-lg-6">
								<div class="col-item">
									<div class="p-30px theme-bg-white theme-border-radius">

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


										<h6 class="m-0px mb-15px">What is your vehicle type?</h6>
                                        <?php if(!isset($this->session->userdata['session_data_fr']['c_name'])) { ?>
										<div class="alert alert-danger p-10px pl-15px pr-15px theme-border-radius">Please log in to continue with your booking</div>
                                        <?php } ?>    
										<form name="contactForm" id="contact_form" method="post" action="<?php base_url(); ?>booking/book">
											<div class="row mb-15px">
												
                                            <?php if(!empty($group)) { foreach($group as $key => $vehcilegroup) { ?>
                                                <div class="col-lg-4">
													<div class="radio-item-wrap">
                                                <input id="car_<?= $key; ?>" name="t_requested_v_type" type="radio" value="<?= $vehcilegroup['gr_id']; ?>" >
														<label for="car_<?= $key; ?>" class="radio-label" for="radio1">
															<img src="<?= base_url(); ?>uploads/<?= $vehcilegroup['gr_image']; ?>" class="radio-image theme-border-radius">
														</label>
														<h5 class="m-0px mt-10px"><?= $vehcilegroup['gr_name']; ?></h5>
													</div>
												</div>
                                            <?php } } ?>     

											</div>
											<div class="p-20px theme-border-radius theme-bg-light">
												<div class="row">
													<div class="col-lg-6">
														<div class="mb-15px">
															<label class="mb-5px">Pick Up Location</label>
															<input type="text" name="t_trip_fromlocation" placeholder="Enter your pickup location" id="autocomplete" autocomplete="off" class="form-control theme-border-radius">
                                                            <ul id="autocomplete-list" class="autocomplete-list"></ul>
														</div>
													</div>
													<div class="col-lg-6">
														<div class="mb-15px">
															<label class="mb-5px">Drop Off Location</label>
															<input type="text" name="t_trip_tolocation" placeholder="Enter your dropoff location" id="autocomplete2" autocomplete="off" class="form-control theme-border-radius">
                                                            <ul id="autocomplete-list2" class="autocomplete-list"></ul>
														</div>
													</div>
													<div class="col-lg-6">
														<div class="mb-15px">
															<label class="mb-5px">From Date &amp; Time</label>
															<div class="input-group">
																<input type="text" class="form-control theme-border-radius datepicker" name="t_start_date" autocomplete="off" placeholder="dd/mm/yyyy">
																<select name="t_start_time" id="pickup-time" class="form-control theme-border-radius">
                                                                    <option selected disabled value="Select time">Time</option>
                                                                    <?= generateTimeOptions(getNearestNextInterval(date('H:i'))); ?>
                                                                </select>
															</div>
														</div>
													</div>
                                                    <?php 
                                                        $currentTime = getNearestNextInterval(date('H:i'));
                                                        $threeHoursLater = date('H:i', strtotime('+3 hours', strtotime($currentTime)));
                                                    ?>     
													<div class="col-lg-6">
														<div class="mb-15px">
															<label class="mb-5px">To Date &amp; Time</label>
															<div class="input-group">
																<input type="text" id="date-picker-2" class="form-control datepicker theme-border-radius" name="t_end_date" autocomplete="off" placeholder="dd/mm/yyyy">
																<select name="t_end_time" class="form-control theme-border-radius">
                                                                    <option selected disabled value="Select time">Time</option>
                                                                    <?= generateTimeOptions($threeHoursLater); ?>
																</select>
															</div>
														</div>
													</div>

                                                    <input type="hidden" id="t_trip_fromlat" name="t_trip_fromlat" value="1">
                                                    <input type="hidden" id="t_trip_fromlog" name="t_trip_fromlog" value="1">
                                                    <input type="hidden" id="t_trip_tolat" name="t_trip_tolat" value="1">
                                                    <input type="hidden" id="t_trip_tolog" name="t_trip_tolog" value="1">
                                                    <input type="hidden" id="t_totaldistance" name="t_totaldistance" value="">

                                                    <input type="hidden" name="t_bookingfrom" value="Frontend">

                                                    <input type="hidden" id="t_driver" name="t_driver" value="0">
                                                    <input type="hidden" id="t_type" name="t_type" value="singletrip">
                                                    <input type="hidden" id="t_trip_status" name="t_trip_status" value="Booked">
                                                    <input type="hidden" id="t_customer_id" name="t_customer_id" value="<?= (isset($this->session->userdata['session_data_fr']['c_id'])?$this->session->userdata['session_data_fr']['c_id']:''); ?>">
                                                   
                                                    <input type="hidden" id="t_created_by" name="t_created_by" value="<?= (isset($this->session->userdata['session_data_fr']['c_id'])?$this->session->userdata['session_data_fr']['c_id']:''); ?>">
                                                    <input type="hidden" id="bookingemail" name="bookingemail" value="<?= (isset($this->session->userdata['session_data_fr']['c_email'])?$this->session->userdata['session_data_fr']['c_email']:''); ?>">
                                                <input type="hidden" id="t_created_date" name="t_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">     


													<div class="col-lg-12">
														<div class="d-grid justify-content-end mt-10px">
															<button type="submit" class="theme-btn theme-border-radius theme-btn-primary">Book Now</button>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="col-item">
									<div class="ml-40px">
										<h4 class="theme-text-primary m-0px mb-25px"><?php echo (isset($content)) ? $content['text1'] : ''; ?></h4>
										<h1 class="text-white m-0px mb-30px fs-60px"><?php echo (isset($content)) ? $content['text2'] : ''; ?></h1>
										<p class="text-white m-0px"><?php echo (isset($content)) ? $content['text3'] : ''; ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<!-- navbar -->

	<!-- carousel -->
	<div id="listings" class="listings theme-bg-white">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-item">
								<div class="row">
									<div class="col-lg-6 m-auto">
										<div class="section-wrap section-title-center">
											<h4 class="section-title"><i class="mdi mdi-car section-title-icon theme-border-radius theme-bg-primary"></i> <?php echo (isset($content)) ? $content['our_fleet_heading'] : ''; ?></h4>
											<p class="section-content"><?php echo (isset($content)) ? $content['our_fleet_subtext'] : ''; ?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="items-carousel custom-slick-carousel hover-slick-btn1 slick-dots-primary-default" data-item="4">
                            <?php if(!empty($vechiclelist)) foreach($vechiclelist as $vl) { { ?>      
                                <div>
									<div class="col-item">
										<div class="listings-wrap theme-border-radius">
											<div class="listing-img">
                                            <?php if ($vl['v_file'] != '' && file_exists(FCPATH . 'assets/uploads/' . $vl['v_file'])) { ?>
                                            <img class="img-fluid"  src="<?= base_url(); ?>assets/uploads/<?= $vl['v_file']; ?>" alt="Vehicle Image">
                                            <?php } else { ?>
                                                <img class="img-fluid" style="height: 250px;"  src="<?= base_url(); ?>uploads/noimage.png" alt="Vehicle Image">
                                            <?php } ?>
											</div>
											<div class="listing-content">
												<div class="listing-price">
													<h4>Price from <span><?php echo $data['s_price_prefix'].output(intval($vl['v_defaultcost'])); ?> |<span><?php echo output($vl['v_default_billing_type']); ?></span></h4>
												</div>
												<h4 class="listing-name">
													<a href="#"><?php echo output($vl['v_name']); ?></a>
												</h4>
											</div>
										</div>
									</div>
								</div>
                            <?php } } ?> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- carousel -->

	<!-- call to action -->
	<div class="cta-section theme-bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="m-0px mt-20px fs-35px">Don't Miss Out! </h4>
					<p class="m-0px mb-20px"><?php echo (isset($content)) ? $content['call_to_action_text'] : ''; ?></p>
					<a href="#" class="theme-btn theme-border-radius theme-btn-primary">Call Us ! <?php echo (isset($content)) ? $content['call_to_action_number'] : ''; ?></a>
				</div>
			</div>
		</div>
	</div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<!-- Include Leaflet Control Geocoder -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<style>
    .autocomplete-list {
        position: absolute;
        z-index: 1000;
        width: 85%;
        background: white;
        max-height: 200px;
        overflow-y: auto;
    }
    .autocomplete-list li {
        list-style: none;
        padding: 8px;
        cursor: pointer;
    }
    .autocomplete-list li:hover {
        background: #f0f0f0;
    }
</style>
<?php include(APPPATH . 'views/frontend/footer.php'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function initAutocomplete(inputId, listId, latId, lonId) {
        let input = document.getElementById(inputId);
        let list = document.getElementById(listId);
        if (!input || !list) return;
        input.addEventListener("input", function () {
            let query = this.value.trim();
            if (!query) {
                list.innerHTML = "";
                return;
            }
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                .then(response => response.json())
                .then(data => {
                    list.innerHTML = "";
                    data.forEach(place => {
                        let item = document.createElement("li");
                        item.textContent = place.display_name;
                        item.onclick = function () {
                            input.value = place.display_name;
                            document.getElementById(latId).value = place.lat;
                            document.getElementById(lonId).value = place.lon;
                            list.innerHTML = "";
                            calculateDistance();
                        };
                        list.appendChild(item);
                    });
                })
                .catch(error => console.error("Error fetching location data:", error));
        });
        document.addEventListener("click", function (e) {
            if (!list.contains(e.target) && e.target !== input) {
                list.innerHTML = "";
            }
        });
    }
    function calculateDistance() {
        let lat1 = parseFloat(document.getElementById("t_trip_fromlat").value);
        let lon1 = parseFloat(document.getElementById("t_trip_fromlog").value);
        let lat2 = parseFloat(document.getElementById("t_trip_tolat").value);
        let lon2 = parseFloat(document.getElementById("t_trip_tolog").value);
        if (!lat1 || !lon1 || !lat2 || !lon2) return;
        let R = '<?= $data['s_mapunit']; ?>' === "mile" ? 3958.8 : 6371;
        let dLat = (lat2 - lat1) * Math.PI / 180;
        let dLon = (lon2 - lon1) * Math.PI / 180;
        let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
        let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        let distance = (R * c).toFixed(2); // Distance in km
        document.getElementById("t_totaldistance").value = distance;
    }
    initAutocomplete("autocomplete", "autocomplete-list", "t_trip_fromlat", "t_trip_fromlog");
    initAutocomplete("autocomplete2", "autocomplete-list2", "t_trip_tolat", "t_trip_tolog");
});
</script>