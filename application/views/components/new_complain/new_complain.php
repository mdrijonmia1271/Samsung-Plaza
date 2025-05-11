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
        $attribute = array( 'name' => '', 'class' => 'form-horizontal', 'id' => '' );
        echo form_open('', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Complain</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9"> 
                
					<div>
					    <div class="form-group">
                          <label class="col-md-3 control-label">Date <span class="req">*</span></label>
                          <div class="col-md-7">
                            <div class="input-group date" id="datetimepickerFrom">
                                    <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                          </div>
                          
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Customer Name <span class="req">*</span></label>
                          <div class="col-md-7">
                            <input type="text" name="name" class="form-control">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Mobile <span class="req">*</span></label>
                          <div class="col-md-7">
                            <input type="text" name="mobile"  class="form-control">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Service Mobile <span class="req">*</span></label>
                          <div class="col-md-7">
                            <input type="text" name="service_mobile"  class="form-control">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Address </label>
                          <div class="col-md-7">
                            <textarea name="address" rows="3" class="form-control"></textarea>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-3 control-label">Brand <span class="req">*</span> </label>
                          <div class="col-md-7">
                            <select name="brand" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" disabled>-- select brand --</option>
                               <?php foreach($brand as $row){?>
                                <option value="<?php echo $row->category; ?>"><?php echo filter($row->category); ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Product Name <span class="req">*</span> </label>
                        <div class="col-md-7">
                           <select name="product" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required> 
                                <option value="" disabled>-- select product --</option>
                                <?php foreach($product as $row ){ ?>
                                <option value="<?php echo $row->product_code; ?>"><?php echo filter($row->product_name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Model <span class="req">*</span></label>
                        <div class="col-md-7">
                           <select name="model" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required> 
                                <option value="" disabled>-- Select Model --</option>
                                <?php foreach($product as $row ){ ?>
                                <option value="<?php echo $row->product_model; ?>"><?php echo filter($row->product_model); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Problem <span class="req">*</span></label>
                        <div class="col-md-7">
                           <textarea name="problem" class="form-control" cols="30" rows="4" required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Status <span class="req">*</span> </label>
                        <div class="col-md-7">
                           <select name="status" class="form-control" required> 
                                <option value="" disabled>-- select product --</option>
                                <option value="pending">Pending</option>
                                <option value="solved">Solved</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-danger" type="reset" value="Clear" style="margin-right: 16px;">
                                <input type="submit" name="save" value="Save" class="btn btn-primary">
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
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>

