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

                <div class="row">
                    <div class="col-xs-6 print-font">
                        <table class="_tbl">
                            <tr>
                                <th>Name</th>
                                <th>:</th>
                                <td><?php  echo $info->name; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <th>:</th>
                                <td><?php echo $info->mobile;; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td><?php echo $info->address;; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-xs-6 print-font">
                        <table class="_tbl">
                            <tr>
                                <th>Invoice No</th>
                                <th>:</th>
                                <td><?php echo $info->inc_code; ?></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>:</th>
                                <td><?php echo $info->transaction_at; ?></td>
                            </tr>
                            <tr>
                                <th>Print Time</th>
                                <th>:</th>
                                <td><?php echo date("h:i:s A"); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php $totalPaid = $info->credit + $info->remission; ?>


                <?php if ($info->customer_type == 'dealer') { ?>

                       <div class="col-xs-12 row">
                           <table class="table table-bordered table-hover">

                               <tr>
                                   <th>Paid</th>
                                   <td class="text-right">
                                       <?php echo $info->credit; ?>
                                   </td>
                                   <th>Remission</th>
                                   <td class="text-right"><?php echo($info->remission ? $info->remission : 0); ?></td>
                               </tr>
                               <tr>
                                   <th>Previous Balance</th>
                                   <td class="text-right"> <?php echo number_format($previousBalance, 2); ?> </td>
                                   <th>Current Balance</th>
                                   <td class="text-right"> <?php echo number_format($currentBalance, 2); ?> </td>
                               </tr>
                               <tr>
                                   <th>Transaction Type</th>
                                   <td class="text-right"><?php echo ucfirst($info->transaction_via); ?></td>
                                   <th>Paid By</th>
                                   <td class="text-right"><?php echo ucfirst(check_null($info->comment)); ?></td>
                               </tr>
                           </table>
                       </div>

                <?php }else { ?>

                <div class="col-xs-12 row">
                    <table class="table table-bordered table-hover">

                        <tr>
                            <th>Paid</th>
                            <td class="text-right">
                                <?php
                                    echo $info->credit;
                                ?>
                                </td>
                            <th>Remission</th>
                            <td class="text-right"><?php echo ($info->remission ? $info->remission : 0); ?></td>
                        </tr>
                        
                        <tr>
                            <th>Total Paid</th>
                            <td class="text-right"><?php echo number_format($totalPaid, 2); ?></td>
                            <th>Paid By</th>
                            <td class="text-right"><?php echo ucfirst(check_null($info->comment)); ?></td>
                        </tr>
                        <tr>
                            <th>Previous Balance </th>
                            <td class="text-right"> <?php echo number_format($previousBalance, 2); ?> </td>
                            <th>Current Balance</th>
                            <td class="text-right"> <?php echo number_format($currentBalance, 2); ?> </td>
                        </tr>
                        <tr>
                            <th>Transaction Type</th>
                            <td class="text-right"><?php echo ucfirst($info->transaction_via); ?></td>
                            <th>&nbsp;</th>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <?php } ?>

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
        $("#inword").html(inWorden( <?php echo $info->credit; ?> ));
    });
</script>