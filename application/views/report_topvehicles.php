<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Top Vehicles
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Top Vehicles Report</li>
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
      <form method="post" id="booking_report" class="card basicvalidation" action="<?php echo base_url();?>reports/topvehicles">
         <div class="card-body">
            <div class="row">
               <div class="col-md-3">
                  <div class="row">
                     <label for="booking_from" class="col-sm-5 col-form-label">Report From</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['booking_from']) ? $_POST['booking_from'] : ''; ?>" id="from" name="from" placeholder="Date From">
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="row">
                     <label for="booking_to" class="col-sm-5 col-form-label">Report To</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['booking_to']) ? $_POST['booking_to'] : ''; ?>" id="to" name="to" placeholder="Date To">
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="row">
                     <label for="booking_to" class="col-sm-3 col-form-label">Vehicle</label>
                     <div class="col-sm-8">
                     <select id="vehicle_group" name="vehicle_group" class="form-control select2">
            <option value="">All Group</option> 
            <?php if(!empty($v_group)) { foreach($v_group as $v_groupdata) { ?>
            <option <?= (isset($_POST['vehicle_group']) && $_POST['vehicle_group'] == $v_groupdata['gr_id'])?'selected':''?> value="<?= $v_groupdata['gr_id'] ?>"><?= $v_groupdata['gr_name'] ?></option> 
            <?php } } ?>
         </select>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="topvehicles" name="topvehicles" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-primary"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>
    <div class="card">

        <div class="card-body p-0">
           <?php if(!empty($topvehicles)){ ?>
         <div class="table-responsive">
                    <table  class="datatableexport table card-table table-vcenter">
                      <thead>
                        <tr>
                          <th class="w-1">S.No</th>
                          <th>Vechicle</th>
                           <th>Total</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>

                     <?php
                           $count=1;
                           foreach($topvehicles as $topvehicle){
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                           <td><?php echo ucfirst($topvehicle['vehicle'] ?? ''); ?></td>
<td><?php echo ucfirst($topvehicle['total_amount'] ?? ''); ?></td>
<td><?php echo ucfirst($topvehicle['t_start_date'] ?? ''); ?></td>
                           
                    
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                   <?php } ?>
        </div>         
        </div>
        <!-- /.card-body -->
      </div>


   </div>
</section>
<!-- /.content -->