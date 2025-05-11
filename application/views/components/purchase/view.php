<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,900" rel="stylesheet">
<style type="text/css">
    table tr td {word-break: break-all;}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                
                <div class="col-md-12 text-center hide">
                    <h3>Purchase Invoice</h3>
                </div>
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
                            <tr>
                                <th>Mobile :</th>
                                <td><?php echo filter($voucherInfo->mobile); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6">
                        <table class="table custom-table">
                            <tr>
                                <th width="200">Date :</th>
                                <td><?php echo $voucherInfo->sap_at; ?></td>
                            </tr>
                            <tr>
                                <th>Voucher No :</th>
                                <td><?php echo $voucherInfo->voucher_no; ?></td>
                            </tr>
                            <tr>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr class="view">
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th>Model</th>
                        <th>Unit</th>
                        <?php if ($voucherInfo->voucher_type == 'mobile') { ?>
                            <th>Serial NO</th>
                        <?php } ?>
                        <th>Quantity</th>
                        <th>Price (TK)</th>
                        <th>Total (TK)</th>
                    </tr>

                    <?php
                    $totalAmount = 0;
                    foreach ($voucherItems as $key => $val) {
                        $amount      = $val->purchase_price * $val->quantity;
                        $totalAmount += $amount;
                        ?>
                        <tr>
                            <td style="width: 50px;"><?php echo($key + 1); ?></td>
                            <td class="view"><?php echo filter($val->product_cat); ?></td>
                            <td class="view"><?php echo filter($val->product_model); ?></td>
                            <td style="width: 80px;"><?php echo filter($val->unit); ?></td>
                            <?php if ($voucherInfo->voucher_type == 'mobile') { ?>
                                <td class="wid-100 text-right"><?php echo $val->product_serial; ?></td>
                            <?php } ?>
                            <td class="wid-100 text-right"><?php echo $val->quantity; ?></td>
                            <td class="wid-100 text-right"><?php echo $val->purchase_price; ?></td>
                            <td class="wid-100 text-right"><?php echo $amount; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="col-xs-offset-8 col-xs-4">
                    <div class="row">
                        <table class="table custom-table text-right">
                            <tr>
                                <th class="view" width="200">Total Amount :</th>
                                <td><b><?php echo f_number($totalAmount); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Total Discount :</th>
                                <td><b><?php echo f_number($voucherInfo->total_discount); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Transport Cost :</th>
                                <td><b><?php echo f_number($voucherInfo->transport_cost); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Grand Total:</th>
                                <td><b><?php echo f_number($voucherInfo->total_bill); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Paid :</th>
                                <td><b><?php echo f_number($voucherInfo->paid); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Due :</th>
                                <td><b><?php echo f_number($voucherInfo->total_bill - $voucherInfo->paid); ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>