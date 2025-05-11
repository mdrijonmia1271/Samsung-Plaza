<div class="container-fluid">
    <div class="row">

         <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>            
               

                <div class="form-group row">
                    <label class="col-md-2 control-label">Date</label>
                    <div class="input-group date col-md-5" id="datetimepickerSMSFrom">
                        <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>          
                
                
                <div class="col-md-7 no-padding">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Show" name="find" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
	<?php echo $confirmation; ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Daily</h1>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">

                   <div class="col-md-3">
                        <div class="dash-box dash-box-5">
                            <span>Previous Balance</span>
                            <h1><?php echo $prev_handCash; ?></h1>
                        </div>                    
                    </div>
                    
                    <div class="col-md-3">
                        <div class="dash-box dash-box-5">
                            <span>Income From Party</span>
                            <h1><?php echo $party_income; ?></h1>
                        </div>                    
                    </div>

                    <div class="col-md-3">
                        <div class="dash-box dash-box-5">
                            <span>Bank Withdraw</span>
                            <h1><?php echo $bank_withdraw; ?></h1>
                        </div>                    
                    </div>
                    
                   <div class="col-md-3">
                        <div class="dash-box dash-box-4">
                            <span>Total Income</span>
                            <h1><?php echo $all_income; ?></h1>
                        </div>                    
                    </div>

                   <div class="col-md-3">
                        <div class="dash-box dash-box-8">
                            <span>General cost</span>
                            <h1><?php echo $general_cost; ?></h1>
                        </div>                    
                    </div>
                   

                    <div class="col-md-3">
                        <div class="dash-box dash-box-8">
                            <span>Paid To Party</span>
                            <h1><?php echo $party_cost; ?></h1>
                        </div>                    
                    </div>

                    <div class="col-md-3">
                        <div class="dash-box dash-box-8">
                            <span>Bank Diposit</span>
                            <h1><?php echo $bank_diposit; ?></h1>
                        </div>                    
                    </div>

                    <div class="col-md-3">
                        <div class="dash-box dash-box-1">
                            <span>Total Cost</span>
                            <h1><?php echo $all_cost; ?></h1>
                        </div>                    
                    </div>

                    <div class="col-md-12">
                        <div class="dash-box dash-box-7">
                            <span>Cash In hand</span>
                            <h1><?php echo $all_income - $all_cost; ?></h1>
                        </div>                    
                    </div> 
                </div>

                <?php echo form_open(''); ?>
                <input type="hidden" name="date" value="<?php echo (isset($_POST['find'])) ? $_POST['date'] : date("Y-m-d"); ?>">
                <input type="hidden" name="opening" value="<?php echo $prev_handCash; ?>">
                <input type="hidden" name="income" value="<?php echo $all_income; ?>">
                <input type="hidden" name="cost" value="<?php echo $all_cost; ?>">
                <input type="hidden" name="bank_withdraw" value="<?php echo $bank_withdraw; ?>">
                <input type="hidden" name="bank_diposit" value="<?php echo $bank_diposit; ?>">
                <input type="hidden" name="hand_cash" value="<?php echo $all_income - $all_cost; ?>">
                <div class="pull-right">
                    <input type="submit" name="submit" class="btn btn-primary pull-right" value="Close">
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });   
</script>