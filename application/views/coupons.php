<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Coupon Management
               <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
                  <i class="fa fa-plus"></i>
               </button>
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
               <table id="" class="table card-table table-vcenter text-nowrap tableexport">
                  <thead>
                     <tr>
                        <th>S.No</th>
                        <th>Coupon Code</th>
                        <th>Discount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Max Limit</th>
                        <th>Used</th>
                        <th>Days Remaining</th>
                        <th>Status</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($coupons)) {
                        $count = 1;
                        foreach ($coupons as $coupon) { ?>
                     <tr>
                        <td><?= $count++; ?></td>
                        <td><?= output($coupon['cp_code']); ?></td>
                        <td><?= output($coupon['cp_discount']); ?> (<?= ucfirst($coupon['cp_discount_method']); ?>)</td>
                        <td><?= output($coupon['cp_start_date']); ?></td>
                        <td><?= output($coupon['cp_end_date']); ?></td>
                        <td><?= output($coupon['cp_usage_limit']); ?></td>
                        <td><?= get_coupon_usage($coupon['cp_code']); ?></td>
                        <td><?= daysRemaining($coupon['cp_end_date']); ?></td>
                        <td>  <span class="badge <?php echo ($coupon['cp_status']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($coupon['cp_status']=='1') ? 'Active' : 'Inactive'; ?></span>  </td>

                        <td>
                           <a class="icon" href="#" onclick="editCoupon(<?= $coupon['cp_id'] ?>, '<?= $coupon['cp_code'] ?>', '<?= $coupon['cp_discount'] ?>', '<?= $coupon['cp_start_date'] ?>', '<?= $coupon['cp_end_date'] ?>', '<?= $coupon['cp_usage_limit'] ?>', '<?= $coupon['cp_discount_method'] ?>', '<?= $coupon['cp_status'] ?>')">
                              <i class="fa fa-edit"></i>
                           </a> |
                           <a href="#"  onclick="confirmation('<?= base_url(); ?>coupon/delete/', '<?= $coupon['cp_id']; ?>')" class="text-danger">
                              <i class="fa fa-trash"></i>
                           </a>
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

<!-- Add Coupon Modal -->
<div class="modal fade" id="modal-add">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Coupon</h4>
            <button type="button" class="close" data-dismiss="modal">
               <span>&times;</span>
            </button>
         </div>
         <div class="modal-body">
         <form id="couponSaveForm" method="post" action="<?= base_url(); ?>coupon/add">
            <div class="card-body">
               <div class="form-group row">
                  <div class="col-md-6">
                     <label>Coupon Code</label>
                     <input type="text" class="form-control" name="cp_code" required>
                  </div>
                  <div class="col-md-6">
                     <label>Discount</label>
                     <input type="number" class="form-control" name="cp_discount" step="0.01" required>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                     <label>Start Date</label>
                     <input type="text" class="form-control datepicker" name="cp_start_date" required>
                  </div>
                  <div class="col-md-6">
                     <label>End Date</label>
                     <input type="text" class="form-control datepicker" name="cp_end_date" required>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                     <label>Usage Limit</label>
                     <input type="text" class="form-control" name="cp_usage_limit">
                  </div>
                  <div class="col-md-6">
                  <label>Discount Method</label>
                  <select class="form-control" name="cp_discount_method" required>
                     <option value="fixed">Fixed</option>
                     <option value="percentage">Percentage</option>
                  </select>
               </div>

               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                     <label>Status</label>
                     <select class="form-control" name="cp_status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>

         </div>
      </div>
   </div>
</div>

<!-- Edit Coupon Modal -->
<div class="modal fade" id="modal-edit">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Coupon</h4>
            <button type="button" class="close" data-dismiss="modal">
               <span>&times;</span>
            </button>
         </div>
         <div class="modal-body">
         <form id="editCouponForm" method="post" action="<?= base_url(); ?>coupon/update">
   <input type="hidden" name="cp_id" id="edit_cp_id">
   <div class="card-body">
      <div class="row">
         <div class="col-md-6">
            <label>Coupon Code</label>
            <input type="text" class="form-control" name="cp_code" id="edit_cp_code" required>
         </div>
         <div class="col-md-6">
            <label>Discount</label>
            <input type="number" class="form-control" name="cp_discount" id="edit_cp_discount" step="0.01" required>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <label>Start Date</label>
            <input type="text" class="form-control datepicker" name="cp_start_date" id="edit_cp_start_date" required>
         </div>
         <div class="col-md-6">
            <label>End Date</label> 
            <input type="text" class="form-control datepicker" name="cp_end_date" id="edit_cp_end_date" required>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <label>Usage Limit</label>
            <input type="text" class="form-control" name="cp_usage_limit" id="edit_cp_usage_limit">
         </div>
         <div class="col-md-6">
            <label>Discount Method</label>
            <select class="form-control" name="cp_discount_method" id="edit_cp_discount_method" required>
               <option value="fixed">Fixed</option>
               <option value="percentage">Percentage</option>
            </select>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <label>Status</label>
            <select class="form-control" name="cp_status" id="edit_cp_status">
               <option value="1">Active</option>
               <option value="0">Inactive</option>
            </select>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Save Changes</button>
   </div>
</form>


         </div>
      </div>
   </div>
</div>

<script>
   function editCoupon(id, code, discount, startDate, endDate, usageLimit, discountMethod, status) {
      $('#edit_cp_id').val(id);
      $('#edit_cp_code').val(code);
      $('#edit_cp_discount').val(discount);
      $('#edit_cp_start_date').val(startDate);
      $('#edit_cp_end_date').val(endDate);
      $('#edit_cp_usage_limit').val(usageLimit);
      $('#edit_cp_discount_method').val(discountMethod);
      $('#edit_cp_status').val(status);
      $('#modal-edit').modal('show');
   }
</script>
