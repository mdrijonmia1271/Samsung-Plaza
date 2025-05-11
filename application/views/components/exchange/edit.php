<!-- Select Option 2 Stylesheet -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Exchange</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array('class' =>'form-horizontal');
	            echo form_open('exchange/exchange/edit/'.$id,$attr); ?>


                <div class="form-group">
                    <label class="col-md-3 control-label"> Receive Product <span class="req">*</span></label>
                    <div class="col-md-4">
                        <select name="receive" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" disabled>-- Select Name --</option>
                            <?php if($stock != null){ foreach($stock as $key=>$value){ ?>
                            <option value="<?php echo $value->code; ?>" <?php if($exchange[0]->receive_code == $value->code){ echo 'selected'; } ?> > <?php echo filter($value->name); ?> </option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label"> Receive Quantity <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="receiveQty" value="<?php echo $exchange[0]->receiveqty; ?>" placeholder="" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label"> Given Product <span class="req">*</span></label>
                    <div class="col-md-4">
                        <select name="given" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" disabled>-- Select Name --</option>
                            <?php if($stock != null){ foreach($stock as $key => $value){ ?>
                            <option value="<?php echo $value->code; ?>" <?php if($exchange[0]->given_code == $value->code){ echo 'selected'; } ?> > <?php echo filter($value->name); ?> </option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label"> Given Quantity <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="givenQty" value="<?php echo $exchange[0]->givenqty; ?>" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Update" name="sub" class="btn btn-primary pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<!-- Select Option 2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>