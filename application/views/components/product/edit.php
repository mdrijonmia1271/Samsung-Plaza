<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<div class="container-fluid">
    <div class="row" ng-controller="productEditCtrl" ng-cloak>
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Product</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php $attr = array('class' => 'form-horizontal');
                echo form_open('product/product/update/' . $info->product_code, $attr); ?>


                <!-- <div class="form-group">
                    <label class="col-md-2 control-label">Product Name </label>
                    <div class="col-md-5">
                        <input type="text" name="product_name" ng-value="product.product_name" class="form-control" required>
                    </div>
                </div> -->

                <div class="form-group">
                    <label class="col-md-2 control-label">Product Model </label>
                    <div class="col-md-5">
                        <input type="text" name="product_model" value="<?php echo $info->product_model; ?>" class="form-control"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Category<span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="category" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" disabled selected> &nbsp;</option>
                            <?php if ($allCategory != null) {
                                foreach ($allCategory as $key => $value) { ?>
                                    <option <?php if ($value->category == $info->product_cat) {
                                        echo 'selected';
                                    } ?> value="<?php echo $value->category; ?>"> <?php echo filter($value->category); ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Subcategory<span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="sub_category" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" disabled selected> &nbsp;</option>
                            <?php if ($allSubcategory != null) {
                                foreach ($allSubcategory as $key => $value) { ?>
                                    <option <?php if ($value->subcategory == $info->subcategory) {
                                        echo 'selected';
                                    } ?> value="<?php echo $value->subcategory; ?>"> <?php echo filter($value->subcategory); ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Brand<span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="brand" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" disabled selected> &nbsp;</option>
                            <?php if ($allBrand != null) {
                                foreach ($allBrand as $key => $value) { ?>
                                    <option <?php if ($value->brand == $info->brand) {
                                        echo 'selected';
                                    } ?> value="<?php echo $value->brand; ?>"> <?php echo filter($value->brand); ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Purchase Price</label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="purchase_price" min="0" value="<?php echo $info->purchase_price; ?>"
                               class="form-control" step="any">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Sale Price </label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="sale_price" min="0" value="<?php echo $info->sale_price; ?>" class="form-control" step="any">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Unit <span class="req">*</span></label>
                    <div class="col-md-5 input-group">
                        <select name="unit" class="form-control" required>
                            <?php foreach (config_item('unit') as $key => $value) { ?>
                                <option value="<?php echo $value; ?>" <?php echo ($value == $info->unit ? 'selected' : ''); ?>><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Status </label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="available" <?php echo ($info->status == 'available' ? 'checked' : ''); ?>> Available
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="notavailable" <?php echo ($info->status == 'notavailable' ? 'checked' : ''); ?>> Not Available
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Update " name="update" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
