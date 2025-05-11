<div class="container-fluid">
    <div class="row">
	    <?php echo $confirmation; ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Damages</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php $attr = array('class' => 'form-horizontal');
	            echo form_open_multipart('', $attr); ?>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name </label>
                    <div class="col-md-5">
                        <select name="proName" id="" class="form-control">
                            <?php foreach ($product as $key => $value) { ?>
                            <option value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                           <?php } ?>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Quantity </label>
                    <div class="col-md-5">
                        <input type="number" name="quantity" class="form-control" step="any">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save " name="product_add" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
