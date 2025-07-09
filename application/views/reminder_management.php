    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reminder Info
              <a href="<?= base_url(); ?>reminder/addreminder" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Reminder Info</li>
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
                          <th>Services</th>
                          <th>Due In</th>
                          <th>Message</th>
                          <th>Status</th>
                          <?php if(userpermission('lr_reminder_delete')) { ?>
                          <th>Action</th>
                          <th>Mark As Complete</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($reminderlist)){  $count=1;
                           foreach($reminderlist as $reminderlists){ 
                          
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                           <td> <?php echo output($reminderlists['v_name']); ?></td>
                           <td> <?php echo output(date(dateformat(), strtotime($reminderlists['r_date']))); ?></td>
                           <td><?php $serviceNames = array(); 
                            foreach ($reminderlists['services'] as $service) {
                                $serviceNames[] = $service['rs_name'];
                            }
                            echo implode(', ', $serviceNames);  ?></td>

                            <td><?php  $result = daysUntilDueDate($reminderlists['r_date']);  

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


                           <td><?php echo output($reminderlists['r_message']); ?></td>

                           <td><span class="badge <?php echo ($reminderlists['r_isread']==1) ? 'badge-success' : 'badge-danger'; 
                            ?>"><?php echo ($reminderlists['r_isread']==1) ? 'Completed' : 'Pending'; ?></span></td>  

                            <?php if(userpermission('lr_reminder_delete')) { ?>
                           <td>
                                <a class="icon" href="<?php echo base_url(); ?>reminder/deletereminder/<?php echo output($reminderlists['r_id']); ?>">
                              <i class="fa fa-trash text-danger"></i>
                            </a>
                          </td>

<td>
    <input type="checkbox" class="is-read-slider" data-id="<?php echo $reminderlists['r_id']; ?>" <?php echo ($reminderlists['r_isread']) ? 'checked' : ''; ?> />
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

<script>
  $(document).ready(function() {
    $('.is-read-slider').on('change', function() {
        var reminderId = $(this).data('id');
        var isRead = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: '<?php echo base_url(); ?>reminder/update_read_status',
            type: 'POST',
            data: {
                r_id: reminderId,
                r_isread: isRead
            },
            success: function(response) {
              if(isRead==1) {
                var status = 'completed';
              } else {
                var status = 'pending';
              }
              alertmessage('Reminder marked as '+status,1);
              setTimeout(function() {
                location.reload();
              }, 1500); // Reload after 2 seconds (2000 milliseconds)
              },
            error: function() {
                alertmessage('Error updating status',0);
                location.reload();
            }
        });
    });
});
</script>

