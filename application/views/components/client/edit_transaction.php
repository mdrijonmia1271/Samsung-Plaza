<script src="<?php echo site_url('private/js/ngscript/ClientEditTransactionCtrl.js?'.time()); ?>"></script>
<div class="container-fluid">
    <div class="row" ng-controller="ClientEditTransactionCtrl" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Transaction</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('', $attr);
                ?>
                <span ng-init="id=<?php echo $info->id; ?>"></span>
                <div class="form-group">
                    <label class="col-md-3 control-label">Date <span class="req">*</span></label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" class="form-control" value="<?php echo $info->transaction_at; ?>" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Name </label>
                    <div class="col-md-5">
                        <input type="text" value="<?php echo filter($info->name); ?>" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Brand <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="brand" ng-init="brand='<?= $info->brand ?>'" ng-model="brand" class="form-control" required>
                            <option value="" selected>Select brand</option>
                            <?php if (!empty($brandList)) {
                                foreach ($brandList as $item) {
                                    echo '<option value="' . $item->brand . '">' . filter($item->brand) . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Previous Balance (TK) </label>
                    <div class="col-md-3">
                        <input type="text" value="<?php echo abs($previousTranInfo->balance); ?>" class="form-control" readonly>
                        <input type="hidden" name="balance" ng-init="previousBalance='<?php echo $previousTranInfo->balance; ?>'" ng-model="previousBalance" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="sign" value="<?php echo $previousTranInfo->status; ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Transaction Type <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select
                            name="payment_type"
                            class="form-control"
                            ng-init="transactionBy='<?php echo $info->transaction_via; ?>'"
                            ng-model="transactionBy"
                            required>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="bkash">bKash</option>
                        </select>
                    </div>
                </div>
                <!-- for selecting cheque -->
                <div ng-if="transactionBy == 'cheque'">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bank name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="meta[bankname]" ng-model="bankname" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Branch name <span class="req">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" name="meta[branchname]" ng-model="branchname" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Account No. <span class="req">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" name="meta[account_no]" ng-model="accountno" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Cheque No. <span class="req">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" name="meta[chequeno]" ng-model="chequeno" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Pass Date <span class="req">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" name="meta[passdate]" class="form-control" value="{{ passdate }}">
                            <input type="hidden" name="meta[status]" value="pending">
                        </div>
                    </div>
                </div>
                <!-- cheque option end  -->
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Payment (TK) <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" ng-init="payment=<?php echo $info->credit; ?>" name="payment" ng-model="payment" class="form-control" step="any" min="0" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Adjustment (TK) <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="adjustment" ng-init="adjustment=<?php echo $info->adjustment; ?>" ng-model="adjustment" placeholder="0" autocomplete="off" class="form-control" step="any" required>
                    </div>
                </div>
                
                <?php if($info->transaction_type == 'installment') { ?>
                <div class="form-group" >
                    <label class="col-md-3 control-label">Remission (TK) <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="number" ng-init="remission=<?php echo $info->remission; ?>" name="remission" ng-model="remission" class="form-control" step="any" min="0">
                    </div>
                </div>
                <?php } ?>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Total Due (TK) </label>
                    <div class="col-md-3">
                        <input type="number" name="totalBalance" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="csign" ng-model="csign" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Paid By <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" value="<?php echo $info->comment; ?>" name="comment" class="form-control">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update" value="Change" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD',
    useCurrent: false
});
</script>