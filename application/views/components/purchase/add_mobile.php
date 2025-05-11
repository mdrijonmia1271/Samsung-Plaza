<script src="<?php echo site_url('private/js/ngscript/PurchaseEntryMobile.js?') . time(); ?>"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
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

    .super-border {
        border: 5px solid #00A8FF;
        border-radius: 5px;
        padding: 20px 15px;
        font-size: 22px;
    }

    .super-color {
        color: #00A8FF;
        font-size: 20px;
    }

    .super-color0 {
        color: #09bb34;
        font-size: 20px;
    }

</style>
<div class="container-fluid" ng-controller="PurchaseEntryMobile" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Mobile Purchase</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php echo form_open('purchase/purchaseMobile/store'); ?>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"
                                       placeholder="Date" required>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="godown_code"
                                        ng-init="godownCode=''"
                                        ng-model="godownCode" required>
                                    <option value="" selected>-- Select Showroom --</option>
                                    <?php if (!empty($godownList)) {
                                        foreach ($godownList as $row) { ?>
                                            <option value="<?php echo $row->code; ?>">
                                                <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="godown_code"
                               ng-init="godownCode='<?php echo $this->data["branch"]; ?>'" ng-value="godownCode">
                    <?php } ?>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" name="voucher_no" placeholder="Voucher No" class="form-control" required
                                   ng-class="{'red': validation}" ng-model="voucherNo" ng-change="exists(voucherNo)"
                                   ng-model-options="{ debounce: 725 }">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <select ui-select2="{ allowClear: true}" class="form-control" name="party_code"
                                    ng-change="setPartyfn(partyCode)" ng-model="partyCode" required>
                                <option value="" selected disable>--Select Supplier--</option>
                                <option ng-repeat="supplier in supplierList" value="{{supplier.code}}">{{ supplier.name
                                    }} - {{ supplier.address }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select ng-model="productCode" ng-change="addNewProductFn()" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected disabled>-- Select Product --</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->product_code; ?>">
                                            <?php echo filter($row->product_model); ?> - <?php echo filter($row->product_model); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <!--<div class="col-md-1">
                        <div class="form-group">
                            <span class="btn btn-success" ng-click="addNewProductFn()"><i class="fa fa-plus"></i></span>
                        </div>
                    </div>-->
                </div>
                <hr style="margin-top: 0px;">

                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th width="150">Model</th>
                        <th width="120">Color</th>
                        <th width="280">Barcode/Serial</th>
                        <th width="90">Comm.(%)</th>
                        <th width="130">Purchase Price</th>
                        <th width="130">Sale Price</th>
                        <th width="80">Qty</th>
                        <th width="130">Total</th>
                        <th width="60">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>

                        <td>
                            <input type="text" name="product_model[]" class="form-control" ng-model="item.product_model"
                                   readonly>
                            <input type="hidden" name="product[]" ng-value="item.product">
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="product_cat[]" ng-value="item.product_cat">
                            <input type="hidden" name="product_subcat[]" ng-value="item.product_subcat">
                            <input type="hidden" name="brand[]" ng-value="item.brand">
                            <input type="hidden" name="unit[]" class="form-control" ng-value="item.unit">
                            <!--<input type="hidden" name="color[]" class="form-control" value="na">-->
                        </td>

                        <td>
                            <select name="color[]" class="form-control">
                                <option value="none" selected disabled>-- Color --</option>
                                <?php foreach ($colorList as $key => $value) { ?>
                                <option value="<?php echo $value->color;?>"><?php echo filter($value->color);?></option>
                                <?php } ?>
                            </select>
                       </td>

                        <td>
                            <input type="text" name="product_serial[]" class="form-control"
                                   ng-change="setQuantityFn($index)" ng-model="item.product_serial"
                                   ng-model-options="{debounce: 700 }" required>
                        </td>
                        
                        <td>
                            <input type="number" step="any" name="commission[]" class="form-control" min="0"
                                ng-model="item.commission" ng-change="setPurchasePrice($index)">
                        </td>
                        <td>
                            <input type="number" name="purchase_price[]" step="any" min="0" class="form-control"
                                ng-model="item.base_price" ng-change="setPurchasePrice($index)">
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0" step="any"
                                   ng-model="item.sale_price" ng-change="setPurchasePrice($index)">
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1" ng-model="item.quantity" readonly>
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

                <div class="row form-horizontal">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks </label>
                            <div class="col-md-8">
                                <textarea name="comment" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="number" name="total_amount" class="form-control" ng-value="getTotalFn()"
                                       step="any" readonly>
                                <input type="hidden" name="total_quantity" ng-value="totalQuantity">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" ng-model="totalDiscount" step="any"
                                       placeholder="0" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Transport Cost </label>
                            <div class="col-md-8">
                                <input type="number" name="transport_cost" ng-model="transportCost" class="form-control"
                                       step="any" placeholder="0">
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
                                        <input type="number" ng-value="balance" class="form-control" step="any"
                                               placeholder="0" readonly>
                                        <input type="hidden" name="previous_balance" ng-value="previousBalance">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="previous_sign" ng-value="previousSign"
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
                                        <input type="number" name="paid" ng-model="payment" class="form-control"
                                               step="any" placeholder="0">
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
                                        <input type="number" ng-value="getCurrentTotalFn()"
                                               class="form-control" step="any" readonly>
                                        <input type="hidden" name="current_balance" ng-value="currentBalance">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="currentSign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-right">
                                <input type="submit" name="save" value="Save" class="btn btn-primary"
                                       ng-disabled="isDisabled">
                            </div>
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

    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>