<script src="<?php echo site_url('private/js/ngscript/hireSaleEntryCtrl.js?' . time()); ?>"></script>
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
<style>
    .p-0 {
        padding: 0 !important;
    }

    .tdBtn {
        padding: 0px !important;
        vertical-align: middle !important;
        text-align: center;
    }

    .super-border {
        border: 5px solid #00A8FF;
        border-radius: 5px;
        padding: 20px 15px;
        font-size: 22px;
    }
</style>
<div class="container-fluid" ng-controller="hireSaleEntryCtrl">
    <div class="row">
        <?php echo $confirmation; ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Hire Sale</h1>
                </div>
                <div class="panal-header-title pull-left">
                    <p class="hide" style="color: red;font-weight:bold; margin-left: 25px;">
                        <?php echo ($last_voucher) ? "Last voucher: " . $last_voucher[0]->voucher_no : " "; ?>
                    </p>
                </div>
            </div>
            <div class="panel-body" ng-cloak>
                <form ng-submit="addNewProductFn()">
                    <div class="row">
                        <div class="col-md-5" style="box-sizing: border-box;">
                            <div class="form-group">
                                <input list="browsers" type="text" placeholder="Type Scan barcode"
                                       ng-model="productSerial" class="form-control super-border" tabindex="1"
                                       autocomplete="off" autofocus>
                                <datalist id="browsers">
                                    <option ng-repeat="row in allProducts" value="{{row.product_serial}}">{{
                                        row.code }} - {{ row.product_model }} - {{ row.product_serial }}
                                    </option>
                                </datalist>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group date" id="datetimepicker">
                                    <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control"
                                        placeholder="YYYY-MM-DD" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3">
                            <select class="form-control" ng-model="godown_code" ng-change="getAllProductsFn()">
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
                        <input type="hidden" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                               ng-model="godown_code" ng-value="godown_code" required>
                    <?php } ?>

                    <div class="col-md-4">
                        <select ui-select2="{ allowClear: true}" class="form-control" ng-model='productCode'
                                data-placeholder="Select Product" ng-change="addNewProductFn()" >
                            <option value="" selected disable></option>
                            <option ng-repeat="product in allProducts" value="{{product.product_serial}}">
                                {{ product.product_model }} - {{ product.product_serial }}
                            </option>
                        </select>
                    </div>
                </div>

                <hr style="margin-top: 5px;">

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th style="width: 15%;">Product Name</th>
                        <th style="width: 15%;">Model</th>
                        <th style="width: 20%;">Serial No.</th>
                        <th style="width: 10%;">Stock</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 10%;">Sale Price</th>
                        <th style="width: 10%;">Total</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                    <tr ng-repeat="item in card">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="category[]" class="form-control"
                                   ng-value="item.category | textBeautify" readonly>
                            <input type="hidden" name="product[]" class="form-control" ng-value="item.product" readonly>
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="godown_code" ng-value="item.godown_code">
                            <input type="hidden" name="unit[]" ng-value="item.unit">
                        </td>

                        <td>
                            <input type="text" name="product_model[]" class="form-control" ng-value="item.product_model"
                                   readonly>
                        </td>

                        <td>
                            <input type="text" class="form-control" name="product_serial[]" ng-value="item.product_serial" readonly>
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1"
                               max="{{ item.maxQuantity }}" ng-model="item.quantity" step="any">
                        </td>
                        <td>
                            <input type="number" name="sale_price[]" class="form-control" ng-model="item.sale_price"
                                   ng-value="item.sale_price" step="any">
                            <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price" step="any">
                        </td>
                        <td>
                            <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                            <input type="hidden" ng-value="purchaseSubtotalFn($index)" step="any">
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
                        <div class="form-group" ng-init="stype='credit'" style="display: none;">
                            <input type="hidden" name="stype" ng-model="stype" checked value="credit">
                        </div>
                        <div ng-init="active1=true;" ng-show="active1">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Client</label>
                                <div class="col-md-9">
                                    <select ui-select2="{ allowClear: true}" class="form-control" name="code"
                                            ng-model="party_code" ng-change="findPartyFn()"
                                            data-placeholder="Select Client" required>
                                        <option value="" selected disable></option>
                                        <option ng-repeat="client in clientList" value="{{client.code}}">
                                            {{ client.code + "-" + client.name + "-" + client.mobile}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mobile </label>
                                <div class="col-md-9">
                                    <input type="text" name="mobile" ng-model="partyInfo.contact" class="form-control"
                                           readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Address </label>
                                <div class="col-md-9">
                                    <textarea name="address" class="form-control" readonly>{{ partyInfo.address }}</textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Send Sms </label>
                                <div class="col-md-2">
                                    <input type="checkbox" checked name="send_sms" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <input type="number" name="totalqty" ng-value="getTotalQtyFn()" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> HMRP</label>
                            <div class="col-md-8">
                                <input type="number" name="total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                                <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()" class="form-control" readonly>
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
                            <label class="col-md-4 control-label">Down Payment</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any">
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control" ng-init="transactionBy='cash'" ng-model="transactionBy" required>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash">bKash</option>
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
                            <!--label class="col-md-4 control-label">Current Balance </label-->
                            <label class="col-md-4 control-label">Due</label>
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


                        <div class="form-group">
                            <label class="col-md-4 control-label">Value Add </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="number" name="commission_per" min="0"
                                               ng-model="amount.added_percentage" ng-change="calculateAddedValueFn()"
                                               class="form-control" step="any">
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="added_amount" ng-model="amount.totalAddedAmount"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Hire Outstanding</label>
                            <div class="col-md-8">
                                <input type="text" name="hire_price" ng-value="calculateHirePrice()"
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Amount </label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                       class="form-control" step="any" readonly>
                            </div>
                        </div>


                        <input type="hidden" name="installment_type" value="monthly">
                        <input type="hidden" ng-init="customer_type='hire'" ng-model="customer_type">

                        <div class="form-group" ng-if="stype == 'credit' && partyInfo.csign=='Receivable'">
                            <label class="col-md-4 control-label">Installment Number</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-5">
                                        <select name="installment_number" ng-model="installment_number"
                                                ng-change="getInstallAmountFn(installment_number);" class="form-control"
                                                required>
                                            <option value="" selected disabled>-- Select Installment --</option>
                                            <?php for ($i = 1; $i <= 15; $i++) { ?>
                                                <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="number" name="installment_amount" ng-value="installment_amount"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group hide" ng-if="stype=='credit' && partyInfo.csign=='Receivable'">
                            <label class="col-md-4 control-label">Installment Date</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="installment_date" placeholder="YYYY-MM-DD"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" name="save" value="Save" class="btn btn-primary" ng-init="isDisabled=false;">
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