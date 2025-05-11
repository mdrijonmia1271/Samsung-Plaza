<script src="<?php echo site_url('private/js/ngscript/sales_elec/ngscript/retailSaleEntryCtrl.js?') . time(); ?>"></script>
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
<style>
    .company_title {display: block !important;}
    .content-fixed-nav {padding-left: 15px;}
    .table2 tr td {padding: 0 !important;}
    .table2 tr td input {border: 1px solid transparent;}
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    #page-content-wrapper {background: #ECEFF4;}
    .select2-choice {border-radius: 0 !important;}
    .custom_sale_table .form-control {height: 30px;}
    .custom_sale_table tr td {line-height: 18px !important;}
    .custom_sale_table .btn {padding: 4px 12px !important;}
    .screen_list {display: flex !important;}
    .full_screen_btn {
        background: #28A9E0;
        border-radius: 50%;
        text-align: center;
        font-size: 20px;
        border: none;
        color: #fff;
        width: 38px;
        height: 38px;
        outline: none;
        box-shadow: none;
    }
    .title_select {
        border: 1px solid #28A9E0;
        display: flex;
    }
    .title_select label {
        border: 1px solid #ccc;
        line-height: 40px;
        padding: 0 5px;
        margin: 0;
    }
    .select2-choice {
        text-transform: capitalize !important;
        line-height: 31px !important;
        font-size: 15px !important;
        height: 32px !important;
    }
    .select2-choice>span:first-child, .select2-chosen {
        padding: 5px 12px !important;
    }
    .select2-container {
        overflow: hidden !important;
        height: 32px;
    }
    .select2-container .select2-choice .select2-arrow b {background-position: 0 6px;}
    .title_date {border: 1px solid #28A9E0;}
    .title_date .form-control {
        line-height: 42px !important;
        height: 42px !important;
    }
    .select2-results .select2-result-label {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
    .title_date .input-group-addon {border-radius: 0 !important;}
    .table_style {
        height: 70vh !important;
        height: 100%;
        overflow: auto;
    }
    .custom_placeholder {position: relative;}
    .custom_placeholder span {
        position: absolute;
        right: 1px;
        background: #ddd;
        top: 1px;
        height: 32px;
        line-height: 32px;
        padding: 0 5px;
        font-size: 14px;
        min-width: 26px;
        text-align: center;
    }
    .d-none {display: none;}
    .submit_but_custom {padding-left: 0;}
    .submit_but_custom .btn {
        width: 100%;
        height: 54px;
        font-size: 19px;
        padding: 0;
        text-transform: uppercase;
        outline: none;
    }
    .developed_part .time {
        padding: 27px 12px;
        background: #ddd;
        text-align: center;
    }
    .developed_part .time h3 {
        font-weight: bold;
        font-size: 29px;
        color: #28A9E0;
        margin: 0;
    }
    .developed_part .developed {
        background: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .developed_part .developed>a {
        display: inline-block;
        padding: 5px 12px;
    }
    .developed_part .developed img {
        max-width: 162px;
        min-height: 75px;
        width: 100%;
    }
    .developed_part .developed h4 {
        position: absolute;
        color: #286090;
        top: -5px;
        left: 5px;
        font-weight: 700;
        font-size: 15px;
    }
    .page_ctrl {
        min-height: calc(100vh - 97px);
        margin-bottom: 0;
    }
    .page_ctrl.active {min-height: 100vh;}
    .page_ctrl.active .panel-body {padding: 30px 15px 15px;}
    .page_ctrl.active .developed_part .time {padding: 20px 12px;}
    .page_ctrl.active .developed_part .time h3 {font-size: 40px;}
    @media print {
        .content-fixed-nav {display: none;}
    }
    @media screen and (min-width: 991px) {
        .desktop_padding {padding-left: 5% !important;}
    }
</style>


<div class="container-fluid" ng-controller="retailSaleEntryCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Retail Sale</h1>
                </div>
                <div class="panal-header-title pull-left">
                    <p class="hide" style="color: red;font-weight:bold; margin-left: 25px;">
                        <?php echo ($last_voucher) ? "Last voucher: " . $last_voucher[0]->voucher_no : " "; ?></p>
                </div>
            </div>

            <div class="panel-body" ng-click>

                <form  class="form-horizontal clearfix" ng-submit="addNewProductFn()">
                    <div class="row">
                        <div class="col-md-5" style="box-sizing: border-box;">
                            <input list="browsers" type="text" placeholder="Type product code here." name="product" ng-model='product_barcode' class="form-control super-border" tabindex="1" autofocus required>
                            <datalist id="browsers">
                                <option ng-repeat="product in allProducts" value="{{product.code}}">{{ product.product_model }} - <small> {{ product.code }}  </small></option>
                            </datalist>
                        </div>
                    </div>
                </form>
                <br>
            
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale_elec/retail_sale/store', $attr);
                ?>

                <div class="row">
                    <div class="col-md-3">
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
                            <select class="form-control" name="godown_code" ng-model="godown_code"
                                    ng-init="godown_code = '<?php echo $this->data['branch']; ?>'">
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
                               ng-model="godown_code" ng-value="godown_code"
                               required>
                    <?php } ?>

                    <div class="col-md-4">
                        <select ui-select2="{ allowClear: true}" class="form-control" ng-model='product_code'
                                data-placeholder="Select Product" ng-change="addNewProductFn()" required>
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
                        <th width="70">QTY</th>
                        <th width="100">Sale Price</th>
                        <th width="50px">Dis.(%)</th>
                        <th width="100px">Discount</th>
                        <th width="50px">Flat Dis</th>
                        <th width="100px">Total</th>
                        <th style="width: 50px;">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="product[]" ng-value="item.product">
                        <input type="hidden" name="product_model[]" ng-value="item.product_model">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="godown_code" ng-value="item.godown_code">
                        <input type="hidden" name="unit[]" ng-value="item.unit">

                        <td class="td-input" ng-bind="$index + 1"></td>
                        <td class="td-input" ng-bind="item.category | textBeautify"></td>
                        <td class="td-input" ng-bind="item.product_model"></td>

                        <td>
                            <input type="text" class="form-control" name="product_serial[]">
                        </td>

                        <td class="td-input" ng-bind="item.stock_qty"></td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1"
                                   max="{{ item.maxQuantity }}"
                                   ng-model="item.quantity" step="any">
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
                            <input type="number" name="flat_discount[]" class="form-control" ng-model="item.flat_discount" >
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

                        <input type="hidden" name="sap_type" value="cash">
                        
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

                        <div class="form-group">
                            <label class="col-md-3 control-label"> Name </label>
                            <div class="col-md-9">
                                <input type="text" name="party_code" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile</label>
                            <div class="col-md-9">
                                <input type="text" name="partyInfo[mobile]" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-9">
                                <textarea name="partyInfo[address]" rows="4" class="form-control"></textarea>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Remark </label>
                            <div class="col-md-9">
                                <textarea name="comment" rows="4" class="form-control"></textarea>
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
                                <input type="text" ng-model="flat_discount" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="total_discount" ng-model="total_discount"
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>