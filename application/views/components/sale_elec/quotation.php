<script src="<?php echo site_url('private/js/ngscript/quotationEntryCtrl.js?') . time(); ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<style>
    .table2 tr td {padding: 0 !important;}
    .table2 tr td input {border: 1px solid transparent;}
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0;}
    input[type=number] {-moz-appearance: textfield;}
</style>
<div class="container-fluid" ng-controller="quotationEntryCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Quotation</h1>
                </div>
                <div class="panal-header-title pull-left">
                    <p class="hide" style="color: red;font-weight:bold; margin-left: 25px;">
                        <?php echo ($last_voucher) ? "Last voucher: " . $last_voucher[0]->voucher_no : " "; ?>
                    </p>
                </div>
            </div>

            <div class="panel-body" ng-click>
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/quotation/store', $attr);
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3">
                            <select class="form-control" name="godown_code" ng-model="godown_code" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'">
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if(!empty($allGodowns)){foreach ($allGodowns as $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                    </option>
                                <?php }} ?>
                            </select>
                        </div>
                    <?php }else{ ?>
                        <input type="hidden" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                               ng-model="godown_code" ng-value="godown_code" required>
                    <?php } ?>

                    <div class="col-md-4">
                        <select ui-select2="{ allowClear: true}" class="form-control" ng-model='product_code'
                                data-placeholder="Select Product" ng-change="addNewProductFn()" required>
                            <option value="" selected disable></option>
                            <option ng-repeat="product in allProducts" value="{{product.product_code}}">
                                {{ product.product_model }}
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
                        <th width="70">QTY</th>
                        <th width="100">Price</th>
                        <th width="100px">Total</th>
                        <th style="width: 50px;">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="product[]" ng-value="item.product">
                        <input type="hidden" name="product_model[]" ng-value="item.product_model">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="unit[]" ng-value="item.unit">

                        <td class="td-input" ng-bind="$index + 1"></td>
                        <td class="td-input" ng-bind="item.category | textBeautify"></td>
                        <td class="td-input" ng-bind="item.product_model"></td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" ng-model="item.quantity" step="any">
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0"
                                   ng-model="item.sale_price"
                                   step="any">
                            <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price"
                                   step="any">
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
                                <textarea name="partyInfo[address]" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Remark </label>
                            <div class="col-md-9">
                                <textarea name="comment" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        
                        <hr />

                        <div class="form-group">
                            <label class="col-md-3 control-label">Warranty </label>
                            <div class="col-md-9">
                                <textarea name="guarantee" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        
                        <hr />
                    
                    </div>
                    
                    <hr />


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
                                <input type="number" min="0" name="total" ng-value="getTotalFn()" class="form-control"
                                       step="any" required readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Discount</label>
                            <div class="col-md-8">
                                <input type="text" name="total_discount" ng-model="flat_discount" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Service Charge</label>
                            <div class="col-md-8">
                                <input type="text"  name="service_charge"  ng-model="service_charge" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total</label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()" class="form-control" step="any" readonly>
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