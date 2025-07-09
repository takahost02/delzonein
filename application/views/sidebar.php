<aside class="main-sidebar elevation-1 theme-color-secondary">
   <?php $data = sitedata();  ?>
   <a href="<?= base_url(); ?>dashboard" class="brand-link">
      <?php if($data['s_icon']!='') { ?>
      <img src="<?= base_url().'assets/uploads/'.$data['s_icon']; ?>" class="brand-image">
      <?php } ?>
      <span class="brand-text font-weight-light">
         <?php echo output(isset($data['s_companyname'])?$data['s_companyname']:''); ?>
      </span>
    </a>
   <div class="sidebar">
      <nav>
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
            <li class="nav-item">
               <a href="<?= base_url(); ?>dashboard" class="nav-link <?php echo activate_menu('dashboard');?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                     Dashboard
                  </p>
               </a>
            </li>
            <?php if(userpermission('lr_vech_availablity')) { ?>
            <li class="nav-item">
               <a href="<?= base_url(); ?>vehicleavailablity" class="nav-link <?php echo activate_menu('vehicleavailablity');?>">
                  <i class="nav-icon fa fa-calendar" aria-hidden="true"></i>
                  <p>
                  Availability
                  </p>
               </a>
            </li>
               <?php } ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('vehicle'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('vehicleroute'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addvehicle'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('viewvehicle'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('editvehicle'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('vehiclegroup'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('vehicle');?> <?php echo activate_menu('vehicleroute');?> <?php echo activate_menu('addvehicle');?><?php echo activate_menu('viewvehicle');?><?php echo activate_menu('editvehicle');?><?php echo activate_menu('vehiclegroup');?>">
                  <i class="nav-icon fas fa-truck"></i>
                  <p>
                     Vehicle's
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <?php if(userpermission('lr_vech_list')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>vehicle" class="nav-link <?php echo activate_menu('vehicle');?><?php echo activate_menu('editvehicle');?><?php echo activate_menu('viewvehicle');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Vehicle List</p>
                     </a>
                  </li>
                 <?php } if(userpermission('lr_vech_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>vehicle/addvehicle" class="nav-link <?php echo activate_menu('addvehicle');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Vehicle</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_vech_group')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>vehicle/vehiclegroup" class="nav-link <?php echo activate_menu('vehiclegroup');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Vehicle Group</p>
                     </a>
                  </li>
                <?php } ?>
                <?php  if(userpermission('lr_route')) { ?>

                <li class="nav-item">
                     <a href="<?= base_url(); ?>vehicle/vehicleroute" class="nav-link <?php echo activate_menu('vehicleroute');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Route</p>
                     </a>
                  </li>
                  <?php } ?>

               </ul>
            </li>
           

            <?php if(userpermission('lr_drivers_list') || userpermission('lr_drivers_add')) { ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('drivers'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('adddrivers'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('editdriver'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('drivers');?> <?php echo activate_menu('adddrivers');?><?php echo activate_menu('editdriver');?>">
                  <i class="nav-icon fas fa-user-secret"></i>
                  <p>
                     Driver's
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <?php if(userpermission('lr_drivers_list')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>drivers" class="nav-link <?php echo activate_menu('drivers');?><?php echo activate_menu('editdriver');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Driver List</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_drivers_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>drivers/adddrivers" class="nav-link <?php echo activate_menu('adddrivers');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Driver</p>
                     </a>
                  </li>
                  <?php } ?>
               </ul>
            </li>
            <?php } ?>
            <?php if(userpermission('lr_vehiclevendors')) { ?>

            <li class="nav-item has-treeview <?php echo ((activate_menu('vehiclevendors'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addvehiclevendors'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('editvehiclevendors'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('vehiclevendors');?> <?php echo activate_menu('addvehiclevendors');?><?php echo activate_menu('editvehiclevendors');?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                  Vehicle Vendor's
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>vehiclevendors" class="nav-link <?php echo activate_menu('vehiclevendors');?><?php echo activate_menu('editvehiclevendors');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Vehicle Vendors List</p>
                     </a>
                  </li>
                  <?php if(userpermission('lr_vehiclevendors_add')) { ?>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>vehiclevendors/addvehiclevendors" class="nav-link <?php echo activate_menu('addvehiclevendors');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Vehicle Vendors</p>
                     </a>
                  </li>
                  <?php }  ?>    

               </ul>
            </li>
           <?php }  ?>    
            <?php if(userpermission('lr_trips_list') || userpermission('lr_trips_list_view')) { ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('trips'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addtrips'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('edittrip'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('details'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('trips');?> <?php echo activate_menu('addtrips');?> <?php echo activate_menu('edittrip');?><?php echo activate_menu('details');?>">
                  <i class="nav-icon fas fa-road"></i>
                  <p>
                  Trips
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <?php if(userpermission('lr_trips_list')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>trips" class="nav-link <?php echo activate_menu('trips');?><?php echo activate_menu('edittrip');?><?php echo activate_menu('details');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Trips List</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_trips_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>trips/addtrips" class="nav-link <?php echo activate_menu('addtrips');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Trips</p>
                     </a>
                  </li>
                  <?php } ?>
               </ul>
            </li>
           <?php } ?>
           <?php if(userpermission('lr_cust_list') || userpermission('lr_cust_add')) { ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('customer'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addcustomer'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('editcustomer'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('customer');?> <?php echo activate_menu('addcustomer');?><?php echo activate_menu('editcustomer');?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     Customer
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                <?php  if(userpermission('lr_cust_list')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>customer" class="nav-link <?php echo activate_menu('customer');?><?php echo activate_menu('editcustomer');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Management</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_cust_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>customer/addcustomer" class="nav-link <?php echo activate_menu('addcustomer');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Customer</p>
                     </a>
                  </li>
                   <?php } ?>
               </ul>
            </li>
            <?php } ?>

            <?php if(userpermission('lr_coupon')) { ?>
            <li class="nav-item">
               <a href="<?= base_url(); ?>coupon" class="nav-link <?php echo activate_menu('coupon');?>">
                  <i class="nav-icon fa fa-copyright"></i>
                  <p>
                     Coupon Management
                  </p>
               </a>
            </li>
            <?php } ?>

            <?php  if(userpermission('lr_maintenace')) { ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('maintenance_edit'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('maintenance'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('maintenance_vendor'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('mechanic'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addmaintenance'))=='active') ? 'menu-open':'' ?> ">
               <a href="#" class="nav-link <?php echo activate_menu('maintenance');?>  <?php echo activate_menu('mechanic');?> <?php echo activate_menu('addmaintenance');?> <?php echo activate_menu('maintenance_vendor');?> <?php echo activate_menu('maintenance_edit');?>">
                  <i class="nav-icon fa fa-wrench"></i>
                  <p>
                  Maintenance
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>maintenance" class="nav-link <?php echo activate_menu('maintenance');?>  ">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Maintenance</p>
                     </a>
                  </li>
                  <?php  if(userpermission('lr_maintenace_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>maintenance/addmaintenance" class="nav-link <?php echo activate_menu('addmaintenance');?> <?php echo activate_menu('maintenance_edit');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Maintenance</p>
                     </a>
                  </li>
                  <?php  } ?>
                  <?php  if(userpermission('lr_mechanic')) { ?>
   
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>maintenance/mechanic" class="nav-link <?php echo activate_menu('mechanic');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Mechanic</p>
                     </a>
                  </li>
                  <?php  } ?>
                  <?php  if(userpermission('lr_vendor')) { ?>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>maintenance/maintenance_vendor" class="nav-link <?php echo activate_menu('maintenance_vendor');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Vendor</p>
                     </a>
                  </li>       
                  <?php  } ?>

                  
               </ul>
            </li>
            <?php } ?>

           
            
            <?php if(userpermission('lr_stock_add') || userpermission('lr_stock')) { ?>
           <li class="nav-item has-treeview <?php echo ((activate_menu('stockinventory'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('purchasehistory'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addstockinventory'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('editstock'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('stockinventory');?> <?php echo activate_menu('addstockinventory');?><?php echo activate_menu('purchasehistory');?><?php echo activate_menu('editstock');?>">
                  <i class="nav-icon fas fa-barcode"></i>
                  <p>
                     Parts Stock 
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>stockinventory" class="nav-link <?php echo activate_menu('stockinventory');?><?php echo activate_menu('editstock');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Stock List</p>
                     </a>
                  </li>
                  <?php  if(userpermission('lr_stock_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>stockinventory/addstockinventory" class="nav-link <?php echo activate_menu('addstockinventory');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Stock</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>stockinventory/purchasehistory" class="nav-link <?php echo activate_menu('purchasehistory');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Purchase History</p>
                     </a>
                  </li>
                  <?php } ?>
               </ul>
            </li>           
          <?php } ?>

            <?php  if(userpermission('lr_fuel_list') || userpermission('lr_fuel_add')) { ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('fuel'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('fuelvendor'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addfuel'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('editfuel'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('fuel');?> <?php echo activate_menu('fuelvendor');?>  <?php echo activate_menu('addfuel');?><?php echo activate_menu('editfuel');?>">
                  <i class="nav-icon fa fa-battery-three-quarters"></i>
                  <p>
                     Fuel
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                <?php  if(userpermission('lr_fuel_list')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>fuel" class="nav-link <?php echo activate_menu('fuel');?> <?php echo activate_menu('editfuel');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Fuel Management</p>
                     </a>
                  </li>
                   <?php } if(userpermission('lr_fuel_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>fuel/addfuel" class="nav-link <?php echo activate_menu('addfuel');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Fuel</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_fuel_vendor')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>fuel/fuelvendor" class="nav-link <?php echo activate_menu('fuelvendor');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Fuel Vendor</p>
                     </a>
                  </li>


                   <?php }  ?>
               </ul>
            </li>
            <?php }  if(userpermission('lr_reminder_list') || userpermission('lr_reminder_add')) { ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('reminder'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('services'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('addreminder'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('editreminder'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('reminder');?> <?php echo activate_menu('services');?> <?php echo activate_menu('addreminder');?><?php echo activate_menu('editreminder');?>">
                  <i class="nav-icon fas fa fa-bullhorn"></i>
                  <p>
                     Reminder
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                <?php  if(userpermission('lr_reminder_list')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reminder" class="nav-link <?php echo activate_menu('reminder');?><?php echo activate_menu('editreminder');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Reminder Management</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_reminder_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reminder/addreminder" class="nav-link <?php echo activate_menu('addreminder');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Reminder</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reminder/services" class="nav-link <?php echo activate_menu('services');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Services</p>
                     </a>
                  </li>

                  <?php } ?>
               </ul>
            </li>
            <?php }  ?>
            
            <?php if(userpermission('lr_accounts')) { ?>
           <li class="nav-item has-treeview <?php echo ((activate_menu('category'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('accounts'))=='active') ? 'menu-open':'' ?><?php echo ((activate_menu('addtransactions'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('transactions'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('transfers'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('accounts');?> <?php echo activate_menu('category');?> <?php echo activate_menu('addtransactions');?> <?php echo activate_menu('transfers');?><?php echo activate_menu('transactions');?>">
                  <i class="nav-icon fas fa-barcode"></i>
                  <p>
                     Accounts
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>accounts" class="nav-link <?php echo activate_menu('accounts');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Accounts</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>accounts/addtransactions" class="nav-link <?php echo activate_menu('addtransactions');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Transactions</p>
                     </a>
                  </li>

                  
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>accounts/transactions" class="nav-link <?php echo activate_menu('transactions');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Transactions</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>accounts/transfers" class="nav-link <?php echo activate_menu('transfers');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Ac Transfers / Deposit</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>accounts/category" class="nav-link <?php echo activate_menu('category');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Transactions Category</p>
                     </a>
                  </li>

               </ul>
            </li>           
          <?php } ?>

            
            <?php if(userpermission('lr_tracking') || userpermission('lr_liveloc')) { ?>
           <li class="nav-item has-treeview <?php echo ((activate_menu('tracking'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('livestatus'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('tracking');?> <?php echo activate_menu('livestatus');?>">
                  <i class="nav-icon fa fa-map-pin"></i>
                  <p>
                     Tracking
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                 <?php  if(userpermission('lr_tracking')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>tracking" class="nav-link <?php echo activate_menu('tracking');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>History Tracking</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_liveloc')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>tracking/livestatus" class="nav-link <?php echo activate_menu('livestatus');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Live Location</p>
                     </a>
                  </li>
                  <?php } ?>
               </ul>
            </li> 
             <?php }  
             if(userpermission('lr_geofence_add') || userpermission('lr_geofence_list') || userpermission('lr_geofence_events')) { ?>
            <li class="nav-item has-treeview <?php echo ((activate_menu('addgeofence'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('geofenceevents'))=='active') ? 'menu-open':'' ?>
               <?php echo ((activate_menu('geofence'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('geofence');?> <?php echo activate_menu('addgeofence');?> <?php echo activate_menu('geofenceevents');?>">
                  <i class="nav-icon fa fa-street-view"></i>
                  <p>
                     Geofence
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                <?php  if(userpermission('lr_geofence_add')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>geofence/addgeofence" class="nav-link <?php echo activate_menu('addgeofence');?>">
                        <i class="nav-icon fas faa-list"></i>
                        <p>Add Geofence</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_geofence_list')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>geofence" class="nav-link <?php echo activate_menu('geofence');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Geofence Management</p>
                     </a>
                  </li>
                  <?php } if(userpermission('lr_geofence_events')) { ?>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>geofence/geofenceevents" class="nav-link <?php echo activate_menu('geofenceevents');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Geofence Events</p>
                     </a>
                  </li>
                  <?php } ?>
               </ul>
            </li>
          <?php }  if(userpermission('lr_reports')) { ?>
               <li class="nav-item has-treeview <?php $reportsmenus = ['topexpense', 'topvehicles', 'toproutes', 'topincome', 'driversreport', 'incomeexpense', 'booking', 'fuels', 'couponreport','remindersreport','maintenancereport'];  foreach ($reportsmenus as $menu) { echo (activate_menu($menu) == 'active') ? 'menu-open ' : '';  } ?>">
               <a href="#" class="nav-link <?php foreach ($reportsmenus as $menu) {  echo activate_menu($menu) . ' '; }?>">
                  <i class="nav-icon fa fa-calculator" aria-hidden="true"></i>
                  <p>
                     Reports
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/booking" class="nav-link <?php echo activate_menu('booking');?>">
                        <i class="fas fa-cosg icon nav-icon"></i>
                        <p>Booking</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/incomeexpense" class="nav-link <?php echo activate_menu('incomeexpense');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Income & Expenses</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/fuels" class="nav-link <?php echo activate_menu('fuels');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Fuel</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/driversreport" class="nav-link <?php echo activate_menu('driversreport');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Driver</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/couponreport" class="nav-link <?php echo activate_menu('couponreport');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Coupon</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/remindersreport" class="nav-link <?php echo activate_menu('remindersreport');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Reminders</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/maintenancereport" class="nav-link <?php echo activate_menu('maintenancereport');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Maintenance</p>
                     </a>
                  </li>


                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/topincome" class="nav-link <?php echo activate_menu('topincome');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Top Income</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/topexpense" class="nav-link <?php echo activate_menu('topexpense');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Top Expense</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/topvehicles" class="nav-link <?php echo activate_menu('topvehicles');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Top Vehicles</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>reports/toproutes" class="nav-link <?php echo activate_menu('toproutes');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Top Routes</p>
                     </a>
                  </li>

               </ul>
            </li>
            <?php } ?>
            <?php if(userpermission('lr_employees')) { ?>      
            <li class="nav-item has-treeview <?php echo ((activate_menu('users'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('adduser'))=='active') ? 'menu-open':'' ?> <?php echo ((activate_menu('edituser'))=='active') ? 'menu-open':'' ?>">
               <a href="#" class="nav-link <?php echo activate_menu('users');?> <?php echo activate_menu('edituser');?><?php echo activate_menu('adduser');?>">
                  <i class="nav-icon fa fa-id-card"></i>
                  <p>
                  Employee                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>users" class="nav-link <?php echo activate_menu('users');?> <?php echo activate_menu('edituser');?>">
                        <i class="fas fa-cosg icon nav-icon"></i>
                        <p>Employee Management</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>users/adduser" class="nav-link <?php echo activate_menu('adduser');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Add Employee</p>
                     </a>
                  </li>
               </ul>
            </li>
            <?php } ?>  
            <?php if(userpermission('lr_settings')) { ?>
            <li class="nav-item has-treeview <?php $reportsmenus = ['backup','sms_template','websitesetting','smsconfig','websitesetting_traccar','smtpconfig','email_template','edit_email_template','frontendcontent'];  foreach ($reportsmenus as $menu) { echo (activate_menu($menu) == 'active') ? 'menu-open ' : '';  } ?>">
               <a href="#" class="nav-link <?php foreach ($reportsmenus as $menu) {  echo activate_menu($menu) . ' '; }?>">
                  <i class="nav-icon fa fa-dollar-sign"></i>
                  <p>
                     Setting's
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>settings/websitesetting" class="nav-link <?php echo activate_menu('websitesetting');?>">
                        <i class="fas fa-cosg icon nav-icon"></i>
                        <p>General Settings</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>settings/frontendcontent" class="nav-link <?php echo activate_menu('frontendcontent');?>">
                        <i class="fas fa-cosg icon nav-icon"></i>
                        <p>Website Content</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>settings/smtpconfig" class="nav-link <?php echo activate_menu('smtpconfig');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>SMTP Configuration</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>settings/email_template" class="nav-link <?php echo activate_menu('email_template');?><?php echo activate_menu('edit_email_template');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Email Template</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>settings/smsconfig" class="nav-link <?php echo activate_menu('smsconfig');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>SMS Configuration</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>settings/sms_template" class="nav-link <?php echo activate_menu('sms_template');?><?php echo activate_menu('edit_sms_template');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>SMS Template</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="<?= base_url(); ?>settings/websitesetting_traccar" class="nav-link <?php echo activate_menu('websitesetting_traccar');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>Traccar Config</p>
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="<?= base_url(); ?>backup" class="nav-link <?php echo activate_menu('backup');?>">
                        <i class="nav-icon fas faa-plus"></i>
                        <p>DB Backup</p>
                     </a>
                  </li>
               </ul>
            </li>
           
            <?php } ?>
            <li class="nav-item">
               <a href="<?= base_url(); ?>resetpassword" class="nav-link <?php echo activate_menu('resetpassword');?>">
                  <i class="nav-icon fa fa-key"></i>
                  <p>
                     Change Password
                  </p>
               </a>
            </li>
         </ul>
      </nav>
   </div>
</aside>
<script>
document.addEventListener("DOMContentLoaded", function() {
   const activeItem = document.querySelector('.nav-link.active');
   if (activeItem) {
      activeItem.scrollIntoView({
         behavior: 'smooth',
         block: 'center'
      });
   }
});
</script>
<div class="content-wrapper pb-2 mb-0">
