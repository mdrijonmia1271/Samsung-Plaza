<style>
    @media print{
        aside, nav, .panel-heading, .none, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .panel .box-width{
            width: 100%;
            float: left;
        }
        .hide{
            display: block !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Report</h1>
                </div>
            </div>

            <div class="panel-body none">
                <div class="row">
                    <?php 
                    $attr = array ('class' => 'form-horizontal');
                    echo form_open('', $attr); 
                    ?>
                    <?php /* if($this->data['privilege'] != 'user'){ ?>
                       <div class="form-group">
                        <label class="col-md-2 control-label">শোরুম  </label>
                        <div class="col-md-5">     
                            <select class="form-control" name="showroom"> 
                             <option value="">শোরুম  নির্বাচন করুন</option>
                              <?php 
                                 if($showroom != NULL){
                                  foreach($showroom as $key=>$value){?>
                                    <option value="<?php echo $value->showroom_id; ?>"><?php echo $value->name; ?></option>
                              <?php  } } ?>
                            </select>                                          
                        </div>
                    </div>
                    <?php }*/ ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Date</label>
                        <div class="input-group date col-md-5" id="datetimepickerFrom">
                            <input type="text" name="date" value="<?php echo date('Y-m-d');?>" class="form-control" placeholder="YYYY-MM-DD">

                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-xs-7">
                        <div class="btn-group pull-right">
                            <input type="submit" value="Show" name="search" class="btn btn-primary">
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        



            <?php if($resultset != null){ ?>
            <div class="panel panel-default">
                
                <div class="panel-heading">
                    <div class="panal-header-title">
                        <h1 class=" pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i>Print </a>
                    </div>
                </div>


                <div class="panel-body">
                    <!-- Print Banner -->
                    <img class="img-responsive hide print-banner" src="<?php echo site_url($banner_info[0]->path); ?>">
                    
                    <h4 class="hide text-center" style="margin-top: -10px;">Report</h4>
                   
                    <div class="row">
                        <div class="col-md-12 box-width">                         

                            <table class="table table-bordered ">
                            <?php foreach($resultset as $key => $row){ ?>
                                <tr>
                                    <td width="50%">Previous Balance</td>
                                    <td><?php echo $row->opening; ?></td>
                                </tr>
                                    <td>Income</td>
                                    <td><?php echo $row->income; ?></td>
                                </tr>
                                 <tr>  
                                    <td>Bank Withdraw</td>
                                    <td><?php echo $row->bank_withdraw; ?></td>
                                </tr>
                                <tr>
                                    <td>Cost</td> 
                                    <td><?php echo $row->cost; ?></td>
                                 </tr> 
                                 <tr>  
                                    <td>Bank Diposit</td>
                                    <td><?php echo $row->bank_diposit; ?></td>
                                </tr>
                                <tr>
                                    <td>Hand Cash </th>
                                    <td><?php echo $row->hand_cash; ?></td>
                                </tr>
                                    
                                <?php } ?>                           
                            </table>
                       </div>                  
                    </div>
                </div>

                <div class="panel-footer">&nbsp;</div>
            </div>
            <?php } ?>
 
        </div>
    </div>
</div>

<script>
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>


