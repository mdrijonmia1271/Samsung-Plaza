<div class="container-fluid">
    <div class="row">

        <?php echo $confirmation; ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit </h1>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">

                    <div class="col-md-7">
                        <?php 
                        $attr = array('class' =>'form-horizontal');
                        echo form_open_multipart('', $attr); 
                        ?>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Image <span class="req">*</span></label>
                            <div class="col-md-9">
                                <input id="input-test" type="file" name="attachFile" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                            </div>
                        </div>

                        <div class="btn-group pull-right">
                            <input type="submit" value="Update" name="update" class="btn btn-primary">
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

