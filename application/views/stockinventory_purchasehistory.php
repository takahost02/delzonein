<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Parts Stock Inventory</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Stock Inventory</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table card-table datatableexport">
                        <thead>
                            <tr>
                                <th class="w-1">S.No</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Stock</th>
                                <th>Purchase From</th>
                                <th>Price</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($stockinventorylist)) {  
                                $count = 1;
                                foreach($stockinventorylist as $si) { ?>
                                    <tr>
                                        <td><?php echo output($count); $count++; ?></td>
                                        <td><?php echo output($si['sh_date']); ?></td>
                                        <td><?php echo output($si['s_name']); ?></td>
                                        <td><?php echo output($si['sh_desc']); ?></td>
                                        <td><?php echo output($si['sh_stock']); ?></td>
                                        <td><?php echo output($si['sh_purhcasefrom']); ?></td>
                                        <td><?php echo output($si['sh_cost']); ?></td>

                                        <td><span class="badge <?php echo ($si['sh_paymentstatus'] == 'Paid') ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo ($si['sh_paymentstatus'] == 'Paid') ? 'Paid' : 'UnPaid'; ?>
                                        </span></td>  
                                    </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>         
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
<!-- /.content -->

<div class="modal fade show" id="modal-add" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="geofencesave" method="post" action="<?php echo base_url(); ?>stockinventory/addstock">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="geo_name" class="col-sm-4 col-form-label">No of Stock</label>
                            <div class="form-group col-sm-8">
                                <input type="number" class="form-control" name="sh_stock" id="sh_stock" required="true" placeholder="Enter No of Stock">
                                <input type="hidden" class="form-control" name="s_id" id="s_id">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="geo_name" class="col-sm-4 col-form-label">Purchased From</label>
                            <div class="form-group col-sm-8">
                                <input type="text" class="form-control" name="sh_purhcasefrom" id="sh_purhcasefrom" placeholder="Purchased From">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="geo_name" class="col-sm-4 col-form-label">Cost</label>
                            <div class="form-group col-sm-8">
                                <input type="number" class="form-control" name="sh_cost" id="sh_cost" required="true" placeholder="Enter Stock Cost">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="geo_name" class="col-sm-4 col-form-label">Payment Status</label>
                            <div class="form-group col-sm-8">
                            <select id="sh_paymentstatus" class="form-control" name="sh_paymentstatus" >
                                <option value="">Select Trip Payment Status</option>
                                <option  value="Paid">Paid</option>
                                <option  value="UnPaid">UnPaid</option>
                            </select>                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="geo_name" class="col-sm-4 col-form-label">Description</label>
                            <div class="form-group col-sm-8">
                                <input type="text" class="form-control" name="sh_desc" id="sh_desc" required="true" placeholder="Enter Description">
                            </div>
                        </div>


                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="geofenvaluesave" class="btn btn-primary">Save</button>
            </div>
                </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.addstockmodel').on('click', function() {
        var stockId = $(this).data('id');
        $('#s_id').val(stockId);
    });
});
</script>
