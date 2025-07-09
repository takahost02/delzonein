<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Stock Management
                    <a href="<?= base_url(); ?>stockinventory" class="btn btn-sm btn-primary"><i class="fa fa-table"></i></a>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Stock Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 col-md-offset-2">
                    <form id="addnewcategory" class="basicvalidation" role="form" action="<?php echo base_url();?>stockinventory/<?php echo (isset($stockdetails))?'updatestockinventory':'insertstockinventory'; ?>" method="post" enctype='multipart/form-data'>
                        <div class="card-body">
                            <?php if(isset($stockdetails)) { ?>
                                <input type="hidden" name="s_id" id="s_id" value="<?php echo (isset($stockdetails)) ? $stockdetails[0]['s_id'] : ''; ?>">
                            <?php } ?>
                            <div class="row">
                                <div class="col-sm-12 col-md-offset-2">
                                    <div class="form-group">
                                        <label>Part Name</label>
                                        <input type="text" name="s_name" value="<?php echo (isset($stockdetails)) ? $stockdetails[0]['s_name'] : ''; ?>" autocomplete="off" required="true" placeholder="Enter name of part" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Part Description</label>
                                <textarea class="form-control" id="s_desc" autocomplete="off" required="true" placeholder="Part description" name="s_desc"><?php echo (isset($stockdetails)) ? $stockdetails[0]['s_desc'] : ''; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-offset-2">
                                    <div class="form-group">
                                        <label>No of Opening Stock</label>
                                        <input type="number" required="true" autocomplete="off" value="<?php echo (isset($stockdetails)) ? $stockdetails[0]['s_stock'] : ''; ?>" name="s_stock" placeholder="Total opening stocks available" class="form-control number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-offset-2">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" required="true" autocomplete="off" value="<?php echo (isset($stockdetails)) ? $stockdetails[0]['s_price'] : ''; ?>" name="s_price" placeholder="Part Price" class="form-control number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Part Status</label>
                                <select name="s_status" id="s_status" class="form-control" required="true">
                                    <option value="">Choose Status</option>
                                    <option <?php echo (isset($stockdetails[0]['s_status']) && $stockdetails[0]['s_status']=='1') ? 'selected' : ''; ?> value="1">Active</option>
                                    <option <?php echo (isset($stockdetails[0]['s_status']) && $stockdetails[0]['s_status']=='0') ? 'selected' : ''; ?> value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary"><?php echo (isset($stockdetails)) ? 'Update' : 'Add'; ?></button>
                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


