<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-lg-6">
            <h1 class="m-0 text-dark">Dashboard
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-lg-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
               <li class="breadcrumb-item active">Dashboard</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<?php if(userpermission('lr_dashboard')) { ?>
<section class="content">
   <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
         <div class="col-lg-3">
            <div class="info-box">
               <span class="info-box-icon bg-info elevation-1"><i class="fas fa-truck text-white"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Vehicle's</span>
                  <span class="info-box-number"><?= (isset($dashboard['tot_vehicles'])) ? $dashboard['tot_vehicles']:'0' ?>  </span>
               </div>
               <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
         </div>
         <!-- /.col -->
         <div class="col-lg-3">
            <div class="info-box mb-3">
               <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user-secret"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Drivers</span>
                  <span class="info-box-number"><?= (isset($dashboard['tot_drivers'])) ? $dashboard['tot_drivers']:'0' ?> </span>
               </div>
               <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
         </div>
         <!-- /.col -->
         <div class="col-lg-3">
            <div class="info-box mb-3">
               <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-user text-white"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Customer</span>
                  <span class="info-box-number"><?= (isset($dashboard['tot_customers'])) ? $dashboard['tot_customers']:'0' ?> </span>
               </div>
               <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
         </div>
         <!-- /.col -->
         <div class="col-lg-3">
            <div class="info-box mb-3">
               <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-id-card"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Today Trips</span>
                  <span class="info-box-number"><?= (isset($dashboard['tot_today_trips'])) ? $dashboard['tot_today_trips']:'0' ?></span>
               </div>
               <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /.row -->
      <div class="row">

         <?php if(userpermission('lr_ie_list')) { ?>
            <div class="col-lg-8">
               <!-- TABLE: LATEST ORDERS -->
               <div class="card">
                  <div class="card-header">
                     <h2 class="card-title">Transactions</h2>
                  </div>
                  <div class="card-header border-transparent">
                     <div class="card-body">
                        <div class="d-flex">
                           <p class="d-flex flex-column">
                           </p>
                           <p class="ml-auto d-flex flex-column text-right">
                              <span class="text-success">
                              </span>
                           </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="position-relative mb-4">
                           <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                 <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                 <div class=""></div>
                              </div>
                           </div>
                           <canvas id="ie-chart" height="200" width="487" class="chartjs-render-monitor" style="display: block; width: 487px; height: 200px;"></canvas>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                           <span class="mr-2">
                           <i class="fas fa-square text-success"></i> Income
                           </span>
                           <span>
                           <i class="fas fa-square text-danger"></i> Expenses
                           </span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php  } ?>

            <?php if(userpermission('lr_dashboard')) { ?>
            <div class="col-lg-4">
            <div class="info-box mb-3 bg-warning">
               <span class="info-box-icon"><i class="fas fa-road"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Today Trip Summary</span>
                  <?php 
                  echo '<span class="info-box-number">';
                  echo implode(' | ', array_map(function($status, $count) {
                      return "<strong>{$status}:</strong> {$count}";
                  }, array_keys($countbytrip_status), $countbytrip_status));
                  echo '</span>';
                  ?>
               </div>
            </div>

               <div class="info-box mb-3 bg-success">
               <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Today Transactions</span>
                  <span class="info-box-number"><strong>Income : <?= (isset($daily_income_expense['total_income'])) ? $daily_income_expense['total_income']:'0' ?></strong> | <strong>Expense : <?= (isset($daily_income_expense['total_expense'])) ? $daily_income_expense['total_expense']:'0' ?></strong></span>
               </div>
               </div>
               <div class="info-box mb-3 bg-danger">
               <span class="info-box-icon"><i class="fas fa-truck"></i></span>
               <div class="info-box-content">
                  <?php $status_counts = ['In Trip' => 0,'Free' => 0];
                        foreach ($vehicles_status as $vehicle) {
                           $status_counts[$vehicle['status']]++;
                        }
                  ?>
                  <span class="info-box-text">Vehicle Status</span>
                  <span class="info-box-number"><strong>Ideal : <?= $status_counts['Free']; ?></strong> | <strong>In Trip : <?= $status_counts['In Trip']; ?></strong></span>
               </div>
               </div>
               <div class="info-box mb-3 bg-info">
               <span class="info-box-icon"><i class="fas fa-database"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Traccar Sycn Status</span>
                  <span class="info-box-number"><?php $data = sitedata(); if($data['s_traccar_enabled']==1) { echo $last_sync_time; } else { echo 'Traccar is disabled'; } ?></span>
               </div>
               <?php if($data['s_traccar_enabled'] == 0): ?>
                  <div class="overlay dark">
                  </div>
                  <i class="fas fa-ban m-4"></i>
               <?php endif; ?>
               </div>
            </div>
          <?php  } ?>

            <?php  if(userpermission('lr_reminder_list')) { ?>
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header ui-sortable-handle" style="cursor: move;">
                     <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Service Reminder
                     </h3>
                     <div class="card-tools">
                     </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <ul class="todo-list ui-sortable" data-widgetyAxes="todo-list">
                        <?php if(!empty($todayreminder)) { foreach($todayreminder as $reminder) { ?>
                        <li id="<?= $reminder['r_id'] ?>">
                           <span class="text">
                              <?= $reminder['v_name']. ' ';  ?>  : <?php if(isset($reminder['services'])) { foreach ($reminder['services'] as $service) {
                                 $serviceNames[] = $service['rs_name'];
                                 }  echo implode(',', $serviceNames); $serviceNames = array(); ?> ( <?= $reminder['r_message']. ' ';  ?> )  =>  <?php  $result = daysUntilDueDate($reminder['r_date']);  
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
                                 } } ?>
                              <div class="tools"> 
                                 <button type="button" data-id="<?= $reminder['r_id'] ?>" class="todayreminderread btn btn-block btn-outline-primary btn-xs">Mark as Completed</button>                 
                              </div>
                           </span>
                        </li>
                        <?php }  } else { echo 'No reminders'; } ?>  
                     </ul>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                     <a href="<?= base_url() ?>reminder/addreminder"><button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add Reminder</button></a>
                  </div>
               </div>
            </div>
         <?php }  if(userpermission('lr_liveloc')) { ?>
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">
                  <h2 class="card-title">Vechicle Current Location</h2>   
                  <div class="card-tools">
                
               </div>
               </div>
               <table  class=" table card-table table-vcenter" id="vehicleTable">
                  <thead>
                  <tr>
                        <th>Vehicle</th>
                        <th>Location</th>
                        <th>Last Update</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
               </table>
            </div>
         </div>
         <?php } ?>

            <div class="col-lg-6">
               <!-- TABLE: LATEST ORDERS -->
               <div class="card">
                  <div class="card-header">
                     <h2 class="card-title">Top Income</h2>
                     <div class="card-tools">
                        <a href="<?= base_url(); ?>reports/topincome"><span class="badge badge-primary">View Details</span></a>
                     </div>
                  </div>
                  <div class="card-header border-transparent">
                     <div class="card-body">
                        <div class="d-flex">
                           <p class="d-flex flex-column">
                           </p>
                           <p class="ml-auto d-flex flex-column text-right">
                              <span class="text-success">
                              </span>
                           </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="position-relative mb-4">
                           <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                 <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                 <div class=""></div>
                              </div>
                           </div>
                           <canvas id="topincome" height="150" width="487" class="chartjs-render-monitor" style="display: block; width: 487px; height: 150px;"></canvas>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
            <div class="col-lg-6">
               <!-- TABLE: LATEST ORDERS -->
               <div class="card">
                  <div class="card-header">
                     <h2 class="card-title">Top Expenses</h2>
                     <div class="card-tools">
                        <a href="<?= base_url(); ?>reports/topexpense"><span class="badge badge-primary">View Details</span></a>
                     </div>
                  </div>
                  <div class="card-header border-transparent">
                     <div class="card-body">
                        <div class="d-flex">
                           <p class="d-flex flex-column">
                           </p>
                           <p class="ml-auto d-flex flex-column text-right">
                              <span class="text-success">
                              </span>
                           </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="position-relative mb-4">
                           <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                 <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                 <div class=""></div>
                              </div>
                           </div>
                           <canvas id="topexpense" class="chartjs-render-monitor"></canvas>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         
            <div class="col-lg-6">
               <!-- TABLE: LATEST ORDERS -->
               <div class="card">
                  <div class="card-header">
                     <h2 class="card-title">Top Vehicles</h2>
                     <div class="card-tools">
                        <a href="<?= base_url(); ?>reports/topvehicles"><span class="badge badge-primary">View Details</span></a>
                     </div>
                  </div>
                  <div class="card-header border-transparent">
                     <div class="card-body">
                        <div class="d-flex">
                           <p class="d-flex flex-column">
                           </p>
                           <p class="ml-auto d-flex flex-column text-right">
                              <span class="text-success">
                              </span>
                           </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="position-relative mb-4">
                           <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                 <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                 <div class=""></div>
                              </div>
                           </div>
                           <canvas id="topvechicles" height="150" width="487" class="chartjs-render-monitor" style="display: block; width: 487px; height: 150px;"></canvas>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
       
         <?php  if(userpermission('lr_vech_list')) { ?>
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">
                  <h2 class="card-title">Vechicle Running Status</h2>
               </div>
               <table class="table card-table vrs">
                  <thead>
                     <tr>
                        <th>Name</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
         <?php } if(userpermission('lr_geofence_list')) { ?>
         <div class="col-lg-6 ">
            <div class="card">
               <div class="card-header">
                  <h2 class="card-title">Vehicle Geofence Status</h2>
               </div>
               <table class="datatable table card-table table-vcenter">
                  <thead>
                     <tr>
                        <th>Vehicle</th>
                        <th>Event</th>
                        <th>Time</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($geofenceevents)){  
                        foreach($geofenceevents as $geofence){
                        ?>
                     <tr>
                        <td> <?php echo output($geofence['v_name']); ?></td>
                        <td>  <?php if($geofence['ge_event']=='inside') { echo 'Moving '.output($geofence['ge_event']).' '.$geofence['geo_name']; } else {  echo 'Exiting '.output($geofence['ge_event']) .' ' .$geofence['geo_name']; } ?></td>
                        <td> <?php echo output($geofence['ge_timestamp']); ?></td>
                     </tr>
                     <?php } } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <?php } ?>
      </div>
      <!-- /.card -->
      <!-- /.col -->
      <!-- /.col -->
   </div>
   <!-- /.row -->
   </div><!--/. container-fluid -->
</section>
<!-- /.content -->
</div>
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<script>
   function fetchVehicleCurrentLocations() {
      $.ajax({
         url: 'dashboard/fetch_vehicle_current_locations',
         method: 'GET',
         dataType: 'json',
         success: function(response) {
               let tableBody = '';
               response.forEach(function(vehicle) {
                  tableBody += `
                     <tr>
                           <td>${vehicle.v_name}</td>
                           <td>${vehicle.address || 'Fetching...'}</td>
                           <td>${vehicle.time}</td>
                     </tr>
                  `;
               });

               $('#vehicleTable tbody').html(tableBody);
         },
         error: function(xhr, status, error) {
               console.error('Error fetching data:', error);
         }
      });
   }

 

   var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
   };
   var mode = 'index';
   var intersect = true;

function getActiveVehicles() {
      $.ajax({
         url: '<?= site_url('dashboard/get_active_vehicles'); ?>',  
         type: 'GET',  
         dataType: 'json',
         success: function(response) {
            var tableBody = '';
                response.forEach(function(vehicle) {
                    tableBody += `
                        <tr>
                            <td>${vehicle.vehicle_name}</td>
                            <td>
                                <span class="badge badge-${vehicle.status !== 'In Trip' ? 'success' : 'warning'}">
                                    ${vehicle.status}
                                </span>
                            </td>
                        </tr>
                    `;
                });

                // Bind the rows to the table
                $('.vrs tbody').html(tableBody);
            },
            error: function() {
                alert('Failed to fetch vehicle data.');
            }
      });
}

$(document).ready(function() {
    getActiveVehicles();
    //fetchVehicleCurrentLocations();

    $.ajax({
        url: 'dashboard/get_incomeexpensechart_data',
        method: 'GET', 
        dataType: 'json', 
        success: function(response) {
            var incomeLabels = response.income_labels;
            var incomeData = response.income_data;
            var expenseLabels = response.expense_labels;
            var expenseData = response.expense_data;
            // Create the chart for Income
            var $incomeChart = $('#topincome');
            var incomeChart = new Chart($incomeChart, {
                data: {
                    labels: incomeLabels,
                    datasets: [{
                        type: 'line',
                        data: incomeData,
                        backgroundColor: 'transparent',
                        borderColor: '#28a745',
                        pointBorderColor: '#28a745',
                        pointBackgroundColor: '#28a745',
                        fill: false,
                        label: 'Income'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            fontColor: '#495057',
                            fontStyle: 'bold'
                        }
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                suggestedMax: Math.max(...incomeData) + 100 // Adjust dynamically based on max value in income data
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });

            // Create the chart for Expense
            var $expenseChart = $('#topexpense');
            var expenseChart = new Chart($expenseChart, {
                data: {
                    labels: expenseLabels,
                    datasets: [{
                        type: 'line',
                        data: expenseData,
                        backgroundColor: 'transparent',
                        borderColor: '#dc3545',
                        pointBorderColor: '#dc3545',
                        pointBackgroundColor: '#dc3545',
                        fill: false,
                        label: 'Expense'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            fontColor: '#495057',
                            fontStyle: 'bold'
                        }
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                suggestedMax: Math.max(...expenseData) + 100 // Adjust dynamically based on max value in expense data
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching income and expense data: ", error);
        }
    });
});


   var vehicleData = <?= json_encode($vehicles); ?>;
   var vehicleLabels = vehicleData.map(function(item) {
      return item.vehicle;
   });
   var vehicleAmounts = vehicleData.map(function(item) {
      return item.total_amount;
   });
   var ctx = $('#topvechicles'); 
    new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: vehicleLabels, // Vehicle names as labels
            datasets: [{
                label: 'Total Amount',
                data: vehicleAmounts, // Total amounts as data
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ],
                borderColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
           
           scales: {
                y: {  // <-- Corrected from yAxes to y
                    beginAtZero: true
                },
                x: {  // <-- Corrected from xAxes to x
                    ticks: {
                        color: '#495057',  // 'fontColor' is changed to 'color'
                        font: {
                            weight: 'bold'  // 'fontStyle' changed to 'font.weight'
                        }
                    }
                }
            }
        }
    });

   
</script>      
<!-- /.content-wrapper -->
<?php if(userpermission('lr_ie_list')) { ?>
   <script>
   var ticksStyle = {
     fontColor: '#495057',
     fontStyle: 'bold'
   }
   var mode      = 'index';
   var intersect = true;
   
   var $visitorsChart = $('#ie-chart');
   
   var incomeData = <?= json_encode(array_column($transactions, 'income')); ?>;
   var expenseData = <?= json_encode(array_column($transactions, 'expense')); ?>;
   var labels = <?= json_encode(array_keys($transactions)); ?>;
   
   var visitorsChart = new Chart($visitorsChart, {
     data: {
       labels: labels,
       datasets: [{
         type: 'line',
         data: incomeData,
         backgroundColor: 'transparent',
         borderColor: '#28a745',
         pointBorderColor: '#28a745',
         pointBackgroundColor: '#28a745',
         fill: false,
         label: 'Income'  // Explicitly adding label for the legend
       }, {
         type: 'line',
         data: expenseData,
         backgroundColor: 'transparent',
         borderColor: '#dc3545',
         pointBorderColor: '#dc3545',
         pointBackgroundColor: '#dc3545',
         fill: false,
         label: 'Expense'  // Explicitly adding label for the legend
       }]
     },
     options: {
       maintainAspectRatio: false,
       tooltips: {
         mode: mode,
         intersect: intersect
       },
       hover: {
         mode: mode,
         intersect: intersect
       },
       legend: {
         display: true,  // Ensure legend is displayed
         position: 'top',  // Optional: Change position of the legend (top, left, right, bottom)
         labels: {
           fontColor: '#495057',  // You can customize the font color for the legend
           fontStyle: 'bold'
         }
       },
       scales: {
         yAxes: [{
           gridLines: {
             display: true,
             lineWidth: '4px',
             color: 'rgba(0, 0, 0, .2)',
             zeroLineColor: 'transparent'
           },
           ticks: $.extend({
             beginAtZero: true,
             suggestedMax: 200
           }, ticksStyle)
         }],
         xAxes: [{
           display: true,
           gridLines: {
             display: false
           },
           ticks: ticksStyle
         }]
       }
     }
   });
</script>
 <?php } } else { echo '<span style="padding-left: 19px;"> No dashboard has been assigned </span>'; } ?>