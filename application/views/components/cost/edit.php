<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
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
        $attribute = array(
            'name' => '',
            'class' => 'form-horizontal',
            'id' => ''
        );
        echo form_open('cost/cost/update_cost/'.$cost[0]->id, $attribute);
    ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Cost</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                <div class="no-title">&nbsp;</div>

                <div class="col-md-9">                                
                    <div class="form-group">
                        <label class="col-md-3 control-label">Date</label>
                        <div class="input-group date col-md-7" id="datetimepicker1">
                            <input type="text" name="date" class="form-control" value="<?php echo $cost[0]->date; ?>" >
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                       <?php  if($this->data['privilege'] == 'super') { ?>
                        <label for="" class="col-md-3 control-label">Showroom</label>
                        <div class="col-md-7">
                            <select name="godown_code" class="form-control" required>
                                <option value="" disabled>-- Select Showroom --</option>
                                <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                                <option <?php if($cost[0]->godown_code==$row->code){echo "selected"; } ?> value="<?php echo $row->code; ?>" >
                                    <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <?php } else { ?>
                            <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                        <?php } ?> 
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Category </label>
                        <div class="col-md-7">
                            <select name="cost_category" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>&nbsp;</option>
                                <?php 
                                    $cost_category= $this->action->read('cost_category'); 
                                    foreach($cost_category as $category){    
                                ?>
                                <option value="<?php echo $category->cost_category;  ?>" <?php if($cost[0]->cost_category == $category->cost_category){  echo 'selected'; }   ?>  ><?php echo $category->cost_category;  ?></option>
                                <?php } ?>
                            </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Cost </label>
                        <div class="col-md-7">
                            <select name="cost_field" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                              <?php foreach ($cost_fields as $key => $value) {?>
                                  <option <?php if($cost[0]->cost_field == $value->cost_field){ echo "selected"; }?> value="<?php echo $value->cost_field; ?>"><?php echo filter($value->cost_field); ?></option>
                              <?php } ?>                             
                             </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Description </label>
                        <div class="col-md-7">
                           <textarea name="description" class="form-control" cols="30" rows="4" placeholder="Enter Description"><?php echo $cost[0]->description; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Amount </label>
                        <div class="col-md-7">
                            <input type="number" name="amount" class="form-control" value="<?php echo $cost[0]->amount; ?>" placeholder="BDT">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Spend By </label>
                        <div class="col-md-7">
                            <input type="text" name="spend_by" class="form-control" value="<?php echo $cost[0]->spend_by; ?>" placeholder="Enter maximum 100 characters">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-primary" type="submit" name="" value="Update">
                                <input class="btn btn-danger" type="reset" value="Clear">
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
