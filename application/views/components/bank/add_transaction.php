<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid">
    <div class="row">
	<?php echo $confirmation; ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Transaction</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
	                $attr=array('class'=>'form-horizontal');
	                echo form_open('',$attr);
                ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <?php if(checkAuth('super')) { ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Showroom <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <select name="godown_code"  id="godown_code"   class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                                <option value="<?php echo $row->code; ?>"
                                    <?php echo ($this->data['branch'] == $row->code) ? 'selected' : ''; ?>>
                                    <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <?php } else { ?>
                        <input type="hidden" name="godown_code" id="godown_code"   value="<?php echo $this->data['branch']; ?>" required>
                    <?php } ?>


                <div class="form-group">
                    <label class="col-md-2 control-label">Bank <span class="req">*</span></label>
                    
                    <div class="col-md-5">
                        <select name="bank_name"    id="bank_name" class="form-control" required>
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
                    <label class="col-md-2 control-label">Holder  Name </label>
                    
                    <div class="col-md-5">
                        <input id="holder_name" type="text"  class="form-control" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Transaction Type <span class="req">*</span></label>
                    
                    <div class="col-md-5">
                        <select name="transaction_type" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="Debit">Debit / দিয়া উত্তলন </option>
                            <option value="Credit" selected>Credit / দিয়া জমা </option>
                            <option value="bank_to_TT" selected>Bank TT</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">TK <span class="req">*</span></label>
                    
                    <div class="col-md-5">
                        <input type="text" name="amount" placeholder="BDT" class="form-control" required>
                    </div>
                </div>                  

                <div class="form-group">
                    <label class="col-md-2 control-label">Transaction By<span class="req">*</span></label>
                    
                    <div class="col-md-5">
                        <input type="text" name="transaction_by"  class="form-control" required>
                    </div>
                </div>
                
                

                <div class="form-group">
                    <label class="col-md-2 control-label">Particulars </label>
                    <div class="col-md-5">
                        <textarea name="remarks" rows="3" class="form-control" ></textarea>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="add_transaction" class="btn btn-primary">
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
 
 
    // by default godownwise bank data
    var godown_code = $('#godown_code').val();
    $.ajax({
				type:"POST",
				data:{
				        godown_code: godown_code
				},
				url:"<?php echo base_url('bank/bankInfo/ajax_bank_list');?>"
			}).success(function(response){
				document.getElementById("bank_name").innerHTML= response;
			});
 
    // godown wise bank dropdown
	$("#godown_code").on("change",function(){
		    var godown_code = $('#godown_code').val();	
			$.ajax({
				type:"POST",
				data:{
				        godown_code: godown_code
				},
				url:"<?php echo base_url('bank/bankInfo/ajax_bank_list');?>"
			}).success(function(response){
				document.getElementById("bank_name").innerHTML= response;
			});
	});
});
</script>





<script>
$(document).ready(function(){
	$("#bank_name").on("change",function(){
	var bank_name = $(this).val();
	var godown_code = $('#godown_code').val();
		 function view_data(){
			$.ajax({
				type:"POST",
				data:{
				        bankName   : bank_name,
				        godown_code: godown_code
				},
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

<script>
$(document).ready(function(){
	$("#account_number").on("change",function(){
	var account_number=$(this).val();
		 function view_data(){
			$.ajax({
				type:"POST",
				data:{account_number:account_number},
				url:"<?php echo base_url('bank/bankInfo/ajax_account_number');?>"
			}).success(function(response){
			    $('#holder_name').val(JSON.parse(response)[0]['holder_name']);
			});
		 }
		 view_data();
	});
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>