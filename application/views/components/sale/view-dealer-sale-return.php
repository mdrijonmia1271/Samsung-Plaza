<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>
<style>
    .table > tbody > tr > td {padding: 2px;}
    .invoice {
        text-align: center;
        padding: 10px 0;
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
                    <h1 class="pull-left">Sale Return Invoice</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 hide">
                    <h4>Sale Return Invoice</h4>
                </div>
                <div class="row">
                    <div class="col-xs-4 print-font">
                        <table class="_tbl">
                            <tr>
                                <th>Name</th>
                                <th>:</th>
                                <td><?php echo $partyInfo->name; ?></td>
                            </tr>
                            <tr>
                                <th>Customer ID</th>
                                <th>:</th>
                                <td><?php echo $partyInfo->code; ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-xs-4 print-font">
                        <table class="_tbl">
                            <tr>
                                <th>Mobile</th>
                                <th>:</th>
                                <td><?php echo $partyInfo->mobile; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td><?php echo $partyInfo->address; ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-xs-4 print-font">
                        <table class="_tbl">
                            <tr>
                                <th>Voucher No</th>
                                <th>:</th>
                                <td><?php echo $voucherInfo->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>:</th>
                                <td><?php echo $voucherInfo->sap_at; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th class="print_hide text-center">SL</th>
                        <th>Product Model</th>
                        <th width="250">IMEI NO</th>
                        <th class="text-center">Qty</th>
                        <th>Price</th>
                        <th width="100">Comm.(%)</th>
                        <th>Commission</th>
                        <th>Total (TK)</th>
                    </tr>
                    <?php
                    $subtotal = $itemDiscount = 0;
                    foreach ($voucherItems as $key => $row) {
                            $amount = ($row->sale_price * $row->quantity - $row->discount);
                            $itemDiscount += $row->discount;
                            $subtotal += $amount;
                        ?>
                        <tr>
                            <td style="width: 50px;" class="print_hide text-center"><?php echo($key + 1); ?></td>
                            
                            <td><?php echo filter($row->product_model); ?>&nbsp;</td>
                            <td><?php echo $row->product_serial;?> </td>
                            <td class="text-center"><?php echo $row->quantity; ?>&nbsp;</td>
                            <td class="text-center"><?php echo $row->sale_price; ?>&nbsp;</td>
                            <td class="text-center"><?php echo f_number($row->discount_percentage); ?>&nbsp;</td>
                            <td class="text-right"><?php echo f_number($row->discount); ?>&nbsp;</td>
                            <td class="text-right"><?php echo f_number($amount); ?>&nbsp;</td>
                        </tr>
                    <?php } ?>
                    
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <td class="text-center"><?php echo $voucherInfo->total_quantity; ?>&nbsp;</td>
                        <th></th>
                        <th></th>
                        <th class="text-right">
                            <?php echo f_number($itemDiscount); ?>
                        </th>
                        <td class="text-right"><?php echo f_number($subtotal, 2); ?>&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <th rowspan="6" colspan="6" style="padding-top: 75px;">In Word : <span class="inword"></span>
                            Taka Only.
                        </th>
                    </tr>

                    <tr>
                        <th>Discount</th>
                        <td class="text-right"><?php echo f_number($voucherInfo->total_discount, 2); ?></td>
                    </tr>
                    
                    <tr>
                        <th>Previous Balance</th>
                        <td class="text-right"><?php echo f_number($partyInfo->previous_balance, 2); ?></td>
                    </tr>

                    <tr>
                        <th>Grand Total</th>
                        <td class="text-right"><?php echo f_number($partyInfo->grand_total, 2); ?></td>
                    </tr>
                    
                    <tr>
                        <th>Paid</th>
                        <td class="text-right"><?php echo f_number($voucherInfo->paid, 2); ?></td>
                    </tr>

                    <tr>
                        <th>Current Balance</th>
                        <td class="text-right"><?php echo f_number($partyInfo->current_balance, 2); ?>&nbsp;</td>
                    </tr>
                </table>

                <?php $saleBy = get_name('sapmeta', 'meta_value', ['meta_key' => 'sale_by', 'voucher_no' => $voucherInfo->voucher_no]); ?>

                <div class="col-sm-3 col-xs-3">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>
                <div class="col-sm-6 col-xs-6"></div>
                <div class="col-sm-3 col-xs-3">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        <?php echo $saleBy; ?>
                    </h4>
                </div>
            </div>

            <!-- PRINT COPY END -->
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".inword").html(inWorden(<?= $voucherInfo->total_bill ?>));
    });
</script>