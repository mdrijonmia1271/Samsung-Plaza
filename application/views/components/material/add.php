<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Material</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr=array("class"=>"form-horizontal");
                echo form_open_multipart('', $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="mats_name" class="form-control" required>
                    </div>
                </div>
                
                <input type="hidden" name="mats_code" class="form-control">
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Price <span class="req">*</span></label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="price" min="0" value="0" class="form-control" step="any" required>
                        <div class="input-group-addon">TK / Kg</div>
                    </div>
                </div>


                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="add_mats" value="Save" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
