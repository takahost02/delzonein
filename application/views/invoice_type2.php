<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php
                if(!isset($this->session->userdata['session_data'])) {
                $url=base_url();
                header("location: $url");
              }  
                $data = sitedata();
                echo ucwords(str_replace('_', ' ', $this->uri->segment(1))).' | '.output($data['s_companyname']); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      width: 80mm; /* Adjust based on your thermal printer width */
    }
    h2 {
      font-size: 14px;
      text-align: center;
    }
    address {
      font-size: 10px;
      line-height: 1.5;
    }
    table {
      width: 90%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      padding: 4px;
      text-align: left;
      font-size: 10px;
    }
    .total th, .total td {
      padding: 5px;
      font-size: 10px;
    }
    .page-header img{
        width: 250px;
    }
    @media print {
      @page {
        margin: 0;
      }
      body {
        margin: 0;
        padding: 5mm;
      }
    }
  </style>
</head>
<body>
<div class="wrapper">
  <section class="invoice">
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <img src="<?= base_url().'assets/uploads/'.$data['s_logo'] ?>" style="max-width: 100%; height: auto;">
          <address>
          <strong><?= $data['s_companyname'] ?></strong><br>
          <?= str_replace(",", ',', $data['s_address']); ?>
        </address>
          
        </h2>
      </div>
    </div>
    <div class="row invoice-info">
      <!-- <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?= $data['s_companyname'] ?></strong><br>
          <?= str_replace(",", '<br>', $data['s_address']); ?>
        </address>
      </div> -->
      <div class="col-sm-4 invoice-col">
      <?php if(!empty($customerdetails['c_name'])) { ?>
        To
        <address>
          <strong><?= isset($customerdetails['c_name'])?$customerdetails['c_name']:''; ?></strong><br>
          <?= isset($customerdetails['c_address'])?$customerdetails['c_address']:''; ?><br>
          Phone: <?= isset($customerdetails['c_mobile'])?$customerdetails['c_mobile']:''; ?><br>
          Email: <?= isset($customerdetails['c_email'])?$customerdetails['c_email']:''; ?>
        </address>
        <?php } ?>
      </div><br>
      <div class="col-sm-4 invoice-col">
      <b>Trip Start:</b> <?= $tripdetails['t_start_date'] ?><br>
      <b>Trip End:</b> <?= $tripdetails['t_end_date'] ?><br>
      
     
        <b>Invoice #<?= output($data['s_inovice_prefix']).date('Ym').$tripdetails['t_id']; ?></b><br>
        <b>Booking ID:</b> <?php echo output($tripdetails['t_bookingid']); ?><br>

        <b>Route:</b> <?= (isset($route[0]['vr_name']))?$route[0]['vr_name']:''; ?><br>
        <b>Vechicle:</b> <?= output($vehiclename[0]['v_name']) ?><br>
        <b>Driver:</b> <?= isset($driverdetails['d_name'])?$driverdetails['d_name']:''; ?><br>
        <b>Trip Status :</b> <?= $tripdetails['t_trip_status'] ?><br>

        <b>Created Date:</b> <?= output($tripdetails['t_created_date']) ?><br>
      </div>
    </div>
    <?php
      
      ?>
    <div class="row">
      <div class="col-12 table-responsive">

      <table class="invoice-items">
            <tr>
                <th>S.No</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            <tr>        <?php $pymentdetails = get_trip_payment_details($tripdetails['t_id']);  ?>

                <td>1</td>
                <td><?= output($tripdetails['t_trip_fromlocation']) ?> <b> to </b>
                <?= output($tripdetails['t_trip_tolocation']) ?></td>
                <?php if($tripdetails['t_billingtype']=='Fixed') { ?>
                <td>1</td>
                <td><?= sitedata()['s_price_prefix'] ?><?php echo $tripdetails['t_withouttax_trip_amount'] ?></td>
                <?php } else { ?>
                <td><?php echo $tripdetails['t_qty'] ?> (<?= str_replace('Per ', '', $tripdetails['t_billingtype']); ?>)</td>
                <td><?= sitedata()['s_price_prefix'] ?><?php echo $tripdetails['t_rate'] ?></td>
                <?php } ?>
                <td><?= sitedata()['s_price_prefix'] ?><?php echo $tripdetails['t_withouttax_trip_amount'] ?></td>
            </tr>
            <?php  $totalincludeexpense = 0; $key = 2;
            if(!empty($trip_includeexpense)) {
            foreach($trip_includeexpense as $includeexpense){ ?>
            <tr class="item">
                <td><?= $key; ?></td>
                <td><?php echo output($includeexpense['te_expense_for']); ?></td>
                <td>1</td>
                <td><?= sitedata()['s_price_prefix'] ?><?php echo $includeexpense['te_amount'] ?></td>
                <td><?= sitedata()['s_price_prefix'] ?><?php echo $includeexpense['te_amount'] ?></td>
            </tr>
            <?php $totalincludeexpense += $includeexpense['te_amount'];  $key++; }
            } 
            ?>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Subtotal</td>
                <td><?= sitedata()['s_price_prefix'] ?><?php echo $pymentdetails['t_withouttax_trip_amount']+ $pymentdetails['total_expenses']; ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Tax (<?php echo $pymentdetails['t_trip_tax'] ?>%)</td>
                <td><?= sitedata()['s_price_prefix'] ?><?php if($pymentdetails['t_trip_tax']!='') { echo round($pymentdetails['t_withouttax_trip_amount']*$pymentdetails['t_trip_tax']/100); } ?></td>
            </tr>
            <?php if($pymentdetails['t_discountamount']!='') { ?>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Discount</td>
                <td style="width: 20%;"><?= sitedata()['s_price_prefix'] ?><?php echo $pymentdetails['t_discountamount'] ?></td>
            </tr>
            <?php } ?>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total</td>
                <td><?= sitedata()['s_price_prefix'] ?><?php echo $pymentdetails['totalamount'] ?></td>
            </tr>
        </table>
      </div>

      <div class="col-6">
        <p class="text-muted">
          <?= output($data['s_inovice_termsandcondition']) ?>
        </p>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript"> 
  window.addEventListener("load", function() {
   //window.print();
  });
</script>
</body>
</html>
