<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">SMS Template</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">SMS Template</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<section class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table card-table datatableexport">
            <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Name</th>
                        <th style="width: 50%;">Template Content</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($smstemplate)) { 
                        $count = 1;
                        foreach ($smstemplate as $smstemplates) { ?>
                     <tr>
                        <td><?php echo output($count); $count++; ?></td>
                        <td><?php echo output($smstemplates['st_name']); ?></td>
                        <td><?php echo output($smstemplates['st_body']); ?></td>
                        <td><span class="badge <?php echo ($smstemplates['st_status'] == 1) ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo ($smstemplates['st_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                        </span></td>  
                        <td><?php echo output(date('Y-m-d', strtotime($smstemplates['st_created_date']))); ?></td>
                        <td>
                        <a class="icon" href="#" 
                           data-toggle="modal" 
                           data-target="#editTemplateModal"
                           data-id="<?php echo output($smstemplates['st_id']); ?>" 
                           data-name="<?php echo output($smstemplates['st_name']); ?>" 
                           data-content="<?php echo output($smstemplates['st_body']); ?>" 
                           data-status="<?php echo $smstemplates['st_status']; ?>">
                           <i class="fa fa-edit"></i>
                        </a>
                     </td>
                     </tr>
                     <?php } } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>


<!-- Edit SMS Template Modal -->
<div class="modal fade" id="editTemplateModal" tabindex="-1" role="dialog" aria-labelledby="editTemplateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTemplateModalLabel">Edit SMS Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editTemplateForm" method="POST" action="<?= base_url(); ?>settings/update_sms_template">
        <div class="modal-body">
          <input type="hidden" name="st_id" id="template_id">
          <div class="form-group">
            <label for="template_name">Name</label>
            <input type="text" class="form-control" id="template_name" name="st_name" readonly>
          </div>
          <div class="form-group">
            <label for="template_content">Template Content</label>
            <textarea class="form-control" id="template_content" name="st_body" rows="4" required></textarea>
            <small style="float: right;color:green" id="charCount" class="form-text text-muted">Count: <span id="count">0</span></small>

          </div>
          <div class="form-group">
            <label for="template_status">Status</label>
            <select class="form-control" id="template_status" name="st_status">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <span class="common">{{bookingid}},{{from}},{{to}},{{vehicle}},{{driver}},{{start_date}},{{end_date}},{{totaldistance}},{{tripstartreading}},{{trip_stops}},{{trip_amount}},{{trip_status}}, {{amount_due}}, {{trackingurl}}</span>
          <span class="maintenace" style="display:none">{{vehicle}},{{vehicle_number}},{{service_date}},{{odometer_reading}},{{status}}</span>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
   $(document).ready(function() {
      const updateCharCount = function() {
         const currentLength = $('#template_content').val().length;
         $('#count').text(currentLength);
      };

      // Update count on input
      $('#template_content').on('input', function() {
         updateCharCount();
      });
      $('#editTemplateModal').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget); 
         var id = button.data('id');
         var name = button.data('name');
         var content = button.data('content');
         var status = button.data('status');
         var modal = $(this);
         modal.find('#template_id').val(id);
         modal.find('#template_name').val(name);
         modal.find('#template_content').val(content);
         modal.find('#template_status').val(status);
         if(name=='Maintenance') {
         $('.maintenace').show();
         $('.common').hide();
        } else {
         $('.maintenace').hide();
         $('.common').show();
        }
         updateCharCount();
      });
   });
</script>