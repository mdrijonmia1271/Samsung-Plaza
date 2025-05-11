<script src="<?php echo site_url('private/js/ngscript/AllBankTransactionCtrl.js'); ?>"></script>
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

<div class="container-fluid" ng-controller="AllBankTransactionCtrl">
    <div class="row">
        <?php
        $total = 0;
        echo $confirmation;
        ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Transaction</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php 
                $attr = array ('class' => 'form-horizontal');
                echo form_open('', $attr); 
                ?>
                <div class="form-group row">
                    <label class="col-md-2 control-label">Bank </label>
                    <div class="col-md-5">
                        <select name="search[bank]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" ng-model="bank" ng-change="getAccountFn()">
                            <option value="" selected disabled>&nbsp;</option>
                            <?php foreach ($allBank as $key => $row) { ?>
                            <option value="<?php echo $row->bank_name; ?>">
                            <?php echo filter($row->bank_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label">Account NO </label>
                    <div class="col-md-5">
                        <select name="search[account_number]" ng-model="account" class="form-control">
                            <option value="" selected disabled>&nbsp;</option>
                            <option ng-repeat="accountNo in allAccount" ng-value="accountNo.account_number">{{ accountNo.account_number }}</option>
                        </select>
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
                <img class="img-responsive print-banner hide" src="<?php echo site_url("private/images/" . $branch . "_banner.jpg"); ?>" alt="photo not found..!">
                <h3 class="text-center hide" style="margin-top: -10px;">All Bank Transaction</h3>

                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th> Bank Name </th>
                        <th> Account Number</th>
                        <th> Initial Balance</th>
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
                
                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th> Date </th>
                        <th> Transaction By </th>
                        <th> Bank Name </th>
                        <th> Account Number</th>
                        <th> Transaction Type </th>
                        <th> Amount </th>
                        <th class="none"> Action </th>
                    </tr>

    			    <?php
                    $accounts = array();
                    foreach($resultset as $key => $transaction) { 
                    ?>
                    <tr>
                        <td> <?php echo $key+1; ?> </td>
                        <td> <?php echo $transaction->transaction_date; ?> </td>
                        <td> <?php echo $transaction->transaction_by; ?></td>
                        <td> <?php echo filter($transaction->bank); ?> </td>
                        <td> <?php echo $accounts[] = $transaction->account_number; ?> </td>
                        <td> <?php echo $transaction->transaction_type; ?> </td>

                        <td>
                        <?php
                        $total += $transaction->amount;
                        echo $transaction->amount;
                        ?>
                        </td>

                        <td class="none">
                        	<a  title="Edit/Change" class="btn btn-warning" href="<?php echo site_url('bank/bankInfo/changeTransaction?id=' . $transaction->id); ?>">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                            </a>
                            
                            <a class="btn btn-danger" href="?id=<?php echo $transaction->id; ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th class="text-right" colspan="6">Total</th>
                        <th><?php echo f_number($total); ?></th>
                        <th>&nbsp;</th>
                    </tr>

                    <caption class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Account Number</th>
                                    <th>Initial Balance</th>
                                </tr>
                                <?php 
                                foreach (array_unique($accounts) as $value) {
                                    $acc_info = $this->action->read("bank_account", array("account_number" => $value));
                                ?>
                                <tr>
                                    <td><?php echo filter($acc_info[0]->bank_name); ?></td>
                                    <td><?php echo $value; ?></td>
                                    <td><?php echo f_number( $acc_info[0]->init_balance); ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </caption>
                </table>
            </div>
            <?php } ?>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
