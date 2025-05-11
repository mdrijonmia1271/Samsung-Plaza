<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>New Loan</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php $attr=array('class'=>'form-horizontal'); echo form_open('',$attr); ?>

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
                    <label class="col-md-2 control-label">Person Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="person_name" class="form-control">
                        <input type="hidden" name="person_code" value="<?php echo $personId; ?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" class="form-control" required minlength="11" maxlength="11">
                    </div>
                </div>
                   
                <div class="form-group">
                    <label class="col-md-2 control-label">Address <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea col="15" rows="5" name="address" class="form-control" required> </textarea>
                    </div>
                </div>
               
                <div class="form-group">
                    <label class="col-md-2 control-label">Amount <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="balance" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Loan Type <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="type" class="form-control" required>
                            <option value="Received">Received</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>
                </div>
                
                <?php if(checkAuth('super')) { ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Showroom <span class="req">*</span></label>
                    
                    <div class="col-md-5">
                        <select name="godown_code" class="form-control" required>
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
                    <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                <?php } ?>
                    
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
<!--<script>-->
<!--	$(document).ready(function(){-->
<!--		$("#bank_name").on("change",function(){-->
<!--		var bank_name=$(this).val();-->
<!--			 function view_data(){-->
<!--				$.ajax({-->
<!--					type:"POST",-->
<!--					data:{bankName: bank_name},-->
<!--					url:"<?php echo base_url('bank/bankInfo/ajax_account_list');?>"-->
<!--				}).success(function(response){-->
<!--					var data=JSON.parse(response);-->
<!--					var per_data=[];-->
<!--					$.each(data,function(key,fieldName){-->
<!--						per_data.push('<option value="'+fieldName.account_number+'">'+fieldName.account_number+'</option>');-->
<!--					});-->
					<!--//$("#account_number").append(per_data);-->
<!--					document.getElementById("account_number").innerHTML='<option value="">-- Select one --</option>'+per_data;-->
<!--				});-->
<!--			 }-->
<!--			 view_data();-->
<!--		});-->
<!--	});-->
<!--</script>-->
