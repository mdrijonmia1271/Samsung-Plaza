<div class="container-fluid">
    <div class="row">
    
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Change Transaction</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
	        $attr = array('class' => 'form-horizontal');
	        echo form_open('bank/bankInfo/changeTransaction?id=' . $this->input->get('id'), $attr);
                ?>
                
                <!-- pre><?php echo print_r($records); ?></pre -->

	            <div class="form-group">
	                <label class="col-md-2 control-label">Date <span class="req">*</span></label>
	                
	                <div class="input-group date col-md-5" id="datetimepicker1">
	                    <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo $records[0]->transaction_date; ?>" class="form-control" required>
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <select name="bank_name" id="bank_name" class="form-control" required>
                                <?php foreach ($bank_list as $key => $value) { ?>
                                <option value="<?php echo $value->bank_name; ?>" <?php if($records[0]->bank == $value->bank_name){echo "selected";} ?>>
                                <?php echo str_replace("_", " ", $value->bank_name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <select id="account_number" name="account_number" class="form-control" required>
                                <option value="">-- Select one --</option>                       
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Transaction Type <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <select name="transaction_type" class="form-control" required>
                                <option value="Debit" <?php if($records[0]->transaction_type == "Debit"){echo "selected";} ?>>Withdraw</option>
                                <option value="Credit" <?php if($records[0]->transaction_type == "Credit"){echo "selected";} ?>>Payment</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">TK <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <input type="text" name="amount" value="<?php echo $records[0]->amount; ?>" placeholder="BDT" class="form-control" required>
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">Transaction By<span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <input type="text" name="transaction_by" value="<?php echo $records[0]->transaction_by; ?>" placeholder="Maximum 100 Digit" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Particulars <span class="req">*</span></label>
                        <div class="col-md-5">
                            <textarea name="remarks" rows="3" class="form-control" required><?php echo $records[0]->remarks; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="edit" class="btn btn-primary">
                    </div>
                    </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
	function view_data(bank_name) {
		$.ajax({
			type:"POST",
			data:{bankName: bank_name},
			url:"<?php echo base_url('bank/bankInfo/ajax_account_list'); ?>"
		}).success(function(response){
			var data	= JSON.parse(response);
			var per_data	= [];
			
			$.each(data, function(key, fieldName) {
				per_data.push('<option value="' + fieldName.account_number + '">' + fieldName.account_number + '</option>');
			});
			
			// $("#account_number").append(per_data);
			document.getElementById("account_number").innerHTML='<option value="">-- Select one --</option>'+per_data;
		});
	 }
	 
	 $("#bank_name").on("change", function(){
		var bank_name = $(this).val();
		view_data(bank_name);
	 });
	 
	 var bank_name = "<?php echo $records[0]->bank; ?>";
	 view_data(bank_name);
});
</script>
