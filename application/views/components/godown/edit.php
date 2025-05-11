<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Showroom</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('godown/godown/editData/'.$id, $attr); ?>
                
                <input type="hidden" value="<?php $godown[0]->code; ?>">
                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" value="<?php echo $godown[0]->name; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Manager <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="manager" class="form-control" value="<?php echo $godown[0]->manager; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" class="form-control" step="any" value="<?php echo $godown[0]->mobile; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address  <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea name="address" rows="4" class="form-control"required><?php echo $godown[0]->address; ?></textarea>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-2 control-label">Prefix  <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="prefix" class="form-control" value="<?php echo $godown[0]->prefix; ?>" readonly required>
                    </div>
                </div> 

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update" value="Update" class="btn btn-success">
                    </div>
                </div>
                    
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

    </div>
</div>
