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
                <?php $attr=array('class'=>'form-horizontal');
	            echo form_open('',$attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date</label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo $edit[0]->date; ?>" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
               
                <div class="form-group">
                    <label class="col-md-2 control-label">Person Name</label>
                    <div class="col-md-5">
                        <input type="text" name="person_name" class="form-control" value="<?php echo $edit[0]->name; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile</label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" class="form-control" minlength="11" maxlength="11" value="<?php echo $edit[0]->mobile; ?>">
                    </div>
                </div>
                   
                <div class="form-group">
                    <label class="col-md-2 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea col="15" rows="5" name="address" class="form-control"><?php echo $edit[0]->address; ?></textarea>
                    </div>
                </div>
               
                <div class="form-group">
                    <label class="col-md-2 control-label">Balance</label>
                    <div class="col-md-5">
                        <input type="text" name="balance" class="form-control" value="<?php echo $edit[0]->balance; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Loan Type </label>
                    <div class="col-md-5">
                        <select name="type" class="form-control" required>
                            <option <?php if($edit[0]->type=='Received'){echo"selected";} ?> value="Received">Received</option>
                            <option <?php if($edit[0]->type=='Paid'){echo"selected";} ?> value="Paid">Paid</option>
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
                                <?php echo ($edit[0]->godown_code == $row->code) ? 'selected' : ''; ?>>
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
                        <input type="submit" value="Update" name="save" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(''); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
