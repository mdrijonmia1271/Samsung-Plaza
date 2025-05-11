<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>

<script src="<?php echo site_url('private/js/ngscript/hireclientLedgerCtrl.js?') . time(); ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    @media print {

        aside,
        nav,
        .none,
        .panel-heading,
        .panel-footer {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }

        .print_banner_logo {
            width: 19%;
            float: left;
        }

        .print_banner_logo img {
            margin-top: 10px;
        }

        .print_banner_text {
            width: 80%;
            float: right;
            text-align: center;
        }

        .print_banner_text h2 {
            margin: 0;
            line-height: 38px;
            text-transform: uppercase !important;
        }

        .print_banner_text p {
            margin-bottom: 5px !important;
        }

        .print_banner_text p:last-child {
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
        }
    }

    .table tr th,
    .table tr td {
        font-size: 13px;
        padding: 4px !important;
    }

    .table tr td p {
        margin: 0;
        padding: 0;
    }
</style>
<div class="container-fluid" ng-controller="hireclientLedgerCtrl">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left"><?= !empty($c_type) ? filter($c_type) : 'Customer' ?> Ledger</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                $client_type = !empty($c_type) ? '?type=' . $c_type : '';
                $attr        = array('class' => 'form-horizontal');
                echo form_open('ledger/hireclientLedger' . $client_type, $attr);
                ?>

                <input type="hidden" ng-init="client_type='<?php echo $c_type; ?>'" ng-model="client_type"
                       ng-value="client_type">

                <div class="form-group">
                    <?php
                    if (checkAuth('super')) {
                        $allGodown = getAllGodown();
                        ?>
                        <div class="col-md-2">
                            <select name="godown_code" ng-model="godown_code" ng-change="getClientFn()"
                                    class="form-control">
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if (!empty($allGodown)) {
                                    foreach ($allGodown as $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo $row->code . '-' . filter($row->name) . '-' . $row->mobile; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="godown_code" ng-model="godown_code"
                               ng-init="godown_code = '<?php echo $this->data['branch']; ?>'" ng-value="godown_code"
                               required>
                    <?php } ?>

                    <div class="col-md-3">
                        <select ui-select2="{ allowClear: true }" class="form-control" name="search[party_code]"
                                ng-model="party_code"
                                data-placeholder="Select Client">
                            <option value="" selected disable></option>
                            <option ng-repeat="client in clientList" value="{{client.code}}">{{
                                client.code+"-"+client.name +"-"+ client.mobile }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        
        
        
        <?php
        if (!empty($defaultData) && empty($_POST['search']['party_code'])) {
            ?>
            <!--Get data before submit result start here-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title">
                        <h1 class="pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                
                <div class="panel-body">
                    <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                    <!-- Print banner End Here -->
                    <div class="col-md-12 text-center hide">
                        <?php

                        if (isset($_GET['type'])) {
                            $type = $_GET['type'];
                        } else {
                            $type = '';
                        }

                        if ($type == 'dealer') {
                            ?>
                            <h3 class="text-center">
                                Dealer Ledger
                            </h3>
                        <?php } elseif ($type == 'hire') { ?>
                            <h3 class="text-center">
                                Hire Ledger
                            </h3>
                        <?php } elseif ($type == 'weekly') { ?>
                            <h3 class="text-center">
                                Weekly Ledger
                            </h3>
                        <?php } else { ?>
                            <h3 class="text-center">
                               Hire Ledger
                            </h3>
                        <?php } ?>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Showroom</th>
                            <th>Client Name</th>
                            <th>Address</th>
                            <th>Opening Balance</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Remission</th>
                            <th>Adjustment</th>
                            <th>Balance</th>
                        </tr>
                        <?php
                        $totalDebit = $totalCredit = $totalAdjustment = $totalRemission = $totalAmount = 0;
                        foreach ($defaultData as $key => $row) {
                            $totalDebit      += $row->debit;
                            $totalCredit     += $row->credit;
                            $totalAdjustment += $row->adjustment;
                            $totalRemission  += $row->remission;
                            $totalAmount     += $row->balance;
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $row->godown_name; ?></td>
                                <td><?php echo $row->code .' - '. $row->name; ?></td>
                                <td><?php echo $row->address; ?></td>
                                <td><?php echo f_number($row->initial_balance); ?></td>
                                <td><?php echo f_number($row->debit); ?></td>
                                <td><?php echo f_number($row->credit); ?></td>
                                <td><?php echo f_number($row->remission); ?></td>
                                <td><?php echo f_number($row->adjustment); ?></td>
                                <td><?php echo f_number($row->balance); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th><?php echo f_number($totalDebit); ?></th>
                            <th><?php echo f_number($totalCredit); ?></th>
                            <th><?php echo f_number($totalRemission); ?></th>
                            <th><?php echo f_number($totalAdjustment); ?></th>
                            <th><?php echo f_number($totalAmount); ?></th>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
            <!--Get data before submit result end here-->
        <?php } ?>
        
        
        <!--Get data after submit result Start here-->
        <?php if (!empty($resultset) && !empty(isset($_POST['search'])) && !empty($_POST['search']['party_code'])) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title">
                        <h1 class="pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- Print banner Start Here -->

                    <div class="col-xs-12 hide"
                         style="border: 1px solid #ddd; padding:15px !important; margin-bottom: 15px;">
                        <div class="print_banner_logo">
                            <img class="img-responsive" src="<?php echo site_url($logo_data['faveicon']); ?>" alt="">
                        </div>
                        <div class="print_banner_text">
                            <h2><?php echo strtoupper($header_info['site_name']); ?></h2>
                            <p><?php echo $header_info['place_name']; ?></p>
                            <p><?php echo $footer_info['addr_moblile']; ?>
                                || <?php echo $footer_info['addr_email']; ?></p>
                        </div>
                    </div>

                    <!-- Print banner End Here -->

                    <?php
                    if (isset($_GET['type'])) {
                        $type = $_GET['type'];
                    } else {
                        $type = '';
                    }
                    if ($type == 'dealer') {
                        $title = 'Dealer Ledger';
                    } elseif ($type == 'hire') {
                        $title = 'Hire Ledger';
                    } elseif ($type == 'weekly') {
                        $title = 'Weekly Ledger';
                    } else {
                        $title = 'All Customer Ledger';
                    } ?>

                    <h3 class="text-center hide"> <?php echo 'Hire Customer Ledger'; ?> </h3>


                    <div class="row">
                        <div class="col-xs-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%">Client ID :</th>
                                    <td><?php echo $partyInfo->code; ?></td>
                                </tr>
                                <tr>
                                    <th>Client :</th>
                                    <td><?php echo filter($partyInfo->name); ?></td>
                                </tr>
                                <tr>
                                    <th> Father's Name :</th>
                                    <td>
                                        <?php
                                        $father_name = get_name('parties','father_name', ['code' => $partyInfo->code]);
                                        echo $father_name;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th> Address :</th>
                                    <td> <?php echo $partyInfo->address; ?> </td>
                                </tr>
                                <tr>
                                    <th> Mobile :</th>
                                    <td> <?php echo $partyInfo->mobile; ?> </td>
                                </tr>

                                <tr>
                                    <th> Showroom :</th>
                                    <td>
                                        <?php
                                        $showroom = get_row('godowns', ['code' => $partyInfo->godown_code]);
                                        echo(isset($showroom->name) ? $showroom->name : 'N/A');
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-offset-2 col-xs-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Date :</th>
                                    <td>
                                        <?php
                                        if ($fromDate != NULL || $toDate != NULL) {
                                            echo $fromDate . ' To ' . $toDate;
                                        } else {
                                            echo date('Y-m-d');
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="40%">Opening Balance :</th>
                                    <td>
                                        <strong>
                                            <?php
                                            $opening_status = ($partyInfo->initial_balance < 0) ? " - " : " ";
                                            echo $opening_status . f_number(abs($partyInfo->initial_balance));
                                            $opening_balance = $partyInfo->initial_balance;
                                            ?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Current Balance :</th>
                                    <td>
                                        <strong>
                                            <?php
                                            // Calculate Balance from partytrasaction table.
                                            // Final balance = total_debit - total_credit + initial_balance.
                                            // Final Balance (+ve) = Receivable and (-ve) = Payable
                                            $where          = array(
                                                'party_code' => $partyInfo->code,
                                                'trash'      => 0
                                            );
                                            $transactionRec = get_result('partytransaction', $where, ['transaction_at', 'credit', 'debit', 'comission', 'remission', 'remark', 'relation']);
                                            $total_credit   = $total_debit = $comission = $remission = 0.0;
                                            if ($transactionRec != null) {
                                                foreach ($transactionRec as $key => $row) {
                                                    $total_credit += $row->credit;
                                                    $total_debit  += $row->debit;
                                                    $comission    += $row->comission;
                                                    $remission    += $row->remission;
                                                }
                                                $balance = $total_debit - $total_credit + $partyInfo->initial_balance + $comission - $remission;
                                            } else {
                                                $balance = $partyInfo->initial_balance;
                                            }
                                            //$status = ($balance < 0) ? " Payable" : " Receivable";                     
                                            $status = ($balance < 0) ? " - " : " ";
                                            echo $status . f_number(abs($balance));

                                            // calculate previous balance before from date
                                            $total_credit = $total_debit = 0.0;
                                            if ($transactionRec != null && $fromDate != NULL) {
                                                foreach ($transactionRec as $key => $row) {
                                                    if ($row->transaction_at < $fromDate) {
                                                        $total_credit += $row->credit;
                                                        $total_debit  += $row->debit;
                                                    }
                                                }
                                                $opening_balance = $total_debit - $total_credit + $partyInfo->initial_balance;
                                            }

                                            ?>
                                        </strong>
                                    </td>
                                </tr>
                                <!-- <tr>
                                <th>Discount :</th>
                                <td>
                                    <strong>
                                        <?php /*
                                        $total_discount = 0.00;
                                        foreach ($transactionRec as $key => $value) {
                                            if($value->remark == 'sale'){
                                                $relationList   = explode(':', $value->relation);
                                                $where          = array('voucher_no' => $relationList[1],'trash' => 0);
                                                $purchase       = $this->action->read('saprecords', $where);
                                                if($purchase){
                                                    $total_discount += $purchase[0]->total_discount;
                                                }
                                            }
                                        }
                                        echo f_number($total_discount)." TK";
                                        */ ?>
                                    </strong>
                                </td>
                            </tr> -->
                            </table>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30px;">SL</th>
                            <th>Date</th>
                            <!--<th>Particular</th>-->
                            <th>Details</th>
                            <th>Paid By</th>
                            <th>Voucher No</th>
                            <th>Product</th>
                            <th>Debit</th>
                            <th>Credit</th>
                           
                            <th>Remission</th>
                            <th>Adjustment</th>
                            <th>Balance</th>
                            <!--<th class="none" style="width:40px;">Action</th>-->
                        </tr>
                        <!-- previous balance row start here -->
                        <?php
                        $staus = ($resultset[0]->previous_balance > 0) ? "Receivable" : "Payable";
                        ?>
                        <tr>
                            <td>1</td>
                            <td colspan="8">Previous Balance</td>
                            <td>
                                <?php echo $opening_status . number_format(abs($opening_balance), 2); ?>
                            </td>
                        </tr>
                        <!-- previous balance row end here -->
                        <?php
                        $totalDebit = $totalCredit = $totalRemission = $totalAdjustment = $total = $stepBalance = $grandtotalQuant = $commission = $totalCommission = 0.00;
                        $stepBalance += $opening_balance;
                        foreach ($resultset as $key => $row) {
                        
                            $totalDebit += $row->debit;
                            $totalCredit += $row->credit;
                            $totalRemission += $row->remission;
                            $totalAdjustment += $row->adjustment;
                            
                            $stepBalance += $row->debit - ($row->credit + $row->remission) + $row->adjustment;
                            
                            $voucher = ($row->remark == 'sale' || $row->remark == 'saleReturn') ? explode(':', $row->relation)[1] : (!empty($row->inc_code) ? $row->inc_code : 'N/A');
                            ?>
                            <tr>
                                <td><?php echo($key + 2); ?></td>
                                <td><?php echo $row->transaction_at; ?></td>
                                <td><strong><?php echo filter($row->remark); ?></strong></td>
                                <td><?php echo ($row->remark == "transaction" ? filter($row->comment) : get_name('saprecords', 'comment', ['voucher_no' => $voucher])); ?></td>
                                <td><?php echo isset($voucher) ? $voucher : ''; ?></td>
                                <td>
                                    <?php 
                                        if(!empty($voucher)){
                                            $product_info = get_result('sapitems', ['voucher_no' => $voucher]); 
                                            if(!empty($product_info)){
                                                $l=1;
                                                foreach($product_info as $val){
                                                    echo $val->product_model; 
                                                    echo ',';
                                                    if($l%3==0){
                                                        echo '<br>';
                                                    }
                                                    $l++;
                                                }
                                            }
                                        }    
                                        ?>
                            
                                </td>
                                <td><?php echo f_number($row->debit, 2); ?></td>
                                <td><?php echo f_number($row->credit, 2); ?></td>
                                <td><?php echo f_number($row->remission, 2); ?></td>
                                <td><?php echo f_number($row->adjustment, 2); ?></td>
                                <td><?php echo f_number($stepBalance, 2); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="6" class="text-right">Total</th>
                            <th><?php echo f_number($totalDebit); ?></th>
                            <th><?php echo f_number($totalCredit); ?></th>
                            <th><?php echo f_number($totalRemission); ?></th>
                            <th><?php echo f_number($totalAdjustment); ?></th>
                            <th><?php echo f_number($stepBalance); ?></th>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
        <!--Get data after submit result End here-->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>