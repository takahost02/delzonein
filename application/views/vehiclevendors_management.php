<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Vendors Info
               <a href="<?= base_url(); ?>/vehiclevendors/addvehiclevendors" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Vehicle Vendors Info</li>
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
                        <th>Company</th>
                        <th>Contact Person</th>
                        <th>Mobile</th>
                        <th>Date of Contract</th>
                        <th>Contract Doc</th>
                        <th>Address</th>
                        <th>Is Active</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                       <?php if(!empty($vehiclevendorslist)){  $count=1;
                        foreach($vehiclevendorslist as $vehiclevendorslist){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($vehiclevendorslist['vn_name']); ?>

                        <td> <?php echo output($vehiclevendorslist['vn_contact_person']); ?>
                        <td> <?php echo output($vehiclevendorslist['vn_mobile']); ?></td>
                       
                        <td><?php  if($vehiclevendorslist['vn_doj']!='') {  echo output(date(dateformat(), strtotime($vehiclevendorslist['vn_doj']))); } else { echo '-'; } ?></td>
                        <td><?php if($vehiclevendorslist['vn_file']!='') { ?>
                        <a target="_blank" href="<?= base_url(); ?>assets/uploads/<?= ucwords($vehiclevendorslist['vn_file']); ?>" class="">
                          View
                        </a>
                        <?php } else { echo '-'; } ?></td>
                        <td> <?php echo output($vehiclevendorslist['vn_address']); ?></td>
                        <td>  <span class="badge <?php echo ($vehiclevendorslist['vn_is_active']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($vehiclevendorslist['vn_is_active']=='1') ? 'Active' : 'Inactive'; ?></span>  </td>
                        <td>
                           <a class="icon" href="<?php echo base_url(); ?>vehiclevendors/editvehiclevendor/<?php echo output(encodeId($vehiclevendorslist['vn_id'])); ?>">
                           <i class="fa fa-edit"></i>
                           </a>
                           <?php  if(userpermission('lr_vehiclevendors_del')) { ?>

                              <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>conductors/deleteconductor','<?= output($vehiclevendorslist['vn_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a>
                           </a> 
                           <?php } ?>
                        </td>
                        <?php } } ?>
                     </tr>
                  </tbody>
               </table>
              
            </div>
         </div>
         <!-- /.card-body -->
      </div>
   </div>
</section>
