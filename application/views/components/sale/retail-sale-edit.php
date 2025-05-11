<script src="<?php echo site_url('private/js/ngscript/editRetailSaleCtrl.js?').time(); ?>"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<style>
    .table2 tr td {
        padding: 0 !important;
    }

    .table2 tr td input {
        border: 1px solid transparent;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

</style>

<div class="container-fluid" ng-controller="editRetailSaleCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Retail Sale</h1>
                </div>
            </div>

            <div class="panel-body" ng-click>

                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/retail_sale_edit/update', $attr);
                ?>

                <div class="row">
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="voucher_no" ng-init="voucher_no='<?php echo $info->voucher_no; ?>'" ng-model="voucher_no" ng-value="voucher_no" readonly>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control"
                                   placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>

                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3">
                            <select class="form-control" ng-model="godown_code"
                                    ng-init="godown_code = '<?php echo $info->godown_code; ?>'">
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
                        <input type="hidden" ng-init="godown_code = '<?php echo $info->godown_code; ?>'"
                               ng-model="godown_code" ng-value="godown_code"
                               required>
                    <?php } ?>

                    <div class="col-md-4">
                        <select ui-select2="{ allowClear: true}" class="form-control" ng-model='product_code'
                                data-placeholder="Select Product" ng-change="addNewProductFn()">
                            <option value="" selected disable></option>
                            <option ng-repeat="product in allProducts" value="{{product.code}}">{{ product.product_model
                                }}
                            </option>
                        </select>
                    </div>
                </div>

                <hr>


                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th style="width:200px;">Product Name</th>
                        <th width="200px">Model</th>
                        <th width="150px">Serial No.</th>
                        <th width="70">Stock</th>
                        <th width="70">Old QTY</th>
                        <th width="70">QTY</th>
                        <th width="100">Sale Price</th>
                        <th width="50px">Dis.(%)</th>
                        <th width="100px">Discount</th>
                        <th width="100px">Old Total</th>
                        <th width="100px">Total</th>
                        <th style="width: 50px;">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="id[]" ng-value="item.item_id">
                        <input type="hidden" name="product[]" ng-value="item.product">
                        <input type="hidden" name="product_model[]" ng-value="item.product_model">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="godown_code" ng-value="item.godown_code">
                        <input type="hidden" name="unit[]" ng-value="item.unit">

                        <td class="td-input" ng-bind="$index + 1"></td>
                        <td class="td-input" ng-bind="item.category | textBeautify"></td>
                        <td class="td-input" ng-bind="item.product_model"></td>

                        <td>
                            <input type="text" class="form-control" name="product_serial[]" ng-value="item.product_serial">
                        </td>

                        <td class="td-input" ng-bind="item.stock_qty"></td>

                        <td class="td-input" ng-bind="item.old_quantity"></td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1" ng-model="item.quantity" step="any">
                            <input type="hidden" name="old_quantity[]" ng-value="item.old_quantity">
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0"
                                   ng-model="item.sale_price"
                                   step="any">
                            <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price"
                                   step="any">
                        </td>

                        <td>
                            <input type="number" name="discount_percentage[]" class="form-control"
                                   ng-model="item.discount" min="0"
                                   step="any">
                        </td>

                        <td>
                            <input type="number" name="discount[]" class="form-control" ng-value="setDiscountFn($index)"
                                   min="0"
                                   step="any" readonly>
                        </td>

                        <td>
                            <input type="number" class="form-control" ng-value="setOldSubtotalFn($index)" readonly>
                        </td>

                        <td>
                            <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
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
                    <div class="col-md-6">

                        <?php $partyInfo = json_decode($info->address) ?>

                        <input type="hidden" name="sap_type" value="<?php echo $info->sap_type; ?>">


                        <div class="form-group">
                            <label class="col-md-3 control-label"> Name </label>
                            <div class="col-md-9">
                                <input type="text" name="party_code" value="<?php echo filter($info->party_code); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile</label>
                            <div class="col-md-9">
                                <input type="text" name="partyInfo[mobile]" value="<?php echo $partyInfo->mobile; ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-9">
                                <textarea name="partyInfo[address]" rows="4" class="form-control"><?php echo $partyInfo->address; ?></textarea>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Remark </label>
                            <div class="col-md-9">
                                <textarea name="comment" rows="4" class="form-control"><?php echo $info->comment; ?></textarea>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Send Sms </label>
                            <div class="col-md-2">
                                <input type="checkbox" name="send_sms" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <input type="number" name="totalqty" ng-value="getTotalQtyFn()" class="form-control"
                                       step="any"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Amount</label>
                            <div class="col-md-8">
                                <input type="number" name="total" ng-value="getTotalFn()" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Discount</label>
                            <div class="col-md-4">
                                <input type="number" ng-model="flat_discount" class="form-control" step="any">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="total_discount"
                                       ng-value="getItemWiseTotalDiscountFn()" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total</label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                       class="form-control" step="any"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Amount</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" ng-model="paid" class="form-control"
                                           step="any">
                                    <span class="input-group-addon" style="cursor: pointer;"
                                          ng-click="getFullPaidFn()"> ৳ </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-value="getPaidFn()" class="form-control"
                                               step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control" ng-init="transactionBy='cash'"
                                                ng-model="transactionBy"
                                                required>
                                            <option value="cash">Cash</option>
                                            <option value="bKash">bKash</option>
                                            <option value="rocket">Rocket</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- for selecting cheque -->
                        <div ng-if="transactionBy == 'cheque'">
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Bank Name <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <select name="meta[bankname]" class="form-control">
                                        <option value="" selected disabled>&nbsp;</option>
                                        <?php foreach (config_item("banks") as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Branch Name <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="meta[branchname]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Cheque No <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="meta[chequeno]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Pass Date <span class="req">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="meta[passdate]" placeholder="YYYY-MM-DD"
                                           class="form-control">
                                    <input type="hidden" name="meta[status]" value="pending">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label" ng-bind="labelName"></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" name="current_balance" ng-value="getCurrentTotalFn()"
                                           class="form-control" step="any" readonly>
                                    <span class="input-group-addon">৳</span>
                                </div>

                                <input type="hidden" name="current_sign" ng-value="labelName">
                            </div>
                        </div>

                        <div class="btn-group pull-right mt-1">
                            <input type="submit" name="update" value="Update" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>