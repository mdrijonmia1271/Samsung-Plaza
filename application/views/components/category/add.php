<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Category</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array(
                    'class' =>'form-horizontal'
                    );
	            echo form_open('category/category/addCategory',$attr); ?>


                <div class="form-group">
                    <label class="col-md-3 control-label"> Category Name <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="category" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Save" name="catetory_submit" class="btn btn-primary pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

