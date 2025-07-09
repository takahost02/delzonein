<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Coupon Usage Report
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Coupon Usage Report</li>
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
      <form method="post" id="booking_report" class="card basicvalidation" action="<?php echo base_url();?>reports/couponreport">
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
               
               <input type="hidden" id="couponreport" name="couponreport" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-primary"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>
    <div class="card">

        <div class="card-body p-0">
           <?php if(!empty($coupon)){ ?>
         <div class="table-responsive">
                    <table  class="datatableexport table card-table">
                    <thead>
            <tr>
            <th class="w-1">S.No</th>

                <th>Coupon Code</th>
                <th>Usage Count</th>
                <th>Total Discount Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php  $count=1; foreach ($coupon as $row): ?>
                <tr>
                <td> <?php echo output($count); $count++; ?></td>
                    <td><?= $row['cp_code'] ?></td>
                    <td><?= $row['usage_count'] ?></td>
                    <td><?= number_format($row['total_discount'], 2) ?></td>
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