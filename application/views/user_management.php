<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Employee's List
               <a href="<?= base_url(); ?>users/adduser" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Employee's List</li>
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
                        <th>S.No</th>
                        <th>Employee No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Last Login</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($userlist)){ $count=1;
                        foreach($userlist as $userlists){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo 'EMP'.output($userlists['u_id']); ?></td>
                        <td> <?php echo output($userlists['u_name']); ?></td>
                        <td> <?php echo output($userlists['u_surname']); ?></td>
                        <td> <?php echo output($userlists['u_mobile']); ?></td>
                        <td><?php echo output($userlists['u_email']); ?></td>
                        <td> <span class="badge <?php echo ($userlists['u_lastlogin']!='') ? '' : 'badge-danger'; ?> "><?php echo ($userlists['u_lastlogin']!='') ? $userlists['u_lastlogin'] : 'Not Logged In'; ?></span>    </td>
                        <td><span class="badge <?php echo ($userlists['u_isactive']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($userlists['u_isactive']=='1') ? 'Active' : 'Inactive'; ?></span>  
                        </td>
                        <td>
                           <a class="icon" href="<?php echo base_url(); ?>users/edituser/<?php echo output($userlists['u_id']); ?>">
                           <i class="fa fa-edit"></i>
                           </a> |
                           <a class="icon" href="<?php echo base_url(); ?>users/edituser/<?php echo output($userlists['u_id']); ?>">
                           <i class="fa fa-envelope" aria-hidden="true"></i>

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
