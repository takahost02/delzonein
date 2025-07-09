<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Accounts Management
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
                        <i class="fa fa-plus"></i>
                    </button>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Accounts Management</li>
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
                    <table class="table card-table datatableexport">
                        <thead>
                            <tr>
                                <th class="w-1">S.No</th>
                                <th>Account Name</th>
                                <th>Balance</th>
                                <th>Created By</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($accountslist)) {  
                                $count = 1;
                                foreach($accountslist as $account) { ?>
                                    <tr>
                                        <td><?php echo output($count); $count++; ?></td>
                                        <td><?php echo output($account['account_name']); ?></td>
                                        <td><?php echo output($account['balance']); ?></td>
                                        <td><?php echo output(strtoupper($account['u_name'])); ?></td>
                                        <td><?php echo output($account['created_date']); ?></td>
                                        <td><span class="badge <?php echo ($account['status'] == 1) ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo ($account['status'] == 1) ? 'Active' : 'Inactive'; ?>
                                        </span></td>  
                                        <td>
                                        <a class="icon edit-account" 
                                            href="javascript:void(0);" 
                                            data-id="<?php echo $account['id']; ?>"
                                            data-name="<?php echo $account['account_name']; ?>"
                                            data-status="<?php echo $account['status']; ?>">
                                                <i class="fa fa-edit"></i>
                                            </a> |
                                            <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>accounts/delete/','<?php echo output($account['id']); ?>')" data-target="#deleteconfirm" class="icon">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>         
            </div>
        </div>
    </div>
</section>

<div class="modal fade show" id="modal-add" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Account</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="accountsave" method="post" action="<?php echo base_url(); ?>accounts/add">
                    <div class="card-body">
                        

                        <div class="form-group row">
                            <label for="account_name" class="col-sm-4 col-form-label">Account Name</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo (isset($accdetails)) ? $accdetails[0]['account_name']:'' ?>" class="form-control" name="account_name" id="account_name" required placeholder="Enter Account Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="balance" class="col-sm-4 col-form-label">Balance</label>
                            <div class="col-sm-8">
                                <input type="number" value="<?php echo (isset($accdetails)) ? $accdetails[0]['balance']:'' ?>" class="form-control" name="balance" id="balance" step="0.0001" required placeholder="Enter Opening Balance">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select id="status" class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option <?php echo (isset($accdetails) && $accdetails[0]['status']==1) ? 'selected':'' ?>  value="1">Active</option>
                                    <option <?php echo (isset($accdetails) && $accdetails[0]['status']==0) ? 'selected':'' ?> value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <input type="hidden" id="created_by" name="created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">
            <input type="hidden" id="created_date" name="created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" id="accountsave" class="btn btn-primary">Save</button>
            </div>
                </form>
        </div>
    </div>
</div>


<!-- Edit/Add Modal -->
<div class="modal fade show" id="modal-edit" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Account Management</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="accountsave" method="post" action="<?php echo base_url(); ?>accounts/update">
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="account_name" class="col-sm-4 col-form-label">Account Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="account_name" id="edit_account_name" required placeholder="Enter Account Name">
                            </div>
                        </div>

                       

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select id="edit_status" class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields for Editing -->
                    <input type="hidden" id="edit_account_id" name="id">
                    <input type="hidden" id="created_by" name="created_by" value="<?php echo output($this->session->userdata['session_data']['u_id']); ?>">
                    <input type="hidden" id="created_date" name="created_date" value="<?php echo date('Y-m-d h:i:s'); ?>">

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" id="accountsave" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    $('.addaccountmodel').on('click', function() {
        $('#modal-add').modal('show');
    });

    $('.edit-account').on('click', function() {
        let accountId = $(this).data('id');
        let accountName = $(this).data('name');
        let status = $(this).data('status');
        $('#edit_account_id').val(accountId);
        $('#edit_account_name').val(accountName);
        $('#edit_status').val(status);
        $('#modal-edit').modal('show');
    });
});
</script>
