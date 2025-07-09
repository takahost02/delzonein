<?php $successMessage = $this->session->flashdata('successmessage');  
           $warningmessage = $this->session->flashdata('warningmessage');                    
      if (isset($successMessage)) { 
        echo '<div id="alertmessage" class="col-md-5">
          <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   '. output($successMessage).'
                  </div>
          </div>'; } 
      if (isset($warningmessage)) { echo '<div id="alertmessage" class="col-md-5">
          <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   '. output($warningmessage).'
                  </div>
          </div>'; }    
      ?>


      <div style="padding: 20px;padding-bottom: 15px;">
<div style="display: none" id="color-palette"></div>
<div class="row w-75 m-auto">
  <div class="col-lg-6">
  <div class="form-group">
      <input id="pac-input" class="form-control" type="text" placeholder="Enter Address">
    </div>
    <ul id="suggestions" class="list-group"></ul>
    </div>
<div class="col-lg-6">
  <div class="form-group">
    <button class="btn btn-block btn-primary" id="showgeofencemodel">Save Geofence</button>
  </div>
</div>
</div>
</div>

   
    <div id="map" style="width: 100%; height: 600px;"></div>
  <style>
  	#map > div > div > div:nth-child(11) > div:nth-child(2) > div,#map > div > div > div:nth-child(11) > div:nth-child(3) > div,#map > div > div > div:nth-child(11) > div:nth-child(4) > div,#map > div > div > div:nth-child(11) > div:nth-child(5) > div {
    	display: none;
	}
	#map > div > div > div:nth-child(10) > div:nth-child(2) > div,#map > div > div > div:nth-child(10) > div:nth-child(3) > div,#map > div > div > div:nth-child(10) > div:nth-child(4) > div,#map > div > div > div:nth-child(10) > div:nth-child(5) > div {
    	display: none;
	}
  </style>
  <div class="modal fade show" id="modal-geofence" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Save Selected Geofence</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div> 
            <div class="modal-body"> 
              <form id="geofencesave" method="post" action="<?php echo base_url(); ?>geofence/geofence_save">
              <div class="card-body">
                  <div class="form-group row">
                    <label for="geo_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="form-group col-sm-8">
                      <input type="text" class="form-control" name="geo_name" id="geo_name" required="true" placeholder="Geofence Name">
                    </div>
                  </div>
                 <div class="form-group row">
                    <label for="geo_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="form-group col-sm-8">
                      <input type="text" class="form-control" name="geo_description" id="geo_description" required="true" placeholder="Geofence Description">
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="Cateogry" class="col-sm-4 col-form-label">Vehicle</label>
                    <div class="form-group col-sm-8">
                        <select class="select2 select2-hidden-accessible" id="geo_vehicles" required="true" name="geo_vehicles[]" multiple="" data-placeholder="Select vehicles" style="width: 100%;"  tabindex="-1" aria-hidden="true">
                          <?php if(!empty($vehicles)) { foreach($vehicles as $vehicle) { ?>
                          <option value="<?= $vehicle['v_id']; ?>"><?= $vehicle['v_name']; ?></option>
                         <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="geo_description" class="col-sm-4 col-form-label">Notification Type</label>
                    <div class="form-group col-sm-8">
                    <select id="m_status" class="form-control" name="geo_notify_type" >
                      <option value="">Choose Type</option>
                      <option value="email" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_notify_type'] == 'email') ? 'selected' : ''; ?>>Email</option>
                      <option value="sms" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_notify_type'] == 'sms') ? 'selected' : ''; ?>>SMS</option>
                      <option value="both" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_notify_type'] == 'both') ? 'selected' : ''; ?>>Both</option>
                  </select>                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="geo_description" class="col-sm-4 col-form-label">Members</label>
                    <div class="form-group col-sm-8">
                    <select  id="exampleSelect2" class="form-control selectized" name="geo_notify_members[]" multiple="multiple" style="width: 100%;">
              <option value="">Select Members</option>
              <?php 
              $data = get_all_users_and_drivers(); // Fetch all users and drivers
              foreach ($data as $item) {
                  $value = $item['phone'] . "|" . $item['email'] . "|" . $item['name'] . "|" . $item['source'];
              ?>
                  <option value="<?php echo htmlspecialchars($value); ?>" >
                      <?php echo htmlspecialchars($item['name'] . " (" . $item['email'] . ")"); ?>
                  </option>
              <?php } ?>
          </select>                    </div>
                  </div>

              


               	<input type="hidden" class="form-control" name="geo_area" id="geo_area">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" id="geofenvaluesave" class="btn btn-primary">Save</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<?php if(sitedata()['s_defaultmapapi']!='google') { ?>
<style>
#suggestions {
  position: absolute;
  z-index: 1000;
  background: white;
  border-radius: 4px;
  max-height: 200px;
  overflow-y: auto;
  width: 100%; /* Matches the width of the input field */
  margin-top: 2px; /* Spacing below the input */
  padding: 0; /* Remove default padding for the list */
  list-style-type: none; /* Remove bullet points */
}

#suggestions .list-group-item {
  padding: 10px;
  cursor: pointer;
}

#suggestions .list-group-item:hover {
  background-color: #f8f9fa;
}
.card-header {
    height: 53px;
}
</style>
<?php } ?>
