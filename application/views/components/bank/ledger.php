
<script src="<?php echo site_url('private/js/ngscript/bankLedger.js'); ?>"></script>
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
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
</style>

<div class="container-fluid" ng-controller="bankLedger">
    <div class="row">
        <?php
        $total = 0;
        echo $confirmation;
        ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Search</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php 
                    $attr = array ('class' => 'form-horizontal');
                    echo form_open('', $attr); 
                ?>
                <div class="form-group row">
                    <label class="col-md-2 control-label">Bank </label>
                    <div class="col-md-5">
                        <select name="search[bank]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" ng-model="bank" ng-change="getAccountFn()" required>
                            <option value="" selected disabled>&nbsp;</option>
                            <?php foreach ($allBank as $key => $row) { ?>
                            <option value="<?php echo $row->bank_name; ?>">
                            <?php echo filter($row->bank_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label">Account No </label>
                    <div class="col-md-5">
                        <select name="search[account_number]" ng-model="account" class="form-control" required>
                            <option value="" selected disabled>&nbsp;</option>
                            <option ng-repeat="accountNo in allAccount" ng-value="accountNo.account_number">{{ accountNo.account_number }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Showroom <span class="req"></span></label>
                    
                    <div class="col-md-5">
                        <select name="search[godown_code]" class="form-control">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>" >
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2 control-label">From </label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2 control-label">To </label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 pull-right">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Transaction</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <?php if(!$this->input->post("show")){ ?>
            <!-- before -->
            <div class="panel-body">
                                          <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <!--<h3 class="text-center hide" style="margin-top: -10px;">All Bank Transaction</h3>-->
                <div class="col-md-12 text-center hide">
                    <h3>Bank Ledger</h3>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th> Bank Name </th>
                        <th> Account Number</th>
                        <th> Opening Balance</th>
                        <th> Total Withdraw</th>
                        <th> Total Payment</th>
                        <th> Amount </th>
                    </tr>

                    <?php 
                    $total = $totalDedit = $totalCredit = 0.00;
                    foreach($resultset as $key => $row) { 
                    ?>
                    <tr>
                        <td> <?php echo ($key + 1); ?> </td>
                        <td> <?php echo $row['bank']; ?> </td>
                        <td> <?php echo $row['account']; ?> </td>
                        <td> <?php echo f_number($row['initial']); ?> </td>
                        <td> <?php echo f_number($row['debit']);$totalDedit += $row['debit']; ?> </td>
                        <td> <?php echo f_number($row['credit']);$totalCredit += $row['credit']; ?> </td>
                        <td> <?php $subtotal = ($row['credit'] - $row['debit']) + $row['initial'];$total += $subtotal;echo f_number($subtotal); ?> </td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <td><?php echo f_number($totalDedit); ?></td>
                        <td><?php echo f_number($totalCredit); ?></td>
                        <td><?php echo f_number($total); ?></td>
                    </tr>
                </table>
            </div>
            <?php } else { ?>

            <!-- after -->
            <div class="panel-body">
                <img class="img-responsive print-banner hide" src="<?php echo site_url("private/images/".$branch."_banner.jpg"); ?>" alt="photo not found..!">
                <h3 class="text-center hide" style="margin-top: -10px;">All Bank Transaction</h3>
                
                <?php if(!empty($resultset)) { ?>
                <table class="table table-bordered">
                    
                    <caption class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Account Number</th>
                                    <th>Opening Balance</th>
                                </tr>
                               <?php 
                                
                                    $where = array('bank_name' => $resultset[0]->bank,'account_number'=> $resultset[0]->account_number);
                                    $bank = $this->action->read('bank_account',$where);
                                    $init = $bank[0]->init_balance;

                                    $debit = $credit = $previous = 0.00;


                                    if($previous_transaction != null && $from_date != null){
                                        foreach ($previous_transaction as $key => $value) {
                                           if($value->transaction_date < $from_date){

                                                if($value->transaction_type == 'Debit'){
                                                    $debit += $value->amount;
                                                }elseif($value->transaction_type == 'bank_to_TT'){
                                                    $debit += $value->amount;
                                                }else{
                                                    $credit += $value->amount;
                                                }
                                           }
                                        }

                                        $previous = $credit + $init - $debit;
                                    }else{
                                        $previous = $init;
                                    }
                               
                               ?>
                                <tr>
                                    <td><?php echo filter($resultset[0]->bank); ?></td>
                                    <td><?php echo $resultset[0]->account_number; ?></td>
                                    <!-- <td><?php //echo f_number($init); ?></td> -->
                                    <td><?php echo f_number($previous); ?></td>
                                </tr>
                                
                            </table>
                        </div>
                    </caption>
                    
                    <tr>
                        <th> SL </th>
                        <th> Date </th>
                        <th> Transaction By </th>
                        <th> Debit </th>
                        <th> Credit </th>
                        <th> Balance </th>
                        <th> Showroom </th>
                    </tr>

    			    <?php
                        $accounts    = array();
                        $stepBalance = 0.0;
                        $totalDebit  = 0.0;
                        $totalCredit = 0.0;
                        foreach($resultset as $key => $transaction) {
                            $debit = '-';
                            $credit = '-';
                            if($transaction->transaction_type == 'Debit'){
                                $debit = $transaction->amount;
                            }elseif($transaction->transaction_type == 'bank_to_TT'){
                                $debit = $transaction->amount;
                            }else{
                                $credit = $transaction->amount;
                            }
                            
                            $stepBalance = $credit + $previous - $debit;
                            $previous = $stepBalance;
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?> </td>
                        <td><?php echo $transaction->transaction_date; ?> </td>
                        <td><?php echo $transaction->transaction_by; ?></td>
                        <td><?php echo $debit;$totalDebit += $debit; ?> </td>
                        <td><?php echo $credit;$totalCredit += $credit; ?> </td>
                        <td><?php echo $stepBalance; ?> </td>
                        <td><?php echo get_name('godowns', 'name', array('code' => $transaction->godown_code)) ?></td>
                        <!--<td class="none">
                        	<a class="btn btn-info" href="<?php echo site_url('bank/bankInfo/changeTransaction?id=' . $transaction->id); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            
                            <a class="btn btn-danger" href="?id=<?php echo $transaction->id; ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>-->
                    </tr>
                    <?php } ?>
                    <tr>
                        <th class="text-right" colspan="3">Total</th>
                        <th><?php echo f_number($totalDebit); ?></th>
                        <th><?php echo f_number($totalCredit); ?></th>
                        <th><?php echo f_number($stepBalance); ?></th>
                        <th>&nbsp;</th>
                    </tr>
                </table>
                <?php }else{ ?>
                <h1 class='text-center'>No records found</h1>
                <?php } ?>
            </div>
            <?php } ?>
            <div class="panel-footer">&nbsp;</div>
        </div>
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
</script>
