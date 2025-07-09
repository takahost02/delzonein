  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Traccar Configuration
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Traccar Configuration</li>
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
                <div class="col-sm-6 col-md-offset-2 ">
              <form id="addnewcategory" class="basicvalidation" role="form" action="<?php echo base_url(); ?>settings/traccarconfigsave" method="post"  enctype='multipart/form-data'>
                <div class="card-body">
                  

                  <div class="form-group">
                     <label>Status</label>
                     <select class="form-control" id="s_traccar_enabled" required="true" name="s_traccar_enabled">
                      <option value="">Choose status</option>
                      <option <?php echo (isset($website_setting[0]['s_traccar_enabled']) && $website_setting[0]['s_traccar_enabled']==1) ? 'selected':'' ?> value="1">Enabled</option>
                      <option <?php echo (isset($website_setting[0]['s_traccar_enabled']) && $website_setting[0]['s_traccar_enabled']==0) ? 'selected':'' ?> value="0">Disabled</option>
                    </select>

                  </div>

                  <div class="form-group">
                    <label>URL</label>
                    <input type="text" class="form-control" required="true" value="<?php echo output(isset($website_setting[0]['s_traccar_url'])?$website_setting[0]['s_traccar_url']:''); ?>" id="s_traccar_url" name="s_traccar_url" placeholder="Enter URL/IP address with Port No">
                  </div>
                  
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" required="true" value="<?php echo output(isset($website_setting[0]['s_traccar_username'])?$website_setting[0]['s_traccar_username']:''); ?>" id="s_traccar_username" name="s_traccar_username" placeholder="Enter Username">
                  </div>


                   <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" required="true" value="<?php echo output(isset($website_setting[0]['s_traccar_password'])?$website_setting[0]['s_traccar_password']:''); ?>" id="s_traccar_password" name="s_traccar_password" placeholder="Enter Password">
                  </div>

                   
               
                    <div class="modal-footer">
                  
                    <button type="submit" class="btn btn-primary">Save Config</button>
                  </div>
                  <b>CRON URL : </b><?= base_url().'traccarsync' ?> <br>
                  <b>CRON COMMAND:</b> wget -q -O- <?= base_url().'traccarsync' ?><br>
                  <a target="_blank" href="<?= base_url().'traccarsync' ?>">Run Cron Manually</a>
                </div>
              </form>
            </div>
            </div>
          </div>
</section>


<div class="modal fade show" id="modal-default" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Test SMTP Configuration</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
       <form   action="<?php echo base_url(); ?>settings/smtpconfigtestemail" method="post" >
      <div class="modal-body">
        <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
              <input type="email" required="true" class="form-control" id="testemailto" name="testemailto" placeholder="Enter email">
              </div>
            </div>            
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send Email</button>
      </div>
          </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>