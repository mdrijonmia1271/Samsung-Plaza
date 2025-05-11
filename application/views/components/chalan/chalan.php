<script src="<?php echo site_url('private/js/ngscript/chalanAddCtrl.js')?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    .table2 tr td{
        padding: 0 !important;
    }
    .table2 tr td input{
        border: 1px solid transparent;
    }
    .new-row-1 .col-md-4{
        margin-bottom: 8px;
    }
    .table tr th.th-width{
        width: 110px !important;
    }
    .table .form-control:focus{
        border-color: transparent;
    }
    .form-group{
        padding: 0 10px;
    }
</style>
<div class="container-fluid" ng-controller="chalanAddCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Chalan</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('', $attr);
                ?>
                <div class="row new-row-1">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker1">
                                <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="Date" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input  type="text" name="chalan_no" value="<?php echo generateUniqueId('chalan',5); ?>" placeholder="Chalan No" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select ng-model="productGiven"  class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>Product</option>
                                <?php foreach ($product as $value) { ?>
                                <option value="<?php echo $value->code; ?>"><?php echo $value->name; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="number" ng-model="quantityGiven" min="0" class="form-control"  placeholder="Quantity" required />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="client_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>---Select Client---</option>
                                <?php foreach ($AllClient as $value) { ?>
                                <option value="<?php echo $value->code; ?>"><?php echo filter($value->name)." ( ".$value->address." ) "; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-right col-md-1 btn-group">
                        <a class="btn btn-success" ng-click="addRowFn()">
                            <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered table2">
                    <tr>
                        <th style="text-align:center;" width="40">SL</th>
                        <th style="width: 133px;">Name</th>
                        <th style="width: 80px;">Unit</th>
                        <th class="th-width">Quantity</th>
                        <th style="text-align:center;" width="55">Action</th>
                    </tr>
                    <tr ng-repeat="row in items">
                        <td style="text-align:center;">{{ $index + 1 }}</td>
                        <td style="padding-left: 10px !important;">
                            {{ row.product }}
                            <input type="hidden" name="code[]" class="form-control" ng-value="row.code">
                        </td>
                        <td style="padding-left: 10px !important;">
                            <input type="text" name="unit[]" class="form-control" ng-value="row.unit" readonly>
                        </td>

                        <td style="padding-left: 10px !important;">
                            <input type="number" name="quantity[]" class="form-control" ng-value="row.quantity">
                        </td>
                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="text-right col-md-12 no-padding">
                    <div class="btn-group">
                        <input class="btn btn-primary" type="submit" name="save" value="Save">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>