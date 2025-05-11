<div class="container-fluid" ><!--ng-controller="addSubcategoryCtrl"  -->
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Brand</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
				$attr = array('class' =>'form-horizontal');
	            echo form_open('brand/brand/add_brand', $attr);
				?>
                <div class="form-group">
                    <label class="col-md-3 control-label">Brand Name <span class="req">*</span></label>

                    <div class="col-md-4">
                        <input type="text" name="brand" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="brand_submit" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
