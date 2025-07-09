<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Maintenance Report
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Maintenance Report</li>
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
      <form method="post" id="booking_report" class="card basicvalidation" action="<?php echo base_url();?>reports/maintenancereport">
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
               <div class="col-md-3">
                  <div class="row">
                     <label for="booking_to" class="col-sm-5 col-form-label">Vehicles</label>
                     <div class="col-sm-6">
                        <select name="vehicle_id"  class="form-control select2">
                           <option value="all">All Vehicles</option>
                           <?php foreach ($vehiclelist as $vehicle): ?>
                           <option value="<?= $vehicle['v_id'] ?>"><?= $vehicle['v_name'] ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="report_maintenance" name="report_maintenance" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-primary"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>

   <?php if(!empty($report)){ ?>

<div class="card">
<div class="card-body d-flex justify-content-center align-items-center" style="height: 100%;">
<?php if (!empty($report)) { ?>
<canvas id="vehicleCostsChart" width="100" height="250" style="max-width: 50%;"></canvas>
<?php } ?>
</div>
</div>

<?php } ?>
   <div class="card">
      <div class="card-body p-0">



         <?php if(!empty($report)){ ?>


         <div class="table-responsive">
            <table  class="datatableexport table card-table">
               <thead>
                  <tr>
                     <th>Date</th>
                     <th>Vehicle</th>
                     <th>Odometer</th>
                     <th>Cost</th>
                     <th>Mechanics</th>
                     <th>Parts Used</th>
                     <th>Vendors</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($report as $row): ?>
                  <tr>
                     <td><?php echo output(date(dateformat(), strtotime($row['m_start_date']))).'<br> to <br>'.output(date(dateformat(), strtotime($row['m_end_date']))); ?>
                     <td><?= $row['v_name'] ?></td>
                     <td><?= $row['m_odometer_reading'] ?></td>
                     <td><?= $row['m_cost'] ?></td>
                     <td><?= $row['mechanics'] ?></td>
                     <td><?= $row['parts_used'] ?></td>
                     <td><?= $row['vendors'] ?></td>
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
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<script>
const vehicleCosts = <?php echo json_encode($vehicle_costs); ?> || [];

// Extract Labels (Vehicle Names) and Data (Costs)
const labels = vehicleCosts.map(item => item.v_name || 'Unknown Vehicle'); // Labels for X-axis
const data = vehicleCosts.map(item => item.total_cost || 0); // Values for Y-axis

// Generate Unique Colors for Each Bar
const colors = vehicleCosts.map((_, index) => {
    return `hsl(${(index * 60) % 360}, 70%, 60%)`; // Generates distinct colors (cycling HSL values)
});

// Chart Initialization
const ctx = document.getElementById('vehicleCostsChart').getContext('2d');
const vehicleCostsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Vehicle Costs',
            data: data,
            backgroundColor: colors,
            borderColor: colors,
            borderWidth: 1,
            barPercentage: 0.5, // 50% of the category width
            categoryPercentage: 0.5 // 50% of the total chart width
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `Cost: ${context.raw.toLocaleString()}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>