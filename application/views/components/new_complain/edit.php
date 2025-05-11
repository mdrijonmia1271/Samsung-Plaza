<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
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
    $attribute = array( 'name' => '', 'class' => 'form-horizontal');
    echo form_open('', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    <div>
					    <div class="form-group">
                          <label class="col-md-3 control-label">Date </label>
                          <div class="col-md-7">
                            <div class="input-group date" id="datetimepickerFrom">
                                    <input type="text" name="date" value="<?php echo $complainInfo[0]->date; ?>" class="form-control">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                          </div>
                          
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Customer Name </label>
                          <div class="col-md-7">
                            <input type="text" name="name" value="<?php echo $complainInfo[0]->name; ?>" class="form-control">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Mobile </label>
                          <div class="col-md-7">
                            <input type="text" name="mobile" value="<?php echo $complainInfo[0]->mobile; ?>" class="form-control">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Service Mobile </label>
                          <div class="col-md-7">
                            <input type="text" name="service_mobile" value="<?php echo $complainInfo[0]->service_mobile; ?>" class="form-control">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Address </label>
                          <div class="col-md-7">
                            <textarea name="address" rows="3" class="form-control"><?php echo $complainInfo[0]->address; ?></textarea>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Brand </label>
                          <div class="col-md-7">
                            <select name="brand" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                                <option value="" disabled>-- select brand --</option>
                               <?php foreach($brand as $row){?>
                                <option <?php if($row->category == $complainInfo[0]->brand){echo "selected";}?> value="<?php echo $row->category; ?>"><?php echo filter($row->category); ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Product Name  </label>
                        <div class="col-md-7">
                          <select name="product" class="selectpicker form-control" data-show-subtext="true" data-live-search="true"> 
                                <option value="" disabled>-- select product --</option>
                                <?php foreach($product as $row ){ ?>
                                <option <?php if($row->product_code == $complainInfo[0]->product){echo "selected";}?> value="<?php echo $row->product_code; ?>"><?php echo filter($row->product_name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Model </label>
                        <div class="col-md-7">
                            <select name="model" class="selectpicker form-control" data-show-subtext="true" data-live-search="true"> 
                                <option value="" disabled>-- select Model --</option>
                                <?php foreach($product as $row ){ ?>
                                <option <?php if($row->product_model == $complainInfo[0]->model){echo "selected";}?> value="<?php echo $row->product_model; ?>"><?php echo filter($row->product_model); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Problem </label>
                        <div class="col-md-7">
                           <textarea name="problem" class="form-control" cols="30" rows="4" ><?php echo $complainInfo[0]->problem; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Status  </label>
                        <div class="col-md-7">
                           <select name="status" class="form-control" > 
                                <option value="" >-- select product --</option>
                                <option <?php if($complainInfo[0]->status=="pending"){echo"selected";}?> value="pending">Pending</option>
                                <option <?php if($complainInfo[0]->status=="solved"){echo"selected";}?> value="solved">Solved</option>
                            </select>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-success" type="submit" name="update" value="Update">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<script>
     $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>

