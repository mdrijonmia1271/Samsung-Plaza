<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Showroom Transaction</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array('class' =>'form-horizontal');
	            echo form_open('md_transaction/md_transaction/addMd_transaction', $attr); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker">
                        <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <?php if(checkAuth('super')) { ?>
                <div class="form-group">
                    <label class="col-md-3 control-label">Showroom <span class="req">*</span></label>
                    <div class="col-md-5" >
                        <select name="godown_code" class="form-control" required>
                            <option value="">-- Select Showroom --</option>
                            <?php if(!empty($allGodown)){
                                foreach($allGodown as $option){
                                    echo '<option value="'.$option->code.'">'. $option->name .' ( '. $option->address .' ) </option>';
                                }   
                            }?>
                        </select>
                    </div>
                </div>
                <?php }else{ ?>
                    <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>">
                <?php } ?>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Type <span class="req">*</span></label>
                    <div class="col-md-5" >
                        <select name="type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            <option value="">-- Select --</option>
                            <?php foreach (config_item('md_transaction_type') as $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5" >
                        <?php 
                            $all_investor = $this->action->read('add_new_md');
                        ?>
                        <select name="name" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            <option value="">-- Select --</option>
                            <?php foreach ($all_investor as $value) { ?>
                            <option value="<?php echo $value->field_fixed_assate; ?>"><?php echo $value->field_fixed_assate; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Amount <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="amount" placeholder="Amount..." step="any" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Particulars <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea name="particulars" class="form-control" placeholder="Particulars..." rows="3" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8">
                        <input type="submit" value="Save" name="catetory_submit" class="btn btn-primary pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>