<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    .col-md-4 {margin-bottom: 15px;}
    .btn-group button {padding: 5px 13px;}
</style>

<div class="container-fluid" ng-controller="productionCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Production</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('', $attr);
                ?>

                <div class="form-group">
                    <div class="col-md-4">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="batch_no" class="form-control" placeholder="Batch No." readonly value="<?php echo generate_batch('production'); ?>">
                    </div>

                    <div class="col-md-4">
                        <select class="selectpicker form-control" ng-model="raw_material" data-show-subtext="true" data-live-search="true"  required>
                            <option value="" selected disabled> Select Raw Material </option>
                            <?php foreach ($raws as $value) { ?>
                            <option value="<?php echo $value->code; ?>"><?php echo filter($value->name); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="number" ng-model="quantity" required  min="0" placeholder="Quantity" class="form-control" step="any">
                            <div class="input-group-addon">KG</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="btn-group">
                            <a href="#" ng-click="addRowFn()" class="btn btn-success"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                        </div>
                    </div>

                </div>
                <hr>

                <table class="table table-hover">
                    <tr>
                        <th width="55">SL</th>
                        <th>Raw Material</th>
                        <th>Stock</th>
                        <th width="25%">Quantity (Kg)</th>
                        <th width="70">Action</th>
                    </tr>

                    <tr ng-repeat="row in allRecords">
                        <td> {{ $index + 1 }}</td>
                        <td>
                             {{ row.raw_mat | textBeautify }}
                             <input type="hidden" name="raw_code[]" ng-value="row.code">
                         </td>
                        <td>{{ row.stock }}</td>
                        <td><input type="number" class="form-control" name="raw_quantity[]" max="{{ row.stock }}" ng-change="calWeight()"  ng-model="row.quantity"></td>
                        <td>
                            <a href="#" ng-click="removeRowFn($index)" class="btn btn-danger" style="padding: 5px 8px; color: #fff; font-weight: bold;">
                                <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3"></td>
                        <td>{{ totalWeight }}</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>


                <div class="form-group">
                    <label class="control-label col-md-3">Finish Product</label>
                    <div class="col-md-5">
                        <select class="selectpicker form-control" ng-change="getProductInfoFn()" ng-model="finish_product_code" name="finish_product_code" data-show-subtext="true" data-live-search="true" required>
                          <option value="" selected disabled> Select Finish Product </option>
                            <?php foreach ($result as $value) { if($value->type == "finish_product"){ ?>
                              <option value="<?php echo $value->code; ?>"> <?php echo filter($value->name); ?></option>
                           <?php } } ?>
                        </select>
                        <input type="hidden" name="finish_product" ng-value="product_name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Quantity</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="number" name="finish_quantity" required min="0" value="0" class="form-control" step="any">
                            <div class="input-group-addon">KG</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="save" value="Save" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>



<script>
    // linking between two date
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate : "2017",
        maxDate : "2019",
        useCurrent: false
    });
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
