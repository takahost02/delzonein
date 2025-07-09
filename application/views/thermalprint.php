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
      font-size: 16px;
      text-align: center;
    }
    address {
      font-size: 12px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: none;
      padding: 5px;
      text-align: left;
      font-size: 12px;
    }
    th {
      background-color: #f2f2f2;
    }
    .total {
      margin-top: 10px;
    }
    @media print {
      @page {
        margin: 0;
      }
      body {
        margin: 10mm;
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
          <small class="float-right">Date: <?= date('Y-m-d') ?></small>
        </h2>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?= $data['s_companyname'] ?></strong><br>
          <?= str_replace(",", '<br>', $data['s_address']); ?>
        </address>
      </div>
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
      </div>
      <div class="col-sm-4 invoice-col">
        <b>Invoice #<?= output($data['s_inovice_prefix']).date('Ym').$tripdetails['t_id']; ?></b><br>
        <b>Order ID:</b> <?= output($tripdetails['t_id']) ?><br>
        <b>Payment Due:</b> <?= date('Y-m-d') ?><br>
      </div>
    </div>
    <?php
      $totalpaidamt = 0;
      if(count($paymentdetails)>=1) {
      foreach ($paymentdetails as $payment) {
          $totalpaidamt += $payment['tp_amount'];
      } }
      ?>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Qty</th>
              <th>Service</th>
              <th>Description</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td><?= output($data['s_inovice_servicename']) ?></td>
              <td>From <br> <?= $tripdetails['t_trip_fromlocation']; ?> <br> to <br><?= $tripdetails['t_trip_tolocation']; ?></td>
              <td><?= output($data['s_price_prefix']).$tripdetails['t_trip_amount'] ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-6">
        <p class="text-muted">
          <?= output($data['s_inovice_termsandcondition']) ?>
        </p>
      </div>
      <div class="col-6">
        <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td><?= output($data['s_price_prefix']).$tripdetails['t_trip_amount'] ?></td>
          </tr>
          <tr>
            <th>Paid:</th>
            <td><?= output($data['s_price_prefix']).$totalpaidamt ?></td>
          </tr>
          <?php if($tripdetails['t_trip_amount'] - $totalpaidamt != 0) { ?>
          <tr>
            <th><?= ($tripdetails['t_trip_amount'] > $totalpaidamt) ? 'Pending' : 'Excess' ?>:</th>
            <td><?= output($data['s_price_prefix']).preg_replace('/[^\d\.]+/', '', $tripdetails['t_trip_amount'] - $totalpaidamt) ?></td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript"> 
  window.addEventListener("load", function() {
    window.print();
  });
</script>
</body>
</html>
