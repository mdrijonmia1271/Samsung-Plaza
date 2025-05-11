<style>
    .table2 tr td{padding: 0 !important;}
    .table2 tr td input{border: 1px solid transparent;}
    .table tr th.th-width{width: 100px !important;}
</style>

<div class="container-fluid" ng-controller="DOEditSaleCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit or, Return Sale</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/doEditCtrl?vno=' . $this->input->get('vno'), $attr);
                ?>

                <p>
                    <label>Date: {{ info.date }} | Voucher No: {{ info.vno }}</label>
                    <label class="pull-right">Truck No: {{ info.truck_no }} | D/N No: {{ info.dn_no }}</label>
                </p>
                <hr style="margin-top: 6px;">

                <!-- all input hidden file -->
                <?php $vno = $this->input->get('vno'); ?>
                <input type="hidden" name="voucher_no" ng-init='info.vno="<?php echo $vno; ?>"' ng-value="info.vno">
                <input type="hidden" name="godown" value="<?php echo $branch; ?>">
                <input type="hidden" name="showroom_id" value="<?php echo $branch; ?>">
                <input type="hidden" name="party_code" ng-value="info.partyCode">
                <input type="hidden" name="party_mobile" ng-value="info.partyMobile">
                <input type="hidden" name="sap_type" ng-value="info.sapType">

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th>Product</th>
                        <th>Company</th>
                        <th class="th-width">Amount</th>
                        <th class="th-width">Old Quantity</th>
                        <th class="th-width">New Quantity</th>
                        <th class="th-width">Old Sum</th>
                        <th class="th-width">New Num</th>
                    </tr>

                    <tr ng-repeat="item in records">
                        <td style="padding: 6px 8px !important;">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            <input type="text" value="{{item.product}}" class="form-control" readonly>
                            <input type="hidden" name="id[]" ng-value="item.id">
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        </td>

                         <td>
                            <input type="text" value="{{item.brand}}" class="form-control" readonly>
                         </td>

                        <td>
                            <input type="number" name="new_sale_price[]" class="form-control" min="0" ng-model="item.newSalePrice" step="any">
                        </td>

                        <td>
                            <input type="number" name="old_quantity[]" class="form-control" ng-model="item.oldQuantity" step="any" readonly>
                        </td>

                        <td>
                            <input type="number" name="new_quantity[]" class="form-control" ng-model="item.newQuantity" step="any" min="0">
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-value="getOldSubtotalFn($index)" readonly>
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-value="getNewSubtotalFn($index)" readonly>
                        </td>
                    </tr>
                </table>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Total </label>
                            <div class="col-md-8">
                                <input type="number" name="old_total" class="form-control" ng-value="amount.oldTotal" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_old_discount" ng-value="amount.oldTotalDiscount" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Grnad Total </label>
                            <div class="col-md-8">
                                <input type="number" name="old_grand_total" class="form-control" ng-value="getOldGrandTotalFn()" step="any" readonly>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Customer Code </label>
                            <div class="col-md-8">
                                <input type="text" name="customerName" class="form-control" ng-value="info.partyCode" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Customer Mobile </label>
                            <div class="col-md-8">
                                <input type="text" name="customerMobile" class="form-control" ng-value="info.partyMobile" readonly>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><label class="control-label">Truck Fare</label></div>
                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <input type="number" step="any" ng-value="getTotalProductQuantityFn()" class="form-control" name="meta[truck_quantity]" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 2px; font-size: 12px;">Per Bag</label>
                                    <input type="number" step="any" min="0" ng-model="info.truck_amount"  class="form-control" name="meta[truck_amount]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 8px; font-size: 12px;">Total</label>
                                    <input type="number" step="any" min="0" ng-value="getTotalTruckRentFn();"  class="form-control" name="meta[truck_total]">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3"><label class="control-label">Commission</label></div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <input
                                        type="number"
                                        min="0"
                                        ng-value="getTotalProductQuantityFn()"
                                        class="form-control"
                                        name="meta[commission_quantity]"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 2px; font-size: 12px;">Per Bag</label>
                                    <input type="number" step="any" min="0" ng-model="info.commission_amount" class="form-control" name="meta[commission_amount]">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div style="display: flex; margin-bottom: 15px;">
                                    <label style="width: 90px; margin-top: 8px; font-size: 12px;">Total</label>
                                    <input type="number" step="any" min="0" readonly class="form-control" ng-value="getCommissionTotalFn();" name="meta[commission_total]" step="any" min="0" >
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Labour Cost </label>
                            <div class="col-md-8">
                                <input type="number" name="meta[labour_cost]" ng-model="info.labour_cost" class="form-control" step="any">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="number" name="new_total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
	                        <label class="col-md-4 control-label">Discount</label>
	                        <div class="col-md-8">
                                <input type="number" name="new_discount" ng-model="amount.discount" class="form-control" step="any">
	                        </div>
	                    </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Truck Fare </label>
                            <div class="col-md-8">
                                <input type="number" name="meta[truck_rent]" ng-value="getTotalTruckRentFn();" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">New Grand Total</label>
                            <div class="col-md-8">
                                <input type="number" name="new_grand_total" ng-value="getNewGrandTotalFn()" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Differences </label>
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
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="previous_balance" ng-model="info.previousBalance" class="form-control" step="any" readonly>
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text" name="previous_sign" ng-value="info.sign" class="form-control" readonly>
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
                                        <input type="text" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly>
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="info.csign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" name="change" value="Update" class="btn btn-primary">
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
