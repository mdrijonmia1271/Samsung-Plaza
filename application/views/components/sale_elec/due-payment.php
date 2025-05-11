<style>
    .table2 tr td{
        padding: 0 !important;
    }
    .table2 tr td input{
        border: 1px solid transparent;
    }
</style>

<div class="container-fluid" ng-controller="DuePaymentCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Due Deposit</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('sale/due/due_payment?vno=' . $this->input->get('vno'), $attr);
                ?>

                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group date" id="datetimepicker">
                                    <input type="text" name="date" class="form-control" ng-model="info.date" readonly>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" name="voucher_number" ng-model="info.voucher" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <?php $vno = $this->input->get('vno'); ?>
                    <span ng-init="vno='<?php echo $vno; ?>'"></span>
                </div>
                <hr>






                <table class="table table-bordered table2" ng-cloak>
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th>Product Name</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>                        
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">
                            {{ $index + 1 }}
                            <input type="hidden" name="id[]" ng-value="item.id">
                        </td>

                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly> 
                           
                        </td>

                        <td>
                            <input type="number" name="price[]" class="form-control" min="0" ng-model="item.price" step="any" readonly>
                        </td>

                        <td>
                            <input type="number" name="newQuantity[]" class="form-control" min="1" ng-model="item.newQuantity" step="any" readonly>
                            
                        </td>

                        <td>
                            <input type="text" name="subtotal[]" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                        </td>
                    </tr>
                </table>
                <hr>







                <div class="row">
                    <div class="col-md-offset-6 col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total  <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input type="number" name="total" class="form-control" ng-value="amount.grand_total" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Discount <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input type="number" name="discount" class="form-control" ng-model="amount.discount" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Remission <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input type="number"  class="form-control" ng-model="amount.total_remission" step="any" readonly>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input type="number" name="paid" class="form-control" step="any" ng-model="amount.paid" max="{{amount.grand_total}}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Deposit <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input type="number" name="deposit" class="form-control" step="any" ng-model="amount.diposit" max="{{amount.grand_total}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Remission <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input type="number" name="remission" class="form-control" step="any" ng-model="amount.remission" max="{{amount.grand_total}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Due <span class="req">*</span></label>
                            <div class="col-md-8">
                                <input type="number" name="due" class="form-control" step="any"  ng-value="getTotalDueFn(amount.diposit , amount.remission,amount.total_remission )" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" name="save" value="Save" class="btn btn-primary">
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