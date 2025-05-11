<script src="<?php echo site_url('private/js/ngscript/returnPurchaseCtrl.js?') . time(); ?>"></script>
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
    .super-border {
        border: 5px solid #00A8FF;
        border-radius: 5px;
        padding: 20px 15px;
        font-size: 22px;
    }
</style>
<div class="container-fluid" ng-controller="returnPurchaseCtrl" ng-cloak>
    <div class="row">

        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Purchase Return</h1>
                </div>
            </div>
            <div class="panel-body">

                <form ng-submit="addNewProductFn()">
                    <div class="row">
                        <div class="col-md-5" style="box-sizing: border-box;">
                            <div class="form-group">
                                <input type="text" placeholder="Type Serial no OR Scan barcode" ng-model="productSerial" class="form-control super-border" autocomplete="off" autofocus>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- horizontal form -->
                <?php echo form_open('purchase/productReturn/store') ?>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="godown_code"
                                        ng-init="godownCode=''"
                                        ng-model="godownCode" required>
                                    <option value="" selected>Select Showroom</option>
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
                               ng-init="godownCode='<?php echo $this->data["branch"]; ?>'" ng-value="godownCode"
                               required>
                    <?php } ?>


                    <div class="col-md-3">
                        <div class="form-group">
                            <select ui-select2="{ allowClear: true}" class="form-control" name="party_code"
                                    ng-change="setPartyfn(partyCode)" ng-model="partyCode" required>
                                <option value="" selected disable>Select Supplier</option>
                                <option ng-repeat="supplier in supplierList" value="{{supplier.code}}">{{ supplier.name
                                    }} -
                                    {{ supplier.address }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 0px;">
                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Serial/Barcode</th>
                        <th width="100">Qty</th>
                        <th width="130">Purchase Price</th>
                        <th width="130">Total</th>
                        <th width="60">Action</th>
                    </tr>
                    <tr ng-repeat="row in cart">

                        <input type="hidden" name="stock_id[]" ng-value="row.stock_id">
                        <input type="hidden" name="sale_price[]" ng-value="row.sale_price">
                        <input type="hidden" name="product_model[]" ng-value="row.product_model">
                        <input type="hidden" name="product_code[]" ng-value="row.product_code">
                        <input type="hidden" name="unit[]" ng-value="row.unit">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="product[]" ng-value="row.product" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="text" name="color[]" ng-value="row.color" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="text" name="product_serial[]" ng-value="row.product_serial" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" step="any" ng-model="row.quantity" readonly>
                        </td>
                        <td>
                            <input type="number" name="purchase_price[]" class="form-control" ng-model="row.purchase_price" required>
                        </td>
                        <td>
                            <input type="text" name="subtotal[]" class="form-control" ng-value="setSubtotalFn($index)" readonly>
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
                    <div class="col-md-offset-6 col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Amount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_amount" class="form-control" ng-value="getTotalFn()" step="any" readonly>
                                <input type="hidden" name="total_quantity" ng-value="totalQuantity">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" ng-model="partyInfo.balance"
                                               class="form-control" step="any" readonly>
                                        <input type="hidden" name="previous_balance" ng-value="partyInfo.previous_balance">
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
                                        <input type="number" name="paid" ng-model="payment" class="form-control"
                                               step="any" placeholder="0" required>
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
                                        <input type="hidden" name="current_balance" ng-value="partyInfo.current_balance">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="partyInfo.csign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            <input type="submit" name="update" value="Update" class="btn btn-primary"
                                   ng-disabled="isDisabled">
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