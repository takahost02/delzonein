<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo (isset($vehiclevendordetails))?'Edit Vehicle Vendor':'Add Vehicle Vendor' ?>
              <a href="<?= base_url(); ?>/vehiclevendors" class="btn btn-sm btn-primary"><i class="fa fa-table"></i></a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Vehicle</a></li>
              <li class="breadcrumb-item active"><?php echo (isset($vehiclevendordetails))?'Edit Vehicle Vendor':'Add Vehicle Vendor' ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form method="post" id="add_conductor" class="card" enctype="multipart/form-data" action="<?php echo base_url();?>vehiclevendors/<?php echo (isset($vehiclevendordetails))?'updatevehiclevendor':'insertvehiclevendor'; ?>">
                <div class="card-body">

                  
                  <div class="row">
                    <?php if(isset($vehiclevendordetails)) { ?>
                   <input type="hidden" name="vn_id" id="vn_id" value="<?php echo (isset($vehiclevendordetails)) ? $vehiclevendordetails[0]['vn_id']:'' ?>" >
                 <?php } ?>
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label">Vehicle Vendor Name<span class="form-required">*</span></label>
                      <div class="form-group">
                        <input type="text" name="vn_name" required id="vn_name" class="form-control" placeholder="Vehicle Vendor Name" value="<?php echo (isset($vehiclevendordetails)) ? $vehiclevendordetails[0]['vn_name']:'' ?>" >
                      </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <label class="form-label">Comtact Person Name<span class="form-required">*</span></label>
                      <div class="form-group">
                        <input type="text" name="vn_contact_person" required id="vn_contact_person" class="form-control" placeholder="Comtact Person Name" value="<?php echo (isset($vehiclevendordetails)) ? $vehiclevendordetails[0]['vn_contact_person']:'' ?>" >
                      </div>
                    </div>


                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Mobile<span class="form-required">*</span></label>
                        <input type="number" name="vn_mobile" required value="<?php echo (isset($vehiclevendordetails)) ? $vehiclevendordetails[0]['vn_mobile']:'' ?>" class="form-control" placeholder="Mobile" >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Date of Contract</label>
                        <input type="text" name="vn_doj" required value="<?php echo (isset($vehiclevendordetails)) ? $vehiclevendordetails[0]['vn_doj']:'' ?>" class="form-control datepicker" placeholder="Contract Start Date" >
                      </div>
                    </div>
                    
                    
                    
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                        <label class="form-label">Address<span class="form-required">*</span></label>
                        <textarea class="form-control" autocomplete="off" placeholder="Address"  name="vn_address"><?php echo (isset($vehiclevendordetails)) ? $vehiclevendordetails[0]['vn_address']:'' ?></textarea>
                        
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label for="vn_is_active" class="form-label">Vehicle Vendor Status</label>
                        <select id="vn_is_active" name="vn_is_active" class="form-control " required="">
                          <option value="">Select Vehicle Vendor Status</option> 
                          <option <?php echo (isset($vehiclevendordetails) && $vehiclevendordetails[0]['vn_is_active']==1) ? 'selected':'' ?> value="1">Active</option> 
                          <option <?php echo (isset($vehiclevendordetails) && $vehiclevendordetails[0]['vn_is_active']==0) ? 'selected':'' ?> value="0">Inactive</option> 
                        </select>
                      </div>
                    </div>

                  
                    <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                      <label class="form-label">Contract Document</label>
                      <input type="file" id="file" name="file" class="form-control"/>
                    </div>
                    </div>
                    </div>
      
                </div>
                  <input type="hidden" id="vn_created_by" name="vn_created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">
                   <input type="hidden" id="vn_created_date" name="vn_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"> <?php echo (isset($vehiclevendordetails))?'Update Vehicle Vendor':'Add Vehicle Vendor' ?></button>

                  <!-- <?php if(!isset($vehiclevendordetails)) { ?>
                  <div class="float-left">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">Bulk Import Conductors</button>
                  <a href="<?php echo site_url('conductors/download_template'); ?>">Download CSV Template</a>
                  </div>
                  <?php } ?> -->
                </div>
              </form>
             </div>
    </section>
    <!-- /.content -->


    <div class="modal fade show" id="importModal" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Bulk Import Conductor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
       <form   action="<?php echo base_url(); ?>conductors/import_csv" method="post" enctype="multipart/form-data">
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