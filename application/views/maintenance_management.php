<div class="content-header">
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Maintenance
        <a href="<?= base_url(); ?>maintenance/addmaintenance" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
      </h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Maintenance</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<div class="card">

  <div class="card-body p-0">
    

   <div class="table-responsive">
   <table id="" class="table card-table table-vcenter tableexport">
   <thead>
                <tr>
                    <th class="w-1">S.No</th>
                    <th>Vehicle</th>
                    <th>Date</th>
                    <th>Service Info</th>
                    <th>Vendor</th>
                    <th>Mechanic</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>

                <?php if(!empty($maintenancelist)){  $count=1;
                     foreach($maintenancelist as $maintenancelists){
                     ?>
                  <tr>
                     <td> <?php echo output($count); $count++; ?></td>
                     <td> <?php echo output($maintenancelists['v_name']); ?></td>
                     <td> <?php echo output(date(dateformat(), strtotime($maintenancelists['m_start_date']))); ?> <br>to <br><?php echo output(date(dateformat(), strtotime($maintenancelists['m_end_date']))); ?></td>
                     <td><?php echo output($maintenancelists['m_service_info']); ?>
                    
                    </td>
                     <td><?php echo output($maintenancelists['mv_name']); ?></td>
                     <td><?php echo output($maintenancelists['mm_name']); ?></td>
                     <td><?php echo sitedata()['s_price_prefix'].output($maintenancelists['m_cost']); ?></td>
                     
                    
                     <td>
                     <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" style="height: 29px;font-size: 11px;width: 100px;" name="m_status" id="m_status" class="input-sm form-control" required="true">
                           <option value="<?= base_url(); ?>maintenance/updatemaintenance_status/<?= $maintenancelists['m_id'] ?>/planned" <?= ($maintenancelists['m_status']=='planned')?'selected':''; ?> value="planned">Planned</option>
                          <option value="<?= base_url(); ?>maintenance/updatemaintenance_status/<?= $maintenancelists['m_id'] ?>/inprogress" <?= ($maintenancelists['m_status']=='inprogress')?'selected':''; ?> value="inprogress">InProgress</option>
                          <option value="<?= base_url(); ?>maintenance/updatemaintenance_status/<?= $maintenancelists['m_id'] ?>/completed" <?= ($maintenancelists['m_status']=='completed')?'selected':''; ?> value="completed">Completed</option>
                         </select>
                     </td>
                     <td>

                       <a data-toggle="modal" data-target="#viewMaintenanceModal" onclick="loadMaintenanceDetails(<?= $maintenancelists['m_id']; ?>)" 
                        class="cursor text-info" > <i class="fas fa-eye arrow"></i> </a> |  <a class="icon" href="<?php echo base_url(); ?>maintenance/maintenance_edit?m_id=<?php echo output($maintenancelists['m_id']); ?>">
                           <i class="fa fa-edit"></i>
                           </a> 
                           | <a data-toggle="modal" onclick="confirmation('<?php echo base_url(); ?>maintenance/deletemaintenance','<?= output($maintenancelists['m_id']); ?>')" data-target="#deleteconfirm" class="cursor  text-danger" ><i class="fas fa-trash-restore arrow"></i></a>
                    </td>
                  </tr>
                  <?php } } ?>
                </tbody>
              </table>
             
  </div>         
  </div>
  <!-- /.card-body -->
</div>

       </div>
</section>
<!-- /.content -->
<div class="modal fade" id="viewMaintenanceModal" tabindex="-1" role="dialog" aria-labelledby="maintenanceModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="maintenanceModalLabel">Maintenance Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-3">
                  <strong>Vehicle Name:</strong>
                  <p id="vehicle_name"></p>
              </div>
              <div class="col-md-3">
                  <strong>Start Date:</strong>
                  <p id="start_date"></p>
              </div>
              <div class="col-md-3">
                  <strong>End Date:</strong>
                  <p id="end_date"></p>
              </div>
              <div class="col-md-3">
                  <strong>Vendor Name:</strong>
                  <p id="vendor_name"></p>
              </div>
              <div class="col-md-3">
                  <strong>Mechanic Name:</strong>
                  <p id="mechanic_name"></p>
              </div>
             
              <div class="col-md-3">
                  <strong>Total Cost:</strong>
                  <p id="total_cost"></p>
              </div>
              <div class="col-md-3">
                  <strong>Odometer Reading:</strong>
                  <p id="odometer_reading"></p>
              </div>
              <div class="col-md-12">
                  <strong>Service Info:</strong>
                  <p id="service_info"></p>
              </div>
              <div class="col-md-12">
                  <strong>Service Status:</strong>
                  <p id="service_status"></p>
              </div>
          </div>

          <h5 class="mt-4">Parts Used:</h5>
<table class="table table-sm" id="parts_used_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Part Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<h5 class="mt-4">Notify Members:</h5>
<table class="table table-sm" id="notify_members_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Contact</th>
            <th>Name</th>
            <th>Notify Type</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
  </div>
</div>
</div>
<style>
  /* Set uniform table width */
  .table {
      width: 100%; /* Full table width */
      table-layout: fixed; /* Ensures columns respect set widths */
  }

  /* Specific column widths */
  .table th:first-child, .table td:first-child {
      width: 5%; /* Small width for S.No */
      text-align: center; /* Center-align content */
  }

  /* Center align other columns */
  .table th, .table td {
      text-align: center;
      vertical-align: middle;
  }
</style>

<script>
function loadMaintenanceDetails(m_id) {
$.ajax({
  url: '<?php echo base_url(); ?>maintenance/getMaintenanceDetails',
  type: 'GET',
  data: { m_id: m_id },
  dataType : 'json',
  success: function(response) {
      if (response) {
          // Populate modal fields with response data
          $('#vehicle_name').text(response.vehicle_name);
          $('#start_date').text(response.m_start_date);
          $('#end_date').text(response.m_end_date);
          $('#vendor_name').text(response.vendor_name);
          $('#mechanic_name').text(response.mechanic_name);
          $('#service_info').text(response.m_service_info);
          $('#total_cost').text(response.m_cost);
          $('#odometer_reading').text(response.m_odometer_reading);
          $('#service_status').text(ucwords(response.m_status));
          $('#parts_used_table tbody').empty();
                if (response.parts_used && response.parts_used.length > 0) {
                    $.each(response.parts_used, function(index, part) {
                        $('#parts_used_table tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${part.part_name}</td>
                                <td>${part.part_price}</td>
                                <td>${part.quantity || 'N/A'}</td>
                            </tr>
                        `);
                    });
                } else {
                    $('#parts_used_table tbody').append('<tr><td colspan="4">No parts used</td></tr>');
                }

          // Populate the notify members table
          $('#notify_members_table tbody').empty();
          if (response.m_notify_members && response.m_notify_type) {
              let notify_type = response.m_notify_type; // Notify type (e.g., "both", "email", "sms")
              $.each(response.m_notify_members, function(index, member) {
                  let row = '<tr><td>' + (index + 1) + '</td>';

                  // Parse the member data (e.g., "3243|jegadeeshkm@gmail.com|Driver|driver")
                  let member_data = member.split('|');
                  let name = member_data[2]; // Name or role
                  let contact = '';

                  // Determine which contact info to show based on notify type
                  if (notify_type === 'both') {
                      contact = `<b>Email: </b>${member_data[1]}<br><b>Phone: </b>${member_data[0]}`;
                  } else if (notify_type === 'email') {
                      contact = member_data[1]; // Email only
                  } else if (notify_type === 'sms') {
                      contact = member_data[0]; // Phone only
                  }

                  row += '<td>' + contact + '</td>';
                  row += '<td>' + ucwords(name) + '</td>';
                  row += '<td>' + ucwords(notify_type) + '</td>';
                  row += '</tr>';
                  $('#notify_members_table tbody').append(row);
              });
          }
      }
  },
  error: function() {
      alert("Error fetching maintenance details.");
  }
});
}
function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}
</script>


