<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customer Info
               <a href="<?= base_url(); ?>customer/addcustomer" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Customer Info</li>
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
               <table id="" class="table card-table tableexport">
                  <thead>
                     <tr>
                        <th class="w-1">S.No</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
                        <?php if(userpermission('lr_cust_edit') || userpermission('lr_cust_del')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($customerlist)){ 
                     $count=1;
                        foreach($customerlist as $customerlists){
                        ?>
                     <tr>
                        <td> <?php echo output($count); $count++; ?></td>
                        <td> <?php echo output($customerlists['c_name']); ?></td>
                        <td> <?php echo output($customerlists['c_mobile']); ?></td>
                        <td><?php echo output($customerlists['c_email']); ?></td>
                        <td><?php echo output($customerlists['c_address']); ?></td>
                         <td>  <span class="badge <?php echo ($customerlists['c_isactive']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($customerlists['c_isactive']=='1') ? 'Active' : 'Inactive'; ?></span>  </td>
                        <?php if(userpermission('lr_cust_edit')) { ?>
                        <td>
                           <a class="icon" href="<?php echo base_url(); ?>customer/editcustomer/<?php echo output($customerlists['c_id']); ?>">
                           <i class="fa fa-edit"></i>
                           </a>
                           <?php  } if(userpermission('lr_cust_del')) { ?> |
                              <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>customer/deletecustomer','<?= output($customerlists['c_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a>
                           </a> 
                           <?php } ?>
                        </td>
                        <?php } ?>
                     </tr>
                     <?php  } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
