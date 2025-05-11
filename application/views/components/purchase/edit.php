<script src="<?php echo site_url('private/js/ngscript/EditPurchaseEntry.js?') . time(); ?>"></script>
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

    .table tr th.th-width {
        width: 100px !important;
    }

    .table tr td.input {
        padding: 6px 8px !important;
        background-color: #eee;
    "
    }
</style>
<div class="container-fluid" ng-controller="EditPurchaseEntry">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Purchase</h1>
                </div>
            </div>
            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('purchase/editPurchase?vno=' . $info->voucher_no, $attr);
                ?>
                <label>Date: <?php echo $info->sap_at; ?></label> |
                <label>Voucher No: <?php echo $info->voucher_no; ?></label>
                <hr style="margin-top: 5px;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" class="form-control" value="<?php echo $info->sap_at; ?>"
                                   placeholder="Date" required>
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <select class="selectpicker form-control" ng-model="product_code"
                                ng-change="addNewProductFn(product_code)" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>-- Select Product --</option>
                            <?php if (!empty($allProducts)) {
                                foreach ($allProducts as $key => $row) { ?>
                                    <option value="<?php echo $row->product_code; ?>">
                                        <?php echo filter($row->product_model); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <br>


                <!-- all hidden file -->
                <input type="hidden" ng-init="godown_code='<?php echo $info->godown_code; ?>'" ng-model="godown_code" ng-value="godown_code">
                <input type="hidden" name="voucher_no" ng-init="vno='<?php echo $info->voucher_no; ?>'" ng-model="vno" ng-value="vno">
                <input type="hidden" name="party_code" value="<?php echo $info->party_code; ?>">
                <!-- product table -->


                <table class="table table-bordered table2">
                    <tr>
                        <th width="10px">SL</th>
                        <th width="250px">Product Name</th>
                        <th width="250px">Model</th>
                        <!--<th width="80px">Unit</th>-->
                        <th width="80px">S.Price</th>
                        <th width="80px">Comm.(%)</th>
                        <th class="th-width">Old Qty</th>
                        <th class="th-width">New Qty</th>
                        <th class="th-width">P.Price</th>
                        <th class="th-width">Old Sum</th>
                        <th class="th-width">New Sum</th>
                        <th width="50">Action</th>
                    </tr>
                    <tr ng-repeat="item in records">

                        <input type="hidden" name="id[]" ng-value="item.id">
                        <input type="hidden" name="product_name[]" ng-value="item.product_name">
                        <input type="hidden" name="product_model[]" ng-value="item.product_model">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="godown_code[]" ng-value="item.godown">
                        <input type="hidden" name="product_cat[]" ng-value="item.product_cat">
                        <input type="hidden" name="subcategory[]" ng-value="item.subcategory">
                        <input type="hidden" name="unit[]" ng-value="item.unit">

                        <td class="input" ng-bind="$index + 1"></td>
                        <td class="input" ng-bind="item.product_cat | textBeautify"></td>
                        <td class="input" ng-bind="item.product_model"></td>
                        <!--<td class="input" ng-bind="item.unit"></td>-->
                        <td>
                            <input type="text" name="sale_price[]" class="form-control" min="0"
                                   ng-model="item.sale_price">
                        </td>
                        <td>
                            <input type="number" name="purchase_commission[]" class="form-control" min="0"
                                   ng-model="item.purchase_commission" step="any">
                        </td>
                        <td>
                            <input type="text" name="old_quantity[]" class="form-control" ng-model="item.old_quantity"
                                   readonly>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control"
                                   ng-model="item.quantity">
                        </td>

                        <td>
                            <input type="text" name="purchase_price[]" class="form-control"
                                   ng-value="setPurchasePriceFn($index)">
                        </td>

                        <td>
                            <input type="text" name="old_subtotal[]" class="form-control" ng-model="item.old_subtotal"
                                   ng-value="getOldSubtotalFn($index)" readonly>
                        </td>
                        <td>
                            <input type="text" name="subtotal[]" class="form-control" ng-model="item.subtotal"
                                   ng-value="getSubtotalFn($index)" readonly>
                        </td>
                        <td class="text-center">
                            <a title="Delete" ng-click="deleteItemFn($index)" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Showroom Name </label>
                            <div class="col-md-8">
                                <?php
                                $showroomInfo = get_row('godowns', ['code' => $info->godown_code]);
                                ?>
                                <input type="text"
                                       value="<?php echo $showroomInfo->name . ' ( ' . $showroomInfo->address . ') '; ?>"
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Supplier Name </label>
                            <div class="col-md-8">
                                <input type="text" value="<?php echo $info->name; ?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Mobile </label>
                            <div class="col-md-8">
                                <input type="text" value="<?php echo $info->mobile; ?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Address </label>
                            <div class="col-md-8">
                                <input type="text" value="<?php echo $info->address; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" ng-value="getTotalFn()"
                                       step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" ng-model="amount.total_discount"
                                       class="form-control" min="0" step="any">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Transport Cost </label>
                            <div class="col-md-8">
                                <input type="number" name="transport_cost" ng-model="amount.transport_cost"
                                       class="form-control" min="0" step="any">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total </label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                       class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="previous_balance"
                                               ng-value="partyInfo.previousBalance" class="form-control" step="any"
                                               readonly>
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
                                        <input type="number" ng-model="amount.paid" class="form-control"
                                               step="any">
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
                            <label class="col-md-4 control-label">Total Paid</label>
                            <div class="col-md-8">
                                <input type="number" name="total_paid" ng-value="getTotalPaidFn()" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="current_balance" ng-value="getCurrentTotalFn()"
                                               class="form-control" step="any" readonly required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="partyInfo.csign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            <input type="submit" name="save" value="Update" class="btn btn-primary">
                        </div>
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
        format: 'YYYY-MM-DD'
    });
</script>