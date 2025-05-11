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
            <h1>Bonus </h1>
        </div>
    </div>

    <div class="panel-body">
        <?php
        $attr = array("class"=>"form-horizontal");
        echo form_open('salary/salary/set_bonus', $attr);
        ?>
        
          <div class="form-group">
            <label class="col-md-3 control-label">Employee <span class="req"> *</span></label>
            <div class="col-md-5">
                <select name="emp_id" class="form-control" required>
                    <option value="">&nbsp;</option>
                    <?php if($employee != NULL){ foreach($employee as $key => $value){ ?>
                    <option value="<?php echo $value->emp_id; ?>"> <?php echo filter($value->name); ?></option>
                    <?php } }?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">Date <span class="req">*</span></label>
            <div class="col-md-5">
                <div class='input-group date' id='datetimepicker10'>
                    <input type='text' name="date" class="form-control" required/>
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
                    <input type="text" name="bonus" placeholder="Set Your Bonus" class="form-control" required>
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="btn-group pull-right">
                <input type="submit" class="btn btn-success" style="margin-right: -5px;" value="Set" name="set" />
            </div>
        </div>
        

        <?php echo form_close(); ?>
    </div>

    <div class="panel-footer">&nbsp;</div>
</div>
<?php if($percent != null){?>
<div class="panel panel-default">

    <div class="panel-heading panal-header">
        <div class="panal-header-title pull-left">
            <h1>Result </h1>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <?php /* <pre><?php print_r($percent); ?></pre> */ ?>
            <table class="table table-bordered">
                <tr>
                    <th width="50">SL</th>
                    <th width="130">Date</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Bonus</th>
                    <th width="110">Action</th>
                </tr>
                <?php 
                   foreach($percent as $key => $value){
                   $name = $this->action->read("employee",array("emp_id" => $value->emp_id));
                   $name = ($name) ? filter($name[0]->name) : "";
                ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo format_date($value->date); ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $value->emp_id; ?></td>
                    <td><?php echo $value->year; ?></td>
                    <td><?php echo $value->month; ?></td>
                    <td><?php echo $value->bonus_percent; ?> %</td>
                    <td>
                        <a href="<?php echo site_url('salary/salary/edit_bonus/'.$value->id); ?>" title="Edit" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        <a href="<?php echo site_url('salary/salary/bonus_delete/'.$value->id); ?>" onclick="return confirm('Do you want to delete this Bonus Data?');" title="Delete" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div class="panel-footer">&nbsp;</div>
</div>
<?php }?>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'MM/YYYY'
        });
    });
</script>