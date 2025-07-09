<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    if(!isset($this->session->userdata['session_data'])) {
    $url=base_url();
    header("location: $url");
  }  
    $data = sitedata();
    echo ucwords(str_replace('_', ' ', $this->uri->segment(1))).' | '.output($data['s_companyname']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            color: #555;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
            color: #333;
        }
        .invoice-header img{
            width: 250px;
        }
        .invoice-details, .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-details th, .invoice-details td,
        .invoice-items th, .invoice-items td {
            border: 1px solid #eee;
            padding: 8px;
            text-align: left;
        }
        .invoice-items th {
            background-color: #f5f5f5;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-header">
        <img src="<?= base_url().'assets/uploads/'.$data['s_logo'] ?>" alt="Company Logo" >
            <h1>Invoice</h1>
            <p>Invoice #<?= output($data['s_inovice_prefix']).date('Ym').$tripdetails['t_id']; ?> | Date: <?= output($tripdetails['t_created_date']) ?></p>
        </div>

        <table class="invoice-details">
            <tr>
                <th>From:</th>
                <th>To:</th>
            </tr>
            <tr>
                <td>
                <strong><?= $data['s_companyname'] ?></strong><br>
                            <?= isset($data['s_address']) 
                                  ? htmlspecialchars(strtok($data['s_address'], ',')) . ', ' . 
                                    implode('<br>', array_map('htmlspecialchars', explode(',', substr($data['s_address'], strpos($data['s_address'], ',') + 1)))) 
                                  : ''; ?><br>
                                  <b>Phone: </b><?= isset($data['s_phoneno'])?$data['s_phoneno']:''; ?><br>
                                  <b>Email: </b><?= isset($data['s_email'])?$data['s_email']:''; ?>
                </td>
                <td>
                <?php if(!empty($customerdetails['c_name'])) { ?>
                    <strong><?= isset($customerdetails['c_name'])?$customerdetails['c_name']:''; ?></strong><br>
                <?= isset($customerdetails['c_address']) 
                ? htmlspecialchars(strtok($customerdetails['c_address'], ',')) . ', ' . 
                implode('<br>', array_map('htmlspecialchars', explode(',', substr($customerdetails['c_address'], strpos($customerdetails['c_address'], ',') + 1)))) 
                : ''; ?><br>

                <b>Phone: </b><?= isset($customerdetails['c_mobile'])?$customerdetails['c_mobile']:''; ?><br>
                <b>Email: </b><?= isset($customerdetails['c_email'])?$customerdetails['c_email']:''; ?>
            
            <?php } ?>
               
                </td>
            </tr>
        </table>

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

        <p class="footer">
        <?= sitedata()['s_inovice_termsandcondition']; ?>

        </p>
    </div>
</body>
</html>
