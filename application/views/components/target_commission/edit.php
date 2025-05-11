<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Target commission</h1>
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
                            <option value="">&nbsp;</option>
                            <?php  foreach ($brands as $brand) { ?>
                            <option <?php if($allCommissions[0]->brand == $brand->subcategory){echo "selected"; } ?> value="<?php echo $brand->subcategory; ?>"><?php echo $brand->subcategory; ?></option>
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
                        <select name="year" class="form-control" >
                            <option value="" selected disabled>&nbsp;</option>
                            <?php 
                            $fromYear = date('Y') - 3;
                            $toYear = date('Y') + 1;
                            for($i=$fromYear;$i<=$toYear;$i++) { 
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <option value="<?php echo ($i); ?>" <?php if($i==$allCommissions[0]->year){ echo "selected";}?>><?php echo $i; ?></option>
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
                        <select name="month" class="form-control" >
                            <option value="" selected disabled>&nbsp;</option>
                            <?php foreach($months as $key => $value) { ?>
                            <option value="<?php echo ($key); ?>" <?php if($key==$allCommissions[0]->month){ echo "selected";}?>><?php echo $value; ?></option>
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
                        <input type="number" name="commission" class="form-control" value="<?php echo $allCommissions[0]->amount; ?>"  step="any" >
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-md-5">
                        <input type="submit" name="update" value="Update" class="btn btn-success">
                    </div>
                </div>
            </div>

            <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
