<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

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
                        <?php 
                            if($this->data['privilege'] == 'super') { 
                            $allGodown = $this->action->read('godowns',array('trash' => 0));
                        ?>    
                      
                        <label for="" class="col-md-2 control-label">Showroom</label>
                        <div class="col-md-5">
                            <select name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                                <option value="<?php echo $row->code; ?>" >
                                    <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <?php } else { ?>
                            <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                        <?php } ?>   
                    </div>



                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank <span class="req">*</span></label>

                        <div class="col-md-5">
                            <select name="bank_name" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>-- Select Bank --</option>
                                <?php if($allBank != null){ foreach($allBank as $key=>$value){ ?>
                                  <option value="<?php echo $value->bank_name; ?>"><?php echo filter($value->bank_name);?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Branch Name<span class="req">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="branch_name" placeholder="Type Branch Name" class="form-control" required>
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
                            <input type="number" name="previous_balance" placeholder="BDT" class="form-control" required>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>