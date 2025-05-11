<script src="<?php echo site_url('private/js/ngscript/lprAddCtrl.js');?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid" ng-controller="lprAddCtrl" ng-cloak>
    <div class="row">
        
        <?php echo $this->session->flashdata('confirmation'); ?>
        
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit LPR</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open_multipart('', $attr); ?>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Date<span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker">
                        <input type="text" name="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Customer</label>
                    <div class="col-md-5">
                        <select name="party_code" ng-model="party_code" ng-change="partyInfo();installmentInfo()" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>---Select---</option>
                            <?php foreach($allClients as $value){ ?>
                            <option value="<?php echo $value->party_code; ?>"> <?php echo $value->code."-".filter($value->name)."-".$value->mobile;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                   
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="party_name" class="form-control" ng-value="info.name" readonly>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-md-3 control-label">Mobile</label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" class="form-control" ng-value="info.mobile" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea name="address" class="form-control" readonly>{{ info.address }}</textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Down Payment</label>
                    <div class="col-md-5">
                        <input type="number" name="down_payment" class="form-control" ng-value="amount.down_payment" readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Sales Amount</label>
                    <div class="col-md-5">
                        <input type="number" name="sales_amount" class="form-control" ng-value="amount.voucher_bill" readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Value Add</label>
                    <div class="col-md-5">
                        <input type="number" name="commission" class="form-control" ng-value="amount.commission" readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Total Paid</label>
                    <div class="col-md-5">
                        <input type="number" name="paid" class="form-control" ng-value="amount.total_paid" readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Due</label>
                    <div class="col-md-5">
                        <input type="number" name="due" class="form-control" ng-value="amount.due" readonly>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Payment</label>
                    <div class="col-md-5">
                        <input type="number" name="payment" class="form-control" ng-model="amount.payment" step="any">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Remission</label>
                    <div class="col-md-5">
                        <input type="number" name="remission" class="form-control" ng-model="amount.remission" step="any">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Balance</label>
                    <div class="col-md-5">
                        <input type="text" name="balance" class="form-control" ng-value="getTotalBalanceFn()" readonly>
                    </div>
                </div>
                
                <!--hidden fields-->
                <input type="hidden" ng-value="info.voucher_no" name="voucher_no">
                
                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update" value="Update" class="btn btn-success">
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });
</script>