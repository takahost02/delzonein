<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Fuel Info
              <a href="<?= base_url(); ?>fuel/addfuel" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Fuel Info</li>
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
                    <table id="" class="table card-table tableexport">
                      <thead>
                        <tr>
                          <th class="w-1">S.No</th>
                           <th>Fuel Fill Date</th>
                          <th>Vechicle</th>
                          <th>Quantity</th>
                          <th>Cost</th>
                          <th>Filled By</th>
                          <th>Reading</th>
                          <th>Source</th>
                          <th>Comments</th>
                          <?php if(userpermission('lr_fuel_edit') || userpermission('lr_fuel_del')) { ?>
                          <th>Action</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($fuel)){  $count=1;
                           foreach($fuel as $fuels){
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                            <td> <?php echo output(date(dateformat(), strtotime($fuels['v_fuelfilldate']))); ?></td>
                           <td> <?php echo output((isset($fuels['vech_name']->v_name))?$fuels['vech_name']->v_name:''); ?></td>
                           <td> <?php echo output($fuels['v_fuel_quantity']); ?></td>
                           <td><?php echo sitedata()['s_price_prefix'].output($fuels['v_fuelprice']); ?></td>
                           <td> <?php echo output((isset($fuels['filled_by']->d_name))?$fuels['filled_by']->d_name:''); ?></td>
                           <td><?php echo output($fuels['v_odometerreading']); ?></td>
                           <td><?php  
                                $source = $fuels['v_fuelsource'] ?? '';
                                $vendor = $fuels['v_fuelvendor'] ?? '';

                                if ($source === 'vendor') {
                                    echo output(strtoupper((string)$source) . ' - ' . $vendor);
                                } else {
                                    echo output(strtoupper((string)$source));
                                }
                            ?></td>
                           <td><?php echo output($fuels['v_fuelcomments']); ?></td>
                           <?php if(userpermission('lr_fuel_edit')) { ?>
                              <td>
                            <a class="icon" href="<?php echo base_url(); ?>fuel/editfuel/<?php echo output($fuels['v_fuel_id']); ?>">
                              <i class="fa fa-edit"></i>
                            </a>
                            <?php  } if(userpermission('lr_booking_del')) { ?> |
                              <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>fuel/deletefuel','<?= output($fuels['v_fuel_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a>
                           </a> 
                           <?php } ?>
                          </td>
                          <?php } ?>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    
        </div>         
        </div>
        <!-- /.card-body -->
      </div>
      
             </div>
    </section>
    <!-- /.content -->



