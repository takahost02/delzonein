<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Email Template
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Email Template</li>
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
               <table id="" class="table card-table datatableexport">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Subject</th>
                        <th>Template Content</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($emailtemplate)){ 
                     $count=1;
                        foreach($emailtemplate as $emailtemplates){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($emailtemplates['et_subject']); ?></td>
                        <td> <?php echo output($emailtemplates['et_body']); ?></td>
                        <td>
                        <a class="icon edit-button" 
                           data-id="<?php echo output($emailtemplates['et_id']); ?>" 
                           data-name="<?php echo output($emailtemplates['et_name']); ?>" 
                           data-body="<?php echo output($emailtemplates['et_body']); ?>" 
                           data-sub="<?php echo output($emailtemplates['et_subject']); ?>"
                           href="#" role="button">
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
<script>
   $(document).ready(function() {
      $('.edit-button').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var body = $(this).data('body');
        var sub = $(this).data('sub');
        $('#templateId').val(id);
        $('#templateName').text(name);
        $('#et_subject').val(sub);
        $('#templateBody').val(body);
        if(name=='maintenance') {
         $('.maintenace').show();
         $('.common').hide();
        } else {
         $('.maintenace').hide();
         $('.common').show();
        }
        $('#editEmailTemplateModal').modal('show');
      });
   });
</script>

<div id="editEmailTemplateModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Email Template - <span id="templateName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTemplateForm" method="POST" action="<?= base_url(); ?>settings/update_template">
                    <input type="hidden" name="et_id" id="templateId">
                    <div class="form-group">
                     <label for="et_subject">Subject</label>
                     <input type="text" class="form-control" id="et_subject" name="et_subject" placeholder="Enter subject" required>
                  </div>
                    <div class="form-group">
                        <label for="templateBody">Template Content</label>
                        <textarea class="form-control" id="templateBody" name="et_body" rows="16" required></textarea>
                        <small  class="form-text text-danger">Note : Please user "p" tag for each new line..</small>
                     <span class="common"> {{bookingid}},{{from}},{{to}},{{vehicle}},{{driver}},{{start_date}},{{end_date}},{{totaldistance}},{{tripstartreading}},{{trip_stops}},{{trip_amount}},{{trip_status}}, {{amount_due}}, {{trackingurl}} </span> 
                     <span class="maintenace" style="display:none">{{vehicle}},{{vehicle_number}},{{service_date}},{{odometer_reading}},{{status}}</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="editTemplateForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
