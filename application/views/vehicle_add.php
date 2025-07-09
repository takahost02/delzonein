   <?php  $data = sitedata(); ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo (isset($vehicledetails))?'Edit Vehicle':'Add Vehicle' ?>
                <a href="<?= base_url(); ?>vehicle" class="btn btn-sm btn-primary"><i class="fa fa-table"></i></a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Vehicle</a></li>
              <li class="breadcrumb-item active"><?php echo (isset($vehicledetails))?'Edit vehicle':'Add Vehicle' ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form method="post" id="vehicle_add" class="card" action="<?php echo base_url();?>vehicle/<?php echo (isset($vehicledetails))?'updatevehicle':'insertvehicle'; ?>" enctype="multipart/form-data">
                <div class="card-body">


                  <div class="row">
                    <?php if(isset($vehicledetails)) { ?>
                   <input type="hidden" name="v_id" id="v_id" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_id']:'' ?>" >
                    <?php } ?>
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label">Registration Number</label>
                      <div class="form-group">
                        <input type="text" name="v_registration_no" id="v_registration_no" class="form-control" placeholder="Registration Number" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_registration_no']:'' ?>">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="form-label">Vehicle Name</label>
                      <div class="form-group">
                        <input type="text" name="v_name" id="v_name" class="form-control" placeholder="Vehicle Name" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_name']:'' ?>">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Model</label>
                        <input type="text" name="v_model" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_model']:'' ?>" class="form-control" placeholder="Model">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Chassis No</label>
                        <input type="text" name="v_chassis_no" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_chassis_no']:'' ?>" class="form-control" placeholder="Chassis No">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Engine No</label>
                        <input type="text" name="v_engine_no" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_engine_no']:'' ?>" class="form-control" placeholder="Engine No">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Manufactured By</label>
                        <input type="text" name="v_manufactured_by" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_manufactured_by']:'' ?>" class="form-control" placeholder="Manufactured By">
                      </div>
                    </div>
                    
                     <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Vehicle Icon</label>
                        <select id="v_type" name="v_type" class="form-control select2" required="">
                         <option value="">Select Vehicle Icon</option> 
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_type']=='CAR') ? 'selected':'' ?> value="CAR">CAR</option> 
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_type']=='MOTORCYCLE') ? 'selected':'' ?> value="MOTORCYCLE">MOTORCYCLE</option> 
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_type']=='TRUCK') ? 'selected':'' ?> value="TRUCK">TRUCK</option> 
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_type']=='BUS') ? 'selected':'' ?> value="BUS">BUS</option> 
                           <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_type']=='TAXI') ? 'selected':'' ?> value="TAXI">TAXI</option> 
                           <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_type']=='BICYCLE') ? 'selected':'' ?> value="BICYCLE">BICYCLE</option> 
                        </select>

                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label for="v_color" class="form-label">Vehicle Color<small> (To show in Map)</small></label>
                        <input id="add-device-color" name="v_color" class="jscolor {valueElement:'add-device-color', styleElement:'add-device-color', hash:true, mode:'HSV'} form-control"  value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_color']:'#D6E1F3' ?>" required>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
    <div class="form-group">
        <label class="form-label">Registration Expiry Date</label>
        <input type="text" required="" name="v_reg_exp_date"
               value="<?php echo (!empty($vehicledetails[0]['v_reg_exp_date']) ? date(dateformat(), strtotime($vehicledetails[0]['v_reg_exp_date'])) : ''); ?>"
               class="form-control datepicker" placeholder="Registration Expiry Date">
    </div>
</div>

<div class="col-sm-6 col-md-3">
    <div class="form-group">
        <label class="form-label">Insurance Expiry Date</label>
        <input type="text" required="" name="v_ins_exp_date"
               value="<?php echo (!empty($vehicledetails[0]['v_ins_exp_date']) ? date(dateformat(), strtotime($vehicledetails[0]['v_ins_exp_date'])) : ''); ?>"
               class="form-control datepicker" placeholder="Insurance Expiry Date">
    </div>
</div>

                
                      
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Odometer Reading</label>
                        <input type="number"  name="v_odometer_reading" value="<?php echo (isset($vehicledetails)) ?$vehicledetails[0]['v_odometer_reading']:'' ?>" class="form-control" placeholder="Odometer Reading">
                      </div>
                  </div>


             

                    
                   
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label for="v_group" class="form-label">Vehicle Group</label>
                        <select id="v_group" name="v_group" class="form-control select2" required="">
                          <option value="">Select Vehicle Group</option> 
                          <?php if(!empty($v_group)) { foreach($v_group as $v_groupdata) { ?>
                          <option <?= (isset($vehicledetails[0]['v_group']) && $vehicledetails[0]['v_group'] == $v_groupdata['gr_id'])?'selected':''?> value="<?= $v_groupdata['gr_id'] ?>"><?= $v_groupdata['gr_name'] ?></option> 
                          <?php } } ?>
                        </select>
                      </div>
                    </div>
                    
                    <?php if(isset($vehicledetails[0])) {
                      $vehicledetail = $vehicledetails[0];
                      $minitruckfields = !empty($vehicledetail['v_minitruckfields']) ? unserialize($vehicledetail['v_minitruckfields']) : [];
                      $openbodytruckfields = !empty($vehicledetail['v_openbodytruckfields']) ? unserialize($vehicledetail['v_openbodytruckfields']) : [];
                      $closedcontainerfields = !empty($vehicledetail['v_closedcontainerfields']) ? unserialize($vehicledetail['v_closedcontainerfields']) : [];
                      $trailerfields = !empty($vehicledetail['v_trailerfields']) ? unserialize($vehicledetail['v_trailerfields']) : [];
                      $tankerfields = !empty($vehicledetail['v_tankerfields']) ? unserialize($vehicledetail['v_tankerfields']) : [];
                      $tipperfields = !empty($vehicledetail['v_tipperfields']) ? unserialize($vehicledetail['v_tipperfields']) : [];
                      $carfields = !empty($vehicledetail['v_carfields']) ? unserialize($vehicledetail['v_carfields']) : [];
                      $vanfields = !empty($vehicledetail['v_vanfields']) ? unserialize($vehicledetail['v_vanfields']) : [];
                      $minibusfields = !empty($vehicledetail['v_minibusfields']) ? unserialize($vehicledetail['v_minibusfields']) : [];
                      $otherfields = !empty($vehicledetail['v_otherfields']) ? unserialize($vehicledetail['v_otherfields']) : [];                      
                    }
                    ?>

                    <!-- Mini Truck Fields -->
                    <div id="minitruckfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Load Capacity</label>
                                <input type="text" id="loadCapacity" name="minitruckfields[loadCapacity]" required class="form-control" placeholder="E.g :  1500 kg" value="<?= isset($minitruckfields['loadCapacity']) ? htmlspecialchars($minitruckfields['loadCapacity']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Vehicle Length</label>
                                <input type="text" id="vehicleLength" name="minitruckfields[vehicleLength]" required class="form-control" placeholder="E.g :  4.5 meters" value="<?= isset($minitruckfields['vehicleLength']) ? htmlspecialchars($minitruckfields['vehicleLength']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Vehicle Width</label>
                                <input type="text" id="vehicleWidth" name="minitruckfields[vehicleWidth]" required class="form-control" placeholder="E.g :  1.8 meters" value="<?= isset($minitruckfields['vehicleWidth']) ? htmlspecialchars($minitruckfields['vehicleWidth']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Open Body Truck Fields -->
                    <div id="openbodytruckfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Bed Size</label>
                                <input type="text" id="bedSize" name="openbodytruckfields[bedSize]" required class="form-control" placeholder="E.g :  2.5m x 2.0m" value="<?= isset($openbodytruckfields['bedSize']) ? htmlspecialchars($openbodytruckfields['bedSize']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Load Capacity</label>
                                <input type="text" id="loadCapacityOpen" name="openbodytruckfields[loadCapacityOpen]" required class="form-control" placeholder="E.g :  3000 kg" value="<?= isset($openbodytruckfields['loadCapacityOpen']) ? htmlspecialchars($openbodytruckfields['loadCapacityOpen']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Towing Capacity</label>
                                <input type="text" id="towingCapacity" name="openbodytruckfields[towingCapacity]" required class="form-control" placeholder="E.g :  2000 kg" value="<?= isset($openbodytruckfields['towingCapacity']) ? htmlspecialchars($openbodytruckfields['towingCapacity']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Closed Container Fields -->
                    <div id="closedcontainerfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Container Size</label>
                                <input type="text" id="containerSize" name="closedcontainerfields[containerSize]" required class="form-control" placeholder="E.g :  20 ft" value="<?= isset($closedcontainerfields['containerSize']) ? htmlspecialchars($closedcontainerfields['containerSize']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Security Features</label>
                                <input type="text" id="securityFeatures" name="closedcontainerfields[securityFeatures]" required class="form-control" placeholder="E.g :  Locking system" value="<?= isset($closedcontainerfields['securityFeatures']) ? htmlspecialchars($closedcontainerfields['securityFeatures']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Ventilation Type</label>
                                <input type="text" id="ventilationType" name="closedcontainerfields[ventilationType]" required class="form-control" placeholder="E.g :  Cross ventilation" value="<?= isset($closedcontainerfields['ventilationType']) ? htmlspecialchars($closedcontainerfields['ventilationType']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Trailer Fields -->
                    <div id="trailerfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Axle Count</label>
                                <input type="text" id="axleCount" name="trailerfields[axleCount]" required class="form-control" placeholder="E.g :  2 Axles" value="<?= isset($trailerfields['axleCount']) ? htmlspecialchars($trailerfields['axleCount']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Load Capacity</label>
                                <input type="text" id="trailerCapacity" name="trailerfields[trailerCapacity]" required class="form-control" placeholder="E.g :  5000 kg" value="<?= isset($trailerfields['trailerCapacity']) ? htmlspecialchars($trailerfields['trailerCapacity']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Trailer Type</label>
                                <input type="text" id="trailerType" name="trailerfields[trailerType]" required class="form-control" placeholder="E.g :  Flatbed" value="<?= isset($trailerfields['trailerType']) ? htmlspecialchars($trailerfields['trailerType']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Tanker Fields -->
                    <div id="tankerfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Tank Capacity</label>
                                <input type="text" id="tankCapacity" name="tankerfields[tankCapacity]" required class="form-control" placeholder="E.g :  2000 liters" value="<?= isset($tankerfields['tankCapacity']) ? htmlspecialchars($tankerfields['tankCapacity']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Tank Type</label>
                                <input type="text" id="tankType" name="tankerfields[tankType]" required class="form-control" placeholder="E.g :  Food-grade" value="<?= isset($tankerfields['tankType']) ? htmlspecialchars($tankerfields['tankType']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Pump Type</label> 
                                <input type="text" id="pumpType" name="tankerfields[pumpType]" required class="form-control" placeholder="E.g :  Electric pump" value="<?= isset($tankerfields['pumpType']) ? htmlspecialchars($tankerfields['pumpType']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Tipper Fields -->
                    <div id="tipperfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Tipper Capacity</label>
                                <input type="text" id="tipperCapacity" required name="tipperfields[tipperCapacity]" class="form-control" placeholder="E.g :  1500 kg" value="<?= isset($tipperfields['tipperCapacity']) ? htmlspecialchars($tipperfields['tipperCapacity']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Body Type</label>
                                <input type="text" id="bodyType" name="tipperfields[bodyType]" required class="form-control" placeholder="E.g :  High-side" value="<?= isset($tipperfields['bodyType']) ? htmlspecialchars($tipperfields['bodyType']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Car Fields -->
                    <div id="carfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Seating Capacity</label>
                                <input type="text" id="seatingCapacityCar" required name="carfields[seatingCapacityCar]" class="form-control" placeholder="E.g :  5" value="<?= isset($carfields['seatingCapacityCar']) ? htmlspecialchars($carfields['seatingCapacityCar']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Fuel Type</label>
                                <input type="text" id="fuelTypeCar" required name="carfields[fuelTypeCar]" class="form-control" placeholder="E.g :  Petrol" value="<?= isset($carfields['fuelTypeCar']) ? htmlspecialchars($carfields['fuelTypeCar']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Transmission Type</label>
                                <input type="text" id="transmissionTypeCar" required name="carfields[transmissionTypeCar]" class="form-control" placeholder="E.g :  Automatic" value="<?= isset($carfields['transmissionTypeCar']) ? htmlspecialchars($carfields['transmissionTypeCar']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Van Fields -->
                    <div id="vanfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Seating Capacity</label>
                                <input type="text" id="seatingCapacityVan" required name="vanfields[seatingCapacityVan]" class="form-control" placeholder="E.g :  8" value="<?= isset($vanfields['seatingCapacityVan']) ? htmlspecialchars($vanfields['seatingCapacityVan']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Cargo Space</label>
                                <input type="text" id="cargoSpace" name="vanfields[cargoSpace]" required class="form-control" placeholder="E.g :  2000 liters" value="<?= isset($vanfields['cargoSpace']) ? htmlspecialchars($vanfields['cargoSpace']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Sliding Doors</label>
                                <input type="text" id="slidingDoors" name="vanfields[slidingDoors]" required class="form-control" placeholder="E.g :  Yes or No" value="<?= isset($vanfields['slidingDoors']) ? htmlspecialchars($vanfields['slidingDoors']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Minibus Fields -->
                    <div id="minibusfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Seating Capacity</label>
                                <input type="text" id="seatingCapacityMinibus" required name="minibusfields[seatingCapacityMinibus]" class="form-control" placeholder="E.g :  15" value="<?= isset($minibusfields['seatingCapacityMinibus']) ? htmlspecialchars($minibusfields['seatingCapacityMinibus']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Usage Type</label>
                                <input type="text" id="usageType" name="minibusfields[usageType]" required class="form-control" placeholder="E.g :  Shuttle service" value="<?= isset($minibusfields['usageType']) ? htmlspecialchars($minibusfields['usageType']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Other Fields -->
                    <div id="otherfields" class="additional-fields row col-sm-12" style="display: none;">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" id="otherDescription" name="otherfields[otherDescription]" class="form-control" placeholder="Describe the vehicle" value="<?= isset($otherfields['otherDescription']) ? htmlspecialchars($otherfields['otherDescription']) : ''; ?>">
                            </div>
                        </div>
                    </div>


                    
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label for="v_is_active" class="form-label">Vehicle Status</label>
                        <select id="v_is_active" name="v_is_active" class="form-control select2" required="">
                          <option value="">Select Vehicle Status</option> 
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_is_active']==1) ? 'selected':'' ?> value="1">Active</option> 
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_is_active']==0) ? 'selected':'' ?> value="0">Inactive</option> 
                        </select>
                      </div>
                    </div>  

                  <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                      <label class="form-label">Vehicle Image</label>
                      <input type="file" id="file" name="file" class="form-control"/>
                    </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                      <label class="form-label">Vehicle Document</label>
                      <input type="file" id="file1" name="file1" class="form-control"/>
                    </div>

                    
                    </div>
                    </div>
                    <div class="row col-sm-12">

                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Default Billing Type</label>
                        <select id="v_default_billing_type" name="v_default_billing_type" class="form-control select2" required="">
                          <option value="">Select Billing Type</option> 
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per Tonne') ? 'selected':'' ?> value="Per Tonne">Per Tonne</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per KG') ? 'selected':'' ?> value="Per KG">Per KG</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per KM') ? 'selected':'' ?> value="Per KM" selected>Per KM</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per Trip') ? 'selected':'' ?> value="Per Trip">Per Trip</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per Day') ? 'selected':'' ?> value="Per Day">Per Day</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per Hour') ? 'selected':'' ?> value="Per Hour">Per Hour</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per Litre') ? 'selected':'' ?> value="Per Litre">Per Litre</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_default_billing_type']=='Per Bag') ? 'selected':'' ?> value="Per Bag">Per Bag</option>
                        </select>
                      </div>
                    </div>


                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Default Cost</label>
                        <input type="number" required  required name="v_defaultcost" value="<?php echo (isset($vehicledetails)) ?$vehicledetails[0]['v_defaultcost']:'' ?>" class="form-control" placeholder="Cost Per KM">
                      </div>
                    </div>

                  <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                      <label class="form-label">Vehicle Ownership</label>
                      <select required name="v_ownership" id="v_ownership" class="form-control select2">
                          <option value="" disabled selected>Select Ownership</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_ownership']=='owned') ? 'selected':'' ?> value="owned">Owned</option>
                          <option <?php echo (isset($vehicledetails) && $vehicledetails[0]['v_ownership']=='vendor') ? 'selected':'' ?> value="vendor">Vendor</option>
                      </select>
                  </div>
              </div>

               
              
              <div id="leased-fields" class="row col-sm-6 col-md-12" style="display:none;">

              <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                      <label class="form-label">Vendor Name</label>
                      <select required name="v_vendor_name" id="v_vendor_name" class="form-control select2">
                          <option value="" disabled selected>Select Vendor</option>
                          <?php if(!empty($vehiclevendors)) { foreach($vehiclevendors as $vehiclevendor) { ?>
      <option <?= (isset($vehicledetails[0]['v_vendor_name']) && $vehicledetails[0]['v_vendor_name'] == $vehiclevendor['vn_id'])?'selected':''?> value="<?= $vehiclevendor['vn_id'] ?>"><?= $vehiclevendor['vn_name'] ?></option> 
      <?php } } ?>
                      </select>
                  </div>
              </div>


    <div class="col-sm-6 col-md-3">
        <div class="form-group">
            <label class="form-label">Lease Start Date</label>
            <input type="text" name="v_lease_start_date" value="<?php echo (isset($vehicledetails)) ?$vehicledetails[0]['v_lease_start_date']:'' ?>" required class="form-control datepicker">
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="form-group">
            <label class="form-label">Lease End Date</label>
            <input type="text" name="v_lease_end_date" value="<?php echo (isset($vehicledetails)) ?$vehicledetails[0]['v_lease_end_date']:'' ?>" required class="form-control datepicker">
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="form-group">
            <label class="form-label">Monthly Payment</label>
            <input type="number" name="v_lease_payment" value="<?php echo (isset($vehicledetails)) ?$vehicledetails[0]['v_lease_payment']:'' ?>" required class="form-control" placeholder="Payment">
        </div>
    </div>
</div>






                  </div>



                    <hr>
                    <div class="form-label"><b>GPS API Details(Feed GPS Data)</b></div>
                    
                     <div class="row">
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Server URL</label>
                        <input type="text" name="v_api_url" class="form-control" placeholder="API URL" value="<?php echo base_url();?>api" readonly>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label class="form-label">Device Identifer</label>
                        <input type="text" id="v_api_username" value="<?php echo (isset($vehicledetails) && $vehicledetails[0]['v_api_username']!='') ? $vehicledetails[0]['v_api_username']:  ((isset($vehicledetails) && $vehicledetails[0]['v_api_username']!='')?$vehicledetails[0]['v_registration_no']:'') ?>" name="v_api_username" class="form-control" placeholder="API Username" readonly>
                      </div>
                    </div>
                  <div class="col-sm-6 col-md-3 d-none">
                      <div class="form-group">
                        <label class="form-label">API Password</label>
                        <input type="text" name="v_api_password" class="form-control" placeholder="API Password" value="<?php echo (isset($vehicledetails)) ? $vehicledetails[0]['v_api_password']:random_string('nozero', 6) ?>"  readonly>
                      </div>
                    </div>

                    <?php $settings=sitedata(); if(isset($settings['s_traccar_enabled']) && $settings['s_traccar_enabled']==1) { ?>  

<div class="col-sm-6 col-md-3">
<div class="form-group">
  <label class="form-label">Traccar Device ID <span title="3 New Messages" class="badge ">(Data sycn based on this value)</span></label>
  <select id="v_traccar_id" name="v_traccar_id" class="form-control select2">
     <option value="">Select Traccar Device ID</option> 
     <?php if(!empty($traccar_list)) { foreach($traccar_list as $traccar) { ?>
      <option <?= (isset($vehicledetails[0]['v_traccar_id']) && $vehicledetails[0]['v_traccar_id'] == $traccar['id'])?'selected':''?> value="<?= $traccar['id'] ?>"><?= $traccar['name'] ?></option> 
      <?php } } ?>
    </select> 
</div>
</div>
<?php } ?>



                  </div>

                       
                </div>
                  <input type="hidden" id="v_created_by" name="v_created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">
                                    <input type="hidden" id="v_mileageperlitre" name="v_mileageperlitre" value="0">

                   <input type="hidden" id="v_created_date" name="v_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"> <?php echo (isset($vehicledetails))?'Update Vehicle':'Add Vehicle' ?></button>
                  <?php if(!isset($vehicledetails)) { ?>
                  <div class="float-left">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">Bulk Import Products</button>
                  <a href="<?php echo site_url('vehicle/download_template'); ?>">Download CSV Template</a>
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
        <h4 class="modal-title">Bulk Import Vehicle</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
       <form   action="<?php echo base_url(); ?>vehicle/import_csv" method="post" enctype="multipart/form-data">
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


<script>
$(document).ready(function() {
    // Function to show the corresponding additional fields based on selected value
    function showAdditionalFields(selectedValue) {
        $('.additional-fields').hide(); // Hide all additional fields
        switch (selectedValue) {
            case "1": // Mini Truck / LCV
                $('#minitruckfields').show();
                break;
            case "2": // Open Body Truck
                $('#openbodytruckfields').show();
                break;
            case "3": // Closed Container
                $('#closedcontainerfields').show();
                break;
            case "4": // Trailer
                $('#trailerfields').show();
                break;
            case "5": // Tanker
                $('#tankerfields').show();
                break;
            case "6": // Tipper
                $('#tipperfields').show();
                break;
            case "7": // Car
                $('#carfields').show();
                break;
            case "8": // Van
                $('#vanfields').show();
                break;
            case "9": // Minibus
                $('#minibusfields').show();
                break;
            case "10": // Other
                $('#otherfields').show();
                break;
        }
    }

    // Event handler for the dropdown change
    $('#v_group').change(function() {
        var selectedValue = $(this).val();
        showAdditionalFields(selectedValue);
    });

    // Automatically trigger change event on page load
    var initialValue = $('#v_group').val();
    if (initialValue) {
        showAdditionalFields(initialValue);
    }
});


$(document).ready(function() {
    var ownership = '<?php echo (isset($vehicledetails) && $vehicledetails[0]['v_ownership'])?$vehicledetails[0]['v_ownership']:'' ?>'; 
    $('#owned-fields').hide();
    $('#leased-fields').hide();
    if (ownership === 'owned') {
        $('#owned-fields').show();
    } else if (ownership === 'vendor') {
        $('#leased-fields').show();
    }

    $('#v_ownership').on('change', function() {
        var selectedOwnership = $(this).val();
        $('#owned-fields').hide();
        $('#leased-fields').hide();
        if (selectedOwnership === 'owned') {
            $('#owned-fields').show();
        } else if (selectedOwnership === 'vendor') {
            $('#leased-fields').show();
        }
    });
    $('#v_ownership').trigger('change');
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function initAutocomplete(inputId, listId, latId, lonId) {
        let input = document.getElementById(inputId);
        let list = document.getElementById(listId);
        if (!input || !list) return;
        input.addEventListener("input", function () {
            let query = this.value.trim();
            if (!query) {
                list.innerHTML = "";
                return;
            }
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                .then(response => response.json())
                .then(data => {
                    list.innerHTML = "";
                    data.forEach(place => {
                        let item = document.createElement("li");
                        item.textContent = place.display_name;
                        item.onclick = function () {
                            input.value = place.display_name;
                            document.getElementById(latId).value = place.lat;
                            document.getElementById(lonId).value = place.lon;
                            list.innerHTML = "";
                            calculateDistance();
                        };
                        list.appendChild(item);
                    });
                })
                .catch(error => console.error("Error fetching location data:", error));
        });
        document.addEventListener("click", function (e) {
            if (!list.contains(e.target) && e.target !== input) {
                list.innerHTML = "";
            }
        });
    }
    function calculateDistance() {
        let lat1 = parseFloat(document.getElementById("t_trip_fromlat").value);
        let lon1 = parseFloat(document.getElementById("t_trip_fromlog").value);
        let lat2 = parseFloat(document.getElementById("t_trip_tolat").value);
        let lon2 = parseFloat(document.getElementById("t_trip_tolog").value);
        if (!lat1 || !lon1 || !lat2 || !lon2) return;
        let R = '<?= $data['s_mapunit']; ?>' === "mile" ? 3958.8 : 6371;
        let dLat = (lat2 - lat1) * Math.PI / 180;
        let dLon = (lon2 - lon1) * Math.PI / 180;
        let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
        let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        let distance = (R * c).toFixed(2); // Distance in km
        document.getElementById("t_totaldistance").value = distance;
    }
    initAutocomplete("autocomplete", "autocomplete-list", "t_trip_fromlat", "t_trip_fromlog");
    initAutocomplete("autocomplete2", "autocomplete-list2", "t_trip_tolat", "t_trip_tolog");
});
</script>

