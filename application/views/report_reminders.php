<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reminders Report
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Reminders Report</li>
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
      <form method="post" id="booking_report" class="card basicvalidation" action="<?php echo base_url();?>reports/remindersreport">
         <div class="card-body">
            <div class="row">
               <div class="col-md-3">
                  <div class="row">
                     <label for="booking_from" class="col-sm-5 col-form-label">Report From</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['from']) ? $_POST['from'] : ''; ?>" id="from" name="from" placeholder="Date From">
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="row">
                     <label for="booking_to" class="col-sm-5 col-form-label">Report To</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['to']) ? $_POST['to'] : ''; ?>" id="to" name="to" placeholder="Date To">
                     </div>
                  </div>
               </div>
               
               <input type="hidden" id="report_reminders" name="report_reminders" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-primary"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>
    <div class="card">

        <div class="card-body p-0">
           <?php if(!empty($reminders)){ ?>
         <div class="table-responsive">
                    <table  class="datatableexport table card-table">
                     <thead>
                           <tr>
                              <th>Reminder Title</th>
                              <th>Reminder Date</th>
                              <th>Vehicle Name</th>
                              <th>Services</th>
                              <th>Due In</th>
                              <th>Status</th>
                           </tr>
                     </thead>
                     <tbody>
                           <?php foreach ($reminders as $row): ?>
                              <tr>
                                 <td><?= $row['r_message'] ?></td>
                                 <td><?php echo output(date(dateformat(), strtotime($row['r_date']))); ?>
                                 <td><?= $row['v_name'] ?></td>
                                 <td><?= $row['services'] ?></td>
                                 <td><?php  $result = daysUntilDueDate($row['r_date']);  
                                    switch ($result) {
                                    case "today":
                                       echo '<span class="badge badge-primary">Today is the due date!</span>';
                                       break;
                                    case "past":
                                       echo '<span class="badge badge-danger">The due date has passed.</span>';
                                       break;
                                    default:
                                       echo '<span class="badge badge-success">Due in ' . $result . ' days.</span>';
                                       break;
                                    } ?></td>
                              <td><span class="badge <?php echo ($row['r_isread']==1) ? 'badge-success' : 'badge-danger'; 
                            ?>"><?php echo ($row['r_isread']==1) ? 'Completed' : 'Pending'; ?></span></td>  
                                                          </tr>

                           <?php endforeach; ?>
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