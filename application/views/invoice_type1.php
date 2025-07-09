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
        margin: 0;
        padding: 20px;
        color: #333;
    }
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
        line-height: 24px;
        color: #555;
    }
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-collapse: collapse;
    }
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    .invoice-box table tr.top table td.title img{
        width: 250px;
    }
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    .invoice-box table td.sno {
        width: 10%; /* Adjust the width as per your requirement */
        text-align: center;
    }
</style>
</head>
<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="<?= base_url().'assets/uploads/'.$data['s_logo'] ?>" alt="Company Logo" style="width:50%; max-width:150px;">
                        </td>
                        <td>
                            Invoice #: <?= output($data['s_inovice_prefix']).date('Ym').$tripdetails['t_id']; ?><br>
                            Created: <?= output($tripdetails['t_created_date']) ?><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            <?php if(!empty($customerdetails['c_name'])) { ?>
                                 <?= isset($customerdetails['c_name'])?$customerdetails['c_name']:''; ?><br>
                                 <?= isset($customerdetails['c_address']) 
                                  ? htmlspecialchars(strtok($customerdetails['c_address'], ',')) . ', ' . 
                                    implode('<br>', array_map('htmlspecialchars', explode(',', substr($customerdetails['c_address'], strpos($customerdetails['c_address'], ',') + 1)))) 
                                  : ''; ?><br>

                                  <b>Phone: </b><?= isset($customerdetails['c_mobile'])?$customerdetails['c_mobile']:''; ?><br>
                                  <b>Email: </b><?= isset($customerdetails['c_email'])?$customerdetails['c_email']:''; ?>
                               
                                <?php } ?>
                        </td>
                        <td>
                            <?= $data['s_companyname'] ?><br>
                            <?= isset($data['s_address']) 
                                  ? htmlspecialchars(strtok($data['s_address'], ',')) . ', ' . 
                                    implode('<br>', array_map('htmlspecialchars', explode(',', substr($data['s_address'], strpos($data['s_address'], ',') + 1)))) 
                                  : ''; ?><br>
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php $pymentdetails = get_trip_payment_details($tripdetails['t_id']);  ?>
        <tr class="heading">
            <!-- <td>S.No</td> -->
            <td>Item / Services</td>
            <td>Price</td>
        </tr>
        <tr class="item">
            <!-- <td>1</td> -->
            <td><?= output($tripdetails['t_trip_fromlocation']) ?> <b> to </b>
            <?= output($tripdetails['t_trip_tolocation']) ?></td>
             <td><?= sitedata()['s_price_prefix'] ?><?php echo $pymentdetails['t_withouttax_trip_amount'] ?></td>
        </tr>
        <?php  $totalincludeexpense = 0; $key = 2;
        if(!empty($trip_includeexpense)) {
          foreach($trip_includeexpense as $includeexpense){ ?>
           <tr class="item">
            <!-- <td><?= $key; ?></td> -->
            <td><?php echo output($includeexpense['te_expense_for']); ?></td>
            <td><?= sitedata()['s_price_prefix'] ?><?php echo $includeexpense['te_amount'] ?></td>
        </tr>
         <?php $totalincludeexpense += $includeexpense['te_amount'];  $key++; }
        } 
        ?>

        <tr class="item">
            <td style="float:right">Subtotal</td>
            <td style="width: 20%;"><?= sitedata()['s_price_prefix'] ?><?php echo $pymentdetails['t_withouttax_trip_amount']+ $pymentdetails['total_expenses']; ?></td>
        </tr>
        
        <?php if($pymentdetails['t_trip_tax']!='') { ?>
        <tr class="item">
            <td style="float:right">Tax (<?php echo $pymentdetails['t_trip_tax'] ?>%)</td>
            <td style="width: 20%;"><?= sitedata()['s_price_prefix'] ?><?php if($pymentdetails['t_trip_tax']!='') { echo round($pymentdetails['t_withouttax_trip_amount']*$pymentdetails['t_trip_tax']/100); } ?></td>
        </tr>
        <?php } ?>
        <?php if($pymentdetails['t_discountamount']!='') { ?>
        <tr class="item">
            <td style="float:right">Discount</td>
            <td style="width: 20%;"><?= sitedata()['s_price_prefix'] ?><?php echo $pymentdetails['t_discountamount'] ?></td>
        </tr>
        <?php } ?>

        <tr class="total">
            <td style="float:right"><b>Total</b></td>
            <td style="width: 20%;"><?= sitedata()['s_price_prefix'] ?><?php echo $pymentdetails['totalamount'] ?></td>
        </tr>
    </table>
    <p class="footer"> <?= sitedata()['s_inovice_termsandcondition']; ?>
        </p>
</div>
</body>
</html>
