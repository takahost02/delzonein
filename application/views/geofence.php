    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Geofence Info
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Geofence Info</li>
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
                    <table id="" class="table card-table table-vcenter text-nowrap tableexport">
                      <thead>
                        <tr>
                          <th class="w-1">S.No</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Vehicle</th>
                          <th>Notification Type</th>
                          <th>Notifiy Users</th>
                          <th>Events</th>
                          <th>Preview</th>
                          <?php if(userpermission('lr_geofence_delete')) { ?>
                        <th>Delete</th>
                        <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                         <?php if(!empty($geofencelist)){
                          $count=1;
                         foreach($geofencelist as $geofence){  
                          $notify_type = $geofence['geo_notify_type']; 
                          $notify_members = [];
                      
                          if (!empty($geofence['geo_notify_members'])) {
                              $notify_members = json_decode($geofence['geo_notify_members'], true);
                          }
                         ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                           <td> <?php echo ucfirst($geofence['geo_name']); ?></td>
                           <td><?php echo output($geofence['geo_description']); ?></td>
                           <td><?php echo output($geofence['geo_vehiclename']); ?></td>
                           <td><?php echo output(ucfirst($notify_type)); ?></td>
                           <td>
                                <table class="table table-bordered" border="0" style="width: 100%;border-collapse: collapse;font-size: x-small;">
                                    <thead>
                                        <tr>
                                            <th>Contact</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($notify_members as $index => $member) {
                                            $member_data = explode('|', $member);
                                            $phone = $member_data[0]; // Phone number
                                            $email = $member_data[1]; // Email address
                                            $name = ucfirst($member_data[2]); // Name or role
                                            $contact = '';

                                            if ($notify_type === 'both') {
                                                $contact = "<b>Email:</b> $email<br><b>Phone:</b> $phone";
                                            } elseif ($notify_type === 'email') {
                                                $contact = "<b>Email:</b>".$email; // Email only
                                            } elseif ($notify_type === 'sms') {
                                                $contact = "<b>Phone:</b>".$phone; // Phone only
                                            }

                                            // Display the row for this member
                                            echo "
                                            <tr>
                                                <td>$contact</td>
                                                <td>$name</td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </td>

                            <td>
                            
                            <a class="icon geofenceevents" data-id='<?= $geofence['geo_id'] ?>' href="javascript:void(0);">
                              <i class="fa fa-eye"></i>
                            </a> </td>
                          


                           <td>
                            
                            <a class="icon geofenceviewpopup" data-id='<?= $geofence['geo_id'] ?>' href="javascript:void(0);">
                              <i class="fa fa-eye"></i>
                            </a> </td>
                             <?php if(userpermission('lr_geofence_delete')) { ?>
                            <td>
                          

                            <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>geofence/geofencedelete','<?= output($geofence['geo_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a>


                          </td>
                           <?php } ?>
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



<div id="geofencepopupmodel" class="modal fade">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">

      
   </head>
   
   <body >
      <div id = "googleMap" style = "width:100%; height:400px;"></div>
   </body>
   
         </div>
         <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
         </div>
      </div>
   </div>
</div>



<!-- Modal for Geofence Events -->
<div class="modal fade" id="geofenceEventsModal" tabindex="-1" role="dialog" aria-labelledby="geofenceEventsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="geofenceEventsModalLabel">Geofence Events</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- DataTable for displaying Geofence Events -->
        <table id="geofenceEventsTable" class="table table-bordered">
          <thead>
            <tr>
              <th>Vehicle</th>
              <th>Geofence</th>
              <th>Event Type</th>
              <th>Timestamp</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
$(document).on('click', '.geofenceevents', function() {
    var geofence_id = $(this).data('id');
    $('#geofenceEventsModal').modal('show');
    
    $.ajax({
        url: '<?= base_url('geofence/get_geofence_events') ?>', 
        type: 'GET',
        dataType: 'json', 
        data: { geo_id: geofence_id },
        success: function(response) {
            if (Array.isArray(response)) {
                $('#geofenceEventsTable tbody').empty();
                response.forEach(function(event) {
                    var row = '<tr>';
                    row += '<td>' + event.v_name + '</td>';
                    row += '<td>' + event.geo_name + '</td>';
                    row += '<td>' + event.ge_event + '</td>';
                    row += '<td>' + event.ge_timestamp + '</td>';
                    row += '</tr>';
                    $('#geofenceEventsTable tbody').append(row);
                });
            } else {
                console.error('Unexpected response format:', response);
            }
        },
        error: function(xhr, status, error) {
            alert('Error fetching geofence events: ' + error);
        }
    });
});


</script>
