<style type="text/css">
    .info-view{
        width: 100%;
        max-width: 230px;
        max-height: 230px;
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    .custom-table tr td{
        padding: 0 !important;
    }

    .custom-table tr td .form-control{
        border: transparent;
    }
</style>

<?php echo $this->session->flashdata('confirmation'); ?>
<div class="panel panel-default" ng-controller="BonusCtrl" ng-cloak>

    <div class="panel-heading panal-header">
        <div class="panal-header-title pull-left">
            <h1>Edit Bonus </h1>
        </div>
    </div>

    <div class="panel-body">
        <?php
        $attr = array("class"=>"form-horizontal");
        echo form_open('salary/salary/bonus_edit/'.$percent[0]->id, $attr);
        
        $datearray = array($percent[0]->month,$percent[0]->year);
        $date = implode("/",$datearray);
        ?>
        <?php /* <pre><?php print_r($percent); ?></pre> */ ?>
          <div class="form-group">
            <label class="col-md-3 control-label">Employee <span class="req"> *</span></label>
            <div class="col-md-5">
                <select name="emp_id" class="form-control" required>
                    <option value="">&nbsp;</option>
                    <?php if($employee != NULL){ foreach($employee as $key => $value){ ?>
                    <option <?php if($value->emp_id == $percent[0]->emp_id){ echo "selected"; } ?>  value="<?php echo $value->emp_id; ?>"> <?php echo filter($value->name); ?></option>
                    <?php } }?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">Date <span class="req">*</span></label>
            <div class="col-md-5">
                <div class='input-group date' id='datetimepicker10'>
                    <input type='text' value="<?php echo $date; ?>" name="date" class="form-control" required/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
        </div>
        
        
        <div class="form-group">
            <label class="col-md-3 control-label">Bonus <span class="req">*</span></label>
            <div class="col-md-5">
                <div class="input-group">
                    <input type="text" name="bonus" value="<?php echo $percent[0]->bonus_percent;?>" placeholder="Set Your Bonus" class="form-control" required>
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="btn-group pull-right">
                <input type="submit" class="btn btn-success" style="margin-right: -5px;" value="Update" name="set" />
            </div>
        </div>
        

        <?php echo form_close(); ?>
    </div>

    <div class="panel-footer">&nbsp;</div>
</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'MM/YYYY'
        });
    });
</script>