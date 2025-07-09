<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Drivers Report
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Drivers Report</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <form method="post" id="fuel_report" class="card basicvalidation" action="<?php echo base_url();?>reports/driversreport">
         <div class="card-body">
            <div class="row">
               <div class="col-md-3">
                  <div class="row">
                     <label for="r_from" class="col-sm-5 col-form-label">Report From</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['r_from']) ? $_POST['r_from'] : ''; ?>" id="r_from" name="r_from" placeholder="Date From">
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="row">
                     <label for="r_to" class="col-sm-5 col-form-label">Report To</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['r_to']) ? $_POST['r_to'] : ''; ?>" id="r_to" name="r_to" placeholder="Date To">
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="row">
                     <label for="booking_to" class="col-sm-3 col-form-label">Drivers</label>
                     <div class="col-sm-8">
                        <select required="true" id="d_id"  class="form-control select2"  name="d_id">
                           <option value="all">All Drivers</option>
                           <?php foreach ($dlist as $key => $driver) { ?>
                           <option <?php echo (isset($_POST['driverreport']) && ($_POST['d_id'] == $driver['d_id'])) ? 'selected':'' ?> value="<?php echo output($driver['d_id']) ?>"><?php echo output($driver['d_name']).' - '. output($driver['d_id']); ?></option>
                           <?php  } ?>
                        </select>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="driverreport" name="driverreport" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-primary"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>
    <div class="card">
        <div class="card-body p-0">
            <?php if(!empty($drivers)){ 
             ?>
                   <table  class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">S.No</th>
                           <th>Booking Date</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Distance</th>
                          <th>Duration</th>
                          <th>Vehicle</th>
                           <th>Driver Name</th>
                          <th>Created Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($drivers)){  $count=1;
                           foreach($drivers as $dridata){
                           ?>
                        <tr>
                              <td><?php echo output($count); $count++; ?></td>
                              <td><?php echo $dridata['t_start_date'] . '<br> to <br>' . $dridata['t_end_date']; ?></td>
                              <td><?php echo output($dridata['t_trip_fromlocation']); ?></td>
                              <td><?php echo output($dridata['t_trip_tolocation']); ?></td>
                              <td><?php echo output($dridata['t_totaldistance']); ?></td>
                              <td>
                                 <?php
                                       $start = new DateTime($dridata['t_start_date']);
                                       $end = new DateTime($dridata['t_end_date']);
                                       $interval = $end->diff($start);
                                       $totalHours = $interval->days * 24 + $interval->h + ($interval->i / 60);
                                       echo number_format($totalHours, 2) . ' Hrs';
                                 ?>
                              </td>
                              <td>
                                 <?php
                                       echo isset($dridata['t_vechicle_details']) && is_object($dridata['t_vechicle_details'])
                                          ? output($dridata['t_vechicle_details']->v_registration_no . ' [' . $dridata['t_vechicle_details']->v_registration_no . ']')
                                          : 'N/A';
                                 ?>
                              </td>
                              <td>
                                 <?php
                                       echo isset($dridata['t_driver_details']) && is_object($dridata['t_driver_details'])
                                          ? output($dridata['t_driver_details']->d_name)
                                          : 'N/A';
                                 ?>
                              </td>
                              <td><?php echo output($dridata['t_created_date']); ?></td>
                           </tr>

                        <?php } } ?>
                      </tbody>
                    </table>
                     <?php }  ?>
        </div>
      </div>
   </div>
</section>
