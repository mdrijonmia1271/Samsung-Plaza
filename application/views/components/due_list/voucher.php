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

        .panel-body {
            height: 96vh;
        }

        .table-bordered,
        .print-font {
            font-size: 16px;
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

    ._tbl tr th,
    ._tbl tr td {
        vertical-align: text-top;
        padding: 3px 10px 3px 0;
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <div class="col-md-12 text-center hide">
                    <h3>Installment Invoice
                    </h3>
                </div>

                <?php
                $partyInfo = json_decode($result->address, true);

                $dPaid = custom_query("SELECT SUM(paid + remission) AS due_paid FROM `due_collect` WHERE voucher_no='$result->voucher_no'");
                $dPaid = (!empty($dPaid[0]->due_paid) ? $dPaid[0]->due_paid : 0);

                $totalPaid = $due = 0;

                $totalPaid  = ($result->paid + $dPaid);


                $due = $result->total_bill - $totalPaid;

                ?>

                <div class="row">
                    <div class="col-xs-6 print-font">
                        <table class="_tbl">
                            <tr>
                                <th>Name</th>
                                <th>:</th>
                                <td><?php echo check_null(filter($result->party_code)); ?></td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <th>:</th>
                                <td><?php echo check_null($partyInfo['mobile']); ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td><?php echo check_null($partyInfo['address']); ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-xs-6 print-font">
                        <table class="_tbl">
                            <tr>
                                <th>Invoice No</th>
                                <th>:</th>
                                <td><?php echo $result->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>:</th>
                                <td><?php echo $result->date; ?></td>
                            </tr>
                            <tr>
                                <th>Print Time</th>
                                <th>:</th>
                                <td><?php echo date("h:i:s A"); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="col-xs-12 row">
                    <table class="table table-bordered table-hover">


                        <tr>
                            <th width="30%">Paid</th>
                            <td class="text-right">
                                <?php echo $result->d_paid; ?>
                            </td>
                            <th width="30%">Remission</th>
                            <td class="text-right"><?php echo get_number_format($result->d_remission); ?></td>
                        </tr>
                        <tr>
                            <th>Total Bill</th>
                            <td class="text-right"><?php echo get_number_format($result->total_bill); ?></td>
                            <th>Total (Paid+Remi.)</th>
                            <td class="text-right"><?php echo get_number_format($totalPaid); ?></td>
                        </tr>

                        <tr>
                            <th>Due</th>
                            <td class="text-right"> <?php echo get_number_format($due); ?> </td>
                            <th></th>
                            <td class="text-right"></td>
                        </tr>
                    </table>
                </div>


                <div class="col-xs-12">&nbsp;</div>
                <div class="col-xs-6 row">
                    <p style="margin-top: 50px;">In Word : <strong id="inword"></strong> Taka Only.</p>
                </div>

                <div class="col-xs-6 pull-right hide">
                    <h4 style="margin-top: 50px;" class="text-center print-font">
                        -------------------------------- <br>
                        Signature of authority
                    </h4>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#inword").html(inWorden( <?php echo $result->d_paid + $result->d_remission; ?> ));
    });
</script>