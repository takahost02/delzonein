<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?php echo (isset($maintenancedetails)) ? 'Edit Vehicle Maintenance' : 'Add Vehicle Maintenance'; ?>
          <a href="<?= base_url(); ?>maintenance" class="btn btn-sm btn-primary"><i class="fa fa-table"></i></a>
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active"><?php echo (isset($maintenancedetails)) ? 'Edit Maintenance' : 'Add Maintenance'; ?></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
  <form id="addnewcategory" class="card basicvalidation" role="form" action="<?php echo base_url();?>maintenance/<?php echo (isset($maintenancedetails))?'updatemaintenance':'insertmaintenance'; ?>" method="post"  enctype="multipart/form-data">
  <div class="card-body">
        <?php if (isset($maintenancedetails)) { ?>
          <input type="hidden" name="m_id" id="m_id" value="<?php echo $maintenancedetails['m_id']; ?>">
        <?php } ?>

        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_v_id">Select Vehicle</label>
              <select id="m_v_id" class="form-control select2" name="m_v_id" required>
                <option value="">Select Vehicle</option>
                <?php foreach ($vechiclelist as $vechicle) { ?>
                  <option value="<?php echo $vechicle['v_id']; ?>" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_v_id'] == $vechicle['v_id']) ? 'selected' : ''; ?>>
                    <?php echo $vechicle['v_name'] . ' [' . $vechicle['v_registration_no'] . ']'; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_vendor_id">Select Vendor</label>
              <select id="m_vendor_id" class="form-control select2" name="m_vendor_id">
                <option value="">Select Vendor</option>
                <?php foreach ($maintenance_vendor as $vendor) { ?>
                  <option value="<?php echo $vendor['mv_id']; ?>" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_vendor_id'] == $vendor['mv_id']) ? 'selected' : ''; ?>>
                    <?php echo $vendor['mv_name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_mechanic_id">Select Mechanic</label>
              <select id="m_mechanic_id" class="form-control select2" name="m_mechanic_id">
                <option value="">Select Mechanic</option>
                <?php foreach ($mechanic as $mech) { ?>
                  <option value="<?php echo $mech['mm_id']; ?>" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_mechanic_id'] == $mech['mm_id']) ? 'selected' : ''; ?>>
                    <?php echo $mech['mm_name'] . ' [' . $mech['mm_category'] . ']'; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_status">Maintenance Status</label>
              <select id="m_status" class="form-control select2" name="m_status" required>
                <option value="">Choose Maintenance Status</option>
                <option value="planned" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_status'] == 'planned') ? 'selected' : ''; ?>>Planned</option>
                <option value="inprogress" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_status'] == 'inprogress') ? 'selected' : ''; ?>>InProgress</option>
                <option value="completed" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
              </select>
            </div>
          </div>
          </div>


        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_start_date">Maintenance Start Date</label>
              <input type="text" id="m_start_date" name="m_start_date"  value="<?php echo (isset($maintenancedetails)) ? $maintenancedetails['m_start_date']:'' ?>"  class="form-control datepicker" placeholder="Choose start date" autocomplete="off" required>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_end_date">Maintenance End Date</label>
              <input type="text" id="m_end_date" name="m_end_date" value="<?php echo (isset($maintenancedetails)) ? $maintenancedetails['m_end_date']:'' ?>" class="form-control datepicker" placeholder="Choose end date" autocomplete="off" required>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_odometer_reading">Odometer Reading</label>
              <input type="number" id="m_odometer_reading" name="m_odometer_reading" value="<?php echo (isset($maintenancedetails)) ? $maintenancedetails['m_odometer_reading']:'' ?>"  class="form-control" placeholder="Enter Current Reading" autocomplete="off" required>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label for="m_cost">Total Cost</label>
              <input type="text" id="m_cost" name="m_cost" class="form-control number" value="<?php echo (isset($maintenancedetails)) ? $maintenancedetails['m_cost']:'' ?>"  placeholder="Total Cost" autocomplete="off">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="m_service_info">Service Details</label>
          <textarea id="m_service_info" name="m_service_info" class="form-control" placeholder="Details" required><?php echo (isset($maintenancedetails)) ? $maintenancedetails['m_service_info'] : ''; ?></textarea>
        </div>

        <div class="row tr_clone">
    <!-- Loop for each part in the parts_used array -->
    <?php if (!empty($parts_used)) { 
        foreach ($parts_used as $index => $part) { ?>
            <div class="col-sm-2 col-md-offset-2 "></div>
            <div class="col-sm-5 col-md-offset-2 ">
                <div class="form-group">
                    <label>Parts Name</label>
                    <select class="selectemployee form-control select2" name="pu_s_id[]">
                        <option value="">Select Parts</option>
                        <?php if (!empty($partsinventory)) {
                            foreach ($partsinventory as $pi) { 
                                // Check if part_name in parts_used matches the current inventory part
                                $selected = ($part['part_name'] == $pi['s_name']) ? 'selected' : ''; ?>
                                <option value="<?= $pi['s_id']; ?>" <?= $selected; ?>><?= $pi['s_name']; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-md-offset-2 ">
                <div class="form-group">
                    <label>Qty</label>
                    <input type="number" name="pu_qty[]" class="form-control number" placeholder="Enter Qty" autocomplete="off" value="<?= $part['quantity']; ?>">
                </div>
            </div>
            <div class="col-sm-2 col-md-offset-2 ">
                <div class="form-group adddelbtn"> 
                    <button type="button" name="add" class="btn btn-success btn-xs rm tr_clone_add">
                        <span class="fa fa-plus"></span>
                    </button>
                </div>
            </div>                        
        <?php } 
    } else { ?>
      <div class="col-sm-2 col-md-offset-2 "></div>
            <div class="col-sm-5 col-md-offset-2 ">
                <div class="form-group">
                    <label>Parts Name</label>
                    <select class="selectemployee form-control select2" name="pu_s_id[]">
                        <option value="">Select Parts</option>
                        <?php if (!empty($partsinventory)) {
                            foreach ($partsinventory as $pi) { 
                                // Check if part_name in parts_used matches the current inventory part
                                $selected = ($part['part_name'] == $pi['s_name']) ? 'selected' : ''; ?>
                                <option value="<?= $pi['s_id']; ?>" <?= $selected; ?>><?= $pi['s_name']; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-md-offset-2 ">
                <div class="form-group">
                    <label>Qty</label>
                    <input type="number" name="pu_qty[]" class="form-control number" placeholder="Enter Qty" autocomplete="off" value="<?php echo (isset($part)) ? $part['quantity']:'' ?> ">
                </div>
            </div>
            <div class="col-sm-2 col-md-offset-2 ">
                <div class="form-group adddelbtn"> 
                    <button type="button" name="add" class="btn btn-success btn-xs rm tr_clone_add">
                        <span class="fa fa-plus"></span>
                    </button>
                </div>
            </div>  
    <?php } ?>
</div>

<div class="row">        
    <div class="col-sm-2">
        <div class="form-group">
            <label for="m_notify_type">Notification Type</label>
            <select id="m_status" class="form-control select2" name="m_notify_type" required>
                <option value="">Choose Type</option>
                <option value="email" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_notify_type'] == 'email') ? 'selected' : ''; ?>>Email</option>
                <option value="sms" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_notify_type'] == 'sms') ? 'selected' : ''; ?>>SMS</option>
                <option value="both" <?php echo (isset($maintenancedetails) && $maintenancedetails['m_notify_type'] == 'both') ? 'selected' : ''; ?>>Both</option>
            </select>
        </div>
    </div>
    <div class="col-sm-10">
        <div class="form-group">
            <label for="m_start_date">Members</label>
            <div class="form-group">
            <select id="exampleSelect2" class="form-control select2" name="m_notify_members[]" multiple="multiple" style="width: 100%;">
              <option value="">Select Members</option>
              <?php 
              $data = get_all_users_and_drivers(); // Fetch all users and drivers
              
              // Decode or handle pre-selected members
              $pre_selected_members = [];
              if (!empty($maintenancedetails['m_notify_members'])) {
                  if (is_string($maintenancedetails['m_notify_members'])) {
                      $pre_selected_members = json_decode($maintenancedetails['m_notify_members'], true); // Convert JSON string to array
                      if (!is_array($pre_selected_members)) {
                          $pre_selected_members = []; // Fallback to empty array if decoding fails
                      }
                  } else {
                      $pre_selected_members = $maintenancedetails['m_notify_members'];
                  }
              }

              foreach ($data as $item) {
                  // Generate the value for the current member
                  $value = $item['phone'] . "|" . $item['email'] . "|" . $item['name'] . "|" . $item['source'];

                  // Check if the current value exists in pre-selected members
                  $selected = in_array($value, $pre_selected_members) ? 'selected' : '';
              ?>
                  <option value="<?php echo htmlspecialchars($value); ?>" <?php echo $selected; ?>>
                      <?php echo htmlspecialchars($item['name'] . " (" . $item['email'] . ")"); ?>
                  </option>
              <?php } ?>
          </select>

            </div>
        </div>
    </div>
</div>


      <div class="form-footer">
          <button type="submit" class="btn btn-primary float-right"><?php echo (isset($maintenancedetails)) ? 'Update Maintenance' : 'Add Maintenance'; ?></button>
        </div>

        </div>
    </form>
  </div>
</section>
