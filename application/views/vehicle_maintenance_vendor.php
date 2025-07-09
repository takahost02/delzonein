<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Maintenance Vendor
               <?php  if(userpermission('lr_vendor_add')) { ?>
               <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
               <i class="fa fa-plus"></i>
               </button>
               <?php } ?>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Maintenance Vendor</li>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($maintenance_vendor)){  $count=1;
                        foreach($maintenance_vendor as $maintenance_vendordata){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($maintenance_vendordata['mv_name']); ?></td>
                        <td> <?php echo output($maintenance_vendordata['mv_email']); ?></td>
                        <td> <?php echo output($maintenance_vendordata['mv_phone']); ?></td>
                        <td> <?php echo output($maintenance_vendordata['mv_created_date']); ?></td>
                        <td>
                           
                           <a class="icon" href="#" data-toggle="modal" data-target="#modal-edit" 
                              data-id="<?php echo output($maintenance_vendordata['mv_id']); ?>" 
                              data-name="<?php echo output($maintenance_vendordata['mv_name']); ?>"
                              data-email="<?php echo output($maintenance_vendordata['mv_email']); ?>"
                              data-phone="<?php echo output($maintenance_vendordata['mv_phone']); ?>"
                              >
                           <i class="fa fa-edit"></i>
                           </a>
                           <?php  if(userpermission('lr_vendor_del')) { ?>
                           | <a class="icon" href="<?php echo base_url(); ?>maintenance/maintenance_vendor_delete/<?php echo output($maintenance_vendordata['mv_id']); ?>">
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

<!-- Add Maintenance Vendor Modal -->
<div class="modal fade show" id="modal-add" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Maintenance Vendor</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="maintenance_vendorsave" method="post" action="<?php echo base_url(); ?>maintenance/addmaintenance_vendor">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="mv_name" class="col-sm-4 col-form-label">Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mv_name" required="true" id="mv_name" required="true" placeholder="Enter vendor name">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mv_email" class="col-sm-4 col-form-label">Email</label>
                     <div class="form-group col-sm-8">
                        <input type="email" class="form-control" name="mv_email" id="mv_email" placeholder="Enter vendor email">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mv_phone" class="col-sm-4 col-form-label">Phone</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mv_phone" required="true" id="mv_phone" placeholder="Enter vendor phone">
                     </div>
                  </div>
                 
               </div>
               <input type="hidden" id="mv_created_date" name="mv_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" id="maintenance_vendorsave" class="btn btn-primary">Save</button>
         </div>
            </form>
      </div>
   </div>
</div>

<!-- Edit Maintenance Vendor Modal -->
<div class="modal fade show" id="modal-edit" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Maintenance Vendor</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="maintenance_vendorupdate" method="post" action="<?php echo base_url(); ?>maintenance/updatemaintenance_vendor">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="mv_name" class="col-sm-4 col-form-label">Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mv_name" id="edit_mv_name" required="true" placeholder="Enter Vendor Name">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mv_email" class="col-sm-4 col-form-label">Email</label>
                     <div class="form-group col-sm-8">
                        <input type="email" class="form-control" name="mv_email" id="edit_mv_email" required="true" placeholder="Enter Vendor Email">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mv_phone" class="col-sm-4 col-form-label">Phone</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="mv_phone" id="edit_mv_phone" required="true" placeholder="Enter Vendor Phone">
                     </div>
                  </div>
                 
               </div>
               <input type="hidden" name="mv_id" id="edit_mv_id">
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" id="maintenance_vendorupdate" class="btn btn-primary">Save Changes</button>
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
   
       var modal = $(this);
       modal.find('#edit_mv_id').val(id);
       modal.find('#edit_mv_name').val(name);
       modal.find('#edit_mv_email').val(email);
       modal.find('#edit_mv_phone').val(phone);
   });
</script>
