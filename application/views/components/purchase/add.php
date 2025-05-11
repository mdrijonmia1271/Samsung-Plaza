<script src="<?php echo site_url('private/js/ngscript/PurchaseEntry.js?').time(); ?>"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    .table2 tr td {
        padding: 0 !important;
    }

    .table2 tr td input {
        border: 1px solid transparent;
    }

    .new-row-1 .col-md-4 {
        margin-bottom: 8px;
    }

    .red,
    .red:focus {
        border-color: red;
    }

    .green,
    .green:focus {
        border-color: green;
    }
</style>
<div class="container-fluid" ng-controller="PurchaseEntry" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Purchase</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('', $attr);
                
                if($this->data['privilege'] == 'super') {
                    $godown = 'yes';
                    $column = '2';
                }else{
                    $godown = 'no';
                    $column = '3';
                }
                ?>


                <div class="row new-row-1">
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d');?>"
                                placeholder="Date" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-2">
                            <select class="form-control" name="godown_code" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'" ng-model="godown_code" required>
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if (!empty($allGodowns)) {
                                    foreach ($allGodowns as $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="godown_code" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                               ng-model="godown_code" ng-value="godown_code"
                               required>
                    <?php } ?>

                    <div class="col-md-2">
                        <input type="text" name="voucher_no" placeholder="Voucher No" class="form-control" required
                            ng-class="{'red': validation}" ng-model="voucherNo" ng-change="exists()">
                    </div>

                    <div class="col-md-2">
                    
                        <select ui-select2="{ allowClear: true}" class="form-control" name="party_code" ng-change="setPartyfn()" ng-model="partyCode" required>
                            <option value="" selected disable>--Select Supplier--</option>
                            <option ng-repeat="supplier in supplierList" value="{{supplier.code}}">{{ supplier.name }} - {{ supplier.address }}
                            </option>
                        </select>

                    </div>

                    <div class="col-md-<?php echo 3 //$column; ?>">
                        <select ng-model="product" class="selectpicker form-control" data-show-subtext="true"
                            data-live-search="true" required>
                            <option value="" selected disabled>-- Select Product --</option>
                            <?php if(!empty($allProducts)){ foreach($allProducts as $key => $row){ ?>
                            <option value="<?php echo $row->product_code; ?>">
                                <?php echo filter($row->product_model); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                   <!-- <div class="col-md-1">
                        <!-- <input type="number" class="form-control" placeholder="Quantity" min="1" ng-model="quantity"> 
                        <?php if($godown == 'yes'){ ?>
                        <a class="btn btn-success pull-right" ng-click="addNewProductFn()">
                            <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                        </a>
                        <?php } ?>
                    </div>

                    <?php if($godown == 'no'){ ?>
                    <div class="col-md-1">
                        <a class="btn btn-success text-right" ng-click="addNewProductFn()">
                            <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                        </a>
                    </div>
                    <?php } ?>-->
                </div>
                <hr>
                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Product Name</th>
                        <!--<th width="200px"> Serial</th>-->
                        <th>Model</th>
                        <th width="130">Sale Price</th>
                        <th width="100">Comm.(%)</th>
                        <!--<th width="80px">Unit</th>-->
                        <th width="100">Qty</th>
                        <th width="130">Purchase Price</th>
                        <th width="130">Total</th>
                        <th width="60">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td style="padding: 6px 8px !important; background-color: #eee;">
                            {{item.product_cat | textBeautify}}
                        </td>

                        <td>
                            <input type="text" name="product_model[]" class="form-control" ng-model="item.product_model"
                                readonly>
                            <input type="hidden" name="product[]" class="form-control" ng-value="item.product" readonly>
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="product_cat[]" ng-value="item.product_cat">
                            <input type="hidden" name="product_subcat[]" ng-value="item.product_subcat">
                            <input type="hidden" name="unit[]" class="form-control" ng-value="item.unit">
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" ng-model="item.sale_price">
                        </td>
                        <td>
                            <input type="number" step="any" name="commission[]" class="form-control"
                                ng-model="item.commission">
                        </td>
                        <!--<td>
                            <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                        </td>-->
                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1"
                                ng-model="item.quantity">
                        </td>

                        <td>
                            <input type="number" name="purchase_price[]" class="form-control" min="0"
                                ng-value="setPurchasePrice($index)" step="any" readonly>
                            <!--<input type="number" name="purchase_price[]" class="form-control" min="0" ng-value="item.price" step="any">
                            <input type="hidden" name="sale_price[]" class="form-control" ng-value="item.sale_price">-->
                        </td>

                        <td>
                            <input type="text" name="subtotal[]" class="form-control" ng-model="item.subtotal"
                                ng-value="setSubtotalFn($index)" readonly>
                        </td>
                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="row">
                    <div class="col-md-offset-6 col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="number" name="total" class="form-control" ng-value="getTotalFn()"
                                    step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" ng-model="amount.totalDiscount"
                                    class="form-control" step="any" max="{{ getTotalFn() }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Transport Cost </label>
                            <div class="col-md-8">
                                <input type="number" name="transport_cost" ng-model="amount.transport_cost"
                                    class="form-control" step="any">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total </label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                    class="form-control" step="any" min="0" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="previous_balance" ng-model="partyInfo.balance"
                                            class="form-control" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="previous_sign" ng-value="partyInfo.sign"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="amount.paid" class="form-control"
                                            step="any" required>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control">
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash">bKash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="current_balance" ng-value="getCurrentTotalFn()"
                                            class="form-control" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="partyInfo.csign"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            <input type="submit" name="save" value="Save" class="btn btn-primary"
                                ng-disabled="validation">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script>
    // linking between two date
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD',
    });
</script>