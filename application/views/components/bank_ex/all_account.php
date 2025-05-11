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
	<?php echo $confirmation; ?>

    <?php if($all_account != NULL) { ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Account</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>

                </div>
            </div>

            <div class="panel-body">
                 <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                <h3 class="text-center hide" style="margin-top: -10px;">All Account</h3>

                <table class="table table-bordered">
                    <tr>
                        <th> Sl</th>
                        <th> Date </th>
                        <th> Bank Name </th>
                        <th> Holder Name </th>
                        <th> Account Number</th>
                        <th> Initial Balance</th>
                        <th> Current Balance</th>
                       <!--<th class="none"> Action </th> -->
                    </tr>
                    <?php
                    $totall = 0.00;
                    foreach($all_account as $key=>$account){

                        $where = array(
                        "bank"              =>  $account->bank_name,
                        "account_number"    =>  $account->account_number
                        );

                        $transaction = $this->retrieve->read("transaction",$where);

                        //echo "<pre>"; print_r($transaction); echo "</pre>";

                        $credits = $debits = $balance = 0;

                        foreach ($transaction as $val) {
                        if ($val->transaction_type=="Credit" || $val->transaction_type=="CTB") {
                            $credits += $val->amount;
                        }else{
                            $debits += $val->amount;
                        }
                      }
                     $balance = $credits - $debits;
                    ?>
                    <tr>
                        <td> <?php echo $key+1; ?> </td>
                        <td> <?php echo $account->datetime; ?> </td>
                        <td> <?php echo ucfirst(str_replace("_"," ",$account->bank_name)); ?>  </td>
                        <td> <?php echo $account->holder_name; ?></td>
                        <td> <?php echo $account->account_number; ?> </td>
                        <td> <?php echo f_number($account->init_balance); ?> </td>
                        <td> <?php echo f_number($account->pre_balance + $balance);$totall += ($account->pre_balance + $balance);  ?></td>
                    </tr>
                   <?php } ?>
                   <tr>
                       <th colspan="6" class="text-right">Total</th>
                       <th><?php echo f_number($totall);?></th>
                   </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
