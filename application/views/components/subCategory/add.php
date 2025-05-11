<div class="container-fluid" ><!--ng-controller="addSubcategoryCtrl"  -->
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Subcategory</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
    				$attr = array('class' =>'form-horizontal');
    	            echo form_open('subCategory/subCategory/add_subcategory', $attr);
				?>
                <div class="form-group">
                    <label class="col-md-3 control-label">Subcategory Name <span class="req">*</span></label>

                    <div class="col-md-4">
                        <input type="text" name="subcategory" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="subcategory_submit" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
