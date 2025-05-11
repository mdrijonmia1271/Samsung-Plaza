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
    $attribute = array(
        'name' => '',
        'class' => 'form-horizontal',
        'id' => ''
    );
    echo form_open('fixed_assate/fixed_assate/add_new_fixed_assate', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>New Fixed Assate</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date<span class="req">*</span></label>
                            <div class="input-group date col-md-7" id="datetimepicker1">
                                <input type="text" name="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                      <div class="form-group">      
                          <label class="col-md-3 control-label">Showroom<span class="req">*</span></label>
                            <div class="col-md-7">
                                 <?php $allGodowns = $this->action->read('godowns',array('trash' => 0)) ?>
                                 <select name="godown_code" id="godown_code"  class="form-control">
                                    <option value="" selected >-- Select Showroom --</option>
                                    <option value="all">All Showroom</option>
                                    <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                    </option>
                                    <?php } } ?>
                                </select>

                            </div>
                     </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Field of Fixed Assate </label>
                            <div class="col-md-7">
                                <select name="field_fixed_assate" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                    <option value="" selected disabled>&nbsp;</option>
                                    <?php foreach ($fixed_assate_fields as $key => $value) {?>
                                    <option value="<?php echo $value->field_fixed_assate; ?>"><?php echo filter($value->field_fixed_assate); ?></option>
                                    <?php } ?>                             
                                </select> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Description </label>
                            <div class="col-md-7">
                               <textarea name="description" class="form-control" cols="30" rows="4" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Quantity </label>
                            <div class="col-md-7">
                                <input type="number" min="0" step="1" name="quantity" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Amount </label>
                            <div class="col-md-7">
                                <input type="number" name="amount" class="form-control" placeholder="BDT">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Spend By </label>
                            <div class="col-md-7">
                                <input type="text" name="spend_by" class="form-control" placeholder="Enter maximum 100 characters">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-7">
                                <div class="btn-group pull-right">
                                    <input class="btn btn-primary" type="submit" name="createProfileBtn" value="Save">
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