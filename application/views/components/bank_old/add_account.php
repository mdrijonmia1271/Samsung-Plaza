<div class="container-fluid">
    <div class="row">
	<?php echo $confirmation; ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Account</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->

                <?php
	                $attr=array('class'=>'form-horizontal');
	                echo form_open('',$attr);
                ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Date <span class="req">*</span></label>

                        <div class="input-group date col-md-5" id="datetimepicker1">
                            <input type="text" name="date" placeholder="YYYY-MM-YY" class="form-control" value="<?php echo date("Y-m-d");?>" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank <span class="req">*</span></label>

                        <div class="col-md-5">
                            <select name="bank_name" class="form-control" required>
                                <option value="">-- Select Bank --</option>
                                <?php foreach(config_item('banks') as $key=>$value){ ?>
                                  <option value="<?php echo $key; ?>"><?php echo filter($value);?></option>
                                <?php } ?>
                                <!--option value="Sonali_Bank_Limited">Sonali Bank Limited</option>
                                <option value="Janata_Bank_Limited">Janata Bank Limited</option>
                                <option value="Agrani_Bank_Limited">Agrani Bank Limited</option>
                                <option value="Rupali_Bank_Limited">Rupali Bank Limited</option>
                                <option value="AB_Bank_Limited">AB Bank Limited</option>
                                <option value="Jamuna_Bank_Limited">Jamuna Bank Limited</option>
                                <option value="National_Bank_Limited">National Bank Limited</option>
                                <option value="NCC_Bank_Limited">NCC Bank Limited</option>
                                <option value="Prime_Bank_Limited">Prime Bank Limited</option>
                                <option value="Standard_Bank_Limited">Standard Bank Limited</option>
                                <option value="The_City_Bank_Limited">The City Bank Limited</option>
                                <option value="Trust_Bank_Limited">Trust Bank Limited</option>
                                <option value="Islami_Bank_Bangladesh_Limited">Islami Bank Bangladesh Limited</option>
                                <option value="Dutch_Bangla_Bank">Dutch Bangla Bank</option-->
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Holder Name<span class="req">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="account_holder_name" placeholder="Type Account Holder Name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="account_number" placeholder="Maximum 15 Digit" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Previous Balance<span class="req">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="previous_balance" placeholder="BDT" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="add_account" class="btn btn-primary">
                    </div>
                    </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
