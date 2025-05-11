<script src="<?php echo site_url('private/js/ngscript/personLoanInfo.js') ?>"></script>
<div class="container-fluid" ng-controller="personLoanInfo">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Loan</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
           
                <?php
	            $attr=array('class'=>'form-horizontal');
	            echo form_open_multipart('',$attr);
	            $p_info = get_row('loan_new', array('person_code' => $loanInfo->person_code));
	            ?>
	                 <div class="form-group">
                        <label class="col-md-2 control-label">Person Name</label>
                        <div class="col-md-5">
                            <input type="hidden" name="person_name" value="<?php echo $loanInfo->person_code; ?>">
                            <input type="text" class="form-control" readonly name="person_name" value="<?php echo $p_info->name; ?>">
<!--                            <select name="person_name" ng-init="code = '--><?php //echo $loanInfo->person_code; ?><!--'" class="form-control" ng-model="code" ng-change="personInfo(code)">-->
<!--                                <option selected disabled >Select Person</option>-->
<!--                                --><?php
//                                    foreach($person as $key => $row) { ?>
<!--                                        <option value="--><?php //echo $row->person_code; ?><!--" >--><?php //echo $row->name; ?><!--</option>-->
<!--                                --><?php //}
//                                ?>
<!--                            </select>-->
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-md-2 control-label">Mobile</label>
                        <div class="col-md-5">
                            <input type="text" value="<?php echo $p_info->mobile ?>" name="mobile" class="form-control" readonly>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-md-2 control-label">Address</label>
                        <div class="col-md-5">
                            <textarea col="15" readOnly rows="5" name="address" class="form-control"><?php echo $p_info->address; ?></textarea>
                        </div>
                    </div>

                <?php
                $received = $paid = $total = 0.0;
                $status = '';
                $received = get_sum('add_trx', array('person_code' => $p_info->person_code, 'type' => 'Received'), 'amount');;
                $paid = get_sum('add_trx', array('person_code' => $p_info->person_code, 'type' => 'Paid'), 'amount');;

                if ($p_info->type == "Received"){
                    $total =($p_info->balance + $received) - $paid;
                    if ($total > 0) {
                        $status = 'Received';
                    }else{
                        $status = 'Paid';
                    }
                }else{
                    $total = ($p_info->balance + $paid) - $received;
                    if ($total > 0) {
                        $status = 'Paid';
                    }else{
                        $status = 'Received';
                    }
                }
                ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Balance</label>
                        <div class="col-md-3">
                            <input type ="number" min="0" value="<?php echo abs($total); ?>" step="any" class="form-control" readonly>
                        </div>
                        <div class="col-md-2">
                            <input type ="text" class="form-control" value="<?php echo $status; ?>" readonly>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-md-2 control-label">Type</label>
                        <div class="col-md-5">
                            <select name="type" class="form-control">
                                <option selected disabled>Select Type</option>
                                <option value="Received" <?= $loanInfo->type == 'Received' ? 'selected' : '' ?>>Received</option>
                                <option value="Paid" <?= $loanInfo->type == 'Paid' ? 'selected' : '' ?>>Paid</option>
                            </select>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-md-2 control-label">Amount</label>
                        <div class="col-md-5">
                           <input type ="number" class="form-control" min="0" name="amount" value="<?= $loanInfo->amount; ?>">
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
                                    <?php echo ($loanInfo->godown_code == $row->code) ? 'selected' : ''; ?>>
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
                        <label class="col-md-2 control-label">Remark</label>
                        <div class="col-md-5">
                          <textarea col="15" rows="4" class="form-control" name="remark"><?= $loanInfo->remark; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-5">
                          <input type="submit" value="Submit" class="btn btn-primary pull-right" name="submit">
                        </div>
                    </div>
                    
                
	           <?php echo form_close(''); ?>
	       </div>
	       <div class="panel-footer" >&nbsp;</div>
	  </div>
	</div>
</div>