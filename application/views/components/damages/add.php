<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<!-- custom Core JavaScript -->
<script src="<?php echo site_url('private/js/ngscript/damageCtrl.js'); ?>"></script>

<div class="container-fluid">
    <div class="row">
	   <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Damage Product</h1>
                </div>
            </div>
            <div class="panel-body" ng-controller="damageCtrl">
                <?php $attr = array('class' => 'form-horizontal');
	            echo form_open('', $attr); ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name <span class="req">*</span></label>
                    <div class="col-md-5" >
                        <select name="product_code" ng-model="damage" ng-init="damage=''" ng-change="damageQty()" id="" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option selected disabled>---Select here---</option>
                            <?php foreach ($product as $key => $value) { ?>
                            <option value="<?php echo $value->code; ?>"><?php echo filter($value->name); ?></option>
                           <?php } ?>
                        </select>
                        <small>Curent Qty : <span style="color:green">{{quantity}}</span></small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Quantity ( {{ unit }} )<span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="quantity" class="form-control" step="any" required>
                        <input type="hidden" name="unit" ng-value="unit">
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-md-2 control-label">Remark</label>
                    <div class="col-md-5">
                        <textarea name="remark" class="form-control" rows="6" cols="12"></textarea>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save " name="product_add" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
