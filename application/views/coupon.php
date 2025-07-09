<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Coupon Management
               <?php if(userpermission('lr_coupon')) { ?>
               <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
                  <i class="fa fa-plus"></i>
               </button>
               <?php } ?>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Coupons</li>
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
               <table id="couponlisttbl" class="table card-table table-vcenter text-nowrap">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <?php if(userpermission('lr_coupon')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($coupons)){ $count=1; foreach($coupons as $coupon) { ?>
                     <tr>
                        <td><?php echo output($count); $count++; ?></td>
                        <td><?php echo output($coupon['code']); ?></td>
                        <td><?php echo output($coupon['discount']); ?></td>
                        <td><?php echo output($coupon['start_date']); ?></td>
                        <td><?php echo output($coupon['end_date']); ?></td>
                        <?php if(userpermission('lr_coupon')) { ?>
                        <td>
                           <a class="icon" href="#" data-toggle="modal" data-target="#modal-edit" onclick="editCoupon(<?php echo json_encode($coupon); ?>)">
                              <i class="fa fa-edit"></i>
                           </a> |  
                           <a class="icon" href="<?php echo base_url(); ?>coupon/delete/<?php echo output($coupon['id']); ?>">
                              <i class="fa fa-trash text-danger"></i>
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

<!-- Add New Coupon Modal -->
<div class="modal fade" id="modal-add" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Coupon</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="addCouponForm" method="post" action="<?php echo base_url(); ?>coupon/add">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="code" class="col-sm-4 col-form-label">Code</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="code" id="code" required="true" placeholder="Enter Coupon Code">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="discount" class="col-sm-4 col-form-label">Discount</label>
                     <div class="form-group col-sm-8">
                        <input type="number" class="form-control" name="discount" id="discount" required="true" placeholder="Enter Discount">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="start_date" class="col-sm-4 col-form-label">Start Date</label>
                     <div class="form-group col-sm-8">
                        <input type="datetime-local" class="form-control" name="start_date" id="start_date" required="true">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="end_date" class="col-sm-4 col-form-label">End Date</label>
                     <div class="form-group col-sm-8">
                        <input type="datetime-local" class="form-control" name="end_date" id="end_date" required="true">
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" id="addCouponSubmit" class="btn btn-primary">Save</button>
         </div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Coupon Modal -->
<div class="modal fade" id="modal-edit" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Coupon</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="editCouponForm" method="post" action="<?php echo base_url(); ?>coupon/edit">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="edit_code" class="col-sm-4 col-form-label">Code</label>
                     <div class="form-group col-sm-8">
                        <input type="hidden" name="id" id="edit_id">
                        <input type="text" class="form-control" name="code" id="edit_code" required="true" placeholder="Enter Coupon Code">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="edit_discount" class="col-sm-4 col-form-label">Discount</label>
                     <div class="form-group col-sm-8">
                        <input type="number" class="form-control" name="discount" id="edit_discount" required="true" placeholder="Enter Discount">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="edit_start_date" class="col-sm-4 col-form-label">Start Date</label>
                     <div class="form-group col-sm-8">
                        <input type="datetime-local" class="form-control" name="start_date" id="edit_start_date" required="true">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="edit_end_date" class="col-sm-4 col-form-label">End Date</label>
                     <div class="form-group col-sm-8">
                        <input type="datetime-local" class="form-control" name="end_date" id="edit_end_date" required="true">
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" id="editCouponSubmit" class="btn btn-primary">Update</button>
         </div>
         </form>
      </div>
   </div>
</div>

<script>
   function editCoupon(data) {
       document.getElementById('edit_id').value = data.id;
       document.getElementById('edit_code').value = data.code;
       document.getElementById('edit_discount').value = data.discount;
       document.getElementById('edit_start_date').value = data.start_date;
       document.getElementById('edit_end_date').value = data.end_date;
   }
</script>
