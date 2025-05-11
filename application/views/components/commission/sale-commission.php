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
        .panel .hide{
            display: block !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
	    <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Sale Commission</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php 
                $attr = array('class' =>'form-horizontal');
                echo form_open('',$attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label"> Company Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="search[brand]" class="form-control">
                            <option>&nbsp;</option>
                            <?php foreach ($company as $key => $value) { ?>
                                <option value="<?php echo $value->slug; ?>"><?php echo filter($value->subcategory); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">From</label>
                    <div class="input-group date col-md-5" id="datetimepickerSMSFrom">
                        <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To</label>
                    <div class="input-group date col-md-5" id="datetimepickerSMSTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Save" name="show" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>



   <?php if($result != NULL){ ?>

        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
               <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
               <hr class="hide" style="border-bottom: 1px solid #ccc;">

               <table class="table table-bordered">
                    <tr>
                       <th width="45px">SL</th>
                       <th>Date</th>
                       <th>Company Name</th>
                       <th>Quantity</th>
                       <th>Commission</th>
                       <th>Amount</th>
                       <th>Status</th>
                     </tr>

                    <?php
                    $total = array();
                    $totalQuantity = 0;
                    foreach ($result as $key => $value) { 
                    ?>
                        <tr>
                           <td width="45px"><?php echo $key + 1 ; ?></td>
                           <td><?php echo $value->sap_at ; ?></td>
                           <td><?php echo v_check($value->brand); ?></td>
                           <td><?php echo $value->quantity;$totalQuantity += $value->quantity; ?></td>
                           <td><?php echo $commission = 5; ?></td>
                           <td><?php echo $total[] = $value->quantity * $commission; ?></td>
                           <td><?php echo "Paid"; ?></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="3" class="text-right"> Total </th> 
                        <th><?php echo $totalQuantity; ?></th> 
                        <th><?php echo $totalQuantity . " x " . $rate . " = " . f_number($totalQuantity * $rate); ?></th> 
                        <th colspan="2"><?php echo f_number(array_sum($total)); ?></th> 
                    </tr>
               </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php } ?>
    </div>
</div>

<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
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

