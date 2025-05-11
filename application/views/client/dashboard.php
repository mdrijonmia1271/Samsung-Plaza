<style>
    @media print {
        .navbar, .card-header {display: none !important;}
    }
    @page {margin: 15px;}
</style>

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between">
        <h5 class="m-0 pt-1 pb-1 fw-bold">Client Ledger</h5>
        <a class="btn btn-primary" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
    </div>
    <div class="card-body">
        <!-- Print banner Start Here -->
        <?php $this->load->view('client/print', $this->data); ?>
        
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Client ID :</th>
                        <td><?php echo $partyInfo->code; ?></td>
                    </tr>
                    <tr>
                        <th>Client :</th>
                        <td><?php echo $partyInfo->name; ?></td>
                    </tr>
                    <tr>
                        <th> Address :</th>
                        <td> <?php echo $partyInfo->address; ?> </td>
                    </tr>
                    <tr>
                        <th> Mobile :</th>
                        <td> <?php echo $partyInfo->mobile; ?> </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th> Showroom :</th>
                        <td>
                            <?php
                            $showroom = get_name('godowns', 'name', ['code' => $partyInfo->godown_code]);
                            echo($showroom ? $showroom : 'N/A');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Date :</th>
                        <td>
                            <?php
                            if (!empty($dateFrom) && !empty($dateTo)) {
                                echo $dateFrom . ' To ' . $dateTo;
                            } else {
                                echo date('Y-m-d');
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th width="40%">Opening Balance :</th>
                        <th><?php echo number_format($partyInfo->initial_balance, 2); ?></th>
                    </tr>
                    <tr>
                        <th>Current Balance :</th>
                        <th><?php echo number_format($balanceInfo['balance'], 2); ?></th>
                    </tr>
                </table>
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
                <th style="width: 30px;">SL</th>
                <th>Date</th>
                <th>Details</th>
                <th>Paid By</th>
                <th>Voucher No</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Balance</th>
            </tr>

            <tr>
                <td>1</td>
                <td colspan="6">Previous Balance</td>
                <td><?php echo number_format($partyInfo->initial_balance, 2); ?></td>
            </tr>
            <!-- previous balance row end here -->
            <?php
            $totalDebit  = $totalCredit = $total = $stepBalance = $commission = $totalCommission = 0.00;
            $stepBalance += $partyInfo->initial_balance;
            foreach ($results as $key => $row) {

                $totalDebit  += $row->debit;
                $totalCredit += ($row->credit + $row->remission);

                $stepBalance += $row->debit - ($row->credit + $row->remission);

                $voucher = ($row->remark == 'sale' || $row->remark == 'saleReturn') ? explode(':', $row->relation)[1] : (!empty($row->inc_code) ? $row->inc_code : 'N/A');
                ?>
                <tr>
                    <td><?php echo($key + 2); ?></td>
                    <td><?php echo $row->transaction_at; ?></td>
                    <td><strong><?php echo $row->remark; ?></strong></td>
                    <td><?php echo($row->remark == "transaction" ? $row->comment : get_name('saprecords', 'comment', ['voucher_no' => $voucher])); ?></td>
                    <td><?php echo $vno = isset($voucher) ? $voucher : ''; ?></td>
                    <td><?php echo number_format($row->debit, 2); ?></td>
                    </td>
                    <td>
                        <?php
                        $credit = $row->credit + $row->remission;
                        echo number_format($credit, 2);
                        ?>
                        <?php if ($row->remission > 0) { ?>
                            <small style="color:red; font-weight: 800;">
                                Remission: <?php echo number_format($row->remission); ?>
                            </small>
                        <?php } ?>
                    </td>
                    <td><?php echo $stepBalance; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="5" class="text-right">Total</th>
                <th><?php echo number_format($totalDebit, 2); ?></th>
                <th><?php echo number_format($totalCredit, 2); ?></th>
                <th><?php echo number_format($stepBalance, 2); ?></th>
            </tr>
        </table>
    </div>
</div>