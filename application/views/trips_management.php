    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Trips
              <a href="<?= base_url(); ?>trips/addtrips" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Trips</li>
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
              <th>Booking ID</th>
              <th>Vehicle & Driver</th>
              <th>Date</th>
              <th>Trip Route</th>
              <th>Distance</th>
              <th>Status</th>
              <th>Created</th>
              <?php if (userpermission('lr_trips_list_edit') || userpermission('lr_booking_del')) { ?>
                <th>Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($triplist)) { 
              $count = 1;
              foreach ($triplist as $trip) { ?>
                <tr>
                  <td><?php echo output($count++); ?></td>
                  <td><?php echo output($trip['t_bookingid']); ?></td>
                  <td>
                    <strong>Vehicle:</strong> <?php echo (isset($trip['t_vechicle_details']->v_name))?output($trip['t_vechicle_details']->v_name):'<span class="badge badge-danger">Yet to Assign</span>'; ?><br>
                    <strong>Driver:</strong> 
                    <?php echo isset($trip['t_driver_details']->d_name) ? $trip['t_driver_details']->d_name : '<span class="badge badge-danger">Yet to Assign</span>'; ?>
                  </td>
                  <td>
                    <strong>Start:</strong> <?php echo date(datetimeformat(), strtotime($trip['t_start_date'])); ?><br>
                    <strong>End:</strong> <?php echo date(datetimeformat(), strtotime($trip['t_end_date'])); ?>
                  </td>
                  <td>
                    <strong>From:</strong> <?php echo output($trip['t_trip_fromlocation']); ?><br>
                    <strong>To:</strong> <?php echo output($trip['t_trip_tolocation']); ?>
                  </td>
                  <td><?php echo ($trip['t_totaldistance']>0)? output($trip['t_totaldistance']):''; ?> </td>
                  <td>
                    <span class="badge badge-success"><?php echo output($trip['t_trip_status']); ?></span><br>
                    <strong>Billing:</strong> <?php echo ($trip['t_billingtype']!='')?output($trip['t_billingtype']):'N/A'; ?>
                  </td>
                  <td>
                    <?php echo date(datetimeformat(), strtotime($trip['t_created_date'])); ?><br>
                    <?php echo ($trip['t_bookingfrom']!='')?'('.output($trip['t_bookingfrom']).')':''; ?>
                    
                  </td>
                  <?php if (userpermission('lr_trips_list_edit') || userpermission('lr_booking_del')) { ?>
                    <td>
                      <?php if (userpermission('lr_trips_list_edit')) { ?>
                        <a class="icon" href="<?php echo base_url(); ?>trips/edittrip/<?php echo output(encodeId($trip['t_id'])); ?>">
                          <i class="fa fa-edit"></i>
                        </a> | 
                        <a class="icon" href="<?php echo base_url(); ?>trips/details/<?php echo output(encodeId($trip['t_id'])); ?>">
                          <i class="fa fa-eye"></i>
                        </a>
                      <?php } ?>
                      <?php if (userpermission('lr_booking_del')) { ?> |
                        <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>trips/deletetrip','<?php echo output($trip['t_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger">
                          <i class="fa fa-trash"></i>
                        </a>
                      <?php } ?>
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



