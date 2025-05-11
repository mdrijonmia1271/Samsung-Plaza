<style>
    @media print{
        aside, nav, .panel-heading, .panel-footer, .none{
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
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Loan</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php $attr = array ('class' => 'form-horizontal');
                echo form_open('', $attr); ?>
                
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Type <span class="req">&nbsp;</span></label> -->
                    <div class="col-md-4">
                        <select name="search[type]" class="form-control">
                            <option value="" selected>-- Select Type --</option>
                            <option value="Bank">Bank</option>
                            <option value="Person">Person</option>
                        </select>
                    </div>

                    <!-- <label class="col-md-2 control-label">Loan Type </label> -->
                    <div class="col-md-4">
                        <select name="search[loan_type]" class="form-control">
                            <option value="" selected>-- Select Loan Type --</option>
                            <option value="Received">Received</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>

                   <!--  <label class="col-md-2 control-label"> Status</label> -->
                    <div class="col-md-4">
                        <select class="form-control" name="search[status]">
                            <option value="" selected>-- Select Status --</option>
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">From</label> -->
                    <div class="col-md-4">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From ( YYYY-MM-DD )">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <!-- <label class="col-md-2 control-label">To</label> -->
                    <div class="col-md-4">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To ( YYYY-MM-DD )">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
 
                    <div class="col-md-2">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>








        <?php if ($allInfo != null) { ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                
                <h3 class="text-center hide" style="margin-top: 0px;">All Loan Information</h3>

                <table class="table table-bordered">
                    <tr>
                        <th width="40px"> SL </th>
                        <th width="90px"> Date </th>
                        <th> Bank / Person Name </th>
                        <!-- <th> Loan By </th> -->
                        <th> Contact Info </th>
                        <th> Type </th>
                        <th> Loan Type </th>
                        <th> Amount </th>
                        <th> Status </th>
                        <th class="none"> Action </th>
                    </tr>
			        <?php
                    $total = array();
                    foreach($allInfo as $key => $row){
                    if ($row->status == "Open") {
                        $color = "red";
                    }else { $color = "green"; }
                    ?>
                    <tr>
                        <td> <?php echo $key + 1; ?> </td>
                        <td> <?php echo $row->date; ?> </td>
                        <td> <?php echo filter($row->name); ?> </td>
                        <!-- <td> <?php //echo filter($row->loan_by); ?> </td> -->
                        <td> <?php echo $row->contact_info; ?> </td>
                        <td> <?php echo $row->type; ?> </td>
                        <td> <?php echo $row->loan_type; ?> </td>
                        <td> <?php echo  f_number($total[] = $row->amount); ?> </td>
                        <td>
                            <a class="none" style="font-weight: bold; color: <?php echo $color; ?>;" class="c-btn" href="<?php echo site_url("loan/loan/status/".$row->id); ?>"><?php echo $row->status; ?></a>
                            <span class="hide"><?php echo $row->status; ?></span>
                        </td>
                        <td class="none" style="width: 160px;">
                            <a title="View" target="_blank" href="<?php echo site_url("loan/loan/preview/". $row->id); ?>" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            
                            <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>
                                    <a title="Edit" target="_blank" href="<?php echo site_url("loan/loan/edit/". $row->id); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want ot delete this data!')" href="<?php echo site_url("loan/loan/delete/". $row->id); ?>"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                        
                             <?php  } ?>  
                        </td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th class="text-right" colspan="6">Total</th>
                        <th><?php echo f_number(array_sum($total)); ?></th>
                        <th></th>
                        <th class="none"></th>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    <?php } ?>
    </div>
</div>

<script type="text/javascript">
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
