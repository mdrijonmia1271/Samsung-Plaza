<script src="<?php echo site_url('private/js/ngscript/PurchaseEntryElec.js?').time(); ?>"></script>
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
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css"/>
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
        padding: 0 12px;
        margin: 0;
    }
    .select2-choice {
        text-transform: capitalize !important;
        line-height: 31px !important;
        font-size: 15px !important;
        height: 42px !important;
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
<style>
    .table tr td {padding: 7px 8px !important;}
    .table tr td.input {padding: 0 !important;}
    .table tr td input {
        border: 1px solid transparent;
        padding: 0 8px;
        text-align: center;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    .super-border {
        border: 5px solid #00A8FF;
        border-radius: 5px;
        padding: 20px 15px;
        font-size: 22px;
    }
    input[type=checkbox] {margin: 0 0 0 -12px;}
</style>
<div class="container-fluid" ng-controller="PurchaseEntryElec" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Electronics Purchase</h1>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel-body" ng-click>
                <!-- horizontal form -->
                  <div class="panel-body" >
                <form  class="form-horizontal clearfix" ng-submit="addNewProductFn()">
                    <div class="row">
                        <div class="col-md-5" style="box-sizing: border-box;">
                            <input list="browsers" type="text" placeholder="Type product code here." name="product" ng-model='product_barcode' class="form-control super-border" tabindex="1" autofocus >
                            <datalist id="browsers">
                                <!--<option ng-repeat="product in allProducts" value="{{product.code}}">{{ product.product_model }} </small></option>-->
                                             <?php if(!empty($allProducts)){ foreach($allProducts as $key => $row){ ?>
                            <option value="<?php echo $row->product_code; ?>">
                                <?php echo  $row->product_code.'-'.filter($row->product_model); ?>
                            </option>
                            <?php }} ?>
                            </datalist>
                        </div>
                    </div>
                </form>
                
               
                <br>
                <br>
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

                    <div class="col-md-1">
                        <!-- <input type="number" class="form-control" placeholder="Quantity" min="1" ng-model="quantity"> -->
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
                    <?php } ?>
                </div>
                <hr>
                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Product Name</th>
                        <th>Model</th>
                        <th width="70">Qty</th>
                        <th width="100">Comm.(%)</th>
                        <th width="100">Flat Dis.</th>
                        <th width="120">Sale Price</th>
                        <th width="120">Purchase Price</th>
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
                            <input type="hidden" name="brand[]" ng-value="item.brand">
                            <input type="hidden" name="unit[]" class="form-control" ng-value="item.unit">
                            <input type="hidden" name="color[]" class="form-control" value="na">
                        </td>
                        
                         <td>
                            <input type="number" name="quantity[]" class="form-control" min="1"
                                ng-model="item.quantity">
                        </td>
                        
                        <td>
                            <input type="number" step="any" name="purchase_commission[]" class="form-control" min="0"
                                ng-model="item.commission">
                        </td>
                        
                        <td>
                            <input type="text" name="flat_discount[]" class="form-control" ng-model="item.flat_discount" >
                        </td>
                        
                        <td>
                            <input type="number" name="sale_price[]" class="form-control" ng-model="item.sale_price">
                            <input type="hidden" name="dealer_sale_price[]" class="form-control" ng-model="item.dealer_sale_price">
                        </td>

                        <td>
                            <input type="text" name="purchase_price[]" class="form-control"
                                ng-value="setPurchasePrice($index)" readonly>
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