<div class="container-fluid">
    <div class="row">
        <?php echo $confirmation; ?>
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>প্রারম্ভিক ব্যালেন্স</h1>
                </div>
            </div>

            <div class="panel-body none">

                <div class="row">
                    <?php 
                    $attr = array (
                        'class' => 'form-horizontal'
                    );
                    echo form_open('', $attr); 
                    ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Opening</label>
                        <div class="col-md-5">
                            <input type="text" name="opening_amount" value="<?php if($opening_val != NULL){ echo custom_fetch($opening_val,"hand_cash"); } else { echo 0;} ?>" class="form-control">
                        </div>
                    </div>

                    <?php 

                        $name   = "update";
                        $value  = 'Update';

                        if ($opening<1) {
                            $name   = "submit";
                            $value  = 'Save';
                        }
                    ?>

                    <div class="col-xs-7">
                        <div class="btn-group pull-right">
                            <input type="submit" value="<?php echo $value; ?>" name="<?php echo $name; ?>" class="btn btn-primary">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

        <div class="panel-footer">&nbsp;</div>
        </div>
        
           