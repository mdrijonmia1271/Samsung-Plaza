<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,900" rel="stylesheet">
<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
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
    }

    .wid-100 {
        width: 100px;
    }

    .custom-table > tbody > tr > th,
    .custom-table > tbody > tr > td {
        border: none;
        line-height: 18px;
        padding: 4px !important;
    }

    .custom-table > tbody > tr > th {
        width: 140px;
    }

    .view {
        font-family: 'Raleway', sans-serif;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Purchase Return Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="row">
                    <div class="col-xs-6">

                        <table class="table custom-table view">
                            <tr>
                                <th>Supplier Name :</th>
                                <td><?php echo filter($voucherInfo->name); ?></td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td><?php echo filter($voucherInfo->address); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6">
                        <table class="table custom-table">
                            <tr>
                                <th>Mobile :</th>
                                <td><?php echo filter($voucherInfo->mobile); ?></td>
                            </tr>
                            <tr>
                                <th width="200">Date :</th>
                                <td><?php echo $voucherInfo->sap_at; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr class="view">
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th>Color</th>
                        <th>IMEI NO</th>
                        <th>Quantity</th>
                        <th>Price (TK)</th>
                        <th>Total (TK)</th>
                    </tr>
                    <?php
                    $totalAmount = 0;
                    foreach ($voucherItems as $key => $row) {
                        $amount      = $row->purchase_price * $row->quantity;
                        $totalAmount += $amount;
                        ?>
                        <tr>
                            <td style="width: 50px;"><?php echo($key + 1); ?></td>
                            <td><?php echo $row->product_model; ?></td>
                            <td><?php echo filter($row->color); ?></td>
                            <td class="wid-100 text-right"><?php echo $row->product_serial; ?></td>
                            <td class="wid-100 text-right"><?php echo $row->quantity; ?></td>
                            <td class="wid-100 text-right"><?php echo $row->purchase_price; ?></td>
                            <td class="wid-100 text-right"><?php echo $amount; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="col-xs-offset-8 col-xs-4">
                    <div class="row">
                        <table class="table custom-table text-right">
                            <tr>
                                <th class="view" width="200">Total Amount :</th>
                                <td><b><?php echo f_number($voucherInfo->total_bill); ?></b></td>
                            </tr>

                            <tr>
                                <th class="view" width="200">Previous Balance :</th>
                                <td><b><?php echo f_number($previousBalance); ?></b></td>
                            </tr>

                            <tr>
                                <th class="view" width="200">Paid :</th>
                                <td><b><?php echo f_number($voucherInfo->paid); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view" width="200">Paid :</th>
                                <td><b><?php echo f_number($currentBalance); ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>