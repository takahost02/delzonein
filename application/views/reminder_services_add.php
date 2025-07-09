<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Services
               <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
               <i class="fa fa-plus"></i>
               </button>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Reminder Services</li>
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
               <table id="" class="table card-table table-vcenter text-nowrap tableexport">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Name</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($reminder_services)){  $count=1;
                        foreach($reminder_services as $reminder_service){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($reminder_service['rs_name']); ?></td>
                        <td> <?php echo output($reminder_service['rs_createddate']); ?></td>
                        <td>
                           
                           <a class="icon" href="<?php echo base_url(); ?>reminder/deletereminderservices/<?php echo output($reminder_service['rs_id']); ?>">
                           <i class="fa fa-trash text-danger"></i>
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
<div class="modal fade show" id="modal-add" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Service</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="reminderservicesave" method="post" action="<?php echo base_url(); ?>reminder/insertreminderservices">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="rs_name" class="col-sm-4 col-form-label">Service Name</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="rs_name" id="rs_name" required="true" placeholder="Enter Service Name">
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         <button type="submit" id="reminderservicesavebtn" class="btn btn-primary">Save</button>
         </div>
         </form>
      </div>
   </div>
</div>
