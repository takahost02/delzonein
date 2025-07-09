 
      
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Details
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Vehicle Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
      
    <!-- Main content -->
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <?php if($vehicledetails['v_file']!='') { ?>
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="<?= base_url(); ?>assets/uploads/<?= ($vehicledetails['v_file']); ?>">
                </div>
                <?php } ?>
                <h3 class="profile-username text-center"><?= ucwords($vehicledetails['v_name']); ?></h3>

                <p class="text-muted text-center"><?= ucwords($vehicledetails['v_type']); ?></p>

                

                <p class="text-muted text-center"><?= ($vehicledetails['v_is_active']==1)?'<span class="right badge badge-success">Active</span>':'<span class="right badge badge-danger">Inactive</span>' ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Bookings</b> <a class="float-right"><?= count($bookings); ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Geofence</b> <a class="float-right"><?= count($vechicle_geofence); ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Notifications</b> <a class="float-right"><?= count($geofence_events); ?></a>
                  </li>

                  <li class="list-group-item">
                    <b>Notifications</b> <a class="float-right"><?= count($geofence_events); ?></a>
                  </li>

                  <li class="list-group-item">
                    <b>Group</b> <a class="float-right"><?= $group; ?></a>
                  </li>
                 <?php 
                    $keyName = 'v_' . strtolower(str_replace(' ', '', $group)) . 'fields';
                    
                    if (isset($vehicledetails[$keyName]) && !empty($vehicledetails[$keyName])) { 
                        $data = unserialize($vehicledetails[$keyName]);
                        
                        foreach ($data as $key => $value) {
                            echo '<li class="list-group-item">';
                            echo '<b>' . htmlspecialchars(ucwords(preg_replace_callback('/([A-Z])/', function ($matches) use (&$count) {
                                return (++$count >= 1 ? ' ' : '') . $matches[0]; 
                            }, $key))) . '</b> <a class="float-right">' . htmlspecialchars($value) . '</a>';
                            echo '</li>';
                        }  
                    } 
                    ?>


                  <li class="list-group-item">
                    <b>Ownership</b> <a class="float-right"><?= ucfirst($vehicledetails['v_ownership']); ?></a>
                  </li>
                  <?php if($vehicledetails['v_ownership']=='vendor') { ?>
                  <li class="list-group-item">
                    <b>Start Date</b> <a class="float-right"><?= ($vehicledetails['v_lease_start_date']!='') ?  ''.output(showdate($vehicledetails['v_lease_start_date'])) : ''; ?></a>
                  </li>

                  <li class="list-group-item">
                    <b>End Date</b> <a class="float-right"><?= ($vehicledetails['v_lease_end_date']!='') ?  ''.output(showdate($vehicledetails['v_lease_end_date'])) : ''; ?></a>
                  </li>
                  <?php } ?>
                  <?php 
                  ?>
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                   <li class="nav-item"><a class="nav-link active" href="#basicinfo" data-toggle="tab">Basic Info</a></li>
                  <li class="nav-item"><a class="nav-link " href="#bookings" data-toggle="tab">Bookings</a></li>
                  <li class="nav-item"><a class="nav-link" href="#vechicle_geofence" data-toggle="tab">Geofence</a></li>
                <li class="nav-item"><a class="nav-link" href="#vechicle_incomexpense" data-toggle="tab">Income & Expense</a></li>
                <li class="nav-item"><a class="nav-link" href="#servicehistory" data-toggle="tab">Service History</a></li>

                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane " id="bookings">
                     <table id="bookingstbl" class="table table-striped projects">
                          <thead>
                              <tr>
                                  <th class="percent1">
                                      #
                                  </th>
                                  <th class="percent25">
                                      Driver
                                  </th>
                                  <th class="percent25">
                                      Customer
                                  </th>
                                  <th class="percent25">
                                    From & To
                                  </th>
                                  <th class="percent25">
                                    Booking Value
                                  </th>
                                 
                                  <th class="percent25">
                                      Trip Status
                                  </th>
                                  <th class="percent25">
                                    Action
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php if(!empty($bookings)) {
                            $count=1;
                            foreach($bookings as $bookingsdata){
                            ?>
                              <tr>
                                  <td>
                                     <?php echo output($count); $count++; ?>
                                  </td>
                                   <td><?= (isset($bookingsdata['t_driver_details']->d_name))?$bookingsdata['t_driver_details']->d_name:'<span class="badge badge-danger">Yet to Assign</span>'; ?></td>
                                  <td>
                                     <?php echo output($bookingsdata['t_customer_details']->c_name);?>
                                  </td>
                                  <td>
                                     <?php echo '<small>'.output($bookingsdata['t_trip_fromlocation']).'</small>'; echo '<br><span class="badge badge-success">to</span><br>';?>
                                     <?php echo '<small>'.output($bookingsdata['t_trip_tolocation']).'</small>';?>
                                  </td>
                                  <td>
                                     <?php echo output($bookingsdata['t_trip_amount']);?>
                                  </td>
                                  
                                   <td>
                              
                                     <?=  $bookingsdata['t_trip_status'] ?>  
                                  </td>
                                  <td> <a class="icon" target="_blank" href="<?php echo base_url(); ?>trips/details/<?php echo output($bookingsdata['t_id']); ?>">
                                     <i class="fa fa-eye"></i>
                                    </a> 
                                  </td>
                              </tr>
                              <?php } } ?>
                          </tbody>
                      </table>

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="vechicle_geofence">
                    <!-- The timeline -->
                    <table id="vgeofencetbl" class="table table-striped projects">
                          <thead>
                              <tr>
                                  <th class="percent1">
                                      #
                                  </th>
                                  <th class="percent25">
                                      Name
                                  </th>
                                  <th class="percent25">
                                      Description
                                  </th>
                                 <th class="percent25">
                                    Action
                                </th>
                                  
                              </tr>
                          </thead>
                          <tbody>
                            <?php if(!empty($vechicle_geofence)){ 
                            $count=1;
                            foreach($vechicle_geofence as $vechicle_geofence){
                            ?>
                              <tr>
                                  <td>
                                     <?php echo output($count); $count++; ?>
                                  </td>
                                  <td>
                                      <?php echo output($vechicle_geofence['geo_name']);?>
                                  </td>
                                  <td>
                                     <?php echo output($vechicle_geofence['geo_description']);?>
                                  </td>
                                  <td> <a class="icon" href="<?php echo base_url(); ?>geofence">
                                     <i class="fa fa-eye"></i>
                                    </a> 
                                  </td>
                              </tr>
                          <?php } } ?>
                          </tbody>
                      </table>
                  </div>

                  <div class="tab-pane" id="vechicle_incomexpense">
                     <table id="incomexpenstbl" class="table table-striped projects">
                          <thead>
                              <tr>
                                  <th class="percent1">
                                      #
                                  </th>
                                  <th class="percent25">
                                      Date
                                  </th>
                                  <th class="percent25">
                                      Description
                                  </th>
                                  <th class="percent25">
                                    Amount
                                  </th>
                                  <th class="percent25">
                                      Type
                                  </th>
                                  <th class="percent25">
                                    Action
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php if(!empty($vechicle_incomexpense)){ 
                            $count=1;
                            foreach($vechicle_incomexpense as $incomexpensdata){
                            ?>
                              <tr>
                                  <td>
                                     <?php echo output($count); $count++; ?>
                                  </td>
                                  <td>
                                      <?php echo output($incomexpensdata['ie_date']);?>
                                  </td>
                                  <td>
                                     <?php echo output($incomexpensdata['ie_description']);?>
                                  </td>
                                  <td>
                                     <?php echo output($incomexpensdata['ie_amount']);?>
                                  </td>
                                  <td>
                                     <?php echo ($incomexpensdata['ie_type']=='income')?'<span class="right badge badge-success">Income</span>':'<span class="right badge badge-danger">Expense</span>'; ?>
                                  </td>
                                 <td> <a class="icon" href="<?php echo base_url(); ?>incomexpense">
                                     <i class="fa fa-eye"></i>
                                    </a> 
                                  </td>                                 
                              </tr>
                          <?php } } ?>
                          </tbody>
                      </table>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane " id="servicehistory">
                  <table id="" class="table card-table tableexport">
                      <thead>
                      <tr>
                          <th class="w-1">S.No</th>
                          <th>Vehicle</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Service Info</th>
                          <th>Vendor</th>
                          <th>Mechanic</th>
                          <th>Cost</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php if(!empty($maintenancelist)){  $count=1;
                           foreach($maintenancelist as $maintenancelists){
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                           <td> <?php echo output($maintenancelists['v_name']); ?></td>
                           <td> <?php echo output(date(dateformat(), strtotime($maintenancelists['m_start_date']))); ?></td>
                           <td><?php echo output(date(dateformat(), strtotime($maintenancelists['m_end_date']))); ?> </td>
                           <td><?php echo output($maintenancelists['m_service_info']); ?>
                           <?php
                           if(!empty($maintenancelists['partsused'])){
                            echo '<br>';
                            foreach($maintenancelists['partsused'] as $partsused){
                                echo $partsused['p_name'].' - '.$partsused['pu_qty'];
                                echo '<br>';
                            }
                           }
                           ?>
                          </td>
                           <td><?php echo output($maintenancelists['mv_name']); ?></td>
                           <td><?php echo output($maintenancelists['mm_name']); ?></td>
                           <td><?php echo sitedata()['s_price_prefix'].output($maintenancelists['m_cost']); ?></td>
                           
                          
                          
                          
                        </tr>
                        <?php } } ?>
                      </tbody>
                    </table>

                  </div>

                  <div class="tab-pane active" id="basicinfo">
                    <table class="table table-sm table-bordered">
                  <tbody>
                    <tr>
                      <td>Registration No</td>
                      <td><?= output($vehicledetails['v_registration_no']) ?></td>
                    </tr>
                    <tr>
                      <td>Name</td>
                      <td><?= output($vehicledetails['v_name']) ?></td>
                    </tr>
                    <tr>
                      <td>Model</td>
                      <td><?= output($vehicledetails['v_model']) ?></td>
                    </tr>
                    <tr>
                      <td>Chassis No.</td>
                      <td><?= output($vehicledetails['v_chassis_no']) ?></td>
                    </tr>
                    <tr>
                      <td>Engine No.</td>
                      <td><?= output($vehicledetails['v_engine_no']) ?></td>
                    </tr>
                    <tr>
                      <td>Manufactured By</td>
                      <td><?= output($vehicledetails['v_manufactured_by']) ?></td>
                    </tr>
                     <tr>
                      <td>Type</td>
                      <td><?= output($vehicledetails['v_type']) ?></td>
                    </tr>
                     <tr>
                      <td>Mileage/Litre</td>
                      <td><?= output($vehicledetails['v_mileageperlitre']) ?></td>
                    </tr>
                     <tr>
                      <td>Server URL</td>
                      <td><?= output($vehicledetails['v_api_url']) ?></td>
                    </tr>
                     <tr>
                      <td>Device Identifer</td>
                      <td><?= output($vehicledetails['v_api_username']) ?></td>
                    </tr>
                    <tr>
                      <td>Insurance Expiry Date</td>
                      <td><?= output($vehicledetails['v_ins_exp_date']) ?> <?php echo daysRemaining($vehicledetails['v_ins_exp_date']) ?></td>
                    </tr>

                    <tr>
                      <td>Registration Expiry Date</td>
                      <td><?= output($vehicledetails['v_reg_exp_date']) ?> <?php echo daysRemaining($vehicledetails['v_reg_exp_date']) ?></td>
                    </tr>

                    <tr>
                      <td>Odometer Reading</td>
                      <td><?= output($vehicledetails['v_odometer_reading']) ?></td>
                    </tr>

                     <tr>
                      <td>Created Date</td>
                      <td><?= output($vehicledetails['v_created_date']) ?></td>
                    </tr>
                     <tr>
                      <td>Modified Date</td>
                      <td><?= output($vehicledetails['v_modified_date']) ?></td>
                    </tr>
                    <tr>
                      <td>Document</td>
                      <td><?php if($vehicledetails['v_file1']!='') { ?>
                        <a target="_blank" href="<?= base_url(); ?>assets/uploads/<?= ucwords($vehicledetails['v_file1']); ?>" class="">
                          View/Download
                        </a>
                        <?php } else { echo '-'; } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="col-sm-3">
                  <a href="<?= base_url(); ?>vehicle/editvehicle/<?= encodeId($vehicledetails['v_id']); ?>">
                   <button type="button" class="btn btn-block btn-success btn-sm">Edit Info</button>
                 </a>
                </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
