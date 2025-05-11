<div class="container-fluid">
    <div class="row">
        <?php //echo $this->session->flashdata('confirmation');
        echo $confirmation; ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Raw Material</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr=array("class"=>"form-horizontal");
                echo form_open_multipart('', $attr);
                ?>

                 <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="mats_name" value="<?php echo $records[0]->name; ?>" class="form-control" >
                    </div>
                </div>
			
                <input type="hidden" name="mats_code" value="<?php echo $records[0]->code; ?>" class="form-control" >

                <div class="form-group">
                    <label class="col-md-2 control-label">Price</label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="price" min="0" value="<?php echo $records[0]->price; ?>" class="form-control" step="any">
                        <div class="input-group-addon">TK / kg</div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-5 input-group">
                        <select name="status" class="form-control">
                            <?php foreach (config_item('status') as $value) { ?>
                                <option <?php if($value==$records[0]->status) echo "selected"; ?> value="<?php echo $value; ?>"><?php echo filter($value); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update_mats" value="Update" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
