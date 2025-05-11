<?php if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true); ?>
<style>
    @media print {
        .table tr td, .table tr th {
            padding: 2px 3px !important;
        }

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

        .block-hide {
            display: none;
        }

        .balance h4 {
            margin: 0;
            line-height: 25px;
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

    .p-0 {
        padding: 0 !important;
    }

    .table {
        margin-bottom: 10px;
    }

    h4 {
        margin: 0;
    }

    .balance {
        background: rgb(245, 245, 245);
    }

    .balance h4 {
        line-height: 48px;
        font-weight: bold;
    }

    .red {
        color: red;
        font-weight: bold;
        background-color: #FFE4E3;
    }

    .green {
        color: green;
        font-weight: bold;
        background-color: #CCE3DF;
    }

    .s_red {
        background-color: #FE3939;
        font-weight: bold;
        color: #fff;
        padding: 10px;
    }

    .s_red:hover {
        color: #fff;
    }

    .s_green {
        background-color: #449D44;
        font-weight: bold;
        color: #fff;
        padding: 10px;
    }

    .s_green:hover {
        color: #fff;
    }
</style>

<?php echo $this->session->flashdata('confirmation'); ?>

<div class="panel panel-default none">
    <div class="panel-heading">
        <div class="panal-header-title pull-left">
            <h1>Search Cash Book </h1>
        </div>
    </div>

    <div class="panel-body">

        <!-- horizontal form -->
        <?php $attribute = array('name' => '', 'class' => 'form-horizontal', 'id' => '');
        echo form_open('', $attribute); ?>
        <?php
        if ($this->data['privilege'] == 'super') {
            $godown = 'yes';
            $column = '2';
        } else {
            $godown = 'no';
            $column = '3';
        }
        $allGodowns = $this->action->read("godowns");
        ?>
        <div class="form-group">

            <?php if ($godown == 'yes') { ?>
                <div class="col-md-3">
                    <select name="godown_code" class="form-control">
                        <option value="" selected disabled>-- Select Showroom --</option>
                        <option value="all">All Showroom</option>
                        <?php if (!empty($allGodowns)) {
                            foreach ($allGodowns as $row) { ?>
                                <option value="<?php echo $row->code; ?>" <?= !empty($_POST['godown_code']) && $_POST['godown_code'] == $row->code ? 'selected' : $this->data['branch'] == $row->code ? 'selected' : '' ?>>
                                    <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                </option>
                            <?php }
                        } ?>
                    </select>
                </div>
            <?php } else { ?>
                <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>">
            <?php } ?>

            <div class="col-md-4">
                <div class="input-group date" id="datetimepickerFrom">
                    <input type="text" name="date[from]"
                           value="<?= !empty($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d') ?>"
                           placeholder="From ( YYYY-MM-DD )" class="form-control" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group date" id="datetimepickerTo">
                    <input type="text" name="date[to]"
                           value="<?= !empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d') ?>"
                           placeholder="To ( YYYY-MM-DD )" class="form-control" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="btn-group">
                <input class="btn btn-primary" type="submit" name="show" value="Show">
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
</div>


<div class="panel panel-default">
    <div class="panel-heading ">
        <div class="panal-header-title">
            <h1 class="pull-left">Cash Book
                <span style="margin-left:100px;color: #25960a; font-size:20px;">
                    <?php echo(isset($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d')); ?>
                </span>
                &nbsp; To
                <span style="color: #25960a; font-size:20px;">
                    <?php echo(isset($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d')); ?>
                </span>
            </h1>
            <a href="#" class="pull-right " style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i
                        class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="panel-body">
        <div class="hide">
            <!-- Print banner Start Here -->
            <?php $this->load->view('print', $this->data); ?>
            <!-- Print banner End Here -->
            <h3 class="text-center">Cash Book
                <small>
                    From : <?php echo(isset($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d')); ?> &nbsp;&nbsp;
                    To : <?php echo(isset($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d')); ?>
                </small>
            </h3>
        </div>

        <?php
        $total_sale = $sale_return_total_paid = $client_payment = $due_Collection = $other_income = $bank_income = $loan_received = $loan_trx_received
            = $total_purchase = $totalSaleReturn = $supplier_payment = $totalCash = $total_cost = $bank_cost = $loan_paid = $loan_trx_paid = 0.00;
        ?>
        <div class="row">

            <!--####################### INCOME START ########################-->

            <!-- [`saleIncome` => Report : (Module-1)] -->
            <?php /*if ($saleIncome != NULL) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Sales Collection</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Voucher</th>
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($saleIncome as $key => $value) {

                            if ($value->sap_type == 'credit') {
                                $type = 'Hire';
                            } elseif ($value->sap_type == 'dealer') {
                                $type = 'Dealer';
                            } elseif ($value->sap_type == 'cash') {
                                $type = 'Retail';
                            } else {
                                $type = $value->sap_type;
                            }
                            $party_name = get_row('parties', ['code' => $value->party_code], ['name']);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->sap_at; ?></td>
                                <td><?php echo $value->voucher_no . " ( " . $type . " ) "; ?></td>
                                <td><?php echo(isset($party_name->name) ? $party_name->name : ($value->party_code ? filter($value->party_code) : 'N/A')) ?></td>
                                <td>
                                    <?php
                                    $total_sale += $value->paid;
                                    echo $value->paid;
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th> <?php echo f_number($total_sale, 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php }*/ ?>
            
            
            <?php if (!empty($creditSaleIncome)) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Hire Sales Collection</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Voucher</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $totalCreditSale = 0;
                        foreach ($creditSaleIncome as $key => $value) {
                            $party_name = get_row('parties', ['code' => $value->party_code], ['name']);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->sap_at; ?></td>
                                <td><?php echo $value->voucher_no . " ( Hire ) "; ?></td>
                                <td><?php echo $value->party_code; ?></td>
                                <td><?php echo $party_name->name; ?></td>
                                <td>
                                    <?php
                                    $total_sale += $value->paid;
                                    $totalCreditSale += $value->paid;
                                    echo $value->paid;
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th> <?php echo f_number($totalCreditSale, 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            
            
            <?php if (!empty($dealerSaleIncome)) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Dealer Sales Collection</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Voucher</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $totalDealerSale = 0;
                        foreach ($dealerSaleIncome as $key => $value) {
                            $party_name = get_row('parties', ['code' => $value->party_code], ['name']);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->sap_at; ?></td>
                                <td><?php echo $value->voucher_no . " ( Dealer ) "; ?></td>
                                <td><?php echo $value->party_code; ?></td>
                                <td><?php echo $party_name->name; ?></td>
                                <td>
                                    <?php
                                    $total_sale += $value->paid;
                                    $totalDealerSale += $value->paid;
                                    echo $value->paid;
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th> <?php echo f_number($totalDealerSale, 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            
            
            <?php if (!empty($cashSaleIncome)) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Retail Sales Collection</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Voucher</th>
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $totalCashSale = 0;
                        foreach ($cashSaleIncome as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->sap_at; ?></td>
                                <td><?php echo $value->voucher_no . " ( Retail ) "; ?></td>
                                <td><?php echo check_null(filter($value->party_code)); ?></td>
                                <td>
                                    <?php
                                    $total_sale += $value->paid;
                                    $totalCashSale += $value->paid;
                                    echo $value->paid;
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th> <?php echo f_number($totalCashSale, 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            
            
             <?php if (!empty($dealerPayment)) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Dealer Collection</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $totalDealerPayment = 0;
                        foreach ($dealerPayment as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->transaction_at; ?></td>
                                <td><?php echo ($value->inc_code != null) ? $value->inc_code : $value->lpr_code; ?></td>
                                <td><?php echo $value->party_code; ?></td>
                                <td><?php echo $value->name; ?></td>
                                <td><?php 
                                    echo $value->credit;
                                    $client_payment += $value->credit;
                                    $totalDealerPayment += $value->credit;
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th> <?php echo f_number(($totalDealerPayment), 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`clientPayment` => Report : (Module-2)] -->
            <?php if (!empty($clientPayment)) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Installment Collection</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $totalClientPayment = 0;
                        foreach ($clientPayment as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->transaction_at; ?></td>
                                <td><?php echo ($value->inc_code != null) ? $value->inc_code : $value->lpr_code; ?></td>
                                <td><?php echo $value->party_code; ?></td>
                                <td><?php echo $value->name; ?></td>
                                <td><?php 
                                    echo $value->credit;
                                    $client_payment += $value->credit; 
                                    $totalClientPayment += $value->credit; 
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th> <?php echo f_number(($totalClientPayment), 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            
             <!-- [`mdTransactionReceived` => Report : (Module-8)] -->
            <?php 
                $md_transaction_received = 0;
                if ($mdTransactionReceived != null) { 
            ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 style="font-weight: 700; color: #00A8FF;">MD Transaction Received</h4>
                    </caption>
                    
                    <tr>
                        <th width="50">SL</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                        foreach ($mdTransactionReceived as $key => $value){
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo filter($value->name); ?></td>
                        <td><?php echo $value->amount; $md_transaction_received += $value->amount ; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><?php echo f_number($md_transaction_received, 2); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>

            <!-- [`dueCollection` => Report : (Module-3)] -->
            <?php if (!empty($dueCollection)) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Due Collection</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Voucher</th>
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($dueCollection as $key => $value) {
                            $field_amount = 0.00;
                            $where        = array(
                                "voucher_no" => $value->voucher_no,
                                "date >="    => (!empty($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d')),
                                "date <="    => (!empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d')),
                            );
                            $due_amount   = $this->action->read_sum('due_collect', 'paid', $where);

                            if ($due_amount[0]->paid > 0) {
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $value->date; ?></td>
                                    <td><?php echo($value->voucher_no); ?></td>
                                    <td><?php echo filter($value->party_code); ?></td>
                                    <td><?php echo $due_amount[0]->paid;
                                        $due_Collection += $due_amount[0]->paid; ?></td>
                                </tr>

                            <?php }
                        } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th><?php echo f_number($due_Collection, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`otherIncome` => Report : (Module-4)] -->
            <?php if ($otherIncome != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">General Income</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Field</th>
                            <th>Collection By</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($otherIncome as $key => $value) {
                            $field_amount = 0.00;
                            $where        = array(
                                'field'    => $value->field,
                                'trash'    => 0,
                                'date >= ' => isset($_POST['date']) ? $_POST['date']['from'] : date('Y-m-d'),
                                'date <= ' => isset($_POST['date']) ? $_POST['date']['to'] : date('Y-m-d')
                            );

                            if (!empty($_POST['godown_code'])) {
                                if ($_POST['godown_code'] != 'all') {
                                    $where['godown_code'] = $_POST['godown_code'];
                                }
                            } else {
                                $where['godown_code'] = $this->data['branch'];
                            }

                            $field_amount = $this->action->read_sum('income', 'amount', $where);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo filter($value->field); ?></td>
                                <td><?php echo filter($value->income_by); ?></td>
                                <td><?php echo $field_amount[0]->amount;
                                    $other_income += $field_amount[0]->amount; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th><?php echo f_number($other_income, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`bankIncome` => Report : (Module-5)] -->
            <?php if (!empty($bankIncome)) {
                ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Bank Withdraw</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Bank</th>
                            <th>Account No.</th>
                            <th>Paid By</th>
                            <th>Amount</th>
                        </tr>
                        <?php foreach ($bankIncome as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->transaction_date; ?></td>
                                <td><?php echo filter($value->bank); ?></td>
                                <td><?php echo $value->account_number; ?></td>
                                <td><?php echo filter($value->transaction_by); ?></td>
                                <td><?php echo $value->amount;
                                    $bank_income += $value->amount ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th><?php echo f_number($bank_income); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`loanReceived` => Report : (Module-6)] -->
            <?php if ($loanReceived != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Loan Received</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php foreach ($loanReceived as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo $value->name; ?></td>
                                <td><?php echo $value->balance;
                                    $loan_received += $value->balance; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th><?php echo f_number($loan_received, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`loanTrxReceived` => Report : (Module-7)] -->
            <?php if ($loanTrxReceived != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Loan Trx Received</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($loanTrxReceived as $key => $value) {
                            $info = $this->action->read('loan_new', array('person_code' => $value->person_code));
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo ($info) ? filter($info[0]->name) : ''; ?></td>
                                <td><?php echo $value->amount;
                                    $loan_trx_received += $value->amount; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th><?php echo f_number($loan_trx_received, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>

            <!--######################### INCOME END ########################-->


            <!--######################### COST START ########################-->

            <!-- [`purchase` => Report : (Module-1)] -->
            <?php if ($purchase != NULL) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Supplier Payment</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Voucher</th>
                            <th>Supplier Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($purchase as $key => $value) {
                            //read supplier name
                            $where     = array('code' => $value->party_code);
                            $partyInfo = $this->action->read('parties', $where);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->sap_at; ?></td>
                                <td><?php echo $value->voucher_no; ?></td>
                                <td><?php echo ($partyInfo) ? filter($partyInfo[0]->name) : filter($value->party_code); ?></td>
                                <td><?php echo $value->paid;
                                    $total_purchase += $value->paid; ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th> <?php echo f_number($total_purchase, 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`SaleReturnInfo` => Report : (Module-2)] -->
            <?php if ($SaleReturnInfo) { ?>
                <div class="col-xs-12">
                    <caption>
                        <h4 style="font-weight: 700; color: #00A8FF;">All Sale Return</h4>
                    </caption>

                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Client's Name</th>
                            <th>Voucher No</th>
                            <th>QTY</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $totalSaleReturn = 0.0;
                        $totalQty        = 0;
                        foreach ($SaleReturnInfo as $key => $row) {
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td><?php echo $row->date; ?></td>
                                <td>
                                    <?php
                                    $where      = array('trash' => 0, 'code' => $row->client_code);
                                    $party_info = get_result('parties', $where, ['name']);
                                    if ($party_info != null) {
                                        echo filter($party_info[0]->name);
                                    } else {
                                        echo "N/A";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row->voucher_no; ?> </td>
                                <td><?php echo number_format($row->totalQty);
                                    $totalQty += $row->totalQty; ?> </td>
                                <td>
                                    <?php
                                    $total           = $row->return_amount;
                                    $totalSaleReturn += $total;
                                    echo f_number($total);
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <th> <?php echo $totalQty; ?> </th>
                            <th><?php echo f_number($totalSaleReturn); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`supplierPayment` => Report : (Module-3)] -->
            <?php if ($supplierPayment != NULL) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Supplier Transaction</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <!--<th>Client ID</th>-->
                            <th>Client Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach (
                            $supplierPayment as $key => $value) {
                            // read client name from `parties` table
                            $where     = array('code' => $value->party_code);
                            $partyInfo = $this->action->read('parties', $where);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->transaction_at; ?></td>
                                <!--<td><?php // echo $value->party_code;
                                ?></td>-->
                                <td><?php echo ($partyInfo) ? filter($partyInfo[0]->name) . ' - ' . $value->party_code : ''; ?>
                                </td>
                                <td><?php echo $value->debit;
                                    $supplier_payment += $value->debit; ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th> <?php echo f_number($supplier_payment, 2); ?> TK</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`cashtoTT` => Report : (Module-4)] -->
            <?php if ($cashtoTT != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Cash to T.T.</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($cashtoTT as $key => $value) {
                            $where     = array('code' => $value->party_code);
                            $partyInfo = $this->action->read('parties', $where);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo ($partyInfo) ? filter($partyInfo[0]->name) : ''; ?></td>
                                <td><?php echo $value->debit;
                                    $totalCash += $value->debit; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th><?php echo f_number($totalCash, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`allCost` => Report : (Module-5)] -->
            <?php if ($allCost != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">General Cost</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Field</th>
                            <th>Spend By</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($allCost as $key => $value) {
                            $field_amount = 0.00;
                            $where        = array(
                                'cost_field' => $value->cost_field,
                                'trash'      => 0,
                                'date >= '   => isset($_POST['date']) ? $_POST['date']['from'] : date('Y-m-d'),
                                'date <= '   => isset($_POST['date']) ? $_POST['date']['to'] : date('Y-m-d')
                            );

                            if (!empty($_POST['godown_code'])) {
                                if ($_POST['godown_code'] != 'all') {
                                    $where['godown_code'] = $_POST['godown_code'];
                                }
                            } else {
                                $where['godown_code'] = $this->data['branch'];
                            }
                            $field_amount = $this->action->read_sum('cost', 'amount', $where);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo filter($value->cost_field); ?></td>
                                <td><?php echo filter($value->spend_by); ?></td>
                                <td><?php echo $field_amount[0]->amount;
                                    $total_cost += $field_amount[0]->amount; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th><?php echo f_number($total_cost); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`bankCost` => Report : (Module-6)] -->
            <?php if ($bankCost != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Bank Deposit</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Bank</th>
                            <th>Account No.</th>
                            <th>Paid By</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $bank_cost = 0.00;
                        foreach ($bankCost as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->transaction_date; ?></td>
                                <td><?php echo filter($value->bank); ?></td>
                                <td><?php echo $value->account_number; ?></td>
                                <td><?php echo filter($value->transaction_by); ?></td>
                                <td><?php echo $value->amount;
                                    $bank_cost += $value->amount; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th><?php echo f_number($bank_cost, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`loanPaid` => Report : (Module-7)] -->
            <?php if ($loanPaid != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Loan Paid</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php foreach ($loanPaid as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo $value->name; ?></td>
                                <td><?php echo $value->balance;
                                    $loan_paid += $value->balance; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th><?php echo f_number($loan_paid, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>


            <!-- [`loanTrxPaid` => Report : (Module-8)] -->
            <?php if ($loanTrxPaid != null) { ?>
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Loan Trx Paid</h4>
                        </caption>

                        <tr>
                            <th width="50">SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        foreach ($loanTrxPaid as $key => $value) {
                            $info = $this->action->read('loan_new', array('person_code' => $value->person_code));
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo ($info) ? filter($info[0]->name) : ''; ?></td>
                                <td><?php echo $value->amount;
                                    $loan_trx_paid += $value->amount; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th><?php echo f_number($loan_trx_paid, 2); ?></th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            
            <?php 
            $sale_return_total_paid = 0.00;
            if(!empty($sale_return)){ ?>
            <div class="col-md-12">
                <h4 class="text-center hide" style="margin-top: 0px;">All Sale</h4>
                    <table class="table table-bordered table2">
                        <tr>
                            <caption>
                                <h4 style="font-weight: 700; color: #00A8FF;">Sale Return</h4>
                            </caption>
                            <th>SL</th>
                            <th width="90">Date</th>
                            <th>Name</th>
                            <th>Voucher No</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                            
                            foreach ($sale_return as $key => $row) {
                           
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td>
                                    <?php
                                    if ($row->sap_type != "cash" && $row->sap_type != "special") {
                                        $where      = array('trash' => 0, 'code' => $row->party_code);
                                        $party_info = $this->action->read('parties', $where);
                                        if ($party_info != null) {
                                            echo filter($party_info[0]->name);
                                        } else {
                                            echo "N/A";
                                        }
                                    } else {
                                        echo filter($row->party_code);
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row->voucher_no; ?> </td>
                                <td>
                                    <?php
                                    if ($row->sap_type == 'cash') {
                                        $due_paid          = $due = 0.00;
                                        $where             = array('voucher_no' => $row->voucher_no);
                                        $due_paid_sum      = $this->action->read_sum('due_collect', 'paid', $where);
                                        $due_remission_sum = $this->action->read_sum('due_collect', 'remission', $where);

                                        $sale_return_total_paid += $row->paid + $due_paid_sum[0]->paid;
                                        echo f_number($row->paid + $due_paid_sum[0]->paid);
                                    } else {
                                        $sale_return_total_paid += $row->paid;
                                        echo f_number($row->paid);
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <th><?php echo f_number($sale_return_total_paid); ?> TK</th>
                        </tr>
                    </table>
            </div>
            <?php } ?>
            
            
            <?php 
            $totalAdvanceSalary = 0;
            if(!empty($advanceSalary)){ ?>
            <div class="col-md-12">
                    <table class="table table-bordered table2">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Advance Salary</h4>
                        </caption>
                        
                        <tr>
                            <th>SL</th>
                            <th width="90">Date</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                            foreach ($advanceSalary as $key => $row) {
                            $totalAdvanceSalary += $row->amount;
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->created; ?> </td>
                                <td> <?php echo $row->name; ?> </td>
                                <td> <?php echo $row->mobile; ?> </td>
                                <td> <?php echo $row->amount; ?> </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <th><?php echo f_number($totalAdvanceSalary); ?> TK</th>
                        </tr>
                    </table>
            </div>
            <?php } ?>
            
            
            <?php 
            $totalSalary = 0;
            if(!empty($salary)){ ?>
            <div class="col-md-12">
                    <table class="table table-bordered table2">
                        <caption>
                            <h4 style="font-weight: 700; color: #00A8FF;">Salary</h4>
                        </caption>
                        
                        <tr>
                            <th>SL</th>
                            <th width="90">Date</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                            foreach ($salary as $key => $row) {
                            $totalSalary += $row->amount;
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->created; ?> </td>
                                <td> <?php echo $row->name; ?> </td>
                                <td> <?php echo $row->mobile; ?> </td>
                                <td> <?php echo $row->amount; ?> </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <th><?php echo f_number($totalSalary); ?> TK</th>
                        </tr>
                    </table>
            </div>
            <?php } ?>
            
             <!-- [`mdTransactionPaid` => Report : (Module-9)] -->
            <?php 
                $md_transaction_paid = 0;
                if($mdTransactionPaid != null) {
            ?>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <caption>
                        <h4 style="font-weight: 700; color: #00A8FF;">MD Transaction Paid</h4>
                    </caption>
                    
                    <tr>
                        <th width="50">SL</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                    <?php 
                        foreach ($mdTransactionPaid as $key => $value){
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo filter($value->name); ?></td>
                        <td><?php echo $value->amount; $md_transaction_paid += $value->amount ; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><?php echo f_number($md_transaction_paid, 2); ?></th>
                    </tr>
                </table>
            </div>
            <?php } ?>

            <!--########################### COST END ########################-->


            <!--closing balance calculation-->
            <?php
            if (isset($_POST['date'])) {
                if (!empty($_POST['date']['from'])) {
                    $presentDate = $_POST['date']['from'];
                }
            } else {
                $presentDate = date('Y-m-d');
            }
            // read previous closing balance
            $previousDate                 = date('Y-m-d', strtotime("-1 day", strtotime($presentDate)));
            $opening_balance_cond['date'] = $previousDate;

            if (!empty($_POST['godown_code'])) {
                if ($_POST['godown_code'] !== 'all') {
                    $opening_balance_cond['godown_code'] = $_POST['godown_code'];
                } else {
                    $opening_balance_cond['godown_code'] = $this->data['branch'];
                }
            } else {
                $opening_balance_cond['godown_code'] = $this->data['branch'];
            }

            $closingInfo    = $this->action->read('opening_balance', $opening_balance_cond);
            $closing_amount = ($closingInfo) ? $closingInfo[0]->closing_balance : 0;
            ?>


            <!-- Calculate Balance -->
            <?php
            $balance = $totalIncome = $totalCost = 0.00;

            $totalIncome = $total_sale + $client_payment + $due_Collection + $other_income + $bank_income + $loan_received + $loan_trx_received + $md_transaction_received;

            $totalCost = $totalSalary + $totalAdvanceSalary + $sale_return_total_paid + $total_purchase + $totalSaleReturn + $supplier_payment + $totalCash + $total_cost + $bank_cost + $loan_paid + $loan_trx_paid +$md_transaction_paid;

            $balance        = ($totalIncome - $totalCost) + $closing_amount;
            $balance_status = ($balance < 0) ? "red" : "green";
            ?>

            <div>
                <div class="col-xs-12" style="height: 53px;">
                    <div class="col-xs-6 p-0">
                        <div class="s_green">Total Income :<?php echo f_number($totalIncome, 2); ?> TK</div>
                    </div>
                    <div class="col-xs-6 p-0">
                        <div class="s_red">Total Cost :<?php echo f_number($totalCost, 2); ?> TK</div>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12" style="margin-top: -15px;">
                    <div class="balance text-center">
                        <h4>Opening Balance = <?php echo f_number($closing_amount, 2); ?></h4>
                        <h4>Balance = <?php echo f_number($totalIncome, 2) . ' - ' . f_number($totalCost, 2); ?></h4>
                        <h4 class="<?php echo $balance_status; ?>"><span>Balance : <?php echo f_number($balance, 2); ?> TK</span>
                        </h4>
                    </div>

                    <?php echo form_open();
                    if (isset($_POST['date'])) {
                        foreach ($_POST['date'] as $key => $val) {

                            if ($val != null && $key == 'from') {
                                $date_from['date'] = $val;
                            }

                            if ($val != null && $key == 'to') {
                                $date_to['date'] = $val;
                            }
                        }
                    }
                    $start_date = isset($date_from['date']) ? $date_from['date'] : date('Y-m-d');
                    $close_date = isset($date_to['date']) ? $date_to['date'] : date('Y-m-d');
                    ?>

                    <input type="hidden" name="opening_balance" value="<?php echo $closing_amount; ?>"
                           class="form-control">
                    <input type="hidden" name="closing_balance" value="<?php echo $balance; ?>" class="form-control">
                    <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" class="form-control">
                    <input type="hidden" name="close_date" value="<?php echo $close_date; ?>" class="form-control">
                    <?php
                    if ($this->input->post('godown_code')) {
                        if ($this->input->post('godown_code') == 'all') { ?>
                            <input type="hidden" name="godownCode" value="" class="form-control">
                        <?php } else { ?>
                            <input type="hidden" name="godownCode"
                                   value="<?php echo $this->input->post('godown_code'); ?>" class="form-control">
                        <?php }
                    } else { ?>
                        <input type="hidden" name="godownCode" value="<?php echo $this->data['branch']; ?>"
                               class="form-control">
                    <?php }
                    ?>

                    <div class="pull-right none">
                        <input type="submit" class="btn btn-info" name="close_balance" value="Close Balance">
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">&nbsp;</div>
</div>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>
