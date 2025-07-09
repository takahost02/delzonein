    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo (isset($incomexpensedetails))?'Edit Transactions':'Add Transactions' ?>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Transactions</a></li>
              <li class="breadcrumb-item active"><?php echo (isset($transactionsdetails))?'Edit Transactions':'Add Transactions' ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <form method="post" id="transactions" class="card basicvalidation" action="<?php echo base_url();?>accounts/<?php echo (isset($transactionsdetails))?'updatetransactions':'inserttransactions'; ?>">
    <div class="card-body">
        <div class="row">
            <?php if(isset($transactionsdetails)) { ?>
                <input type="hidden" name="id" id="id" value="<?php echo (isset($transactionsdetails)) ? $transactionsdetails[0]['id']:'' ?>" >
            <?php } ?>

            <div class="col-sm-6 col-md-3">
                <label class="form-label">Vehicles</label>
                <div class="form-group">
                    <select class="form-control select2"  name="transactionsv_id">
                        <option value="">Select Vehicle</option>
                        <?php foreach ($vechiclelist as $key => $vechiclelists) { ?>
                            <option <?php if((isset($transactionsdetails)) && $transactionsdetails[0]['v_id'] == $vechiclelists['v_id']){ echo 'selected';} ?> value="<?php echo output($vechiclelists['v_id']) ?>"><?php echo output($vechiclelists['v_name']).' - '. output($vechiclelists['v_registration_no']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Transaction Type<span class="form-required">*</span></label>
                    <select name="transaction_type" id="transaction_type" class="form-control select2" required>
                        <option value="">Select Type</option>
                        <option <?php if((isset($transactionsdetails)) && $transactionsdetails[0]['transaction_type'] == 'Credit'){ echo 'selected';} ?> value="Credit">Credit</option>
                        <option <?php if((isset($transactionsdetails)) && $transactionsdetails[0]['transaction_type'] == 'Debit'){ echo 'selected';} ?> value="Debit">Debit</option>
                    </select>
                </div>
            </div>
            
            <div class="col-sm-6 col-md-3">
                <label class="form-label">Transaction Category</label>
                <div class="form-group">
                    <select class="form-control select2"  name="cat_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($cat as $key => $cats) { ?>
                            <option <?php if((isset($transactionsdetails)) && $transactionsdetails[0]['cat_id'] == $cats['ie_cat_id']){ echo 'selected';} ?> value="<?php echo output($cats['ie_cat_id']) ?>"><?php echo output($cats['ie_cat_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label">Account<span class="form-required">*</span></label>
                <div class="form-group">
                <select id="account_id" class="form-control select2" name="account_id" required>
                        <option value="">Select Account</option>
                        <?php foreach ($account as $key => $accounts) { ?>
                            <option <?php if((isset($transactionsdetails)) && $transactionsdetails[0]['account_id'] == $accounts['id']){ echo 'selected'; } ?> value="<?php echo output($accounts['id']) ?>"><?php echo output($accounts['account_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

        
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Transaction Date<span class="form-required">*</span></label>
                    <input type="text" class="form-control datepicker" id="transaction_date" name="transaction_date" value="<?php echo (isset($transactionsdetails)) ? date('Y-m-d', strtotime($transactionsdetails[0]['transaction_date'])):'' ?>" required>
                </div>
            </div>
            
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Amount<span class="form-required">*</span></label>
                    <input type="number" class="form-control" id="amount" name="amount" value="<?php echo (isset($transactionsdetails)) ? $transactionsdetails[0]['amount']:'' ?>" required placeholder="Amount">
                </div>
            </div>
            
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Reference Number</label>
                    <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo (isset($transactionsdetails)) ? $transactionsdetails[0]['reference_number']:'' ?>" placeholder="Reference Number">
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Comments</label>
                    <textarea class="form-control" id="note" name="note" placeholder="Note"><?php echo (isset($transactionsdetails)) ? $transactionsdetails[0]['note']:'' ?></textarea>
                </div>
            </div>

          

            

          
        </div>

        <input type="hidden" id="created_date" name="created_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
        <input type="hidden" id="created_by" name="created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"> <?php echo (isset($transactionsdetails))?'Update Transaction':'Add Transaction' ?></button>
        </div>
    </div>
</form>

      </div>
    </section>
    <!-- /.content -->



