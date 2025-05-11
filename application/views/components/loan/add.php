<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Loan Received & Paid</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
	            $attr=array('class'=>'form-horizontal');
	            echo form_open('loan/loan/add',$attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

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
                <div ng-show="type == 'Bank'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <select name="bank_name" class="form-control">
                                <option value="">-- Select Bank --</option>
                                <option value="Brac_Bank_Ltd">BRAC Bank Ltd</option>
                                <option value="Sonali_Bank_Ltd">Sonali Bank Ltd</option>
                                <option value="Rupali_Bank_Ltd">Rupali Bank Ltd</option>
                                <option value="Janata_Bank_Ltd">Janata Bank Ltd</option>
                                <option value="Agrani_Bank_Ltd">Agrani Bank Ltd</option>
                                <option value="AB_Bank_Ltd">AB Bank Ltd</option>
                                <option value="NCC_Bank_Ltd">NCC Bank Ltd</option>
                                <option value="Jamuna_Bank_Ltd">Jamuna Bank Ltd</option>
                                <option value="National_Bank_Ltd">National Bank Ltd</option>
                                <option value="Prime_Bank_Ltd">Prime Bank Ltd</option>
                                <option value="Standard_Bank_Ltd">Standard Bank Ltd</option>
                                <option value="The_City_Bank_Ltd">The City Bank Ltd</option>
                                <option value="Trust_Bank_Ltd">Trust Bank Ltd</option>
                                <option value="Islami_Bank_Bangladesh_Ltd">Islami Bank Bangladesh Ltd</option>
                                <option value="Dutch_Bangla_Bank_Ltd">Dutch Bangla Bank Ltd</option>
                                <option value="Mutual_Trust_Bank_Ltd">Mutual Trust Bank Ltd</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"> Branch Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="branch" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="account_no" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Person -->
                <div ng-show="type == 'Person'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Person Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="person_name" class="form-control">
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-2 control-label">Contact Info <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="contact_info" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea name="address" rows="3" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Loan Type <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="loan_type" class="form-control" required>
                            <option value="Received">Received</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Amount <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="amount" placeholder="BDT" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Loan By <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="loan_by" placeholder="Maximum 100 Digit" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Remarks <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <textarea name="remarks" class="form-control" rows="3"></textarea>
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
<script>
	$(document).ready(function(){
		$("#bank_name").on("change",function(){
		var bank_name=$(this).val();
			 function view_data(){
				$.ajax({
					type:"POST",
					data:{bankName: bank_name},
					url:"<?php echo base_url('bank/bankInfo/ajax_account_list');?>"
				}).success(function(response){
					var data=JSON.parse(response);
					var per_data=[];
					$.each(data,function(key,fieldName){
						per_data.push('<option value="'+fieldName.account_number+'">'+fieldName.account_number+'</option>');
					});
					//$("#account_number").append(per_data);
					document.getElementById("account_number").innerHTML='<option value="">-- Select one --</option>'+per_data;
				});
			 }
			 view_data();
		});
	});
</script>
