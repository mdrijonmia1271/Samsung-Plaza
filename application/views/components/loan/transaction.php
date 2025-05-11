<div class="container-fluid" ng-controller="loanTransactionCtrl" >
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Loan Transaction</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
    	            $attr=array('class'=>'form-horizontal');
    	            echo form_open('',$attr);
                ?>

                <div class="form-group" ng-init="type='Person'">
                    <label class="col-md-2 control-label">Type <span class="req">*</span></label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input type="radio" name="type" ng-model="type" value="Bank" required>
                            <strong>Bank</strong>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" ng-model="type" value="Person"  required>
                            <strong>Person</strong>
                        </label>
                    </div>
                </div>

               <!-- Bank Info -->
                <div ng-if="type == 'Bank'">

                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                        <div class="col-md-5">
                           <!--  <input type="text" name="account_no" class="form-control"> -->
                           <select class="form-control" ng-model="loan_id" ng-change="getTotal(loan_id)" name="loan_id">
                                <option value="" selected>-- Select --</option>
                                <?php foreach ($banks as $bank) { ?>
                                <option value="<?php echo $bank->id; ?>"><?php echo $bank->account_no; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Person -->
                <div ng-if="type == 'Person'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Person Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <!-- <input type="text" name="person_name" class="form-control"> -->
                            <select class="form-control" ng-model="loan_id" ng-change="getTotal(loan_id)" name="loan_id">
                                <option value="" selected>-- Select --</option>
                                <?php foreach ($persons as $person) { ?>
                                <option value="<?php echo $person->id; ?>"><?php echo $person->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Transaction By <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="transaction_by" ng-model="test" placeholder="Maximum 100 Digit" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Loan Amount <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" ng-model="TotalAmount" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Total Paid <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" ng-model="TotalPaid" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Amount <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" ng-model="NewPaid" name="amount" placeholder="BDT" max="{{TotalAmount-TotalPaid}}" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Due <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="due" ng-value="(TotalAmount-TotalPaid)-NewPaid" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input value="Save" name="save" class="btn btn-primary pull-right" type="submit">
                    </div>
                </div>


               <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#bank_name").on("change",function(){})
    });
</script>
