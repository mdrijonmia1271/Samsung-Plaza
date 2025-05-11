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

        <?php if($resultset != NULL){ ?>
         <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Transactions</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                 <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                <h3 class="text-center hide" style="margin-top: -10px;">All Bank Transaction</h3>

                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th> Bank Name </th>
                        <th> Account Number</th>
                        <th> Initial Balance</th>
                        <th> Total Withdraw</th>
                        <th> Total Deposit</th>
                        <th> Balance </th>
                    </tr>

                    <?php 
                    $total = $totalDedit = $totalCredit = 0.00;
                    foreach($resultset as $key => $row) { 
                    ?>
                    <tr>
                        <td> <?php echo ($key + 1); ?> </td>
                        <td> <?php echo filter($row['bank']); ?> </td>
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
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
