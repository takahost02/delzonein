<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Type
            <?php if(userpermission('lr_vech_group_action')) { ?>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
            <i class="fa fa-plus"></i>
            </button>
            <?php } ?>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Vehicle Group</li>
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
               <table id="" class="table card-table table-vcenter text-nowrap tableexport">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Vehicle Type</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Frontend Booking</th>
                        <th>Created Date</th>
                        <?php if(userpermission('lr_vech_group_action')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($vehiclegroup)){  $count=1;
                        foreach($vehiclegroup as $vehiclegroupdata){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($vehiclegroupdata['gr_name']); ?></td>
                        <td> <?php echo output($vehiclegroupdata['gr_desc']); ?></td>
                        <td>
                        <?php if (!empty($vehiclegroupdata['gr_image'])) { ?>
                           <img src="<?= base_url('uploads/' . output($vehiclegroupdata['gr_image'])); ?>" alt="Group Image" width="50">
                        <?php } else { ?>
                           No Image
                        <?php } ?>
                     </td>
                     <td><span class="badge <?php echo ($vehiclegroupdata['gr_visibletobooking'] == 1) ? 'badge-success' : 'badge-danger'; ?>">
                     <?php echo ($vehiclegroupdata['gr_visibletobooking'] == 1) ? 'Visible' : 'Hidden'; ?>
                  </span></td>                          
                  <td> <?php echo output($vehiclegroupdata['gr_created_date']); ?></td>
                        <?php if(userpermission('lr_vech_group_action')) { ?>
                        <td>
                          <a href="#" class="icon preventDefault" onclick="editGroup(<?= $vehiclegroupdata['gr_id'] ?>, '<?= $vehiclegroupdata['gr_name'] ?>', '<?= $vehiclegroupdata['gr_desc'] ?>', '<?= $vehiclegroupdata['gr_image'] ?>','<?= $vehiclegroupdata['gr_visibletobooking'] ?>')">
                           <i class="fa fa-edit"></i>
                           </a>   |  
                           <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>vehicle/vehiclegroup_delete/','<?= output(encodeId($vehiclegroupdata['gr_id'])); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a>
                           </a> 
                           
                           </a> 
                        </td>
                        <?php } ?>
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
            <h4 class="modal-title">Add New Vehicle Type</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="geofencesave" method="post" action="<?php echo base_url(); ?>vehicle/addgroup" enctype="multipart/form-data">
               <div class="card-body">
                 
                  

               <div class="form-group row">
                     <label for="edit_gr_name" class="col-sm-4 col-form-label">Vehicle Type Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="gr_name" required placeholder="Enter Vehicle Type Name">
                     </div>
                  </div>

               <div class="form-group row">
                  <label for="Cateogry" class="col-sm-4 col-form-label">Description</label>
                  <div class="form-group col-sm-8">
                     <input type="text" class="form-control" name="gr_desc" id="gr_desc" required="true" placeholder="Enter Description">
                  </div>
               </div>

               <div class="form-group row">
               <label for="group_image" class="col-sm-4 col-form-label">Image</label>
               <div class="form-group col-sm-8">
                  <input type="file" required class="form-control" name="group_image" id="group_image" accept="image/*">
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


<div class="modal fade" id="modal-edit" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Vehicle Type</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
         <form id="editGroupForm" method="post" action="<?php echo base_url(); ?>vehicle/updategroup" enctype="multipart/form-data">
         <input type="hidden" name="gr_id" id="edit_gr_id">
               <div class="card-body">
                  
                  
               <div class="form-group row">
                     <label for="edit_gr_name" class="col-sm-4 col-form-label">Vehicle Type Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="gr_name" id="edit_gr_name" required placeholder="Enter Vehicle Type Name">
                     </div>
                  </div>

                  <div class="form-group row">
                     <label for="edit_gr_desc" class="col-sm-4 col-form-label">Description</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="gr_desc" id="edit_gr_desc" required placeholder="Enter Description">
                     </div>
                  </div>

                  <div class="form-group row">
                     <label for="edit_group_image" class="col-sm-4 col-form-label">Image</label>
                     <div class="form-group col-sm-8">
                        <input type="file" class="form-control" name="group_image" id="edit_group_image" accept="image/*">
                        <img style="width: 90%;" id="existing_image" src="" alt="Image" />
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="gr_visibletobooking">
                        <input type="checkbox" id="gr_visibletobooking" name="gr_visibletobooking">
                        Visible to Booking Option
                     </label>
               </div>
               </div>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
         </div>
         </form>
      </div>
   </div>
</div>

<script>
   function editGroup(id, name, description, image,visibletobooking) {
      $('#edit_gr_id').val(id);
      $('#edit_gr_name').val(name);
      $('#edit_gr_desc').val(description);
      if(image=='') {
         $('#existing_image').css('display','none')
      } else {
         var image = '<?= base_url(); ?>uploads/'+image;
         $('#existing_image').attr('src', image);
      }
      if (visibletobooking == 1) {
        $('#gr_visibletobooking').prop('checked', true);
      } else {
         $('#gr_visibletobooking').prop('checked', false);
      }
      $('#modal-edit').modal('show');
   }
   </script>