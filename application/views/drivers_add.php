    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo (isset($driverdetails))?'Edit driver':'Add driver' ?>
            <a href="<?= base_url(); ?>drivers" class="btn btn-sm btn-primary"><i class="fa fa-table"></i></a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Vehicle</a></li>
              <li class="breadcrumb-item active"><?php echo (isset($driverdetails))?'Edit driver':'Add driver' ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form method="post" id="add_driver" class="card" enctype="multipart/form-data" action="<?php echo base_url();?>drivers/<?php echo (isset($driverdetails))?'updatedriver':'insertdriver'; ?>">
                <div class="card-body">

                  
                  <div class="row">
                    <?php if(isset($driverdetails)) { ?>
                   <input type="hidden" name="d_id" id="d_id" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_id']:'' ?>" >
                 <?php } ?>
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label">Driver Name<span class="form-required">*</span></label>
                      <div class="form-group">
                        <input type="text" name="d_name" id="d_name" class="form-control" placeholder="Driver Name" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_name']:'' ?>" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Mobile<span class="form-required">*</span></label>
                        <input type="text" name="d_mobile" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_mobile']:'' ?>" class="form-control" placeholder="Mobile" >
                      </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Email<span class="form-required">*</span></label>
                        <input type="text" name="d_email" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_email']:'' ?>" class="form-control" placeholder="Email" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Age<span class="form-required">*</span></label>
                        <input type="text" name="d_age" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_age']:'' ?>" class="form-control" placeholder="Age" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">License No<span class="form-required">*</span></label>
                        <input type="text" name="d_licenseno" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_licenseno']:'' ?>" class="form-control" placeholder="License No" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">License Expiry Date<span class="form-required">*</span></label>
                        <input type="text" name="d_license_expdate" value="<?php echo (isset($driverdetails)) ? date(dateformat(), strtotime($driverdetails[0]['d_license_expdate'])):'' ?>" class="form-control datepicker" placeholder="License Expiry Date" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                        <label class="form-label">Total Experiance<span class="form-required">*</span></label>
                        <input type="text" name="d_total_exp" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_total_exp']:'' ?>" class="form-control" placeholder="Total Experiance" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                        <label class="form-label">Date of Joining<span class="form-required">*</span></label>
                        <input type="text" name="d_doj" value="<?php echo (isset($driverdetails)) ? date(dateformat(), strtotime($driverdetails[0]['d_doj'])):'' ?>" class="form-control datepicker" placeholder="Date of Joining" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                        <label class="form-label">Reference/Notes</label>
                        <input type="text" name="d_ref" value="<?php echo (isset($driverdetails)) ? $driverdetails[0]['d_ref']:'' ?>" class="form-control" placeholder="Reference or Notes" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                        <label class="form-label">Address<span class="form-required">*</span></label>
                        <textarea class="form-control" autocomplete="off" placeholder="Address"  name="d_address"><?php echo (isset($driverdetails)) ? $driverdetails[0]['d_address']:'' ?></textarea>
                        
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label for="d_is_active" class="form-label">Driver Status</label>
                        <select id="d_is_active" name="d_is_active" class="form-control select2" required="">
                          <option value="">Select Driver Status</option> 
                          <option <?php echo (isset($driverdetails) && $driverdetails[0]['d_is_active']==1) ? 'selected':'' ?> value="1">Active</option> 
                          <option <?php echo (isset($driverdetails) && $driverdetails[0]['d_is_active']==0) ? 'selected':'' ?> value="0">Inactive</option> 
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                      <label class="form-label">Driver Photo</label>
                      <input type="file" id="file" name="file" class="form-control"/>
                    </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                      <label class="form-label">Driver Document</label>
                      <input type="file" id="file1" name="file1" class="form-control"/>
                    </div>
                    </div>

                  


                    </div>

                    
      
                </div>
                  <input type="hidden" id="d_created_by" name="d_created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">
                   <input type="hidden" id="d_created_date" name="d_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"> <?php echo (isset($driverdetails))?'Update Driver':'Add Driver' ?></button>

                  <?php if(!isset($driverdetails)) { ?>
                  <div class="float-left">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">Bulk Import Drivers</button>
                  <a href="<?php echo site_url('drivers/download_template'); ?>">Download CSV Template</a>
                  </div>
                  <?php } ?>

                </div>
              </form>
             </div>
    </section>
    <!-- /.content -->



    <div class="modal fade show" id="importModal" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Bulk Import Drivers</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
       <form   action="<?php echo base_url(); ?>drivers/import_csv" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">File</label>
              <div class="col-sm-10">
              <input type="file" class="form-control" name="file" required>
                          </div>
            </div>            
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
          </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>