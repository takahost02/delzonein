<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo (isset($tripdetails))?'Edit Booking':'Add Booking' ?>
            <a href="<?= base_url(); ?>trips" class="btn btn-sm btn-primary"><i class="fa fa-table"></i></a>
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Vehicle</a></li>
               <li class="breadcrumb-item active"><?php echo (isset($tripdetails))?'Edit Booking':'Add Booking' ?></li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <form method="post" id="trip_add" class="card"  action="<?php echo base_url();?>Trips/<?php echo (isset($tripdetails))?'updatetrips':'inserttrips'; ?>">
         <div class="card-body">
            <div class="row">
               <?php if(isset($tripdetails)) { ?>
               <input type="hidden" name="t_id" id="t_id" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_id']:'' ?>" >
               <?php } ?>    
               <div class="col-sm-6 col-md-3">
                  <label class="form-label">Customer Name<span class="text-danger">*</span></label>
                  <div class="form-group">
                     <select id="t_customer_id"  class="form-control select2" required="true" name="t_customer_id">
                        <option value="">Select Customer</option>
                        <?php foreach ($customerlist as $key => $customerlists) { ?>
                        <option <?php if((isset($tripdetails)) && $tripdetails[0]['t_customer_id'] == $customerlists['c_id']){ echo 'selected';} ?> value="<?php echo output($customerlists['c_id']) ?>"><?php echo output($customerlists['c_name']) ?></option>
                        <?php  } ?>
                     </select>
                  </div>
               </div>
               <div class="col-sm-6 col-md-2">
                  <div class="form-group">
                     <label class="form-label">Trip Start Date<span class="text-danger">*</span></label>
                     <input type="text" value="<?php echo (isset($tripdetails)) ? date(datetimeformat(), strtotime($tripdetails[0]['t_start_date'])):'' ?>" name="t_start_date" value="" class="form-control datetimepicker" placeholder="Trip Start Date">
                  </div>
               </div>
               <div class="col-sm-6 col-md-2">
                  <div class="form-group">
                     <label class="form-label">Trip End Date<span class="text-danger">*</span></label>
                     <input type="text" value="<?php echo (isset($tripdetails)) ? date(datetimeformat(), strtotime($tripdetails[0]['t_end_date'])):'' ?>" name="t_end_date" value="" class="form-control datetimepicker" placeholder="Trip End Date">
                  </div>
               </div>
                
               <div class="col-sm-6 col-md-2">
                  <div class="form-group">
                     <label class="form-label">Trip Type<span class="text-danger">*</span></label>
                     <select id="t_type"  class="form-control select2"  name="t_type">
                        <option value="">Select Trip Type</option>
                        <option <?php if((isset($tripdetails)) && $tripdetails[0]['t_type'] == 'singletrip'){ echo 'selected';} ?> value="singletrip">Single Trip</option>
                        <option <?php if((isset($tripdetails)) && $tripdetails[0]['t_type'] == 'roundtrip'){ echo 'selected';} ?> value="roundtrip">Round Trip</option>
                     </select>
                  </div>
               </div>

              <?php if(isset($tripdetails[0]['t_requested_v_type'])) {
               $this->db->where('gr_id',$tripdetails[0]['t_requested_v_type']);
               $query = $this->db->get('vehicle_group');
               $vehicle_groups = $query->result_array(); }
               ?>
               <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Vechicle<span class="text-danger">*</span></label> <?php
                      if (!empty($vehicle_groups) && isset($vehicle_groups[0]['gr_name'])) {
                        echo "<span class='blinking-text'>(User requested " . $vehicle_groups[0]['gr_name'] . ")</span>";
                     }
                     ?> 
                     <select id="t_vechicle"  class="form-control select2"  name="t_vechicle" >
                        <option value="">Select Vechicle</option>
                        <?php  foreach ($vechiclelist as $key => $vechiclelists) { ?>
                        <option <?php if((isset($tripdetails)) && $tripdetails[0]['t_vechicle'] == $vechiclelists['v_id']){ echo 'selected';} ?> value="<?php echo output($vechiclelists['v_id']) ?>"><?php echo output($vechiclelists['v_name']).' - '. output($vechiclelists['v_registration_no']); ?></option>
                        <?php  } ?>
                     </select>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Driver<span class="text-danger">*</span></label>
                     <select id="t_driver"  class="form-control select2"  name="t_driver">
                        <option value="">Select Driver</option>
                        <?php  foreach ($driverlist as $key => $driverlists) { ?>
                        <option <?php if((isset($tripdetails)) && $tripdetails[0]['t_driver'] == $driverlists['d_id']){ echo 'selected';} ?> value="<?php echo output($driverlists['d_id']) ?>"><?php echo output($driverlists['d_name']); ?></option>
                        <?php  } ?>
                     </select>
                  </div>
               </div>
               
               <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Trip Start Location<span class="text-danger">*</span></label>
                     <input type="text" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_fromlocation']:'' ?>" id="autocomplete"  name="t_trip_fromlocation" id="t_trip_fromlocation" class="form-control" placeholder="Trip Start Location">
                     <ul id="autocomplete-list" class="autocomplete-list"></ul>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Trip End Location<span class="text-danger">*</span></label>
                     <input type="text" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_tolocation']:'' ?>" id="autocomplete2"  name="t_trip_tolocation" id="t_trip_tolocation" class="form-control" placeholder="Trip End Location">
                     <ul id="autocomplete-list2" class="autocomplete-list"></ul>

                  </div>
               </div>
               <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Approx Total KM<span class="text-danger">*</span></label>
                     <input type="text" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_totaldistance']:'' ?>" readonly="true" name="t_totaldistance" id="t_totaldistance" class="form-control" placeholder="Approx Total KM">
                  </div>
               </div>
               
             
               <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Trip Status</label>
                     <select name="t_trip_status" id="t_trip_status" required="true" class="form-control select2">
                     <option value="">Trip Status</option>
                     <?php if (isset($trip_statuses) && !empty($trip_statuses)): ?>
                        <?php foreach ($trip_statuses as $status): ?>
                           <option value="<?php echo $status->tsm_name; ?>"
                                 <?php echo (isset($tripdetails) && $tripdetails[0]['t_trip_status'] == $status->tsm_name) ? 'selected' : ''; ?>>
                                 <?php echo $status->tsm_name; ?>
                           </option>
                        <?php endforeach; ?>
                     <?php endif; ?>
                     </select>
                  </div>
               </div>

               <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                     <label class="form-label">Start Kms Reading<span class="text-danger">*</span></label>
                     <input type="text" required value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_tripstartreading']:'' ?>"name="t_tripstartreading" id="t_tripstartreading" class="form-control" placeholder="Enter Start Kms Reading">
                  </div>
               </div>
              
               <!-- Add Multiple Pickup Locations -->

               <?php if(isset($tripdetails[0]['t_trip_stops']) && $tripdetails[0]['t_trip_stops']!='') { ?>
                  <?php $trip_stops = json_decode($tripdetails[0]['t_trip_stops'], true); if (!empty($trip_stops)) { ?>
                  <?php foreach ($trip_stops as $index => $location) { ?>
                  <div class="col-sm-6 col-md-3 tr_clone">
                     <div class="form-group">
                        <label class="location-label">Add Multiple Pickup Locations</label> <button style="font-size: 0.55rem;" type="button" class="btn btn-danger btn-xs tr_clone_remove_location" <?php echo $index == 0 ? 'style="display: none;"' : ''; ?>><span class="fa fa-trash"></span></button>
                        <?php if($index==0) { ?>  <span class="form-group adddelbtn">
                        <button style="font-size: 0.55rem;" type="button" name="add" class="btn btn-success btn-xs tr_clone_add_location"><span class="fa fa-plus"></span></button>
                        </span> <?php } ?>
                        <input type="text" name="t_trip_stops[]" id="t_trip_stops" value="<?php echo htmlspecialchars($location); ?>" class="form-control" placeholder="Enter Location 1">
                     </div>
                  </div> 

               <?php } } } else { ?>
               <div class="col-sm-6 col-md-3 tr_clone">
                  <div class="form-group">
                     <label class="location-label">Add Multiple Pickup Locations</label>  <span class="form-group adddelbtn">
                     <button style="font-size: 0.55rem;" type="button" name="add" class="btn btn-success btn-xs tr_clone_add_location"><span class="fa fa-plus"></span></button>
                     </span>
                     <input type="text" name="t_trip_stops[]" id="autocomplete3" class="form-control" placeholder="Enter Location 1">
                     <ul id="autocomplete-list3" class="autocomplete-list"></ul>
                  </div>
               </div>
               <?php } ?>
            
            </div>
            
            <div class="form-group">
    <label for="t_billingtype">Billing Type<span class="text-danger">&thinsp;*</span></label>
    <div class="d-flex flex-wrap">
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypeFixed" value="Fixed" 
        <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Fixed') ? 'checked' : ''; ?>>
    <label class="form-check-label" for="partyBillingTypeFixed">Fixed</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerTonne" value="Per Tonne" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per Tonne') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerTonne">Per Tonne</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerKG" value="Per KG" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per KG') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerKG">Per KG</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerKM" value="Per KM" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per KM') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerKM">Per KM</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerTrip" value="Per Trip" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per Trip') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerTrip">Per Trip</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerDay" value="Per Day" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per Day') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerDay">Per Day</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerHour" value="Per Hour" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per Hour') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerHour">Per Hour</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerLitre" value="Per Litre" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per Litre') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerLitre">Per Litre</label>
      </div>
      <div class="form-check form-check-inline">
         <input class="form-check-input" type="radio" name="t_billingtype" id="partyBillingTypePerBag" value="Per Bag" 
            <?php echo (isset($tripdetails[0]['t_billingtype'])) && ($tripdetails[0]['t_billingtype'] === 'Per Bag') ? 'checked' : ''; ?>>
         <label class="form-check-label" for="partyBillingTypePerBag">Per Bag</label>
      </div>

    </div>
</div>

<div id="additionalFields" class="row col-md-12" style="display:none;">
        <div class="col-sm-4 col-md-2" id="rateDiv">
            <div class="form-group" >
                <label class="form-label" for="rateInput">Rate</label>
                <input type="number" name="t_rate" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_rate']:'' ?>" required="true" class="form-control" id="rateInput" placeholder="Enter Rate">
            </div>
        </div>

        <div class="col-sm-4 col-md-2" id="quantityDiv">
            <div class="form-group" >
                <label class="form-label" for="quantityInput">Quantity (Tonne, KG, KM)</label>
                <input type="number" name="t_qty" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_qty']:'' ?>" required="true" class="form-control" id="quantityInput" placeholder="Enter Quantity">
            </div>
        </div>

        <div class="col-sm-4 col-md-2" id="freightAmountDiv">
            <div class="form-group" >
                <label class="form-label" for="freightAmount">Amount</label>
                <input type="number" required="true" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_withouttax_trip_amount']:'' ?>" name="t_withouttax_trip_amount" id="t_withouttax_trip_amount" class="form-control" placeholder="Amount Without Tax">
            </div>
        </div>

        <div class="col-sm-4 col-md-2" id="tax">
            <div class="form-group" >
                <label class="form-label" for="tax">Tax</label>
                <select name="t_trip_tax" id="t_trip_tax" class="form-control select2">
                     <option value="">Select Tax</option>
                     <?php if (isset($tax) && !empty($tax)): ?>
                        <?php foreach ($tax as $taxlist): ?>
                           <option data-type = "<?php echo $taxlist->ts_tax_type; ?>" value="<?php echo $taxlist->ts_tax_percentage; ?>"
                                 <?php echo (isset($tripdetails) && $tripdetails[0]['t_trip_tax'] == $taxlist->ts_tax_percentage) ? 'selected' : ''; ?>>
                                 <?php echo $taxlist->ts_tax_name; ?> [ <?php echo $taxlist->ts_tax_percentage; ?> ] 
                           </option>
                        <?php endforeach; ?>
                     <?php endif; ?>
                     </select>
            </div>
        </div>

        <div class="col-sm-4 col-md-2" id="">
            <div class="form-group" >
                <label class="form-label" for="freightAmount">Total Amount</label>
                <input type="number" required="true" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_amount']:'' ?>" name="t_trip_amount" id="t_trip_amount" class="form-control" placeholder="Total Amount">
                <span class="showmsg text-danger"></span>

            </div>
        </div>
</div>

            <div class="col-sm-6 col-md-5">
               <div class="form-group">
                  <label class="form-label">Email</label>
                  <div class="form-group mb-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" name="t_bookingemail" id="bookingemail" class="custom-control-input" id="bookingemail" <?php echo (isset($tripdetails[0]['t_bookingemail']) && $tripdetails[0]['t_bookingemail']==1) ? 'checked':'' ?>>
                        <label class="custom-control-label" for="bookingemail">Booking Email</label>
                     </div>
                  </div>
                  <div class="form-group mb-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" name="t_bookingsms" id="bookingsms" class="custom-control-input" id="bookingsms" <?php echo (isset($tripdetails[0]['t_bookingsms']) && $tripdetails[0]['t_bookingsms']==1) ? 'checked':'' ?>>
                        <label class="custom-control-label" for="bookingsms">Booking SMS</label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <input type="hidden" id="t_trip_fromlat" name="t_trip_fromlat" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_fromlat']:0 ?>">
         <input type="hidden" id="t_trip_fromlog" name="t_trip_fromlog" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_fromlog']:0 ?>">
         <input type="hidden" id="t_trip_tolat" name="t_trip_tolat" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_tolat']:0 ?>">
         <input type="hidden" id="t_trip_tolog" name="t_trip_tolog" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_tolog']:0 ?>">
         <input type="hidden" id="t_created_by" name="t_created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">
         <input type="hidden" id="t_created_date" name="t_created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">
         
         <input type="hidden" id="t_discount_method" name="t_discount_method">
         <input type="hidden" id="t_discountvalue" name="t_discountvalue">
         <input type="hidden" id="t_discountamount" name="t_discountamount">
         <input type="hidden" name="t_bookingfrom" value="Backend">

         <div class="card-footer text-right">

         <button id="apply-discount-btn" type="button" class="btn btn-secondary btn-sm">Apply Discount</button>
         <button id="cancel-discount-btn" type="button" class="btn btn-danger btn-sm d-none">Cancel</button>

    <!-- Small Discount Code Input and Apply Button -->
    <div id="discount-section" class="d-inline-block ml-2">
        <input type="text" name = "t_discountcode" id="discount-code" class="form-control form-control-sm d-none" style="width: 120px; display: inline-block;" placeholder="Coupon Code">
        <button id="validate-coupon-btn" type="button" class="btn btn-info btn-sm d-none ml-1">Apply</button>
        <button id="remove-coupon-btn" type="button" class="btn btn-sm btn-danger" style="display:none;">Remove Coupon</button>

    </div>

             Total Trip Amount :  <span>
        <input value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_final_amount']:'' ?>" type="text" class="t_trip_final_amount" name="t_trip_final_amount" style="border: none; background: transparent; width: 70px; text-align: left;" readonly onfocus="this.removeAttribute('readonly');">
    </span>
            <button type="submit" class="btn btn-primary"> <?php echo (isset($tripdetails))?'Update Trip':'Add Trip' ?></button>
         </div>
      </form><br>
   </div>
</section>

<?php if(isset($tripdetails)) { ?>
   <input type="hidden"  id="editt_discountcode" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_discountcode']:'' ?>" >
   <input type="hidden"  id="trip_amount" value="<?php echo (isset($tripdetails)) ? $tripdetails[0]['t_trip_amount'] - $tripdetails[0]['t_trip_final_amount']:'' ?>" >
<?php } ?>    

<!-- /.content -->
<?php $data = sitedata(); ?>
<script>
  $(document).ready(function () {

   $(document).on('click', '.tr_clone_remove_location', function () {
        $(this).closest('.tr_clone').remove(); // Remove the closest tr_clone div
    });


    const $additionalFields = $('#additionalFields');
    const $rateDiv = $('#rateDiv');
    const $quantityDiv = $('#quantityDiv');
    const $tWithoutTaxAmount = $('#t_withouttax_trip_amount');
    const $tTripAmount = $('#t_trip_amount');
    const $tTripFinalAmount = $('.t_trip_final_amount');
    const $showMsg = $('.showmsg');
    const $rateInput = $('#rateInput');
    const $quantityInput = $('#quantityInput');
    const $tripTax = $('#t_trip_tax');
    const $applyDiscountBtn = $('#apply-discount-btn');
    const $discountCodeInput = $('#discount-code');
    const $validateCouponBtn = $('#validate-coupon-btn');
    const $removeCouponBtn = $('#remove-coupon-btn');
    const $cancelDiscountBtn = $('#cancel-discount-btn');

    const existingCouponCode = $('#editt_discountcode').val(); 
    const t_discountvalue = $('#trip_amount').val(); 

    if (existingCouponCode) {
        $discountCodeInput.val(existingCouponCode).removeClass('d-none').hide();
        $applyDiscountBtn.addClass('d-none');
        $validateCouponBtn.hide();
        $removeCouponBtn.show();
        $cancelDiscountBtn.hide();
        $('#t_discountamount').val(t_discountvalue);
        $showMsg.html('Coupon Applied, Discount: ' + t_discountvalue);

    }


    function resetCoupon() {
         $('#t_discountamount').val('');
        $tTripFinalAmount.val($tTripAmount.val());
        $discountCodeInput.val('').addClass('d-none').show(); // Show input with "d-none" class
        $validateCouponBtn.addClass('d-none').show(); // Show validate button with "d-none"
        $applyDiscountBtn.removeClass('d-none').show(); // Show apply button without "d-none"
        $cancelDiscountBtn.addClass('d-none').hide(); // Hide cancel discount
        $removeCouponBtn.hide();
        $showMsg.hide();
    }

    function calculateFreightAmount() {
        const rate = parseFloat($rateInput.val()) || 0;
        const quantity = parseFloat($quantityInput.val()) || 0;
        $tWithoutTaxAmount.val((rate * quantity).toFixed(2));
        $tripTax.trigger('change');
    }

    function calculateTotalAmount() {
         resetCoupon();
        const taxPercentage = parseFloat($tripTax.val()) || 0;
        const taxType = $tripTax.find('option:selected').data('type');
        const tripAmountWithoutTax = parseFloat($tWithoutTaxAmount.val()) || 0;
        let totalAmount = tripAmountWithoutTax;

        if (taxType === 'percentage') {
            totalAmount += tripAmountWithoutTax * (taxPercentage / 100);
        } else if (taxType === 'fixed') {
            totalAmount += taxPercentage;
        }

        $tTripAmount.val(totalAmount.toFixed(2));
        $tTripFinalAmount.val(totalAmount.toFixed(2));
    }
    const billingType = $('input[name="t_billingtype"]:checked').val();
    if (billingType) {
        if (billingType === 'Fixed') {
            $additionalFields.show();
            $rateDiv.hide();
            $quantityDiv.hide();
        } else {
            $additionalFields.show();
            $rateDiv.show();
            $quantityDiv.show();
            $rateInput.attr("placeholder", "Enter Rate " + billingType);
        }
    } else {
        $('input[name="t_billingtype"][value="Fixed"]').prop('checked', true);
        $additionalFields.show();
        $rateDiv.hide();
        $quantityDiv.hide();
    }

    $('input[name="t_billingtype"]').on('change', function() {
         $rateInput.val('');
         $quantityInput.val('');
        const selectedType = $('input[name="t_billingtype"]:checked').val();
        $additionalFields.hide();
        $rateDiv.hide();
        $quantityDiv.hide();
        resetCoupon();
        if (selectedType === 'Fixed') {
            $additionalFields.show();
        } else if (selectedType) {
            $rateInput.attr("placeholder", "Enter Rate " + selectedType);
            $additionalFields.show();
            $rateDiv.show();
            $quantityDiv.show();
        }
        
        calculateFreightAmount();
    });

    $rateInput.add($quantityInput).on('input', calculateFreightAmount);

    $tripTax.change(calculateTotalAmount);
    $tWithoutTaxAmount.change(calculateTotalAmount);

    $applyDiscountBtn.click(function () {
        $(this).addClass('d-none');
        $discountCodeInput.add($validateCouponBtn).add($cancelDiscountBtn).removeClass('d-none').show();
    });

    $validateCouponBtn.click(function () {
        $showMsg.html('');
        const discountCode = $discountCodeInput.val();
        const originalAmount = parseFloat($tTripFinalAmount.val());

        if (originalAmount > 0 && discountCode) {
            $(this).text('Processing...').prop('disabled', true);

            $.ajax({
                url: '<?= base_url('trips/validate_coupon') ?>',
                type: 'POST',
                data: { coupon_code: discountCode, original_amount: originalAmount },
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        $tTripFinalAmount.val(result.final_amount.toFixed(2));
                        $showMsg.html('Coupon Applied, Discount: ' + result.discount_amount.toFixed(2));
                        $('#t_discountamount').val(result.discount_amount.toFixed(2));
                        $validateCouponBtn.hide();
                        $removeCouponBtn.show();
                        $cancelDiscountBtn.hide();
                        $discountCodeInput.hide();
                        $showMsg.show();
                        $('#t_discount_method').val(result.discount_method);
                        $('#t_discountvalue').val(result.discount_value);
                    } else {
                        alert(result.message);
                    }
                },
                complete: function () {
                    $validateCouponBtn.text('Apply Coupon').prop('disabled', false);
                }
            });
        } else {
            alert(discountCode ? 'Value is 0' : 'Please enter a coupon code.');
        }
    });

    $removeCouponBtn.click(function () {
        resetCoupon();
    });

    $cancelDiscountBtn.click(resetCoupon);
});


</script>

<style>
        /* CSS for blinking effect */
        .blinking-text {
            font-size: 14px;
            font-weight: bold;
            color: #ff0000;
            animation: blink 1s step-start infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }
        .autocomplete-list {
        position: absolute;
        z-index: 1000;
        width: 100%;
        background: white;
        max-height: 200px;
        overflow-y: auto;
        margin-left: -20px;
    }
    .autocomplete-list li {
        list-style: none;
        padding: 8px;
        cursor: pointer;
    }
    .autocomplete-list li:hover {
        background: #f0f0f0;
    }
    </style>
