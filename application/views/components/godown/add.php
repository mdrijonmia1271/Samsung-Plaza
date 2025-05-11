<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Showroom</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php $attr = array("class" => "form-horizontal"); echo form_open('godown/godown/add', $attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" required>                        
                        <input type="hidden" name="code" value="<?php echo generateUniqueId('godowns') ?>">                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Manager <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="manager" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" class="form-control" step="any" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address  <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea name="address" rows="4" class="form-control" required></textarea>
                    </div>
                </div> 

                <div class="form-group">
                    <label class="col-md-2 control-label">Prefix  <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="prefix" class="form-control" step="any"    required>
                    </div>
                </div> 


                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="save" value="Save" class="btn btn-primary">
                    </div>
                </div>
                    
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
 