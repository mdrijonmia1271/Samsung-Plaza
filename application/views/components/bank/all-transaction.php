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
        
        <!--<div class="panel panel-default">-->
        <!--    <div class="panel-heading panal-header">-->
        <!--        <div class="panal-header-title">-->
        <!--            <h1 class="pull-left">Filter</h1>-->
        <!--        </div>-->
        <!--    </div>-->

        <!--    <div class="panel-body"></div>-->
        <!--    <div class="panel-footer">&nbsp;</div>-->
        <!--</div>-->

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Transaction</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <?= $this->session->flashdata('confirmation') ?>

            <!-- before -->
            <div class="panel-body">
                <img class="img-responsive print-banner hide" src="<?php echo site_url("private/images/" . $branch . "_banner.jpg"); ?>" alt="photo not found..!">
                <h3 class="text-center hide" style="margin-top: -10px;">All Bank Transaction</h3>

                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th width="10%"> Date </th>
                        <th> Bank Name </th>
                        <th> Account Number </th>
                        <th> Debit </th>
                        <th> Credit </th>
                        <th> Transaction By </th>
                        <th> Action </th>
                    </tr>
                    <?php 
                    $debit = 0;
                    $credit = 0;
                    foreach($transactions as $key=>$transaction){
                    ?>
                    <tr>
                        <td> <?php echo $key+1; ?> </td>
                        <td> <?php echo $transaction->transaction_date; ?> </td>
                        <td> <?php echo $transaction->bank; ?> </td>
                        <td> <?php echo $transaction->account_number; ?> </td>
                        <td><?php 
                            if($transaction->transaction_type == "Debit"){ 
                                echo $transaction->amount;
                                $debit += $transaction->amount;
                            }  ?> 
                        </td>
                        <td><?php 
                            if($transaction->transaction_type == "Credit"){ 
                                echo $transaction->amount;
                                $credit += $transaction->amount;
                            }  ?> 
                        </td>
                        <td> <?php echo $transaction->transaction_by; ?> </td>
                        <td> <a href="<?= site_url("bank/bankInfo/delete_tran/$transaction->id") ?>" class="btn btn-danger" onclick="return confirm('Are your sure delete this data ?')"> <span><i class="fa fa-trash"></i></span></a> </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" style="text-align: right;">Total </td>
                        <td><?php echo $debit;?>TK</td>
                        <td><?php echo $credit;?>TK</td>
                        <td colspan="2"></td>
                    </tr>
                </table>
            </div>

    </div>
</div>
