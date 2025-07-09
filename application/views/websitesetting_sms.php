<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Twilio Configuration</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Twilio Configuration</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 col-md-offset-2">
                    <form id="addnewcategory" class="basicvalidation" role="form" action="<?php echo base_url(); ?>settings/twilioconfigsave" method="post" enctype='multipart/form-data'>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" id="ss_is_active" required="true" name="ss_is_active">
                                    <option value="">Choose status</option>
                                    <option <?php echo (isset($twilioconfig[0]['ss_is_active']) && $twilioconfig[0]['ss_is_active'] == 1) ? 'selected' : '' ?> value="1">Enabled</option>
                                    <option <?php echo (isset($twilioconfig[0]['ss_is_active']) && $twilioconfig[0]['ss_is_active'] == 0) ? 'selected' : '' ?> value="0">Disabled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Account SID</label>
                                <input type="text" class="form-control" required="true" value="<?php echo output(isset($twilioconfig[0]['ss_account_sid']) ? $twilioconfig[0]['ss_account_sid'] : ''); ?>" id="ss_account_sid" name="ss_account_sid" placeholder="Enter Account SID">
                            </div>

                            <div class="form-group">
                                <label>Auth Token</label>
                                <input type="password" class="form-control" required="true" value="<?php echo output(isset($twilioconfig[0]['ss_auth_token']) ? $twilioconfig[0]['ss_auth_token'] : ''); ?>" id="ss_auth_token" name="ss_auth_token" placeholder="Enter Auth Token">
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" required="true" value="<?php echo output(isset($twilioconfig[0]['ss_number']) ? $twilioconfig[0]['ss_number'] : ''); ?>" id="ss_number" name="ss_number" placeholder="Enter Phone Number">
                            </div>

                            <div class="modal-footer">
                            <?php if(isset($twilioconfig[0]['ss_auth_token']) && $twilioconfig[0]['ss_auth_token']!='') { ?>
                              <button type="button" class="btn btn-light waves-effect" data-toggle="modal" data-target="#testsms">Test SMS</button>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary">Save Config</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="testsms" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Test SMS Configuration</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="needs-validation custom-validation" novalidate action="<?php echo base_url(); ?>settings/twilioconfigtestsms" method="post">
        <div class="modal-body">
          <div class="form-group row">
            <label for="testsmsto" class="col-sm-3 col-form-label">Phone No.</label>
            <div class="col-sm-9">
              <input type="number" required="true" class="form-control" id="testsmsto" name="testsmsto" placeholder="Enter phone number with country code">
              <div class="invalid-feedback">
                Please enter test phone number.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send SMS</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
