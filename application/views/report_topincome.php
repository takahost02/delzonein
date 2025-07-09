<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Top Income Report
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Top Income Report</li>
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
      <form method="post" id="booking_report" class="card basicvalidation" action="<?php echo base_url();?>reports/topincome">
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
               <div class="col-md-4">
                  <div class="row">
                     <label for="booking_to" class="col-sm-3 col-form-label">Vehicle</label>
                     <div class="col-sm-8">
                     <select id="v_id" name="v_id" class="form-control select2">
            <option value="all">All Vehicle</option> 
            <?php if(!empty($vehiclelist)) { foreach($vehiclelist as $v_groupdata) { ?>
            <option <?= (isset($_POST['v_id']) && $_POST['v_id'] == $v_groupdata['v_id'])?'selected':''?> value="<?= $v_groupdata['v_id'] ?>"><?= $v_groupdata['v_name'] ?></option> 
            <?php } } ?>
         </select>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="topincome" name="topincome" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-primary"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>
    <div class="card">
    <?php if (!empty($transaction_graph)) { ?>
      <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>

      <div style="width: 700px; overflow: hidden; margin: 0 auto;">
    <canvas id="transactionChart" width="500" height="300"></canvas>
</div>

<script>
    var ctx = document.getElementById('transactionChart').getContext('2d');
    var transactionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($transaction_graph['labels']); ?>,
            datasets: [{
                label: 'Total Amount',
                data: <?php echo json_encode($transaction_graph['amounts']); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                barThickness: 4 // Smaller bars
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allow custom size
            plugins: {
                legend: {
                    display: false // Hide legend for small chart
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Amount: ' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString(); // Format y-axis with commas
                        }
                    }
                }
            }
        }
    });
</script>


        <?php } ?>
        <div class="card-body p-0">
           <?php if(!empty($topincome)){ ?>
         <div class="table-responsive">
                    <table  class="datatableexport table card-table table-vcenter">
                      <thead>
                        <tr>
                          <th class="w-1">S.No</th>
                          <th>Vechicle</th>
                          <th>Vechicle No</th>
                          <th>Income Category</th>
                          <th>Description</th>
                           <th>Total</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>

                     <?php
                           $count=1;
                           foreach($topincome as $topincomes){
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                           <td> <?php echo ucfirst($topincomes['v_name']); ?></td>
                           <td> <?php echo output($topincomes['v_registration_no']); ?></td>
                           <td><?php echo ucfirst($topincomes['category']); ?></td>
                           <td><?php echo $topincomes['note']?ucfirst($topincomes['note']):''; ?></td>
                             <td><?php echo ucfirst($topincomes['total_amount']); ?></td>
                              <td><?php echo ucfirst($topincomes['transaction_date']); ?></td>
                           
                    
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