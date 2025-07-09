<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Driver Info
               <a href="<?= base_url(); ?>drivers/adddrivers" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Driver Info</li>
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
      <div class="card">
         <div class="card-body p-0">
            <div class="table-responsive">
               <table id="" class="table card-table table-vcenter text-nowrap tableexport">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>License No</th>
                        <th>License Expiry </th>
                        <th>Date of Joining</th>
                        <th>Doc</th>
                        <th>Is Active</th>
                        <?php if(userpermission('lr_drivers_list_edit') || userpermission('lr_driver_del')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                       <?php if(!empty($driverslist)){  $count=1;
                        foreach($driverslist as $driverslists){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td>
                        <?php if ($driverslists['d_file'] != '' && file_exists(FCPATH . 'assets/uploads/' . $driverslists['d_file'])) { ?>
                           <img class="img-fluid" style="width: 58px;" src="<?= base_url(); ?>assets/uploads/<?= $driverslists['d_file']; ?>" alt="Driver Image">
                        <?php } else { ?>
                           <small class="text-muted">No image</small>
                        <?php } ?>
                     </td>
                        <td> <?php echo output($driverslists['d_name']); ?></td>
                        <td> <b>Mobile :</b> <?php echo output($driverslists['d_mobile']); ?><br>
                        <b>Email :</b> <?php echo output($driverslists['d_email']); ?></td>
                        <td><?php echo output($driverslists['d_licenseno']); ?></td>
                        <td><?php echo output(date(dateformat(), strtotime($driverslists['d_license_expdate']))); ?>
                       <?php  echo '<br>'.daysRemaining($driverslists['d_license_expdate']); ?>

                     </td>
                        <td><?php if($driverslists['d_doj']!='') { echo output(date(dateformat(), strtotime($driverslists['d_doj']))); } else { echo '-'; } ?></td>
                        <td><?php if($driverslists['d_file1']!='') { ?>
                        <a target="_blank" href="<?= base_url(); ?>assets/uploads/<?= ucwords($driverslists['d_file1']); ?>" class="">
                          View
                        </a>
                        <?php } else { echo '-'; } ?></td>
                        <td>  <span class="badge <?php echo ($driverslists['d_is_active']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($driverslists['d_is_active']=='1') ? 'Active' : 'Inactive'; ?></span>  </td>
                        <td>
                           <?php if(userpermission('lr_drivers_list_edit')) { ?>
                           <a class="icon" href="<?php echo base_url(); ?>drivers/editdriver/<?php echo output($driverslists['d_id']); ?>">
                           <i class="fa fa-edit"></i>
                           </a>
                           <?php  } if(userpermission('lr_driver_del')) { ?> |
                              <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>drivers/deletedriver','<?= output($driverslists['d_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a>
                           </a> 
                           <?php } ?>
                        </td>
                        <?php }  } ?>
                     </tr>
                  </tbody>
               </table>
              
            </div>
         </div>
         <!-- /.card-body -->
      </div>
   </div>
</section>
<!-- /.content -->