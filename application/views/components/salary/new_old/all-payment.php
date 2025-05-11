<style type="text/css">
@media print{
aside, nav, .none, .panel-heading, .panel-footer {
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
}
.table tr td{
vertical-align: middle !important;
}
.cap-border {
    border-top: 1px solid #ddd;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    background:#eee;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Search Payment</h1>
                    
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal none");
                echo form_open("",$attr);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Employee <span class="req"> *</span></label>
                            <div class="col-md-5">
                                <select name="search[eid]" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <?php if($employee != NULL){ foreach($employee as $key => $value){ ?>
                                    <option value="<?php echo $value->emp_id; ?>"> <?php echo filter($value->name); ?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-md-2 control-label">Year <span class="req"> *</span></label>
                            <div class="col-md-5">
                                <select name="search[year]" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <?php
                                    for($i=2016; $i <= date('Y'); $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div-->
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Month <span class="req"> &nbsp;</span></label>
                            <div class="col-md-5">
                                <select name="search[month]" class="form-control">
                                    <option value="">&nbsp;</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo 'From' ;?></label>
                            <div class="input-group date col-md-5" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo 'To' ;?></label>
                            <div class="input-group date col-md-5" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7">
                                <input type="submit" name="show" value="Show" class="btn btn-info pull-right">
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                
                <?php /* if($result != NULL) { ?>
                <!-- Print banner -->
                <p class="text-center hide" style="margin:10px auto;">All Payments List</p>
                <span class="text-center hide print-time">
                    Employee :
                    <?php
                    $info = $this->action->read("employee",array('emp_id' => $_POST['search']['eid']));
                    echo ($info) ? filter($info[0]->name) : "";
                    ?>
                </span><br>
                <div>
                    <hr class="none" style="border: 1px dashed  #ddd; margin-top: 5px;">
                    <div class="none">&nbsp;</div>
                    <table class="table table-bordered" >
                        <tr>
                            <th width="40"> SL </th>
                            <th width="200"> Advanced Payment</th>
                            <th width="200"> Salary Payment</th>
                            <th>Remarks</th>
                            <th> Status </th>
                        </tr>
                        <?php
                        $totalAdvanced = $balance = 0.00;
                        $status = "";
                        $monthArray = config_item("all_months");
                        foreach ($result as $key => $value) {
                        $condition = array(
                        "emp_id"  => $value->eid,
                        "year"    => $value->year,
                        "month"   => $value->month,
                        );
                        $advanced = $this->action->read_sum("advanced_payment","amount",$condition);
                        $advanced = ($advanced) ? $advanced[0]->amount : 0.00;
                        $totalAdvanced += $advanced;
                        ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $advanced; ?></td>
                            <td><?php echo $value->paid; ?></td>
                            <td>The payment of  the month of
                                <?php
                                echo $monthArray[$value->month];
                                ?>&nbsp;has been Paid
                            </td>
                            <td>
                                <?php
                                $balance = $value->total - $value->paid;
                                $status = ($balance < 0) ? "Receivable" : "Payable";
                                echo abs($balance) . " TK  " . $status;
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } */ ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
</div>

<?php 
  $allMonths = config_item('all_months');
  $totalAdvanced = $totalBonus = $totalSalary  = 0.00;
  if($advanced != NULL || $salary != NULL) {
      $employeeInfo = ($salary) ? $this->action->read('employee',array('emp_id'=> $salary[0]->eid)) :"";
      // print_r($employeeInfo);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panal-header-title">
            <h1 class="pull-left">All Payment of <?php echo($employeeInfo)? $employeeInfo[0]->name:"";?></h1>
            
            <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
    <div class="panel-body">

         <!-- Print banner -->
         
                <!--Print Banner Start Here-->
                
                <?php $banner_info = $this->action->read("banner"); ?>
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>" alt="">
                
                <!--Print Banner End Here-->
                
                
         <div class="row hide">
            <!--div class="view-profile">
                <div class="col-xs-4">
                    <div class="loag-area">
                        <img src="<?php echo site_url($vheaderInfo[0]->path); ?>" alt="" />
                    </div>
                </div>
                
                <div class="col-xs-8">
                    <div class="institute">
                        <h2 class="title" style="margin-top: 10px; font-weight: bold;">
                        <?php echo $GLOBALS['footer_info']['header_txt']; ?>
                        </h2>
                        
                        <h4 style="margin: 0;">
                        <?php echo $GLOBALS['footer_info']['addr_address']; ?>
                        </h4>
                        
                        <h4 style="margin: 0;">
                        Mobile: <?php echo $GLOBALS['footer_info']['addr_moblile']; ?>
                        </h4>
                    </div>
                </div>
            </div-->
            
        </div>
                        
                        
                <hr class="hide" style="border-bottom: 2px solid #ccc; margin-top: 5px;">
                <h4 class="text-center hide" style="margin-top: 0px;">All Payment of <?php echo($employeeInfo)? $employeeInfo[0]->name:"";?></h4><hr class="hide">
        <div class="col-md-6">
            <table class="table table-bordered table-hover">
                <caption class="cap-border text-center"><strong>Salary</strong></caption>
                <tr>
                    <th width="50">SL</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Bonus</th>
                    <th>Amount</th>
                </tr>
                <?php foreach($salary as $sl=>$val) { ?>
                    <tr>
                        <td><?php echo $sl+1; ?></td>
                        <td><?php echo $val->year; ?></td>
                        <td><?php echo $allMonths[$val->month]; ?></td>
                        <td><?php echo $val->bonus_amount; $totalBonus += $val->bonus_amount; ?> TK</td>
                        <td><?php echo $val->paid; $totalSalary += $val->paid; ?> TK</td>
                    </tr>
                <?php } ?>
                <tr>
                    <th class="text-right" colspan="3">Total</th>
                    <th><?php printf("%.2f",$totalBonus); ?> TK</th>
                    <th><?php printf("%.2f",$totalSalary); ?> TK</th>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-hover">
                <caption class="cap-border text-center"><strong>Advanced</strong></caption>
                <tr>
                    <th width="50">SL</th>
                    <th>Date</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Amount</th>
                </tr>
                <?php foreach($advanced as $key=>$value) { ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo format_date($value->date);?></td>
                        <td><?php echo $value->year; ?></td>
                        <td><?php echo $allMonths[$value->month]; ?></td>
                        <td><?php echo $value->amount; $totalAdvanced += $value->amount; ?> TK</td>
                    </tr>
                <?php } ?>
                <tr>
                    <th class="text-right" colspan="4">Total</th>
                    <th><?php printf("%.2f",$totalAdvanced); ?> TK</th>
                </tr>
            </table>
        </div>
        
        <div class="col-md-offset-6 col-md-6">
            <table class="table table-bordered table-hover">
                <tr>
                    <th width="110" style="background: #009688; color: #fff; text-align: right;" >Balance</th>
                    <th style="background: #009688; color: #fff; text-align: center;" >
                        <?php 
                           $balance = $totalAdvanced - $totalSalary; 
                           printf("%.2f",abs($balance));
                        ?> Tk
                    </th>
                    <?php if($balance >= 0) { ?>
                    <th width="110" style="background: #009688; color: #fff; text-align: center;" >Receivable</th>
                    <?php } else{ ?>
                    <th width="110" style="background: #009688; color: #fff; text-align: center;" >Payable</th>
                    <?php } ?>
                </tr>
            </table>
        </div>
        
        
    </div>
    <div class="panel-footer">&nbsp;</div>
  </div>
  <?php } ?>
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
</script>