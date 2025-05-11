<script src="<?php echo site_url('private/js/ngscript/productAddCtrl.js') ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid">
    <div class="row" ng-controller="productAddCtrl">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Product</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php $attr = array('class' => 'form-horizontal');
                echo form_open('product/product/store', $attr); ?>

                <!-- <div class="form-group">
                    <label class="col-md-2 control-label">Product Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="product_name" class="form-control" required>
                    </div>
                </div> -->
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Model</label>
                    <div class="col-md-5">
                        <input type="text" name="product_model" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Code</label>
                    <div class="col-md-5">
                        <input type="text" name="code" class="form-control" ng-model="code" ng-change="exists(code)" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Category<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="category" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>---Select---</option>
                            <?php if($allCategory != null){ foreach ($allCategory as $key => $value) { ?>
                            <option value="<?php echo $value->category ?>"> <?php echo filter($value->category); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Subcategory<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="sub_category" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>---Select---</option>
                            <?php if($allSubcategory != null){ foreach ($allSubcategory as $key => $value) { ?>
                            <option value="<?php echo $value->subcategory ?>"> <?php echo filter($value->subcategory); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Brand<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="brand" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>---Select---</option>
                            <?php if($allBrand != null){ foreach ($allBrand as $key => $value) { ?>
                            <option value="<?php echo $value->brand ?>"> <?php echo filter($value->brand); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Purchase Price</label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="purchase_price" min="0" value="0" class="form-control" step="any">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Sale Price </label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="sale_price" min="0" value="0" class="form-control" step="any">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Unit <span class="req">*</span></label>
                    <div class="col-md-5 input-group">
                        <select name="unit" class="form-control" required>
                            <option value="" selected disabled>--Select--</option>
                            <?php foreach(config_item('unit') as $key=> $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Status </label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="available" checked> Available
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="notavailable"> Not Available
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save " name="save" class="btn btn-primary" ng-disabled="validation">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>