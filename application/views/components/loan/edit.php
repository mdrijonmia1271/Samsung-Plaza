<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Loan</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
	            $attr=array('class'=>'form-horizontal');
	            echo form_open('loan/loan/loan_edit/'.$info[0]->id,$attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date </label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo $info[0]->date; ?>" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group" ng-init="type='<?php echo $info[0]->type; ?>'">
                    <label class="col-md-2 control-label">Type </label>
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
                <div ng-show="type == 'Bank'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank Name </label>
                        <div class="col-md-5">
                            <select name="bank_name" class="form-control">
                                <option value="">-- Select Bank --</option>
                                <option <?php if($info[0]->name == "Brac_Bank_Ltd"){echo "selected";} ?> value="Brac_Bank_Ltd">BRAC Bank Ltd</option>
                                <option <?php if($info[0]->name == "Sonali_Bank_Ltd"){echo "selected";} ?> value="Sonali_Bank_Ltd">Sonali Bank Ltd</option>
                                <option <?php if($info[0]->name == "Rupali_Bank_Ltd"){echo "selected";} ?> value="Rupali_Bank_Ltd">Rupali Bank Ltd</option>
                                <option <?php if($info[0]->name == "Janata_Bank_Ltd"){echo "selected";} ?> value="Janata_Bank_Ltd">Janata Bank Ltd</option>
                                <option <?php if($info[0]->name == "Agrani_Bank_Ltd"){echo "selected";} ?> value="Agrani_Bank_Ltd">Agrani Bank Ltd</option>
                                <option <?php if($info[0]->name == "AB_Bank_Ltd"){echo "selected";} ?> value="AB_Bank_Ltd">AB Bank Ltd</option>
                                <option <?php if($info[0]->name == "NCC_Bank_Ltd"){echo "selected";} ?> value="NCC_Bank_Ltd">NCC Bank Ltd</option>
                                <option <?php if($info[0]->name == "Jamuna_Bank_Ltd"){echo "selected";} ?> value="Jamuna_Bank_Ltd">Jamuna Bank Ltd</option>
                                <option <?php if($info[0]->name == "National_Bank_Ltd"){echo "selected";} ?> value="National_Bank_Ltd">National Bank Ltd</option>
                                <option <?php if($info[0]->name == "Prime_Bank_Ltd"){echo "selected";} ?> value="Prime_Bank_Ltd">Prime Bank Ltd</option>
                                <option <?php if($info[0]->name == "Standard_Bank_Ltd"){echo "selected";} ?> value="Standard_Bank_Ltd">Standard Bank Ltd</option>
                                <option <?php if($info[0]->name == "The_City_Bank_Ltd"){echo "selected";} ?> value="The_City_Bank_Ltd">The City Bank Ltd</option>
                                <option <?php if($info[0]->name == "Trust_Bank_Ltd"){echo "selected";} ?> value="Trust_Bank_Ltd">Trust Bank Ltd</option>
                                <option <?php if($info[0]->name == "Islami_Bank_Bangladesh_Ltd"){echo "selected";} ?> value="Islami_Bank_Bangladesh_Ltd">Islami Bank Bangladesh Ltd</option>
                                <option <?php if($info[0]->name == "Dutch_Bangla_Bank_Ltd"){echo "selected";} ?> value="Dutch_Bangla_Bank_Ltd">Dutch Bangla Bank Ltd</option>
                                <option <?php if($info[0]->name == "Mutual_Trust_Bank_Ltd"){echo "selected";} ?> value="Mutual_Trust_Bank_Ltd">Mutual Trust Bank Ltd</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"> Branch Name </label>
                        <div class="col-md-5">
                            <input type="text" name="branch" value="<?php echo $info[0]->branch; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number </label>
                        <div class="col-md-5">
                            <input type="text" name="account_no" value="<?php echo $info[0]->account_no; ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Person -->
                <div ng-show="type == 'Person'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Person Name </label>
                        <div class="col-md-5">
                            <input type="text" name="person_name" value="<?php echo $info[0]->name; ?>" class="form-control">
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-2 control-label">Contact Info </label>
                    <div class="col-md-5">
                        <input type="text" name="contact_info" value="<?php echo $info[0]->contact_info; ?>"  class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address </label>
                    <div class="col-md-5">
                        <textarea name="address" rows="3" class="form-control"><?php echo $info[0]->address; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Loan Type </label>
                    <div class="col-md-5">
                        <select name="loan_type" class="form-control" required>
                            <option <?php if($info[0]->loan_type == "Received"){echo "selected";} ?> value="Received">Received</option>
                            <option <?php if($info[0]->loan_type == "Paid"){echo "selected";} ?> value="Paid">Paid</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Amount </label>
                    <div class="col-md-5">
                        <input type="number" name="amount" placeholder="BDT" value="<?php echo $info[0]->amount; ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Loan By </label>
                    <div class="col-md-5">
                        <input type="text" name="loan_by" placeholder="Maximum 100 Digit" value="<?php echo $info[0]->loan_by; ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Particulars </label>
                    <div class="col-md-5">
                        <textarea name="remarks" class="form-control" rows="3"><?php echo $info[0]->remarks; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Save" name="save" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
