<div class="container-fluid">
    <div class="row">
	    <?php echo $confirmation; ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Sister Concern</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php 
                $attr = array('class' => 'form-horizontal');
	            echo form_open_multipart('', $attr); 
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Image <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input id="input-test" type="file" name="image" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save " name="save" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

