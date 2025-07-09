<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Trips Details - <?php echo $tripdetails['t_bookingid']; ?> 
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
               <li class="breadcrumb-item active">Trips Details</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="card">
         <?php
            $totalpaidamt = 0;
            if(count($paymentdetails)>=1) {
            foreach ($paymentdetails as $payment) {
                $totalpaidamt += $payment['amount'];
            } }
            $pymentdetails = get_trip_payment_details($tripdetails['t_id']);
            ?>
         <div class="card-body">
            <div class="row">
               <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                  <div class="row">
                     <?php if($tripdetails['t_trip_fromlocation']!='' && $tripdetails['t_trip_tolocation']!='') {     
                        $stops = ($tripdetails['t_trip_stops']!='')?json_decode($tripdetails['t_trip_stops'], true):'';
                        ?>
                     <div class="col-lg-12">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <div class="bus-stop-timeline">
                                 <div class="bus-stop-line"></div>
                                 <div class="bus-stop">
                                    <i class="fa fa-map-marker stop-marker" aria-hidden="true"></i>
                                    <div class="stop-label"> <?php echo $tripdetails['t_trip_fromlocation']; ?><br><span style="font-size: 9px;"><?= $tripdetails['t_start_date'] ?></span>
                                    </div>
                                 </div>
                                 <?php if (!empty($stops)) { foreach ($stops as $stop) { ?>
                                 <div class="bus-stop">
                                    <i class="fa fa-map-marker stop-marker" aria-hidden="true"></i>
                                    <div class="stop-label"><?php echo $stop; ?></div>
                                 </div>
                                 <?php } } ?>  
                                 <div class="bus-stop">
                                    <i class="fa fa-map-marker stop-marker" aria-hidden="true"></i>
                                    <div class="stop-label"><?php echo $tripdetails['t_trip_tolocation']; ?> <br><span style="font-size: 9px;"><?= $tripdetails['t_start_date'] ?></span></div>
                                 </div>
                              </div>
                              <span>Total Distance : <?php echo $tripdetails['t_totaldistance']; ?>  </span>  
                           </div>
                        </div>
                     </div>
                     <?php } ?>
                     <div class="col">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">Subtotal</span>
                              <span class="info-box-number text-center text-muted mb-0"><?= sitedata()['s_price_prefix'] ?><?= $pymentdetails['t_withouttax_trip_amount']; ?> </span>
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">Tax</span>
                              <span class="info-box-number text-center text-muted mb-0"><?php if($tripdetails['t_trip_tax']!='0.00') { echo sitedata()['s_price_prefix'] ?><?= $tripdetails['t_trip_final_amount'] - $tripdetails['t_withouttax_trip_amount']; } else { echo '-';} ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">Discount</span>
                              <span class="info-box-number text-center text-muted mb-0"><?= ($pymentdetails['t_discountamount']!='')? sitedata()['s_price_prefix'].$pymentdetails['t_discountamount']:'-'  ?>               
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">Trip + Expense</span>
                              <span class="info-box-number text-center text-muted mb-0"><?= sitedata()['s_price_prefix'] ?><?= $tripamount = $pymentdetails['t_trip_final_amount'] +  $pymentdetails['total_expenses']; ?>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="col">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">Paid Amount</span>
                              <span class="info-box-number text-center text-muted mb-0"><?= sitedata()['s_price_prefix'] ?><?= $totalpaidamt; ?></span>
                           </div>
                        </div>
                     </div>
                     <?php if($pymentdetails['totalamount']-$totalpaidamt !=0) { ?>
                     <div class="col">
                        <div class="info-box bg-light">
                           <div class="info-box-content">
                              <span class="info-box-text text-center text-muted"><?= (($pymentdetails['totalamount']-$totalpaidamt) < $totalpaidamt)?'Excess':'Pending' ?></span>
                              <span class="info-box-number text-center text-muted mb-0"><?= sitedata()['s_price_prefix'] ?><?php echo abs($pymentdetails['totalamount']-$totalpaidamt); ?> <span>
                              </span></span>
                           </div>
                        </div>
                     </div>
                     <?php } ?>
                     <div class="col-lg-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                           <div class="card-header p-0 border-bottom-0">
                              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                 <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#tripexpense" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Trip Expense</a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Payment Log</a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Email Log</a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">SMS Log</a>
                                 </li>
                              </ul>
                           </div>
                           <div class="card-body">
                              <div class="tab-content" id="custom-tabs-four-tabContent">

                                 <div class="tab-pane fade show active" id="tripexpense" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                 <div class="post clearfix">
                                       <?php if(!empty($trip_expenses)) { ?>
                                       <table class="table table-bordered table-sm  table-hover text-center align-middle">
                                          <thead>
                                             <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Expense For</th>
                                                <th>Amount</th>
                                                <th>Notes</th>
                                                <th>Added to Customer Bill</th>
                                                <th>#</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $count=1;
                                                foreach($trip_expenses as $trip_expenses){ ?>
                                             <tr>
                                                <td><?php echo output($count); $count++; ?></td>
                                                <td><?php echo output($trip_expenses['te_expense_date']); ?></td>
                                                <td><?php echo output($trip_expenses['te_expense_for']); ?></td>
                                                <td><?php echo output($trip_expenses['te_amount']); ?></td>
                                                <td><?php echo output($trip_expenses['te_notes']); ?></td>
                                                
                                                <td><span class="badge <?php echo ($trip_expenses['te_includetocustomer']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($trip_expenses['te_includetocustomer']=='1') ? 'Yes' : 'No'; ?></span>  
                                                </td>
                                              
                                                <td>
                                                   <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>trips/deletetripexpense/','<?php echo output($trip_expenses['te_id']); ?>')" data-target="#deleteconfirm" class="icon">
                                                      <i class="fa fa-trash text-danger"></i>
                                                </td>
                                             </tr>
                                             <?php } ?>
                                          </tbody>
                                       </table>
                                       <?php 
                                          }  
                                          else
                                          {
                                          echo '<div class="callout callout-warning"><p>No trip expense details found !.</p></div>
                                          ';
                                          }
                                          ?>
                                    </div>
                                 </div>


                                 <div class="tab-pane fade" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="post clearfix">
                                       <?php if(!empty($paymentdetails)) { ?>
                                       <table class="table table-bordered table-sm  table-hover text-center align-middle">
                                          <thead>
                                             <tr>
                                                <th>#</th>
                                                <th>Account</th>
                                                <th>Amount</th>
                                                <th>Comments</th>
                                                <th>Paid On</th>
                                                <th>#</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $count=1;
                                                foreach($paymentdetails as $paymentdetails){ ?>
                                             <tr>
                                                <td><?php echo output($count); $count++; ?></td>
                                                <td><?php echo output($paymentdetails['account_name']); ?></td>
                                                <td><?php echo output($paymentdetails['amount']); ?></td>
                                                <td><?php echo output($paymentdetails['reference_number']); ?></td>
                                                <td><?php echo output($paymentdetails['transaction_date']); ?></td>
                                                <td>
                                                   <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>accounts/deletetransactions/','<?php echo output($paymentdetails['id']); ?>')" data-target="#deleteconfirm" class="icon">
                                                      <i class="fa fa-trash text-danger"></i>
                                                </td>
                                             </tr>
                                             <?php } ?>
                                          </tbody>
                                       </table>
                                       <?php 
                                          }  
                                          else
                                          {
                                          echo '<div class="callout callout-warning"><p>No payment details found !.</p></div>
                                          ';
                                          }
                                          ?>
                                    </div>
                                 </div>
                                 <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                
                                 <div class="post clearfix">
                                       <?php if(!empty($email_log)) { ?>
                                       <table class="table table-bordered table-sm  table-hover text-center align-middle">
                                          <thead>
                                             <tr>
                                                <th>#</th>
                                                <th>Content</th>
                                                <th>Status</th>
                                                <th>Send Date</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $count=1;
                                                foreach($email_log as $email_log){ ?>
                                             <tr>
                                                <td><?php echo output($count); $count++; ?></td>
                                                <td><?php echo output($email_log['content']); ?></td>
                                                <td><span class="badge <?php echo ($email_log['status']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($email_log['status']=='1') ? 'Send' : 'Failed'; ?></span>  
                                                </td>
                                                <td><?php echo date(datetimeformat(), strtotime($email_log['created_at'])); ?> </td>
                                             </tr>
                                             <?php } ?>
                                          </tbody>
                                       </table>
                                       <?php 
                                          }  
                                          else
                                          {
                                          echo '<div class="callout callout-warning"><p>Email log not found !.</p></div>
                                          ';
                                          }
                                          ?>
                                    </div>

                                 </div>
                                 <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                 <div class="post clearfix">
                                       <?php if(!empty($sms_log)) { ?>
                                       <table class="table table-bordered table-sm  table-hover">
                                          <thead>
                                             <tr>
                                                <th>#</th>
                                                <th style="width: 65%;">Content</th>
                                                <th>SMS Status</th>
                                                <th>Send Date</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $count=1;
                                                foreach($sms_log as $sms_log){ ?>
                                             <tr>
                                                <td><?php echo output($count); $count++; ?></td>
                                                <td><?php echo ($sms_log['status']=='1') ? $sms_log['content'] : $sms_log['error_description']; ?> </td>
                                                <td><span class="badge <?php echo ($sms_log['status']=='1') ? 'badge-success' : 'badge-danger'; ?> "><?php echo ($sms_log['status']=='1') ? 'Send' : 'Failed'; ?></span>  
                                                </td>
                                                <td><?php echo date(datetimeformat(), strtotime($sms_log['created_at'])); ?> </td>
                                             </tr>
                                             <?php } ?>
                                          </tbody>
                                       </table>
                                       <?php 
                                          }  
                                          else
                                          {
                                          echo '<div class="callout callout-warning"><p>Email log not found !.</p></div>
                                          ';
                                          }
                                          ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- /.card -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
               <div class="mt-2 mb-3 d-flex flex-wrap">
               <a href="#" 
                  class="btn btn-sm btn-success <?= round(($tripdetails['t_trip_final_amount'] + (($trip_includeexpense != '') ? $trip_includeexpense : 0)) - $totalpaidamt==0) ? 'disabled' : '' ?> mx-1" 
                  data-toggle="modal" 
                  data-target="#modal-AddPayment">
                  Add Payment
               </a>
               <a href="#" 
                  class="btn btn-sm btn-success mx-1" 
                  data-toggle="modal" 
                  data-target="#modal-tripexpense">
                  Trip Expense
               </a>
               <a href="#" data-toggle="modal" data-target="#smsModal"
                  class="btn btn-sm btn-success mx-1">
                  Send SMS
               </a>
               <a href="#" data-toggle="modal" data-target="#emailModal"
                  class="btn btn-sm btn-success mx-1">
                  Send Email
               </a>
               <a style="margin-top: 6px;" href="<?= base_url(); ?>trips/invoice/<?= encodeid($tripdetails['t_id']); ?>" 
                  target="_blank" 
                  class="btn btn-sm btn-success mx-1">
                  Generate Invoice
               </a>
            </div>

               <br>
               <div class="text-muted">
               <p class="text-sm">Customer Info
               <?php if(!empty($customerdetails['c_name'])) { ?>
               <b class="d-block"><?= isset($customerdetails['c_name'])?$customerdetails['c_name']:''; ?></b>
               <b class="d-block"><?= isset($customerdetails['c_mobile'])?$customerdetails['c_mobile']:''; ?></b>
               <b class="d-block"><?= isset($customerdetails['c_email'])?$customerdetails['c_email']:''; ?></b>
               <b class="d-block"><?= isset($customerdetails['c_address'])?$customerdetails['c_address']:''; ?></b>
               <?php } else { echo '<b class="d-block"><span class="badge badge-danger">Not selected</span></b>'; } ?>
               </p> 
               <p class="text-sm">Driver Info
               <?php if(isset($driverdetails['d_name'])) { ?>
               <b class="d-block"><?= $driverdetails['d_name']; ?></b>
               <b class="d-block"><?= $driverdetails['d_mobile']; ?></b>
               <b class="d-block"><?= $driverdetails['d_licenseno']; ?></b>
               <?php  } else { echo '<b class="d-block"><span class="badge badge-danger">Yet to Assign</span></b>'; } ?>
               </p>
               <p class="text-sm">Tracking URL
               <b class="d-block"><a target="_new" href="<?= base_url().'triptracking/'.$tripdetails['t_trackingcode']; ?>"><?= base_url().'triptracking/'.$tripdetails['t_trackingcode']; ?></a></b>
               </p>
             
               </div>
               </div>
            </div>
         </div>
         <!-- /.card-body -->
      </div>
   </div>
</section>
<div class="modal fade show" id="modal-AddPayment" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Make Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" id="trippayments" action="<?= base_url() ?>trips/trippayment" method="post">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="totalamount" class="col-sm-4 col-form-label">Category</label>
                     <div class="col-sm-8">
                        <select class="form-control select2" name="cat_id" style="width: 100%;" required>
                           <option value="">Select Category</option>
                           <?php foreach ($cat as $key => $cats) { ?>
                           <option <?php if((isset($transactionsdetails)) && $transactionsdetails[0]['cat_id'] == $cats['ie_cat_id']){ echo 'selected';} ?> value="<?php echo output($cats['ie_cat_id']) ?>"><?php echo output($cats['ie_cat_name']); ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="totalamount" class="col-sm-4 col-form-label">Total Amount</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="totalamount" value="<?= $pymentdetails['t_trip_final_amount'] +  $pymentdetails['total_expenses']; ?>" id="totalamount" placeholder="Enter totalamount" disabled>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="paidamount" class="col-sm-4 col-form-label">Pending Amount</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="pendingamount" value="<?= round(($pymentdetails['totalamount']-$totalpaidamt)); ?>" id="pendingamount" placeholder="Paid Amount" disabled>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="totalamount" class="col-sm-4 col-form-label">Account</label>
                     <div class="col-sm-8">
                        <select id="account_id" class="form-control" name="account_id" required>
                           <option value="">Select Account</option>
                           <?php foreach ($account as $key => $accounts) { ?>
                           <option <?php if((isset($transactionsdetails)) && $transactionsdetails[0]['account_id'] == $accounts['id']){ echo 'selected'; } ?> value="<?php echo output($accounts['id']) ?>"><?php echo output($accounts['account_name']); ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="transaction_date" class="col-sm-4 col-form-label">Transaction Date</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control datepicker" name="transaction_date" required id="transaction_date" placeholder="Date">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="tp_amount" class="col-sm-4 col-form-label">Pay</label>
                     <div class="form-group col-sm-8">
                        <input type="text" class="form-control" name="amount" id="amount" required placeholder="Pay">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="tp_notes" class="col-sm-4 col-form-label">Notes/Ref</label>
                     <div class="form-group col-sm-8">
                        <textarea class="form-control" id="reference_number" name="reference_number" rows="2" placeholder="Enter Notes"></textarea>
                     </div>
                  </div>
               </div>
               <input type="hidden" class="form-control" value="Credit" name="transaction_type" id="transaction_type">
               <input type="hidden" class="form-control" value="<?= $tripdetails['t_id']; ?>" name="trip_id" id="trip_id" placeholder="v_id">
               <input type="hidden" class="form-control" value="<?= $tripdetails['t_vechicle']; ?>" name="transactionsv_id" id="transactionsv_id" placeholder="trip_id">
               <input type="hidden" id="created_by" name="created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Payment</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade show" id="modal-tripexpense" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Trip Expense</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" id="addtripexpense" action="<?= base_url() ?>trips/addtripexpense" method="post">
               <div class="card-body">
                  <div class="form-group row">
                     <label for="ie_amount" class="col-sm-4 col-form-label">Date</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" required="true" name="te_expense_date" id="te_expense_date" placeholder="Expense Date">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="ie_amount" class="col-sm-4 col-form-label">Expense For</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" required="true" name="te_expense_for" id="te_expense_for" placeholder="Expense Details">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="te_amount" class="col-sm-4 col-form-label">Amount</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" pattern="^[0-9]*$" required="true" name="te_amount" id="te_amount" placeholder="Enter amount">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="te_notes" class="col-sm-4 col-form-label">Notes</label>
                     <div class="form-group col-sm-8">
                        <textarea class="form-control" required="true" id="te_notes" name="te_notes" rows="2" placeholder="Enter Notes"></textarea>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="te_amount" class="col-sm-4 col-form-label">Options</label>
                     <div class="col-sm-8">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="te_includetocustomer" id="te_includetocustomer" value="1">
                           <label class="form-check-label" for="te_includetocustomer">
                           Need to Include in Customer Bill
                           </label>
                        </div>
                        <!-- <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="te_showinvoice" id="te_showinvoice" value="1">
                           <label class="form-check-label" for="te_showinvoice">
                           Need to Show in Invoice
                           </label>
                        </div> -->
                     </div>
                  </div>
               </div>
               <input type="hidden" id="te_created_at" name="te_created_at" value="<?php echo date('Y-m-d h:i:s'); ?>">
               <input type="hidden" class="form-control" value="<?= $tripdetails['t_vechicle']; ?>" name="te_vehicle_id" id="te_vehicle_id">
               <input type="hidden" class="form-control" value="<?= (isset($driverdetails['d_id']))?$driverdetails['d_id']:''; ?>" name="te_driver_id" id="te_driver_id">
               <input type="hidden" class="form-control" value="<?= $tripdetails['t_id']; ?>" name="te_trip_id" id="te_trip_id">
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Expense</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="smsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smsModalLabel">Send SMS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="smsForm" method="post" action="<?= base_url('trips/sendsms'); ?>">
                <div class="modal-body">
                <input type="hidden" value="<?= $tripdetails['t_id']; ?>" class="form-control" id="t_id" name="t_id" >

                    <div class="form-group">
                        <label for="mobile_number">Mobile Number</label>
                        <input type="text" value="<?= $customerdetails['c_mobile']; ?>" class="form-control" id="mobile_number" name="mobile_number" required>
                    </div>

                    <div class="form-group">
                     <label for="template">Select Template</label>
                     <select class="form-control" id="template" name="template">
                        <option value="">Select a Template</option>
                     </select>
                  </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="smsmessage" name="smsmessage" rows="5" maxlength="160" required></textarea>
    <small id="charCount" class="form-text text-muted">0/160 characters used</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send SMS</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="emailForm" class="form-horizontal" method="post" action="<?= base_url('trips/customemail'); ?>">
    <div class="modal-body">
        <input type="hidden" value="<?= $tripdetails['t_id']; ?>" id="t_id" name="t_id">
        <input type="hidden"  id="emailname" name="emailname">

        <div class="form-row align-items-center">
            <div class="form-group col-md-6">
                <label for="email">Customer Email</label>
                <input type="email"value="<?= $customerdetails['c_email']; ?>" class="form-control" id="email" name="email" placeholder="Enter email" required
                >
            </div>
            <div class="form-group col-md-6">
                <label for="emailtemplate">Select Template</label>
                <select class="form-control" id="emailtemplate" name="emailtemplate" required>
                    <option value="">Select a Template</option>
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="emailsubject">Subject</label>
                <input type="text" class="form-control" id="emailsubject" name="emailsubject" placeholder="Enter subject" required>
            </div>
        </div>

        <!-- Message -->
        <div class="form-group">
            <label for="emailmessage">Message</label>
            <textarea class="form-control" id="emailmessage" name="emailmessage" rows="10" placeholder="Enter your message" required></textarea>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send Email</button>
    </div>
</form>

        </div>
    </div>
</div>

<script>
    document.getElementById('smsmessage').addEventListener('input', function () {
        const maxLength = 160;
        const currentLength = this.value.length;
        document.getElementById('charCount').textContent = `${currentLength}/${maxLength} characters used`;
    });

$(document).ready(function () {
      $.ajax({
         url: '<?= base_url('trips/get_sms_templates'); ?>',
         method: 'GET',
         dataType: 'json',
         success: function (data) {
               var templateDropdown = $('#template');
               templateDropdown.empty().append('<option value="">Select a Template</option>');
               $.each(data, function (key, template) {
                  templateDropdown.append(
                     `<option value="${template.st_body}">${template.st_name}</option>`
                  );
               });
         }
      });
      $('#template').on('change', function () {
         var templateBody = $(this).val();
         $('#smsmessage').val(templateBody);
         updateCharCount(); 
      });
      $('#smsmessage').on('input', function () {
         updateCharCount();
      });
      function updateCharCount() {
         var charCount = $('#smsmessage').val().length;
         $('#charCount').text(`${charCount}/160 characters used`);
      }

      $.ajax({
         url: '<?= base_url('trips/get_email_templates'); ?>',
         method: 'GET',
         dataType: 'json',
         success: function (data) {
               var templateDropdown = $('#emailtemplate');
               templateDropdown.empty().append('<option value="">Select a Template</option>');
               $.each(data, function (key, template) {
                  templateDropdown.append(
                     `<option data-name="${template.et_name}" value="${template.et_body}">${template.et_subject}</option>`
                  );
               });
         }
      });
      $('#emailtemplate').on('change', function () {
         var templateBody = $(this).val();
         $('#emailsubject').val($(this).find('option:selected').text());
         $('#emailname').val($(this).find('option:selected').data('name'));
         $('#emailmessage').val(templateBody);
      });


});


</script>
<style>
   /* Styling the bus stop timeline container */
   .bus-stop-timeline {
   display: flex;
   align-items: center;
   justify-content: space-between;
   margin: 12px auto;
   position: relative;
   padding: 20px;
   max-width: 800px;
   }
   /* Styling each bus stop */
   .bus-stop {
   position: relative;
   z-index: 2;
   text-align: center;
   flex: 1;
   }
   /* Font Awesome marker icon as the stop */
   .bus-stop .stop-marker {
   font-size: 24px;
   color: #5c95d2;
   margin-bottom: 10px;
   }
   /* Labels for bus stops */
   .bus-stop .stop-label {
   font-size: 14px;
   color: #333;
   }
</style>