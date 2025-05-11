<script src="<?php echo site_url('private/js/ngscript/returnSaleCtrl.js') ?>"></script>
<style>
    .table2 tr td{
    padding: 0 !important;
    }
    .table2 tr td input{
    border: 1px solid transparent;
    }
    .new-row-1 .col-md-4{
    margin-bottom: 8px;
    }
    .table tr th.th-width{
    width: 100px !important;
}
</style>
<div class="container-fluid" ng-controller="returnSaleCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Return Sale</h1>
                </div>
            </div>
            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('sale/saleReturnCtrl?vno=' . $this->input->get('vno'), $attr);
                ?>
                <label>Date: {{ amount.date }}</label> |
                <label>Voucher No: {{ amount.voucher }}</label>
                <hr style="margin-top: 5px;">
                <?php
                $info = $this->action->read("saprecords",array("voucher_no" => $this->input->get('vno')));
                $date = ($info) ? $info[0]->sap_at : date("Y-m-d");
                ?>
                <div class="col-md-4">
                    <div class="input-group date" id="datetimepicker">
                        <input type="text" name="date" class="form-control" value="<?php echo $date; ?>" placeholder="Date" readonly>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <br><br>
                <!-- all hidden file -->
                <?php $vno = $this->input->get('vno'); ?>
                <input type="hidden" name="voucher_no" ng-init="vno='<?php echo $vno; ?>'" ng-model="vno">
                <input type="hidden" name="party_code" ng-value="amount.partyCode">
                <input type="hidden" name="stock_type" ng-value="amount.sapType">
                <!-- product table -->
                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th width="250px">Product Name</th>
                        <th width="80px">Unit</th>
                        <th class="th-width">Sale Price</th>
                        <th class="th-width">Old Quantity</th>
                        <th class="th-width">Return Quantity</th>
                        <th class="th-width">Old Sum</th>
                        <th class="th-width">Return Sum</th>
                    </tr>
                    <tr ng-repeat="item in records">
                        <td style="padding: 6px 8px !important;">
                            {{ $index + 1 }}
                            <input type="hidden" name="id[]" value="{{ item.id }}">
                        </td>
                        <td style="padding: 6px 8px !important;">
                            <input type="text" readonly  class="form-control" value="{{ item.product_name }}">
                            <input type="hidden" name="product_code[]" value="{{ item.product_code }}">
                            <input type="hidden" name="godown" value="{{ item.godown }}">
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                        </td>
                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0" ng-model="item.sale_price" step="any" readonly>
                        </td>
                        <td>
                            <input type="number" name="old_quantity[]" class="form-control" ng-model="item.oldQuantity" readonly>
                        </td>
                        <td>
                            <input type="number" name="return_quantity[]" class="form-control" min="0" ng-model="item.newQuantity" max="{{ item.maxQuantity}}">
                        </td>
                        <td>
                            <input type="number" name="subtotal[]" class="form-control" ng-model="item.oldSubtotal" ng-value="getOldSubtotalFn($index)" readonly step="any">
                        </td>
                        <td>
                            <input type="number" name="newsubtotal[]" class="form-control" ng-model="item.newSubtotal" ng-value="getNewSubtotalFn($index)" readonly step="any">
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-6 control-label">Previous Total </label>
                            <div class="col-md-6">
                                <input type="number" name="total" class="form-control" ng-value="amount.oldTotal" step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6 control-label">Previous Discount </label>
                            <div class="col-md-6">
                                <input type="number" name="total_discount" ng-value="amount.oldTotalDiscount" class="form-control" step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6 control-label">Previous Grand Total </label>
                            <div class="col-md-6">
                                <input type="number" name="old_grand_total" class="form-control" ng-value="getOldGrandTotalFn()" step="any" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6 control-label">Previous Paid </label>
                            <div class="col-md-6">
                                <input type="number" name="old_paid" class="form-control" ng-value="amount.old_paid" step="any" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Return Amount </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="new_total" class="form-control" ng-value="getTotalFn()" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="amount_sign" ng-value="amount.sign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-md-4 control-label">Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="new_total_discount" ng-model="amount.newTotalDiscount" class="form-control" step="any">
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-md-4 control-label">New Grand Total </label>
                            <div class="col-md-8">
                                <input type="number" name="new_grand_total" ng-value="getNewGrandTotalFn()" class="form-control" step="any" readonly>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-md-4 control-label">Difference</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="grand_total" ng-value="getGrandTotalDifferenceFn()" class="form-control" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="amount_sign" ng-value="amount.sign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="previous_balance" ng-value="partyInfo.previousBalance" class="form-control" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="previous_sign" ng-value="partyInfo.sign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-md-4 control-label">Paid </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any">
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
                        </div-->
                        <!--div class="form-group">
                            <label class="col-md-4 control-label">Total Paid</label>
                            <div class="col-md-8">
                                <input type="number" name="total_paid" ng-value="getTotalPaidFn()" class="form-control" step="any" readonly>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="partyInfo.csign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group pull-right">
                            <input type="submit" name="change" value="Return" class="btn btn-info">
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
        format: 'YYYY-MM-DD',
        minDate : "2017",
        maxDate : "2019",
        useCurrent: false
    });
</script>