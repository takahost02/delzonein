<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle's Management
               <a href="<?= base_url(); ?>vehicle/addvehicle" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Vehicle's Management</li>
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
                        <th>Img</th>
                        <th>Vehicle Name</th>
                        <th>Reg. Number</th>
                        <th>Model</th>
                        <th>Expiry Date</th>
                        <th>Group</th>
                        <th>Ownership</th>
                        <th>Is Active</th>
                        <?php if(userpermission('lr_vech_list_view') || userpermission('lr_vech_list_edit') || userpermission('lr_vech_del')) { ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($vehiclelist)){  $count=1; foreach($vehiclelist as $vehiclelists){  ?>
                     <tr>
                        <td><?php echo output($count); $count++; ?></td>
                        <td>   <?php if ($vehiclelists['v_file'] != '' && file_exists(FCPATH . 'assets/uploads/' . $vehiclelists['v_file'])) { ?>
                           <img class="img-fluid" style="width: 58px;" src="<?= base_url(); ?>assets/uploads/<?= $vehiclelists['v_file']; ?>" alt="Vehicle Image">
                        <?php } else { ?>
                           <small class="text-muted">No image</small>
                        <?php } ?></td>
                        <td><?php echo output($vehiclelists['v_name']); ?></td>
                        <td><?php echo output($vehiclelists['v_registration_no']); ?></td>
                        <td><?php echo output($vehiclelists['v_model']); ?></td>
                        <td><?php echo '<b>Registration:</b> '.output(showdate($vehiclelists['v_reg_exp_date'])); echo '<br>'.daysRemaining($vehiclelists['v_reg_exp_date']); ?><br>
                        <?php echo '<b>Insurance:</b> '.output(showdate($vehiclelists['v_ins_exp_date'])); echo '<br>'.daysRemaining($vehiclelists['v_ins_exp_date']) ?> </td>
                        <td><?php echo output($vehiclelists['gr_name']); ?>
                        <?php if ($vehiclelists['gr_image'] != '' && file_exists(FCPATH . 'uploads/' . $vehiclelists['gr_image'])) { ?>
                          <br> <img class="img-fluid" style="width: 58px;" src="<?= base_url(); ?>uploads/<?= $vehiclelists['gr_image']; ?>" >
                        <?php } ?>
                     
                        <?php echo ($vehiclelists['v_defaultcost']!='' && $vehiclelists['v_default_billing_type']!='') ?  '<br>'.$vehiclelists['v_defaultcost'].' / '.$vehiclelists['v_default_billing_type'] : '' ?>
                        </td>

                        <td><?php echo output(strtoupper($vehiclelists['v_ownership'])); 
                        if($vehiclelists['v_ownership']!='owned') {
                        echo ($vehiclelists['v_lease_start_date']!='') ?  '<b><br> Start Date : </b>'.output(showdate($vehiclelists['v_lease_start_date'])) : '';
                        echo ($vehiclelists['v_lease_end_date']!='') ?  '<b> <br> End Date : </b> '.output(showdate($vehiclelists['v_lease_end_date'])):'';
                        echo ($vehiclelists['v_lease_end_date']!='') ? '<br>'.daysRemaining($vehiclelists['v_lease_end_date']):'';  }  ?>
                        </td>
                        <td><span class="badge <?php echo ($vehiclelists['v_is_active']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($vehiclelists['v_is_active']=='1') ? 'Active' : 'Inactive'; ?></span>  
                        </td>
                        <?php if(userpermission('lr_vech_list_view') || userpermission('lr_vech_list_edit') || userpermission('lr_vech_del')) { ?>
                        <td>
                           <?php if(userpermission('lr_vech_list_view')) { ?>
                           <a class="icon" href="<?php echo base_url(); ?>vehicle/viewvehicle/<?php echo encodeId(output($vehiclelists['v_id'])); ?>">
                           <i class="fa fa-eye"></i>
                           </a> | 
                           <?php } if(userpermission('lr_vech_list_edit')) { ?>
                           <a class="icon" href="<?php echo base_url(); ?>vehicle/editvehicle/<?php echo encodeId(output($vehiclelists['v_id'])); ?>">
                           <i class="fa fa-edit"></i>
                           </a>
                           <?php } if(userpermission('lr_vech_del')) { ?> |
                              <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>vehicle/deletevehicle','<?= output($vehiclelists['v_id']); ?>')" data-target="#deleteconfirm" class="icon text-danger" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i></a>
                           </a> 
                           <?php } ?>
                        </td>
                        <?php } ?>
                     </tr>
                     <?php } } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
