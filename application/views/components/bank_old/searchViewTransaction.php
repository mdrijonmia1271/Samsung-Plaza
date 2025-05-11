<style>
    @media print{
        aside{
            display: none !important;
        }
        nav{
            display: none;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .none{
            display: none;
        }
        .panel-heading{
            display: none;
        }

        .panel-footer{
            display: none;
        }
        .panel .hide{
            display: block !important;
        }
        .title{
            font-size:  25px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Custom Search</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr=array("class"=>"form-horizontal");
               	echo  form_open('',$attr);
                ?>

                <div class="form-group">
                    <!-- <label class="col-md-2 control-label">Bank <span class="req">*</span></label> -->
                    <div class="col-md-3">
                        <select name="search[bank]" class="form-control" required>
                            <option value="">-- Select Bank --</option>
                           <?php foreach ($bank_list as $key => $value) { ?>
                           <option value="<?php echo $value->bank_name; ?>"><?php echo str_replace("_"," ",$value->bank_name); ?></option>
                           <?php } ?>
                        </select>
                    </div>

                    <!-- <label class="col-md-2 control-label">Account Number</label> -->
                    <div class="col-md-4">
                        <input type="text" name="search[account_number]" placeholder="Account Number ( Maximum 15 Digit )" class="form-control">
                    </div>

                    <!-- <label class="col-md-2 control-label">From <span class="req">&nbsp;</span></label> -->
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <!-- <label class="col-md-2 control-label">To <span class="req">&nbsp;</span> --></label>
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="btn-group">
                        <input type="submit" value="Show" name="custom_show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

	    <?php if($bank_record!=null){?>
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <h3 class="text-center hide">Transaction</h3>

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Transaction Type</th>
                        <th>Bank Name</th>
                        <th>Account Number</th>
                        <th>Transaction By</th>
                        <th>Amount</th>
                    </tr>

                    <?php
                    $type = config_item('type');
						$accounts = array();
						$pre_balances = array();

						$credits = array();
						$debits = array();
						foreach ($bank_record as $key => $transaction) {

                        if ($transaction->transaction_type=="Credit") {
                            $credits[] = $transaction->amount;
                        }else{
                            $debits[] = $transaction->amount;
                        }

					?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $transaction->transaction_date; ?></td>
                        <td><?php echo $type[$transaction->transaction_type]; ?></td>
                        <td><?php echo filter($transaction->bank); ?></td>
                        <td><?php echo $accounts[] = $transaction->account_number; ?></td>
                        <td><?php echo $transaction->transaction_by; ?></td>
                        <td><?php echo f_number($transaction->amount); ?></td>
                    </tr>
                    <?php } ?>

                    <caption class="row">
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Account Number</th>
                                    <th>Initial Balance</th>
                                </tr>
                                <?php foreach (array_unique($accounts) as $value) {
                                    $acc_info = $this->action->read("bank_account",array("account_number"=>$value));
                                ?>
                                <tr>
                                    <th><?php echo $value; ?></th>
                                    <td><?php echo f_number($pre_balances[] = $acc_info[0]->pre_balance); ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </caption>

                    <tr>
                        <th colspan="6" class="text-right">Balance</th>
                        <td><?php echo f_number(array_sum($pre_balances) + array_sum($credits)-array_sum($debits)); ?></td>
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
