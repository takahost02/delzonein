<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Accounts Transactions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Accounts Transactions</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<style>
.filter-container .form-control {
    height: 30px; /* Set a specific height */
    padding: 0.25rem 0.5rem; /* Adjust padding if needed */
    font-size: 14px; /* Adjust font size if necessary */
}
.filter-container .btn {
    height: 30px; /* Match button height with input */
    line-height: 0.5; /* Adjust line height for vertical alignment */
    padding: 0.25rem 0.5rem; /* Adjust padding */
}
.dataTables_wrapper .dt-buttons {
    float: right; /* Align buttons to the right */
    margin-left: 10px; /* Add space between length menu and buttons */
}

.dataTables_length {
    display: inline-block; /* Ensure length menu is inline */
    margin-bottom: 10px; /* Adjust bottom margin as needed */
}
</style>



<div class="container-fluid">
        <div class="filter-container mb-3">
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <input type="text" id="fromDate" class="form-control datepicker" placeholder="Choose From Date">
                </div>
                <div class="col-md-2">
                    <input type="text" id="toDate" class="form-control datepicker" placeholder="Choose To Date">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="filter" class="btn btn-primary">Filter</button>
                    <button id="clearFilter" class="btn btn-secondary ml-2">Clear</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table card-table actrans">
                        <thead>
                            <tr>
                                <th class="w-1">S.No</th>
                                <th>Date</th>
                                <th>Vechile</th>
                                <th>Account</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Category</th>
                                <th>Ref No</th>
                                <th>Note</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (!empty($transactionslist)) { $count = 1; foreach ($transactionslist as $account) { ?>
                                <tr>
                                    <td><?php echo output($count); $count++; ?></td>
                                    <td><?php echo output($account['transaction_date']); ?></td>
                                    <td><?php echo output($account['v_registration_no'].' - '.$account['v_name']); ?></td>
                                    <td><?php echo output($account['account_name']); ?></td>
                                    <td><span class="badge badge-danger"><?php echo ($account['transaction_type'] == 'Debit') ?  output($account['amount']) : ''; ?></span></td>
                                    <td><span class="badge badge-success"><?php echo ($account['transaction_type'] == 'Credit') ? output($account['amount']) : ''; ?></span></td>
                                    <td><?php echo output($account['ie_cat_name']); ?></td>  
                                    <td><?php echo output($account['reference_number']); ?></td>
                                    <td><?php echo output($account['note']); ?></td>    
                                    <td><?php echo output(ucwords($account['u_name'])); ?></td>
                                    <td> 
                                    <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>accounts/deletetransactions/','<?php echo output($account['id']); ?>')" data-target="#deleteconfirm" class="icon">
                                                <i class="fa fa-trash text-danger"></i>
                                    </a>

                                    </td>
                                </tr>
                            <?php 
                                } 
                            } 
                            ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="1"><b>Total</b></td>
                            <td id="totalDebit">0</td>
                            <td id="totalCredit">0</td>
                            <td colspan="5"></td>
                        </tr>
                    </tfoot>
                    </table>
                    
                </div>         
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function() {
    var table = $('.actrans').DataTable({
              "ordering": false,
               dom: 'Blfrtip',
               buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdfHtml5'
           ],
            "pageLength": 10, 
            "lengthMenu": [  
                [5, 10, 25, 50, -1], 
                [5, 10, 25, 50, "All"] 
            ]
           });

    $('#filter').on('click', function() {
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        // Reset filters
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var date = data[1]; // Use the date column index
                return (fromDate === "" || date >= fromDate) && (toDate === "" || date <= toDate);
            }
        );

        table.draw();
        calculateSums();
    });

    function calculateSums() {
        let totalDebit = 0;
        let totalCredit = 0;
        table.rows({ filter: 'applied' }).every(function() {
            var rowData = this.node();
            var debit = $(rowData).find('td:eq(4) .badge').text();
            var credit = $(rowData).find('td:eq(5) .badge').text();

            totalDebit += parseFloat(debit) || 0;
            totalCredit += parseFloat(credit) || 0;
        });

        $('#totalDebit').text(totalDebit);
        $('#totalCredit').text(totalCredit);
    }
    calculateSums();
    table.on('draw', function() {
        calculateSums();
    });
  

    $('#clearFilter').on('click', function() {
        $('#fromDate').val('');
        $('#toDate').val('');
        $.fn.dataTable.ext.search.pop();
        table.draw();
        calculateSums();
    });
});

</script>