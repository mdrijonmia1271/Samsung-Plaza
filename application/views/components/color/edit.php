<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Category</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array('class' => 'form-horizontal');
                echo form_open('color/color/update/' . $info->id, $attr); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Color Name <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="color" value="<?php echo $info->color; ?>" placeholder=""
                               class="form-control"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Update" name="update" class="btn btn-primary pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

