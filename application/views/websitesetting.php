<!-- Content Header -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
               <li class="breadcrumb-item active">Settings</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<!-- Main Content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- Side Tab Navigation -->
         <div class="col-md-2">
            <div class="nav flex-column nav-pills" id="settingSideTabs" role="tablist" aria-orientation="vertical">
               <a class="nav-link active" id="general-side-tab" data-bs-toggle="pill" href="#general-side" role="tab" aria-controls="general-side" aria-selected="true">General</a>
               <a class="nav-link" id="invoice-side-tab" data-bs-toggle="pill" href="#invoice-side" role="tab" aria-controls="invoice-side" aria-selected="false">Invoice</a>
               <a class="nav-link" id="api-side-tab" data-bs-toggle="pill" href="#api-side" role="tab" aria-controls="api-side" aria-selected="false">MAP API</a>
               <a class="nav-link" id="logo-side-tab" data-bs-toggle="pill" href="#logo-side" role="tab" aria-controls="logo-side" aria-selected="false">Logo</a>
            </div>
         </div>

         <!-- Tab Content -->
         <div class="col-md-10">
            <form id="settingsForm" class="basicvalidation" role="form" action="websitesetting_save" method="post" enctype="multipart/form-data">
               <div class="tab-content" id="settingSideTabsContent">
                  <!-- General Tab -->
                  <div class="tab-pane fade show active" id="general-side" role="tabpanel" aria-labelledby="general-side-tab">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_companyname'])?$website_setting[0]['s_companyname']:''); ?>" id="s_companyname" name="s_companyname" placeholder="Enter Company Name">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_address'])?$website_setting[0]['s_address']:''); ?>" id="s_address" name="s_address" placeholder="Enter Address">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_phoneno'])?$website_setting[0]['s_phoneno']:''); ?>" id="s_phoneno" name="s_phoneno" placeholder="Enter Phone Number">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_email'])?$website_setting[0]['s_email']:''); ?>" id="s_email" name="s_email" placeholder="Enter Email">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                 <label for="s_date_format" class="form-label">Date Format</label>
                                 <select id="s_date_format" name="s_date_format" class="form-control " required="">
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_date_format']=='Y-m-d H:i') ? 'selected':'' ?> value="Y-m-d H:i">Y-m-d H:i</option>
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_date_format']=='m-d-Y H:i') ? 'selected':'' ?> value="m-d-Y H:i">m-d-Y H:i</option> 
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_date_format']=='d-m-Y H:i') ? 'selected':'' ?> value="d-m-Y H:i">d-m-Y H:i</option> 
                                 </select>
                              </div>
                           </div>   

                           
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Booking ID Prefix</label>
                                    <input type="text" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_booking_prefix'])?$website_setting[0]['s_booking_prefix']:''); ?>" id="s_booking_prefix" name="s_booking_prefix" placeholder="Enter Booking ID Prefix">
                                 </div>
                              </div>

                              <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                 <label for="s_timezone" class="form-label">Default TimeZone</label>
                                 <select id="s_timezone" name="s_timezone" class="form-control" required="">
                                    <?= generateTimezoneOptionsWithOffset($website_setting[0]['s_timezone']); ?>
                                 </select>
                              </div>
                           </div> 
                           <div class="col-sm-6 col-md-4">
                              <label class="form-label">Admin Primary Color</label>
                              <div class="form-group">
                              <input id="add-device-color" name="s_admin_pcolor" class="jscolor {valueElement:'add-device-color', styleElement:'add-device-color', hash:true, mode:'HSV'} form-control"  value="<?php echo (isset($website_setting[0]['s_admin_pcolor'])) ? $website_setting[0]['s_admin_pcolor']:'#78CA5C' ?>" >
                              </div>
                           </div>

                           <div class="col-sm-6 col-md-4">
                              <label class="form-label">Admin Secondary Ccolor</label>
                              <div class="form-group">
                              <input id="add-device-color-sec" name="s_admin_scolor" class="jscolor {valueElement:'add-device-color-sec', styleElement:'add-device-color-sec', hash:true, mode:'HSV'} form-control"  value="<?php echo (isset($website_setting[0]['s_admin_scolor'])) ? $website_setting[0]['s_admin_scolor']:'#199e1c' ?>" >
                              </div>
                           </div>

                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Invoice Tab -->
                  <div class="tab-pane fade" id="invoice-side" role="tabpanel" aria-labelledby="invoice-side-tab">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">

                           <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                 <label for="s_invoice_template" class="form-label">Invoice Template</label>
                                 <select id="s_invoice_template" name="s_invoice_template" class="form-control " required="">
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_invoice_template']=='1') ? 'selected':'' ?> value="1">Template 1</option>
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_invoice_template']=='2') ? 'selected':'' ?> value="2">Template 2 [Thermal Printer Format]</option>
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_invoice_template']=='3') ? 'selected':'' ?> value="3">Template 3</option>
                                 </select>
                              </div>
                           </div>   


                           <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Invoice Curreny</label>
                                    <input type="text" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_price_prefix'])?$website_setting[0]['s_price_prefix']:''); ?>" id="s_price_prefix" name="s_price_prefix" placeholder="Enter Curreny Symbol / Word">
                                 </div>
                              </div>

                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Invoice Prefix</label>
                                    <input type="text" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_inovice_prefix'])?$website_setting[0]['s_inovice_prefix']:''); ?>" id="s_inovice_prefix" name="s_inovice_prefix" placeholder="Enter Invoice Prefix">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Invoice Service Name</label>
                                    <input type="text" class="form-control" required value="<?php echo output(isset($website_setting[0]['s_inovice_servicename'])?$website_setting[0]['s_inovice_servicename']:''); ?>" id="s_inovice_servicename" name="s_inovice_servicename" placeholder="Invoice Service Name">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Invoice Terms and Conditions</label>
                                    <textarea id="s_inovice_termsandcondition" name="s_inovice_termsandcondition" rows="4" cols="50" class="form-control" required placeholder="Enter Terms and Conditions"><?php echo output(isset($website_setting[0]['s_inovice_termsandcondition'])?$website_setting[0]['s_inovice_termsandcondition']:''); ?></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- API Tab -->
                  <div class="tab-pane fade" id="api-side" role="tabpanel" aria-labelledby="api-side-tab">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                           <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                 <label for="s_defaultmapapi" class="form-label">Default Map API</label>
                                 <select id="s_defaultmapapi" name="s_defaultmapapi" class="form-control " required="">
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_defaultmapapi']=='openstreetmap') ? 'selected':'' ?> value="openstreetmap">Openstreetmap</option>
                                 <option <?php echo (isset($website_setting) && $website_setting[0]['s_defaultmapapi']=='google') ? 'selected':'' ?> value="google">Google Map</option>
                                 </select>
                              </div>
                              </div>

                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label for="s_mapunit" class="form-label">Map Unit</label>
                                    <select id="s_mapunit" name="s_mapunit" class="form-control " required="">
                                    <option <?php echo (isset($website_setting) && $website_setting[0]['s_mapunit']=='km') ? 'selected':'' ?> value="km">Km</option>
                                    <option <?php echo (isset($website_setting) && $website_setting[0]['s_mapunit']=='mile') ? 'selected':'' ?> value="mile">Mile</option>
                                    </select>
                                 </div>
                              </div>   
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Google API Key</label>
                                    <input type="text" class="form-control"  value="<?php echo output(isset($website_setting[0]['s_googel_api_key'])?$website_setting[0]['s_googel_api_key']:''); ?>" id="s_googel_api_key" name="s_googel_api_key" placeholder="Enter Google API Key">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                              <label for="s_mapstarting_marker">Map Starting Marker</label>
                              <input type="file" class="form-control" name="s_mapstarting_marker" id="s_mapstarting_marker">
                              <?php if (!empty($website_setting[0]['s_mapstarting_marker'])): ?>
                                 <img src="<?= base_url($website_setting[0]['s_mapstarting_marker']); ?>" alt="Map Starting Marker" height="50">
                              <?php endif; ?>
                           </div>
                           </div>
                           <div class="col-sm-6 col-md-4">

                           <div class="form-group">
                              <label for="s_mapending_marker">Map Ending Marker</label>
                              <input type="file" class="form-control" name="s_mapending_marker" id="s_mapending_marker">
                              <?php if (!empty($website_setting[0]['s_mapending_marker'])): ?>
                                 <img src="<?= base_url($website_setting[0]['s_mapending_marker']); ?>" alt="Map Ending Marker" height="50">
                              <?php endif; ?>
                           </div>
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Logo Tab -->
                  <div class="tab-pane fade" id="logo-side" role="tabpanel" aria-labelledby="logo-side-tab">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Icon</label>
                                    <div class="input-group">
                                       <input type="file" class="form-control" id="icon_file" name="icon_file" <?php echo output(($website_setting[0]['s_icon']!='')?'disabled=true':''); ?>>
                                    </div>
                                    <!-- <span class="bg-gradient-success btn-xs">Image should be 50x50px and in PNG format</span> -->
                                 </div>
                                 <?php if($website_setting[0]['s_icon']!='') { ?>
                                    <img src="<?= base_url().'assets/uploads/'.$website_setting[0]['s_icon']; ?>" class="w-80px h-80px object-fit-contain" alt="Icon"  />
                                    <button type="button" class="icondelete btn btn-primary">Delete</button>
                                 <?php } ?>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                 <div class="form-group">
                                    <label>Logo</label>
                                    <div class="input-group">
                                       <input type="file" class="form-control" id="file" name="file" <?php echo output(($website_setting[0]['s_logo']!='')?'disabled=true':''); ?>>
                                    </div>
                                    <!-- <span class="bg-gradient-success btn-xs">Image should be 50x50px and in PNG format</span> -->
                                 </div>
                                 <?php if($website_setting[0]['s_logo']!='') { ?>
                                    <img src="<?= base_url().'assets/uploads/'.$website_setting[0]['s_logo']; ?>" class="w-100px h-100px object-fit-contain" alt="Logo"  />
                                    <button type="button" class="logodelete btn btn-primary">Delete</button>
                                 <?php } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Submit Button -->
                  <div id="addnewcategory_submit" class="btn-block text-right mt-3">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>

<!-- Bootstrap JS & jQuery (ensure you have these included) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
