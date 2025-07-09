<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?php echo (isset($transferDetails)) ? 'Edit Transfer' : 'Add Transfer / Deposit'; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Transfers</a></li>
                    <li class="breadcrumb-item active"><?php echo (isset($transferDetails)) ? 'Edit Transfer' : 'Add Transfer / Deposit'; ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form method="post" id="transferForm" class="card basicvalidation" action="<?php echo base_url(); ?>accounts/execute_transfer">
            <div class="card-body">
                <div class="row">
                    <?php if (isset($transferDetails)) { ?>
                        <input type="hidden" name="id" id="id" value="<?php echo (isset($transferDetails)) ? $transferDetails['id'] : ''; ?>">
                    <?php } ?>

                    <div class="col-sm-6 col-md-3">
                        <label class="form-label">From Account</label>
                        <div class="form-group">
                            <select id="from_account" class="form-control select2" name="from_account" >
                                <option value="">Select From Account</option>
                                <?php foreach ($accounts as $account) { ?>
                                    <option <?php echo (isset($transferDetails) && $transferDetails['from_account'] == $account['id']) ? 'selected' : ''; ?> value="<?php echo output($account['id']); ?>"><?php echo output($account['account_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <label class="form-label">To Account<span class="form-required">*</span></label>
                        <div class="form-group">
                            <select id="to_account" class="form-control select2" name="to_account" required>
                                <option value="">Select To Account</option>
                                <?php foreach ($accounts as $account) { ?>
                                    <option <?php echo (isset($transferDetails) && $transferDetails['to_account'] == $account['id']) ? 'selected' : ''; ?> value="<?php echo output($account['id']); ?>"><?php echo output($account['account_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Amount<span class="form-required">*</span></label>
                            <input type="number" class="form-control" id="amount" name="amount" value="<?php echo (isset($transferDetails)) ? $transferDetails['amount'] : ''; ?>" required placeholder="Amount">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Date<span class="form-required">*</span></label>
                            <input type="text" class="form-control datepicker" id="transfer_date" name="transfer_date" value="<?php echo (isset($transferDetails)) ? date('Y-m-d', strtotime($transferDetails['transfer_date'])) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Reference Number</label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo (isset($transferDetails)) ? $transferDetails['reference_number'] : ''; ?>" placeholder="Reference Number">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Comments</label>
                            <textarea class="form-control" id="note" name="note" placeholder="Note"><?php echo (isset($transferDetails)) ? $transferDetails['note'] : ''; ?></textarea>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="created_date" name="created_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
                <input type="hidden" id="created_by" name="created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> <?php echo (isset($transferDetails)) ? 'Update Transfer' : 'Add Transfer'; ?></button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- /.content -->
