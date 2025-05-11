<div class="container-fluid">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                   <h1>Edit Brand</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array('class' => "form-horizontal");
                echo form_open('subCategory/subCategory/edit' . '?id=' . $this->input->get('id'), $attr);
                ?>

                <!--<div class="form-group">
                    <label class="col-md-3 control-label">
                        Category Name
                        <span class="req">*</span>
                    </label>

                    <div class="col-md-4">
                        <select name="category" class="form-control" required>
                            <?php
                            if($categories != null){
                            foreach ($categories as $key => $value) { ?>
                            <option value="<?php echo $value->category; ?>" <?php if($subcategory[0]->category == $value->category){echo "selected";} ?>>
                                <?php echo str_replace('_', ' ', $value->category); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>-->

                <div class="form-group">
                    <label class="col-md-3 control-label">Subcategory Name <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input
                            type="text"
                            name="subcategory"
                            value="<?php echo str_replace('_', ' ',$subcategory[0]->subcategory); ?>"
                            class="form-control" required>

                        <input
                            type="hidden"
                            name="old_sub_category"
                            value="<?php echo $subcategory[0]->subcategory; ?>"
                            class="form-control" required>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Update" class="btn btn-primary">
                    </div>
                </div>
               <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
