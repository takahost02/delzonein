<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Mechanic
               <?php  if(userpermission('lr_mechanic_add')) { ?>
               <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
               <i class="fa fa-plus"></i>
               </button>
               <?php } ?>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Mechanic</li>
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
               <table id="" class="table card-table table-vcenter text-nowrap  tableexport">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Category</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($mechanic)){  $count=1;
                        foreach($mechanic as $mechanicdata){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($mechanicdata['mm_name']); ?></td>
                        <td> <?php echo output($mechanicdata['mm_email']); ?></td>
                        <td> <?php echo output($mechanicdata['mm_phone']); ?></td>
                        <td> <?php echo output($mechanicdata['mm_category']); ?></td>
                        <td> <?php echo output($mechanicdata['mm_created_date']); ?></td>
                        <td>
                           
                           <a class="icon" href="#" data-toggle="modal" data-target="#modal-edit" 
                              data-id="<?php echo output($mechanicdata['mm_id']); ?>" 
                              data-name="<?php echo output($mechanicdata['mm_name']); ?>"
                              data-email="<?php echo output($mechanicdata['mm_email']); ?>"
                              data-phone="<?php echo output($mechanicdata['mm_phone']); ?>"
                              data-category="<?php echo output($mechanicdata['mm_category']); ?>">
                           <i class="fa fa-edit"></i>
                           </a>
                           <?php  if(userpermission('lr_mechanic_del')) { ?>
                               | <a class="icon" href="<?php echo base_url(); ?>maintenance/mechanic_delete/<?php echo output($mechanicdata['mm_id']); ?>">
                           <i class="fa fa-trash text-danger"></i>
                           </a>
                           <?php } ?>
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
            <h4 class="modal-title">Add New Mechanic</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="mechanicsave" method="post" action="<?php echo base_url(); ?>maintenance/addmechanic">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="mm_name" class="col-sm-4 col-form-label">Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mm_name" id="mm_name" required="true" placeholder="Enter mechanic name">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mm_email" class="col-sm-4 col-form-label">Email</label>
                     <div class="form-group col-sm-8">
                        <input type="email" class="form-control" name="mm_email" id="mm_email"  placeholder="Enter mechanic email">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mm_phone" class="col-sm-4 col-form-label">Phone</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mm_phone" id="mm_phone" placeholder="Enter mechanic phone">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mm_category" class="col-sm-4 col-form-label">Category</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mm_category" id="mm_category" required="true" placeholder="Enter mechanic category">
                     </div>
                  </div>
               </div>
               <input type="hidden" id="mm_created_date" name="mm_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">

         </div>
         <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         <button type="submit" id="mechanicsave" class="btn btn-primary">Save</button>
         </div>
         </form>
      </div>
   </div>
</div>


<!-- Edit Mechanic Modal -->
<div class="modal fade show" id="modal-edit" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Mechanic</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="mechanicupdate" method="post" action="<?php echo base_url(); ?>maintenance/updatemechanic">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="mm_name" class="col-sm-4 col-form-label">Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mm_name" id="edit_mm_name" required="true" placeholder="Enter Mechanic Name">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mm_email" class="col-sm-4 col-form-label">Email</label>
                     <div class="form-group col-sm-8">
                        <input type="email" class="form-control" name="mm_email" id="edit_mm_email" required="true" placeholder="Enter Mechanic Email">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mm_phone" class="col-sm-4 col-form-label">Phone</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mm_phone" id="edit_mm_phone" required="true" placeholder="Enter Mechanic Phone">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mm_category" class="col-sm-4 col-form-label">Category</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mm_category" id="edit_mm_category" required="true" placeholder="Enter Mechanic Category">
                     </div>
                  </div>
               </div>
               <input type="hidden" name="mm_id" id="edit_mm_id">
         </div>
         <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         <button type="submit" id="mechanicupdate" class="btn btn-primary">Save Changes</button>
         </div>
         </form>
      </div>
   </div>
</div>
<script>
   $('#modal-edit').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget); // Button that triggered the modal
       var id = button.data('id');
       var name = button.data('name');
       var email = button.data('email');
       var phone = button.data('phone');
       var category = button.data('category');
   
       var modal = $(this);
       modal.find('#edit_mm_id').val(id);
       modal.find('#edit_mm_name').val(name);
       modal.find('#edit_mm_email').val(email);
       modal.find('#edit_mm_phone').val(phone);
       modal.find('#edit_mm_category').val(category);
   });
</script>