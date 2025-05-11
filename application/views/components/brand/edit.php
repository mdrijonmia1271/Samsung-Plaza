<div class="container-fluid">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                   <h1>Edit Brand</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array('class' => "form-horizontal");
                echo form_open('', $attr);
                ?>

                <input type="hidden" name="old_brand" value="<?php echo $brand->brand; ?>">
                <div class="form-group">
                    <label class="col-md-3 control-label">Brand Name <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input
                            type="text"
                            name="brand"
                            value="<?php echo filter($brand->brand); ?>"
                            class="form-control" required>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update"value="Update" class="btn btn-primary">
                    </div>
                </div>
               <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
