<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Income and Expenses Report
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Income and Expenses Report</li>
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
      <form method="post" id="incomeexpense_report" class="card basicvalidation" action="<?php echo base_url();?>reports/incomeexpense">
         <div class="card-body">
            <div class="row">
               <div class="col-md-3">
                  <div class="row">
                     <label for="incomeexpense_from" class="col-sm-5 col-form-label">Report From</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['incomeexpense_from']) ? $_POST['incomeexpense_from'] : ''; ?>" id="incomeexpense_from" name="incomeexpense_from" placeholder="Date From">
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="row">
                     <label for="incomeexpense_to" class="col-sm-5 col-form-label">Report To</label>
                     <div class="col-sm-6">
                        <input type="text" required="true" class="form-control datepicker" value="<?php echo isset($_POST['incomeexpense_to']) ? $_POST['incomeexpense_to'] : ''; ?>" id="incomeexpense_to" name="incomeexpense_to" placeholder="Date To">
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="row">
                     <label for="booking_to" class="col-sm-3 col-form-label">Vehicle</label>
                     <div class="col-sm-8">
                        <select required="true" id="incomeexpense_vechicle"  class="form-control select2"  name="incomeexpense_vechicle">
                           <option value="all">All Vechicle</option>
                           <?php foreach ($vehiclelist as $key => $vechiclelists) { ?>
                           <option <?php echo (isset($_POST['booking_vechicle']) && ($_POST['booking_vechicle'] == $vechiclelists['v_id'])) ? 'selected':'' ?> value="<?php echo output($vechiclelists['v_id']) ?>"><?php echo output($vechiclelists['v_name']).' - '. output($vechiclelists['v_registration_no']); ?></option>
                           <?php  } ?>
                        </select>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="incomeexpensereport" name="incomeexpensereport" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-primary"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>
    <div class="card">
        <div class="card-body p-0">
            <?php if(!empty($incomexpense)){ 
                $income = $expense = 0;
                foreach ($incomexpense as $item) {
                    if($item['transaction_type']=='Credit') {
                      $income += $item['amount'];
                    }
                     if($item['transaction_type']=='Debit') {
                      $expense += $item['amount'];
                    }
                }
                $total = $income - $expense;
            ?>
          <div class="row">
          <div class="col-12 col-sm-6 col-md-2">
     
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Income</span>
                <span class="info-box-number"><?= $income; ?> </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-thumbs-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Expense</span>
                <span class="info-box-number"><?= $expense; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-calculator"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= ($total>=0)?'Profit':'Loss'; ?></span>
                <span class="info-box-number"><?= $total; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        
                 <table  class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">S.No</th>
                          <th>Date</th>
                          <th>Vechicle</th>
                          <th>Category</th>
                          <th>Account</th>
                          <th>Ref. No</th>
                          <th>Amount</th>
                          <th>Type</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php $count=1;
                           foreach($incomexpense as $incomexpenses){
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                           <td> <?php echo output($incomexpenses['transaction_date']); ?></td>
                           <td> <?php echo $incomexpenses['v_name'] . '[ '.$incomexpenses['v_registration_no'].']'; ?></td>
                           <td> <?php echo output($incomexpenses['ie_cat_name']); ?></td>
                           <td> <?php echo output($incomexpenses['account_name']); ?></td>

                           <td><?php echo output($incomexpenses['reference_number']); ?></td>
                           <td><?php echo output($incomexpenses['amount']); ?></td>
                           <td>  <span class="badge <?php echo ($incomexpenses['transaction_type']=='Credit') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($incomexpenses['transaction_type']); ?></span>  </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                   <?php } ?>
        </div>
      </div>
   </div>
</section>
