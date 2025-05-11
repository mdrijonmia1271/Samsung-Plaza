<script src="<?php echo site_url('private/js/ngscript/mobileSaleReturnEntryCtrl.js?') . time(); ?>"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
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
<div class="container-fluid" ng-controller="mobileSaleReturnEntryCtrl" ng-cloak>
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Mobile Sale Return</h1>
                </div>
            </div>

            <div class="panel-body">

                <form ng-submit="addNewProductFn()">
                    <div class="row">
                        <div class="col-md-5" style="box-sizing: border-box;">
                            <div class="form-group">
                                <input type="text" placeholder="Type IMEI no OR Scan barcode" ng-model="productSerial" class="form-control super-border" autocomplete="off" autofocus>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/mobile_sale_return/store', $attr);
                ?>

                <div class="row">
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
                            <select name="godown_code" class="form-control" ng-init="godownCode=''"
                                    ng-model="godownCode" required>
                                <option value="" selected>Select Showroom</option>
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
                        <input name="godown_code" type="hidden"
                               ng-init="godownCode='<?php echo $this->data["branch"]; ?>'"
                               ng-model="godownCode" ng-value="godownCode"
                               required>
                    <?php } ?>
                </div>
                <hr>

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th>Product Model</th>
                        <th style="width: 18%;">IMEI NO</th>
                        <th style="width: 7%;">Color</th>
                        <th style="width: 7%;">Stock</th>
                        <th style="width: 7%;">QTY</th>
                        <th style="width: 10%;">Sale Price</th>
                        <th style="width: 7%;">Dis.(%)</th>
                        <th style="width: 7%;">Dis.</th>
                        <th style="width: 10%;">Total</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="stock_id[]" ng-value="item.stock_id">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="product_model[]" ng-value="item.product_model">
                        <input type="hidden" name="unit[]" ng-value="item.unit">
                        <input type="hidden" name="product_serial[]" ng-value="item.product_serial">
                        <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price">
                        <input type="hidden" name="color[]" ng-value="item.color">

                        <td ng-bind="$index + 1"></td>
                        <td ng-bind="item.product_model"></td>
                        <td ng-bind="item.product_serial"></td>
                        <td ng-bind="item.color"></td>
                        <td class="text-center" ng-bind="item.stock_qty"></td>

                        <td class="p-0">
                            <input type="number" name="quantity[]" class="form-control" min="1" ng-model="item.quantity"
                                   step="any" readonly>
                        </td>

                        <td class="p-0">
                            <input type="number" name="sale_price[]" class="form-control" min="0"
                                   ng-model="item.sale_price" step="any">
                        </td>

                        <td class="p-0">
                            <input type="number" name="discount_percentage[]" class="form-control"
                                   ng-model="item.discount_percentage" min="0" step="any">
                        </td>

                        <td class="p-0">
                            <input type="number" name="discount[]" class="form-control" ng-value="setDiscountFn($index)"
                                   min="0" step="any" readonly>
                        </td>

                        <td class="p-0">
                            <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                        </td>

                        <td class="tdBtn">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>

                <div class="row">
                    <div class="col-md-6">

                        <input type="hidden" name="sap_type" ng-value="sapType">

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <span ng-class="buttonOne" ng-click="setSaleType('cash')">Cash Sale</span>
                                <span ng-class="buttonTwo" ng-click="setSaleType('dealer')">Dealer Sale</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Brand <span class="req">*</span></label>
                            <div class="col-md-9">
                                <select name="brand" class="form-control" required>
                                    <option value="" selected>Select Brand</option>
                                    <?php if (!empty($brandList)){
                                        foreach ($brandList as $item) {
                                            echo '<option value="'. $item->brand .'">' . filter($item->brand) . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div ng-show="sapType=='cash'">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Name </label>
                                <div class="col-md-9">
                                    <input type="text" name="client_name" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mobile</label>
                                <div class="col-md-9">
                                    <input type="text" name="client_mobile" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Address </label>
                                <div class="col-md-9">
                                    <textarea name="client_address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div ng-show="sapType=='dealer'">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Client </label>
                                <div class="col-md-9">
                                    <select name="party_code" ui-select2="{ allowClear: true}" class="form-control"
                                            ng-model="partyCode"
                                            data-placeholder="Select Client" ng-change="setPartyInfoFn(partyCode)">
                                        <option value="" selected></option>
                                        <option ng-repeat="row in partyList" value="{{row.code}}">{{row.name}} -
                                            {{row.mobile}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mobile</label>
                                <div class="col-md-9">
                                    <input type="text" name="party_mobile" ng-value="partyMobile" class="form-control"
                                           readonly>
                                    <input type="hidden" name="party_name" ng-value="partyName" class="form-control"
                                           readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Address </label>
                                <div class="col-md-9">
                                    <textarea name="party_address" ng-value="partyAddress" class="form-control"
                                              readonly></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Remark </label>
                            <div class="col-md-9">
                                <textarea name="comment" class="form-control"></textarea>
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Quantity</label>
                            <div class="col-md-8">
                                <input type="text" name="total_quantity" ng-value="totalQuantity" class="form-control"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Amount</label>
                            <div class="col-md-8">
                                <input type="number" name="total_amount" ng-value="getTotalFn()" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Discount</label>
                            <div class="col-md-4">
                                <input type="number" ng-model="flatDiscount" class="form-control" placeholder="0"
                                       step="any">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="total_discount" class="form-control"
                                       ng-value="getTotalDiscountFn()" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total</label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                       class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="text" ng-value="partyBalance" class="form-control" readonly>
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
                            <label class="col-md-4 control-label">Paid</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="payment" class="form-control"
                                               step="any" placeholder="0">
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control" ng-init="transactionBy='cash'"
                                                ng-model="transactionBy" required>
                                            <option value="cash">Cash</option>
                                            <option value="bKash">bKash</option>
                                            <option value="rocket">Rocket</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" ng-value="getCurrentTotalFn()" class="form-control"
                                               step="any" readonly>
                                        <input type="hidden" name="current_balance" ng-value="currentBalance">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="currentSign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group pull-right mt-1">
                            <input type="submit" name="save" value="Save" class="btn btn-primary">
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
    var submitbtn = document.querySelector("input[type='submit']");
    var paid_amount = document.querySelector("input[name='paid']");
    var message = document.querySelector("#message");
    var submitvalidate = true;

    document.addEventListener("click", (event) => {
        if (event.target.type == "submit") {
            validation();
        }
    });

    function validation() {
        if (paid_amount.value == "") {
            message.innerText = "Paid field is required , This field cannot be empty";
        }
        if (paid_amount.value != "" && submitvalidate == true) {
            message.innerText = "";
            submitbtn.click();
            submitbtn.style.display = "none";
            submitvalidate == false;
        }
    }

    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
