<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Route
               <?php  if(userpermission('lr_route_add')) { ?>
               <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
               <i class="fa fa-plus"></i>
               </button>
               <?php } ?>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Vehicle Route</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body p-0">
            <div class="table-responsive">
               <table id="vehiclelisttbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Name</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($vehicleroute)){  $count=1;
                        foreach($vehicleroute as $vehicleroutedata){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($vehicleroutedata['vr_name']); ?></td>
                        <td> <?php echo output($vehicleroutedata['vr_created_date']); ?></td>
                        <td>
                           <?php  if(userpermission('lr_route_del')) { ?>

                           <a class="icon" data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>vehicle/vehicleroute_delete','<?= output($vehicleroutedata['vr_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top">
                           <i class="fa fa-trash text-danger"></i>
                           </a> 
                           <?php } else { echo '-'; } ?>
                        </td>
                     </tr>
                     <?php } } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="modal fade show" id="modal-add" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Route</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="geofencesave" method="post" action="<?php echo base_url(); ?>vehicle/addroute">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="route_name" class="col-sm-4 col-form-label">Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="vr_name" id="vr_name" required="true" placeholder="Enter Route Name">
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         <button type="submit" id="geofenvaluesave" class="btn btn-primary">Save</button>
         </div>
         </form>
      </div>
   </div>
</div>
