<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
        .block-hide{
            display: none;
        }
    }
</style>


<div class="container-fluid block-hide">
    <div class="row">

    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
    $attribute = array( 'name' => '', 'class' => 'form-horizontal', 'id' => 'complainInfo[0]->id' );
    echo form_open('complain/complain/edit/', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Complain</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Date</label>
                        <div class="input-group date col-md-7" id="datetimepicker1">
                            <input type="text" name="date" class="form-control" value="<?php echo $complainInfo[0]->date; ?>" readonly> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Sale Type</label>
                        <div class="input-group col-md-7">
                            <input type="text" name="sale_type" class="form-control" value="<?php echo $complainInfo[0]->sale_type; ?>" readonly> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Customer Name</label>
                        <div class="input-group col-md-7">
                            <input type="text" name="name" class="form-control" value="<?php echo $complainInfo[0]->name; ?>"> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Mobile</label>
                        <div class="input-group col-md-7">
                            <input type="text" name="mobile" class="form-control" value="<?php echo $complainInfo[0]->mobile; ?>"> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Address</label>
                        <div class="input-group col-md-7">
                            <textarea rows="3" type="text" name="address" class="form-control" value="<?php echo $complainInfo[0]->address; ?>"><?php echo $complainInfo[0]->address; ?> </textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Name</label>
                        <div class="input-group col-md-7">
                            <textarea rows="3" type="text" name="product_name" class="form-control" value="<?php echo $complainInfo[0]->product_name; ?>"><?php echo $complainInfo[0]->product_name; ?> </textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Complain</label>
                        <div class="input-group col-md-7">
                            <textarea rows="4" type="text" name="complain" class="form-control" value="<?php echo $complainInfo[0]->product_name; ?>"><?php echo $complainInfo[0]->complain; ?> </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Status </label>
                        <div class="col-md-7">
                            <input type="text" name="status" class="form-control" value="<?php echo $complainInfo[0]->status; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-danger" type="reset" value="Clear">
                                <input class="btn btn-primary" type="submit" name="update" value="Update">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>




