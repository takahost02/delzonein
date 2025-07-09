<?php
if($this->uri->segment(3)) {
	$data = $this->uri->segment(3);
} else {
	$data = 0;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="<?php echo base_url(); ?>assets/fontawesome-markers.min.js"></script>
<?php if(sitedata()['s_defaultmapapi']=='google') { ?>
<script id="group" data-name="<?= $data  ?>" src="<?php echo base_url(); ?>assets/livetrack.js"></script>
<div class="col-lg-12 col-md-12" id="map_canvas" style="width: 100%; height: 85vh; position: relative;"></div>
<div id="legend" style="position: absolute; top: 10px; right: 10px; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.3); z-index: 1000; width: 400px;text-align: center;">
</div>
<?php } else { ?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script id="group" data-name="<?= $data ?>" src="<?php echo base_url(); ?>assets/livetrack_leaflet.js"></script>

<div class="col-lg-12 col-md-12" id="map_canvas" style="width: 100%; height: 85vh; position: relative;"></div>
    <!-- Legend Container -->
    <div id="legend" style="position: absolute; top: 10px; right: 10px; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.3); z-index: 1000; width: 400px;text-align: center;">
    </div>
</div>


<?php } ?>
</div>
</div>