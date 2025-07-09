<footer class="main-footer">
   <strong>Developed By <a href="http://codeforts.com" target="_blank">Codeforts</a>.</strong>
   <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 7.0
   </div>
</footer>
</div>
</div>
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url(); ?>assets/plugins/overlayScrollbars/jquery.overlayScrollbars.min.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/adminlte.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<?php $CI = get_instance(); $last = $CI->uri->total_segments();  $seg = $CI->uri->segment($last);  if(is_numeric($seg)) { $seg = $CI->uri->segment($last-1); } ?>
<script src="<?= base_url(); ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<script src="<?= base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/jscolor.js"></script>
<script src="<?= base_url(); ?>assets/plugins/selectize.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>

<script src="<?= base_url(); ?>assets/plugins/datetimepicker/datetimepicker.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datetimepicker/datetimepicker.css">
<script type="text/javascript">
   <?php if ($this->session->flashdata('successmessage')) { ?>
      const Toast = Swal.mixin({toast: true,position: 'top',showConfirmButton: false,timer: 5000});
      Toast.fire({
       type: 'success',
       title: '<?= $this->session->flashdata('successmessage'); ?>'
       });
   <?php if(isset($_SESSION['successmessage'])){
            unset($_SESSION['successmessage']);
        } } else if ($this->session->flashdata('warningmessage')) { ?>
       const Toast = Swal.mixin({toast: true,position: 'top',showConfirmButton: false,timer: 5000});
       Toast.fire({
       type: 'error',
       title: '<?= $this->session->flashdata('warningmessage'); ?>'
       });
   <?php if(isset($_SESSION['warningmessage'])){
            unset($_SESSION['warningmessage']);
        } } ?>
</script>
<script src="<?= base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<?php  $data = sitedata();
if($data['s_defaultmapapi']=='google') {
   if($seg=='addgeofence' || $seg=='addtrips' || $seg=='geofence' || $seg == 'livestatus' || $seg == 'tracking') {
    ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript"
   src="https://maps.google.com/maps/api/js?key=<?php echo output($data['s_googel_api_key']); ?>&sensor=false&v=3.21.5a&libraries=drawing&signed_in=true&libraries=places,drawing"></script>
<script src="<?php echo base_url(); ?>assets/distance_calculator.js"></script>
<?php } } else { ?>
<script src="<?php echo base_url(); ?>assets/distance_calculator_opensource.js"></script>
<?php } ?>


<script src="<?= base_url(); ?>assets/custom.js?v=<?= mt_rand(); ?>"></script>

<?php if($seg=='addgeofence') { if(sitedata()['s_defaultmapapi']=='google') { ?>
   <script src="<?php echo base_url(); ?>assets/geofence.js"></script>
<?php } else { ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="<?php echo base_url(); ?>assets/geofence_leaflet.js"></script>
<?php } } ?>
<?php 
   if($seg=='addgeofence') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap4.min.css">
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script>$('.select2').select2()</script>
<?php } ?>
<?php 
   if($seg=='vehicleavailablity') { ?>
<script src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.js"></script>
<?php } ?>
<script>
   $('#file').change(function(){
      var ext = $('#file').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','docx']) == -1) {
         alert('Invalid file, only accepts gif,png,jpg,jpeg');
         this.value = '';
      }
   });
   $('#file1').change(function(){
      var ext = $('#file1').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['pdf','docx']) == -1) {
         alert('Invalid file, only accepts pdf,docx');
         this.value = '';
      }
   });

   $('.tr_clone_add').click(function () {
    var $tr = $(this).closest('.tr_clone');

    // Destroy Select2 instances before cloning
    $tr.find('select.select2-hidden-accessible').each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) {
            $(this).select2('destroy');
        }
    });

    // Clone the row
    var $clone = $tr.clone();

    // Clear input fields
    $clone.find(':text').val('');
    $clone.find('.rm').remove();

    // Replace the add button with a remove button
    $clone.find('.adddelbtn').html('<button type="button" class="btn btn-danger btn-xs tr_clone_remove"><span class="fa fa-trash"></span></button>');

    // Re-append clone to DOM
    $tr.after($clone);

    // Re-initialize Select2 on the new clone
    $clone.find('select.select2').select2({
        width: '100%' // or whatever options you used before
    });

    // Bind remove button
    $('.tr_clone_remove').off('click').on('click', function () {
        $(this).closest('.tr_clone').remove();
        updateLocationLabels();
    });

    // Update label/placeholder text
    updateLocationLabels();
});


   function addAddress() {
      $("#new").on("click", function() {
         var inc = $(".row_address").length + 1,
         $newAddressRow = `
               <div id="${inc}" class="row row_address col-sm-6" >
                     <input type="text" name="address" class="form-control" placeholder="Address...">
               <button class="remove">X</button>
            </div>
            `;

         $($newAddressRow).insertBefore($(this));
            var $newAddressInput = $("input[name='address']:last");
            $newAddressInput.focus();
            applySearchAddress($newAddressInput);
      });
   };

   function delAddress() {
      $(document).on("click", ".remove", function() {
         $(this).closest(".row_address").remove();
         $("#predictions_" + $(this).closest("div").attr("id")).remove();
      });
   };

   function applySearchAddress($input) {
      if (google.maps.places.PlacesServiceStatus.OK != "OK") {
      console.warn(google.maps.places.PlacesServiceStatus)
      return false;
      }
      var autocomplete = new google.maps.places.Autocomplete($input.get(0));
      
      setTimeout(function() {
      var rowId = $input.closest("div").attr("id");
      $(".pac-container:last").attr("id", "predictions_" + rowId);
      }, 100);
   };
   $(document).ready(function() {
      addAddress();
      delAddress();
   });


   $('.tr_clone_add_location').click(function() {
      var $tr = $(this).closest('.tr_clone');
      var $clone = $tr.clone();
      var count = $('.tr_clone').length + 3; // Start numbering from 3
      $clone.find('input')
         .attr('id', 'autocomplete' + count)
         .val('')
         .attr('placeholder', 'Enter Location ' + count)
         .attr('required', true);
      $clone.find('.autocomplete-list')
         .attr('id', 'autocomplete-list' + count)
         .removeAttr('style') 
         .empty(); // Clear autocomplete list entries
      $clone.find('.adddelbtn').html(
         '<button style="font-size: 0.55rem;" type="button" name="remove" class="btn btn-danger btn-xs tr_clone_remove"><span class="fa fa-trash"></span></button>'
      );
      $tr.parent().append($clone);
      initAutocomplete('autocomplete' + count, 'autocomplete-list' + count, 't_trip_stops', 't_trip_stops');
      updateLocationLabels();
      $clone.find('.tr_clone_remove').click(function() {
         $(this).closest('.tr_clone').remove();
         updateLocationLabels();
      });
   });
    var currentController = "<?= $this->router->fetch_class(); ?>";
   function updateLocationLabels() {
      var $trClones = $('.tr_clone');
      if ($trClones.length === 1) {
         $trClones.first().find('.location-label').text('Add Multiple Pickup Locations');
         $trClones.first().find('input').attr('placeholder', 'Enter Location 1');
      } else {
         $trClones.each(function(index) {
               if (index === 0) {
                  $(this).find('.location-label').text('Add Multiple Pickup Locations');
                  $(this).find('input').attr('placeholder', 'Enter Location 1');
               } else {
                  $(this).find('.location-label').text('Location ' + (index + 1));
                  $(this).find('input').attr('placeholder', 'Enter Location ' + (index + 1));
               }
         });
      }
   }
   if (currentController === 'trips') {
      updateLocationLabels();
   }



</script>
</body>
</html>