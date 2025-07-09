<!-- Content Header -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">DB Backup
               <a href="<?= base_url('backup/daily_backup'); ?>">
<button type="button" class="btn btn-sm btn-primary">
      Generate Backup
      </button>
      </a>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
               <li class="breadcrumb-item active">DB Backup</li>
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
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>Backup Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($backups)){ $count=1;
                        foreach($backups as $backup){
                        ?>
                     <tr>
                        <td> <?php echo $count++; ?></td>
                        <td> <?php echo $backup['file_name']; ?></td>
                        <td> <?php echo $backup['file_size']; ?></td>
                        <td> <?php echo $backup['backup_date']; ?></td>
                        <td>
                           <a class="icon" href="<?= base_url($backup['file_name']); ?>" download>
                           <i class="fa fa-download text-success"></i>
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