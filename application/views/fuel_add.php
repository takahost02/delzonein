    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo (isset($fueldetails))?'Edit Fuel':'Add Fuel' ?>
              <a href="<?= base_url(); ?>fuel" class="btn btn-sm btn-primary"><i class="fa fa-list"></i></a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Fuel</a></li>
              <li class="breadcrumb-item active"><?php echo (isset($fueldetails))?'Edit Fuel':'Add Fuel' ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       	      <form method="post" id="fuel" class="card" action="<?php echo base_url();?>fuel/<?php echo (isset($fueldetails))?'updatefuel':'insertfuel'; ?>">
          <div class="card-body">

                  <div class="row">
                    <?php if(isset($fueldetails)) { ?>
                   <input type="hidden" name="v_fuel_id" id="v_fuel_id" value="<?php echo (isset($fueldetails)) ? $fueldetails[0]['v_fuel_id']:'' ?>" >
                 <?php  } ?>
                    <div class="col-sm-6 col-md-3">
                          <label class="form-label">Vechicle<span class="form-required">*</span></label>
                      <div class="form-group">
                         <select id="v_id"  class="form-control select2"  name="v_id" required="true">
                        <option value="">Select Vechicle</option>
                        <?php  foreach ($vechiclelist as $key => $vechiclelists) { ?>
                        <option <?php if((isset($fueldetails)) && $fueldetails[0]['v_id'] == $vechiclelists['v_id']){ echo 'selected';} ?> value="<?php echo output($vechiclelists['v_id']) ?>"><?php echo output($vechiclelists['v_name']).' - '. output($vechiclelists['v_registration_no']); ?></option>
                        <?php  } ?>
                     </select>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Added Driver<span class="form-required">*</span></label>
                     <select id="v_fueladdedby" required="true" class="form-control select2"  name="v_fueladdedby">
                       <option value="">Select Driver</option>
                        <?php  foreach ($driverlist as $key => $driverlists) { ?>
                        <option <?php if((isset($fueldetails)) && $fueldetails[0]['v_fueladdedby'] == $driverlists['d_id']){ echo 'selected';} ?> value="<?php echo output($driverlists['d_id']) ?>"><?php echo output($driverlists['d_name']); ?></option>
                        <?php  } ?>
                     </select>
                  </div>
               </div>
                   <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                          <label class="form-label">Fill Date<span class="form-required">*</span></label>
                         <input type="text" required="true" class="form-control datepicker" id="v_fuelfilldate" name="v_fuelfilldate" value="<?php echo (isset($fueldetails)) ? date(dateformat(), strtotime($fueldetails[0]['v_fuelfilldate'])):'' ?>" placeholder="Fuel Fill Date">

                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                          <label class="form-label">Quantity<span class="form-required">*</span></label>
                         <input type="text" <?php if(isset($fueldetails)) { echo 'readonly'; }?> class="form-control" id="v_fuel_quantity" name="v_fuel_quantity" value="<?php echo (isset($fueldetails)) ? $fueldetails[0]['v_fuel_quantity']:'' ?>" placeholder="Quantity">

                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                          <label class="form-label">Odometer Reading<span class="form-required">*</span></label>
                         <input type="text" class="form-control" id="v_odometerreading" name="v_odometerreading" value="<?php echo (isset($fueldetails)) ? $fueldetails[0]['v_odometerreading']:'' ?>" placeholder="Odometer Reading">

                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                         <label class="form-label">Amount<span class="form-required">*</span></label>
                          <input type="text" class="form-control" id="v_fuelprice" value="<?php echo (isset($fueldetails)) ? $fueldetails[0]['v_fuelprice']:'' ?>" name="v_fuelprice" placeholder="Amount">
                      </div>
                    </div>
                     <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                       <label class="form-label">Comment</label>
                          <input type="text" class="form-control" id="v_fuelcomments" value="<?php echo (isset($fueldetails)) ? $fueldetails[0]['v_fuelcomments']:'' ?>" name="v_fuelcomments" placeholder="Fuel Comments">
                      </div>
                    </div>
                    <?php if(!isset($fueldetails)) {  ?>
                 
                	

                  <br>
                     <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                       <label class="form-label">Fuel is Coming from</label><br>

                       <input type="radio" id="fueltank" name="v_fuelsource" value="fueltank">
                       <label for="apple">Fuel Tank</label> (<span id="currentstock"></span> Liters in stock)  <button data-toggle="modal" data-target="#fuelModal" type="button" class="btn btn-sm btn-success"> Add Fuel</button><br>
                       
                       <input type="radio" id="vendor" name="v_fuelsource" value="vendor">
                       <label for="banana">Vendor</label>

                       <div id="vendorDropdown" style="display:none; margin-top:10px;">
                          <label for="vendorSelect">Select Vendor:</label>
                          <select  required="true" name="v_fuelvendor" id="vendorSelect" class="form-control select2">
                              <option value="">Select Fuel Vendor</option>
                              <?php  foreach ($fuelvendor as $key => $fuelvendors) { ?>
                        <option <?php if((isset($fueldetails)) && $fueldetails[0]['v_fuelvendor'] == $fuelvendors['fv_name']){ echo 'selected';} ?> value="<?php echo output($fuelvendors['fv_name']) ?>"><?php echo output($fuelvendors['fv_name']); ?></option>
                        <?php  } ?>
                          </select>
                      </div>

                      </div>
                    </div>
                    <?php } ?>


                  </div>
      
                </div>
                 <input type="hidden" id="v_created_date" name="v_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">
  
      <div class="modal-footer">

                  <button type="submit" class="btn btn-primary"> <?php echo (isset($fueldetails))?'Update Fuel':'Add Fuel' ?></button>
      </div>
    </form>
             </div>
    </section>



    <div class="modal fade" id="fuelModal" tabindex="-1" aria-labelledby="fuelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fuelModalLabel">Add Fuel Stock</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="fuelForm">
                            <div class="form-group">
                                <label for="stockQuantity">Stock Quantity</label>
                                <input type="number" class="form-control" id="stockQuantity" name="stockQuantity" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveStock">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function(){
  fetchStockValue();
    $('input[name="v_fuelsource"]').change(function(){
        if($('#vendor').is(':checked')) {
            $('#vendorDropdown').show();
        } else {
            $('#vendorDropdown').hide();
        }
    });
    $('#saveStock').click(function() {
        var stockQuantity = $('#stockQuantity').val();
        $.ajax({
            url: '<?= base_url() ?>fuel/update_stock',  
            type: 'POST',
            dataType: 'json', 
            data: { stockQuantity: stockQuantity },
            success: function(response) {
                if(response.success) {
                  fetchStockValue();
                  $('#stockQuantity').val('');
                    alert('Stock updated successfully!');
                    $('#fuelModal').modal('hide');
                } else {
                    alert('Error updating stock.');
                }
            },
            error: function() {
                alert('Error processing request.');
            }
        });
    });

    function fetchStockValue() {
        $.ajax({
            url: '<?= base_url("fuel/get_current_stock") ?>',
            type: 'GET',
            dataType: 'html',
            success: function(response) {
                $('#currentstock').text(response);
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: " + status + " " + error);
            }
        });
    }

});
</script>


    <!-- /.content -->



