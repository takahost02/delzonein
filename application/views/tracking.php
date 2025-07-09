<div class="content-header">
<div class="container-fluid">
<form id="track" method="post" >
   <div class="row col-md-12">
      <div class="col-md-2">
         <div class="form-group">
            <input type="text" required="true" name="fromdate" id="fromdate" class="form-control datepicker" placeholder="From Date" >
         </div>
      </div>
      <div class="col-sm-2">
         <div class="form-group">
            <input type="text" required="true" name="todate" id="todate" class="form-control datepicker" placeholder="To Date" >
         </div>
      </div>
      <div class="col-md-5">
         <div class="form-group">
            <select id="t_vechicle" required="true" class="form-control select2"  name="t_vechicle">
               <option value="">Select Vechicle</option>
               <?php  foreach ($vechiclelist as $key => $vechiclelists) { ?>
               <option value="<?php echo output($vechiclelists['v_id']) ?>"><?php echo output($vechiclelists['v_name']).' - '. output($vechiclelists['v_registration_no']); ?></option>
               <?php  } ?>
            </select>
         </div>
      </div>
      <div class="col-md-3">
         <div class="form-group">
            <button type="submit"  class="btn btn-primary">Load</button>
            <button type="button"  id="show-summary" class="btn btn-info" style="display: none;">Show Trip Summary</button>
         </div>
      </div>
   </div>
</form>
<input type="hidden" id="s_mapstarting_marker" value="<?= sitedata()['s_mapstarting_marker']; ?>" />
<input type="hidden" id="s_mapending_marker" value="<?= sitedata()['s_mapending_marker']; ?>" />
<?php
if(sitedata()['s_defaultmapapi']=='google') { ?>
<section class="content">
   <div class="container-fluid">
     <div class="row-cards">
   <script type="text/javascript" src="https://www.google.com/jsapi"></script>
   <script src="<?php echo base_url(); ?>assets/map.js"></script>
   <div class="col-lg-12 col-md-12" id="map" style="width: 100%; height: 525px"></div>
   </div>
   </div>
   </section> 
   <div id="map-legend" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); background: rgba(255, 255, 255, 0.7); padding: 10px; border-radius: 5px; font-size: 14px; max-width: 90%; white-space: nowrap;">
    <div id="trip-legend" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;"></div>
</div>
<style>/* This CSS targets the close button of the InfoWindow */
#map-legend {
    z-index: 10;
    color: #333;
    font-size: 14px;
    padding: 5px;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.8);
    max-width: 95%;
    white-space: nowrap;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.legend-color-box {
    width: 15px;
    height: 15px;
    border-radius: 3px;
}

.gm-ui-hover-effect {
    font-size: 8px !important; /* Reduce the font size of the 'X' */
    width: 18px !important;     /* Set the width */
    height: 18px !important;    /* Set the height */
    padding: 6px !important;    /* Adjust padding */
    color: black !important;  
}
</style>
<?php } else {  ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<section class="content">
   <div class="container-fluid">
      <div class="row-cards">
         <script src="<?php echo base_url(); ?>assets/map_leaflet.js"></script>
         <div class="col-lg-12 col-md-12" id="map" style="width: 100%; height: 525px"></div>
         <div id="map-legend"></div>

      </div>
   </div>
</section>
<style>
   #map-legend {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255, 255, 255, 0.8);
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
    max-width: 90%;
    white-space: nowrap;
    z-index: 999;
    display: flex;
    flex-direction: column;
    gap: 5px;
   }
   .legend-item {
      display: flex;
      align-items: center;
      gap: 8px;
   }
   .legend-color-box {
      width: 15px;
      height: 15px;
      border-radius: 3px;
   }
   #map {
   height: 500px;
   width: 100%;
   }

   #trip-summary {
   padding: 10px;
   background-color: #f9f9f9;
   max-height: 300px;
   overflow-y: auto;
   border: 1px solid #ccc;
   }
   @media (max-width: 768px) {
   #map {
   height: 300px;
   }
   #trip-summary {
   max-height: 200px;
   }
   }
</style>
<?php } ?>
<!-- Modal Popup -->
<div id="trip-summary-modal" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Trip Summary</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="trip-summary" style="max-height: 300px; overflow-y: auto;">
               <!-- Trip summaries will be dynamically inserted here -->
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
