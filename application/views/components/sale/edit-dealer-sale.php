<script src="<?php echo site_url('private/js/ngscript/EditDealerSaleEntryCtrl.js?').time(); ?>"></script>
<style>
    .table2 tr td{padding: 0 !important;}
    .table2 tr td input{border: 1px solid transparent;}
    .table tr th.th-width{width: 100px !important;}
</style>

<div class="container-fluid" ng-controller="EditDealerSaleEntryCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Dealer Voucher</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/dealerSaleEditCtrl?vno=' . $info->voucher_no, $attr);
                ?>

                <div class="col-md-5">
                    <label class="col-md-2">Date</label>
                    <div class="form-group col-md-8">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" value="{{ info.date }}" class="form-control" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <label class="col-md-6">Voucher No: <?php echo $info->voucher_no; ?></label>
                
                <hr style="margin-top: 6px;">
                

                <!-- all input hidden file -->
                <input type="hidden" name="voucher_no" ng-init='voucher_no="<?php echo $info->voucher_no; ?>"' ng-model="voucher_no" ng-value="voucher_no">
                <input type="hidden" name="godown_code" ng-init='godown_code="<?php echo $info->godown_code; ?>"' ng-model="godown_code" ng-value="godown_code">
                <input type="hidden" name="party_code" ng-init='party_code="<?php echo $info->party_code; ?>"' ng-model="party_code" ng-value="party_code">
                <input type="hidden" name="party_mobile" ng-value="info.partyMobile">
                <input type="hidden" name="sap_type" ng-value="info.sapType">

                <table class="table table-bordered table2">
                    <tr>
                        <th style="40px;">SL</th>
                        <th style="345px;">Product Name</th>
                        <th width="150px">Model</th>
                        <th>Old Qty</th>
                        <th>New Qty</th>
                        <th>Sale Price</th>
                        <th>Com.(%)</th>
                        <th>Commission</th>
                        <th>Old Total</th>
                        <th>New Total</th>
                    </tr>

                    <tr ng-repeat="item in records">
                        <td style="padding: 6px 8px !important;">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            <input type="text"   value="{{ item.category | textBeautify }}" class="form-control" readonly>
                            <input type="hidden" ng-value="item.product" class="form-control" readonly>
                            <input type="hidden" name="id[]" ng-value="item.id">
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="unit[]" class="form-control" ng-value="item.unit" readonly>
                        </td>
                        <td style="padding: 6px 8px !important;">
                            {{item.pro_model}}
                        </td>
                        <td>
                            <input type="number" name="old_quantity[]" class="form-control" ng-model="item.oldQuantity" step="any" readonly>
                        </td>
                        <td>
                            <input type="number" name="new_quantity[]" class="form-control" ng-model="item.newQuantity" step="any" min="0">
                        </td>
                        <td>
                            <input type="number" name="new_sale_price[]" class="form-control" min="0" ng-model="item.newSalePrice" step="any">
                        </td>
                        <td>
                            <input type="number" name="commission_per[]" class="form-control" min="0" ng-model="item.discount_percentage" step="any">
                        </td>
                        <td>
                            <input type="number" name="commission[]" class="form-control" min="0" ng-value="getCommissionFn($index)" readonly>
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
                     
                    <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                             <label class="col-md-3 control-label">Client</label>
                             <div class="col-md-9">
                                 <input type="text" name="name" readonly ng-value="info.partyName" class="form-control">
                             </div>
                          </div>

                          <div class="form-group">
                             <label class="col-md-3 control-label">Mobile </label>
                             <div class="col-md-9">
                                 <input type="text" name="mobile_number" readonly ng-value="info.partyMobile" class="form-control">
                             </div>
                          </div>

                          <div class="form-group">
                             <label class="col-md-3 control-label">Address</label>
                             <div class="col-md-9">
                                 <textarea name="details_address" class="form-control" readonly ng-model="info.partyAddress"></textarea>
                             </div>
                          </div>
                      </div>
                     </div>

                       <hr>

                       <div class="row">
                         <div class="col-md-12">
                           <div class="form-group">
                               <label class="col-md-6 control-label">Previous Total</label>
                               <div class="col-md-6">
                                    <input type="text" name="old_total" class="form-control" ng-value="amount.oldTotal" step="any" readonly>
                               </div>
                           </div>
                         </div>
                         <div class="col-md-12">
                           <div class="form-group">
                               <label class="col-md-6 control-label">Previous Discount</label>
                               <div class="col-md-6">
                                    <input type="text" name="total_old_discount" ng-value="amount.oldTotalDiscount" class="form-control" step="any" readonly>
                               </div>
                           </div>
                         </div>
                         <div class="col-md-12">
                           <div class="form-group">
                               <label class="col-md-6 control-label">Previous GrandTotal</label>
                               <div class="col-md-6">
                                    <input type="text" name="old_grand_total" class="form-control" ng-value="amount.oldGrandTotal" step="any" readonly>
                               </div>
                           </div>
                         </div>
                         <div class="col-md-12">
                           <div class="form-group">
                               <label class="col-md-6 control-label">Previous Paid</label>
                               <div class="col-md-6">
                                   <input type="number" ng-model="amount.oldPaid" class="form-control" readonly>
                               </div>
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
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="number" name="new_total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-4 control-label">Total Commission </label>
                          <div class="col-md-8">
                            <input type="number" name="new_total_discount" ng-value="getTotalDiscountFn()" class="form-control" readonly >
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
                                        <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any" required>
                                        <input type="hidden" name="previousPaid" ng-value="amount.previousPaid" class="form-control" step="any">
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
                                <input type="number" name="total_paid" ng-value="getTotalPaidFn()" class="form-control" step="any" readonly>
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
                        
                        
                        <!--div class="form-group">
                            <label class="col-md-4 control-label">Installment Type</label>
                            <div class="col-md-8">
                                <select name="installment_type" ng-model="installment.installment_type" class="form-control">
                                    <option value="" selected disabled> Select </option>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Installment Number</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="number" name="installment_number" ng-model="installment.installment_number"  class="form-control" step="any" min="0">
                                    </div>
                                    <div class="col-md-7">
                                        <input type="number" name="installment_amount" ng-value="calculate_installment_amount(installment.installment_number)" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Installment Date</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="installment_date" value="{{ installment.installment_date }}" placeholder="YYYY-MM-DD" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div-->
                        
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
