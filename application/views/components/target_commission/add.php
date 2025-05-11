<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Target commission</h1>
                </div>
            </div>

            <div class="panel-body">
            <!-- horizontal form -->
            <?php
            $attr = array("class" => "form-horizontal");
            echo form_open('', $attr);
            ?>

            <div class="col-md-12">

                <div class="form-group">
                    <div class="col-md-2 text-right">
                        <label class="control-label">
                            Brand <span class="req">*</span>
                        </label>
                    </div>

                    <div class="col-md-5">
                        <select name="brand" class="form-control" required>
                        <?php  foreach ($brands as $brand) { ?>
                        <option value="<?php echo $brand->subcategory; ?>"><?php echo $brand->subcategory; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-2 text-right">
                        <label class="control-label">
                            Year <span class="req">*</span>
                        </label>
                    </div>

                    <div class="col-md-5">
                        <select name="year" class="form-control" required>
                            <option value="" selected>&nbsp;</option>
                            <?php
                            $fromYear = date('Y') - 3;
                            $toYear = date('Y') + 1;
                            for($i=$fromYear;$i<=$toYear;$i++) { 
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-2 text-right">
                        <label class="control-label">
                            Month <span class="req">*</span>
                        </label>
                    </div>

                    <div class="col-md-5">
                        <select name="month" class="form-control" required>
                            <option value="" selected>&nbsp;</option>
                            <?php foreach($months as $key => $value) { ?>
                            <option value="<?php echo ($key + 1); ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-2 text-right">
                        <label class="control-label">
                            Commission <span class="req">*</span>
                        </label>
                    </div>

                    <div class="col-md-5">
                        <input type="number" name="commission" class="form-control" value="0.00" min="0" step="any" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-md-5">
                        <input type="submit" name="save" value="Save" class="btn btn-primary">
                    </div>
                </div>
            </div>

            <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
