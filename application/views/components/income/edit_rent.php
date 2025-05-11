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
    echo form_open('income/income/editRent/'.$rent[0]->id, $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Rent</h1>
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
                            <input type="text" name="date" class="form-control" value="<?php echo $rent[0]->date; ?>" >
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Income </label>
                        <div class="col-md-7">
                            <select name="field" class="form-control">
                              <?php foreach ($fields as $key => $value) {?>
                                  <option <?php if($rent[0]->field == $value->field){ echo "selected"; }?> value="<?php echo $value->field; ?>"><?php echo str_replace(" ","_",$value->field); ?></option>
                              <?php } ?>                             
                             </select> 
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Year </label>
                        <div class="col-md-7">
                            <select name="year" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>&nbsp;</option>
                                <?php for($i=date('Y'); $i<=date('Y')+5; $i++) {?>
                                <option <?php if($rent[0]->year == $i){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>                             
                            </select> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Month </label>
                        <div class="col-md-7">
                            <select name="month" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>&nbsp;</option>
                                <?php foreach (config_item('months') as $value) {?>
                                <option <?php if($rent[0]->month == $value){ echo 'selected'; } ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php } ?>                             
                            </select> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Amount </label>
                        <div class="col-md-7">
                            <input type="text" name="amount" class="form-control" value="<?php echo $rent[0]->amount; ?>" placeholder="BDT">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Received By </label>
                        <div class="col-md-7">
                            <input type="text" name="received_by" class="form-control" value="<?php echo $rent[0]->received_by; ?>" placeholder="Enter maximum 100 characters">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Given By </label>
                        <div class="col-md-7">
                           <textarea name="remark" class="form-control" cols="30" rows="1" placeholder=""><?php echo $rent[0]->remark; ?></textarea>
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




