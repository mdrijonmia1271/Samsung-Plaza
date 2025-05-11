<script src="<?php echo site_url('private/js/ngscript/editHireSaleCtrl.js?'.time()); ?>"></script>
<style>
    .table2 tr td{padding: 0 !important;}
    .table2 tr td input{border: 1px solid transparent;}
    .table tr th.th-width{width: 100px !important;}
</style>
 
<div class="container-fluid" ng-controller="editHireSaleCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Sale Voucher</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $vno = $this->input->get('vno');
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/editHireSale?vno=' . $vno, $attr);
                ?>
                
                <!-- initialization voucher no -->
                <input type="hidden" name="voucher_no" ng-init='info.vno="<?php echo $vno; ?>"' ng-value="info.vno">

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
                
                <label class="col-md-6">Voucher No: {{ info.vno }}</label>
                
                <hr style="margin-top: 6px;">
                
                <!-- all input hidden file -->
                <input type="hidden" name="party_code" ng-value="info.partyCode">
                <input type="hidden" name="party_mobile" ng-value="info.partyMobile">
                <input type="hidden" name="sap_type" ng-value="info.sapType">

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th style="width:250px;">Product Name</th>
                        <th width="170px">Model</th>
                        <th width="170px">Product Serial</th>
                        <!--<th width="80px">Unit</th>-->
                        <!--<th>Stock</th>-->
                        <th>Old Qty</th>
                        <th>New Qty</th>
                        <th>Sale Price</th>
                       <!-- <th>Dis. (%)</th>
                        <th>Dis. Amount (Tk)</th>-->
                        <th>Total</th>
                    </tr>
                    
                <tr ng-repeat="item in card">
                    <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                    
                    <td style="padding: 6px 8px !important; background-color: #eee;">
                        {{ item.category | textBeautify }}
                        <input type="hidden" name="id[]" ng-value="item.id">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="godown_code" ng-value="item.godown_code">
                        <input type="hidden" name="unit[]" class="form-control" ng-model="item.unit" ng-value="item.unit" readonly>
                    </td>
                 
                     <td style="padding: 7px 8px !important; background-color: #eee;">
                        {{ item.product_model }}
                    </td>
                    
                    <td>
                      <input type="text" name="product_serial[]" class="form-control"  ng-value="item.product_serial"  readonly>
                    </td>
                    
                    <!--<td>
                      <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
                    </td>-->
                    
                    <td>
                      <input type="number" name="quantity[]" class="form-control" min="1" ng-value="item.old_quantity" step="any" readonly>
                    </td>
                    
                    <td>
                      <input type="number" name="new_quantity[]" class="form-control" min="0"  ng-model="item.quantity" step="any">
                    </td>
                    
                    <td>
                      <input type="number" name="sale_price[]" class="form-control" ng-model="item.sale_price" ng-value="item.sale_price" step="any">
                      <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price" step="any">
                    </td>
                    
                    <!--
                    <td>
                      <input type="number" name="discount_percentage[]" class="form-control" ng-model="item.discount_percentage" min="0" step="any">
                    </td>
                    
                    <td>
                      <input type="number" name="discount[]" class="form-control" ng-value="setDiscountFn($index)" min="0" step="any" readonly>
                    </td>-->
                    
                    <td>
                      <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                      <input type="hidden"  ng-value="purchaseSubtotalFn($index)" step="any">
                    </td>
                </tr>

                    
                </table>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        
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


                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 control-label"> Total Quantity </label>
                          <div class="col-md-8">
                            <input type="number" name="totalqty" ng-value="getTotalQtyFn()" class="form-control" step="any" readonly>
                          </div>
                        </div>
                        
                        <!--<div class="form-group">
                          <label class="col-md-4 control-label"> Total Discount</label>
                          <div class="col-md-8">
                            <input type="number" name="total_discount" ng-value="getItemWiseTotalDiscountFn()" class="form-control" readonly>
                          </div>
                        </div> -->
                        
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
                                <input type="number" name="previous_balance" ng-model="info.previousBalance" class="form-control" step="any" readonly>
                              </div>
                              <div class="col-md-5">
                                <input type="text" name="previous_sign" ng-value="info.sign" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                     

                        <!--<div class="form-group">
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
                        </div>-->


                        <div class="form-group">
                            <label class="col-md-4 control-label">Down Payment </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any" required>
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
                        <label class="col-md-4 control-label">Due</label>
                        <div class="col-md-8">
                          <div class="row">
                            <div class="col-md-7">
                              <input type="number" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly>
                            </div>
                            <div class="col-md-5">
                              <input type="text" name="current_sign" ng-value="info.csign" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                        <div class="form-group">
                            <label class="col-md-4 control-label">Value Add </label>
                            <div class="col-md-8">
                                <div class="row">
                                  <div class="col-md-5">
                                    <input type="number" name="commission_per" min="0" ng-model="amount.added_percentage" class="form-control" step="any">
                                  </div>
                                  <div class="col-md-7">
                                    <input type="text" name="added_amount" ng-model="amount.totalAddedAmount" class="form-control">
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-4 control-label">Hire Outstanding</label>
                          <div class="col-md-8">
                            <input type="text" name="hire_price" ng-value="calculateHirePrice()" class="form-control" readonly>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-4 control-label">Total Amount </label>
                          <div class="col-md-8">
                            <input type="number" name="grand_total" ng-value="getGrandTotalFn()" class="form-control" step="any" readonly>
                          </div>
                        </div>
                        

                        <!--<div class="form-group">
                            <label class="col-md-4 control-label">Installment Type</label>
                            <div class="col-md-8">
                                <select name="installment_type" ng-model="installment.installment_type" class="form-control">
                                    <option value="" selected disabled> Select </option>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                            </div>
                        </div>-->
                        
                        <input type="hidden" name="installment_type" ng-value="installment_type">
                        
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Installment Number</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="number" name="installment_number" ng-model="installment_number"  class="form-control" step="any" min="0">
                                    </div>
                                    <div class="col-md-7">
                                        <input type="number" name="installment_amount" ng-value="getInstallAmountFn()" class="form-control" readonly>
                                        <input type="hidden" name="voucher_due" ng-value="voucher_due" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Installment Date</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="installment_date" value="{{ installment_date }}" placeholder="YYYY-MM-DD" class="form-control">
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
