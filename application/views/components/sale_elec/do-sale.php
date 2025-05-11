<style>
    .table2 tr td{padding: 0 !important;}
    .table2 tr td input{border: 1px solid transparent;}

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button{
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>

<div class="container-fluid" ng-controller="DOSale" ng-cloak>
    <div class="row">
        <?php echo $confirmation; ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">New DO Sale</h1>

                    <div class="pull-right">
                        <strong style="color: green; font-size: 20px;">{{available}}</strong>
                    </div>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
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
                                    <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" name="voucher_number"
                                 value="<?php if($voucher_number != NULL){echo $voucher_number;} ?>"
                                 placeholder="Voucher No" class="form-control" required >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" name="meta[company]">
                            <option value="">-- Company --</option>
                            <?php foreach ($allCompany as $key => $row) { ?>
                            <option value="<?php echo $row->code; ?>"><?php echo filter($row->name); ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                           <div class="col-md-12">
                                <select class="form-control" ng-model="category"
                                    ng-change="setAllBrand();" required>
                                    <option value="" selected disabled>
                                        -- Category --
                                    </option>
                                    <?php
                                    if($allCategory != null){
                                        foreach($allCategory as $key => $row){
                                    ?>
                                    <option value="<?php echo $row->category; ?>">
                                        <?php echo str_replace('_', ' ', $row->category); ?>
                                    </option>
                                    <?php }} ?>
                                </select>
                           </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="col-md-12">
                                <select class="form-control" ng-model="subcategory"
                                    ng-change="setAllProducts();" required>
                                    <option value="" selected disabled>
                                        -- Brand --
                                    </option>
                                    <option ng-repeat="row in allSubcategory" ng-value="row.subcategory">
                                        {{ row.subcategory | removeUnderScore }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="col-md-12">
                                <select class="form-control" ng-model="product" ng-change="setAllDONoFn()" required>
                                    <option value="" selected disabled>Product</option>
                                    <option ng-repeat="row in allProducts" ng-value="row.product_name">
                                        {{ row.product_name | removeUnderScore }}
                                    </option>
                                </select>
                            </div>
                         </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="col-md-12">
                                <select class="form-control" ng-model="do_no" ng-change="getdoStockFn();" required>
                                    <option value="" selected disabled>DO No </option>
                                    <option ng-repeat="row in allDONO" ng-value="row.do_no">{{ row.do_no }}</option>
                                </select>

                                <input type="hidden" class="form-control" ng-value="unit" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div style="display: flex; margin-bottom: 15px;">
                            <label style="width: 100px; margin-top: 8px;">Truck No</label>
                            <input type="text" class="form-control" name="meta[truck_no]">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label  style="float:left; width: 75px;" class="control-label">D/N No</label>
                            <div class="col-md-9" style="padding: 0 0 0 15px;">
                                <input type="text" name="meta[dn_no]"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div ng-init="showroom_id='<?php echo $branch; ?>'">
                            <div class="pull-right">
                                <a class="btn btn-success" ng-click="addNewProductFn()">
                                    <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th>Product </th>
                        <th>Company</th>
                        <th width="120px">DO IN</th>
                        <th width="120px">Quantity</th>
                        <th width="120px">Buy Rate</th>
                        <th width="100px">Sale Rate</th>
                        <th width="100px">Total</th>
                        <th style="width: 50px;">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>
                            <input type="hidden" name="product_code[]" value="{{ item.product_code }}">
                            <input type="hidden" name="unit[]" class="form-control" value="{{item.unit}}">
                            <input type="hidden" name="do_no[]" class="form-control" value="{{item.do_no}}">
                        </td>

                        <td>
                            <input type="text"  name="brand[]" class="form-control" ng-model="item.subcategory" readonly>
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1" max="{{ item.maxQuantity }}" ng-model="item.quantity" step="any">
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-value="item.purchase_price" readonly>
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0" ng-model="item.price" step="any">
                            <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price" step="any">
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-value="setSubtotalFn($index)" readonly>
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

                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Customer </label>
                            <div class="col-md-9">
                                <!--select
                                    name="code"
                                    ng-model="partyCode"
                                    ng-change="findPartyFn()"
                                    class="form-control">
                                    <option value="" selected disabled>&nbsp;</option>
                                    <?php
                                    if($allClients != null){
                                        foreach ($allClients as $key => $row) {
                                    ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo $row->name; ?>
                                    </option>
                                    <?php }} ?>
                                </select-->
                                <input
                                    name="code"
                                    ng-model="partyCode"
                                    ng-change="findPartyFn()"
                                    class="form-control" type="text" list="clientList"/>
                                <datalist id="clientList">
                                    <?php
                                    if($allClients != null){
                                        foreach ($allClients as $key => $row) {
                                    ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo $row->name . "[" . $row->address . "]"; ?>
                                    </option>
                                    <?php }} ?>
                                </datalist>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-md-3 control-label">Customer Name</label>
                            <div class="col-md-9">
                                <input type="text"  ng-model="partyInfo.name" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile Number </label>
                            <div class="col-md-9">
                                <input type="text" name="mobile" ng-model="partyInfo.contact" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-9">
                                <textarea name="address" class="form-control" readonly>{{ partyInfo.address }}</textarea>
                            </div>
                        </div>


                        <!--div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Less/Discount</label>
                            </div>
                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <input type="number" step="any" min="0" ng-model="less.quantity" class="form-control" name="meta[less_quantity]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 2px; font-size: 12px;">Per Bag</label>
                                    <input type="number" step="any" min="0" ng-model="less.amount" class="form-control" name="meta[less_amount]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 8px; font-size: 12px;">Total</label>
                                    <input type="number" step="any" min="0" readonly ng-value="getLessTotal();" class="form-control" name="meta[less_total]">
                                </div>
                            </div>

                             <div class="col-md-12">
                                <p style="font-weight: bold; font-size: 12px; text-align: center; color: #ff7d2e;">(Note: যদি কোন ছাড় / লেছ না হয় discount এর ঘর 0.00 থাকবে।</p>
                            </div>

                        </div-->

                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Truck Fare</label>
                            </div>
                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <input type="number" step="any" min="0" ng-model="truck.quantity" ng-value="totalQuantityFn()"  class="form-control" name="meta[truck_quantity]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 2px; font-size: 12px;">Per Bag</label>
                                    <input type="number" step="any" min="0" ng-model="truck.amount"  class="form-control" name="meta[truck_amount]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 8px; font-size: 12px;">Total</label>
                                    <input type="number" step="any" min="0" ng-value="getTruckTotal();"  class="form-control" name="meta[truck_total]">
                                </div>
                            </div>

                            <!-- <div class="col-md-12">
                                <p style="font-weight: bold; font-size: 12px; text-align: center; color: #ff7d2e;">(Note: যদি customer ভাড়া দিয়ে দেয় তাহলে truck ভাড়া total এ হবে আর  না দিলে ভাড়া বাদ হবে)</p>
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">Commission</label>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <input
										type="number"
										min="0"
										ng-model="commission.quantity" ng-value="totalQuantityFn()"
										class="form-control"
										name="meta[commission_quantity]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 2px; font-size: 12px;">Per Bag</label>
                                    <input type="number" step="any" min="0" ng-model="commission.amount" class="form-control" name="meta[commission_amount]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 8px; font-size: 12px;">Total</label>
                                    <input type="number" step="any" min="0" readonly class="form-control" ng-value="getCommissionTotal();" name="meta[commission_total]" step="any" min="0" >
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <p style="font-weight: bold; font-size: 12px; text-align: center; color: #ff7d2e;">(Note: Default 0.00 থাকবে। কমিশন যদি পায় তাহলে আমরা বসিয়ে দিব)</p>
                        </div> -->
                    </div>





                    <div class="col-md-6">
                      <div class="form-group">
                            <label class="col-md-4 control-label">Labour Cost</label>
                            <div class="col-md-8">
                                <input type="number" name="meta[labour_cost]" ng-model="amount.labour" class="form-control" step="any">
                            </div>
                        </div>

	                    <div class="form-group">
	                        <label class="col-md-4 control-label">Total </label>
	                        <div class="col-md-8">
	                            <input type="number" name="total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                                <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()" class="form-control" readonly>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label class="col-md-4 control-label">Discount</label>
	                        <div class="col-md-8">
                                <input type="number" name="discount" ng-model="amount.discount" class="form-control" step="any">
	                        </div>
	                    </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Truck Fare</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" readonly ng-value="amount.truck_rent" name="meta[truck_rent]" required>
                            </div>
                        </div>

	                    <div class="form-group">
	                        <label class="col-md-4 control-label">Grand Total</label>
	                        <div class="col-md-8">
	                            <input type="number" name="grand_total" ng-value="getGrandTotalFn()" class="form-control" step="any" readonly>
	                        </div>
	                    </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="previous_balance" ng-model="partyInfo.balance" class="form-control" step="any" readonly>
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text" name="previous_sign" ng-value="partyInfo.sign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

	                    <div class="form-group">
	                        <label class="col-md-4 control-label">Paid <span class="req">*</span></label>
                            <div class="col-md-8">
	                            <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any">
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" ng-model="transactionBy" class="form-control" required>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash" >bKash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
	                    </div>


                        <?php /*
                        <!-- for cash cash -->
                        <div ng-if="transactionBy == 'cash'">
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Bank Name <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <select  name="do_meta[bankname]" class="form-control">
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
                                    <input type="text" name="do_meta[branchname]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Account No <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <input type="text" name="do_meta[accountno]" class="form-control">
                                </div>
                            </div>
                        </div>
                        */ ?>

                        <!-- for selecting cheque -->
                        <div ng-if="transactionBy == 'cheque'">
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Bank Name <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <select  name="do_meta[bankname]" class="form-control">
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
                                    <input type="text" name="do_meta[branchname]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Cheque No <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <input type="text" name="do_meta[chequeno]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Pass Date <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <input type="text" name="do_meta[passdate]" placeholder="YYYY-MM-DD" class="form-control">
                                    <input type="hidden" name="do_meta[status]" value="pending">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly>
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="partyInfo.csign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
		            </div>
                </div>

                <div class="btn-group pull-right" ng-init="active=false" ng-hide="active">
                    <input type="submit" name="save" value="Save"   class="btn btn-primary">
                </div>
                <div class="btn-group pull-right">
                  <p ng-bind="message" style="font-weight:bold;color:red;font-size:18px;"></p>
                </div>


                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });

    });
</script>
