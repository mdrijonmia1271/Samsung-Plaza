<div class="container-fluid">
    <div class="row">
    <?php echo $confirmation;
     ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Import Data</h1>
                </div>
            </div>

            <div class="panel-body">

                <!--blockquote class="form-head">

                    <h4>Import Data</h4>

                    <ol style="font-size: 14px;">
                        <li>1 . If you want to insert <mark>new employee</mark> then use the fields</li>
                        <li>2 . At last click on the <mark>Save</mark> button</li>
                    </ol>

                </blockquote>

                <hr-->


                <!-- horizontal form -->
                <?php
                    $attr=array("class"=>"form-horizontal");
                    echo form_open_multipart('', $attr);
                ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Select File <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input id="input-test" type="file" name="datafile" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                        </div>

                        <div class="btn-group">
                            <input type="submit" name="upload" value="Upload" class="btn btn-primary">
                        </div>
                    </div>
                    
                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
