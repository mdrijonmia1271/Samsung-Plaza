<?php if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true); ?>
<style>
    .table > tbody > tr > td {
        padding: 2px;
    }

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

    ._tbl tr th, ._tbl tr td {
        vertical-align: text-top;
        padding: 1px 10px 1px 0;
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
                <div class="col-md-12 invoice hide">
                    <h4 class="text-center">Hire Sale Invoice</h4>
                </div>
                <div class="row">
                    <div class="col-xs-6 print-font">
                        <?php
                        $info = $this->action->read("sapmeta", array("meta_key" => "sale_by", "voucher_no" => $result->voucher_no));
                        ?>
                        <table class="_tbl">
                            <tr>
                                <th>Voucher No</th>
                                <th>:</th>
                                <td><?php echo $result->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>:</th>
                                <td><?php echo check_null($result->name); ?></td>
                            </tr>
                            <tr>
                                <th>Customer ID</th>
                                <th>:</th>
                                <td><?php echo $result->party_code; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td><?php echo check_null($result->address); ?></td>
                            </tr>
                            <tr>
                                <th>1<sup>st</sup> Guarantor</th>
                                <th>:</th>
                                <td>
                                    <?php echo check_null($result->guarantor_name); ?>
                                    <br>
                                    <?php echo check_null($result->guarantor_mobile); ?>
                                    <br>
                                    <?php echo check_null($result->guarantor_address); ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-xs-6 print-font">

                        <table class="_tbl">
                            <tr>
                                <th>Father's Name</th>
                                <th>:</th>
                                <td><?php echo check_null($result->father_name); ?></td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <th>:</th>
                                <td><?php echo check_null($result->mobile); ?></td>
                            </tr>
                            <tr>
                                <th>Print Time</th>
                                <th>:</th>
                                <td><?php echo $result->sap_at; ?> - <?php echo date("h:i:s A"); ?></td>
                            </tr>
                            <tr>
                                <th>Installment Day</th>
                                <th>:</th>
                                <td><?php echo $result->installment_day; ?></td>
                            </tr>
                            <tr>
                                <th>2<sup>nd</sup> Guarantor</th>
                                <th>:</th>
                                <td>
                                    <?php echo check_null($result->guarantor_name2); ?>
                                    <br>
                                    <?php echo check_null($result->guarantor_mobile2); ?>
                                    <br>
                                    <?php echo check_null($result->guarantor_address2); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered none">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th style="width: 20%;">Product Name</th>
                        <th style="width: 15%;">Model</th>
                        <th style="width: 15%;">Serial</th>
                        <th style="width: 8%;">Qty</th>
                        <th style="width: 17%;">Price</th>
                        <th style="width: 20%; text-align: right;">Total (TK)</th>
                    </tr>

                    <?php
                    $total_sub = $total_discount = 0.0;
                    $where     = array('voucher_no' => $result->voucher_no);
                    $saleInfo  = get_result('sapitems', $where, ['product_code', 'product_serial', 'quantity', 'sale_price', 'discount', 'godown_code']);
                    foreach ($saleInfo as $key => $row) {
                        $productInfo = get_row('stock', ['code' => $row->product_code, 'godown_code' => $row->godown_code], ['subcategory', 'category', 'product_model']);
                        ?>
                        <tr>
                            <td style="width: 50px;"><?php echo($key + 1); ?></td>
                            <td>
                                <?php echo !empty($productInfo) ? filter(check_null($productInfo->subcategory)) : ''; ?>
                            </td>
                            <td>
                                <?php echo !empty($productInfo) ? filter(check_null($productInfo->product_model)) : ''; ?>
                            </td>
                            <td><?php echo check_null($row->product_serial); ?>&nbsp;</td>
                            <td class="text-right"><?php echo $row->quantity; ?>&nbsp;</td>
                            <td class="text-left">&nbsp; <?php echo $row->sale_price; ?></td>
                            <td class="text-right">
                                <?php
                                $subtotal       = $row->sale_price * $row->quantity;
                                $total_sub      += $subtotal;
                                $total_discount += $row->discount;
                                echo f_number(($subtotal - $row->discount), 2)
                                ?>&nbsp;
                            </td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="4" class="text-center">Total Quantity</th>
                        <td class="text-right"><?php echo $result->total_quantity; ?>&nbsp;</td>
                        <th>HMRP Value</th>
                        <td class="text-right"><?php echo f_number(($total_sub - $total_discount), 2); ?> &nbsp;</td>
                    </tr>

                    <tr>
                        <th rowspan="6" colspan="5" style="padding-top: 55px;">In Word : <span class="inword"></span>
                            Taka Only.
                        </th>
                    </tr>


                    <tr>
                        <th>Total Hire Price</th>
                        <td class="text-right">
                            <?php
                            echo f_number($result->hire_price, 2);
                            ?> &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <th>Previous Balance</th>
                        <td class="text-right">

                            <?php
                            $where      = array('relation' => 'sales:' . $result->voucher_no);
                            $current_sl = get_row('partytransaction', $where, 'id');
                            if (!empty($current_sl)) {

                                $where = array(
                                    'party_code' => $result->party_code,
                                    'id <'       => $current_sl->id,
                                    'trash'      => 0
                                );

                                $transactionRec = $this->retrieve->read('partytransaction', $where);
                                $total_credit   = $total_debit = $total_remission = 0.0;

                                foreach ($transactionRec as $key => $row) {
                                    $total_credit    += $row->credit;
                                    $total_debit     += $row->debit;
                                    $total_remission += $row->remission;
                                }
                                $balance = $total_debit - $total_credit - $total_remission + $result->initial_balance;
                            } else {
                                $balance = $result->initial_balance;
                            }
                            $status  = ($balance < 0) ? "Payable" : " Receivable";
                            $status2 = ($balance < 0) ? "-" : "";
                            echo $status2 . ' ' . f_number(abs($balance), 2);
                            ?>

                            &nbsp;
                        </td>
                    </tr>

                    <?php
                    $paid      = $result->paid;
                    $remission = 0.00;
                    ?>
                    <tr>
                        <th>Down Payment</th>
                        <td class="text-right"><?php echo f_number($paid, 2); ?> &nbsp;</td>
                    </tr>

                    <tr>
                        <th>Hire Outstanding</th>
                        <td class="text-right">
                            <?php
                            $gtotal = $total = $result->party_balance;
                            echo f_number($total, 2);
                            ?> &nbsp;
                        </td>
                    </tr>


                    <?php if ($remission > 0) { ?>
                        <tr>
                            <th>Remission</th>
                            <td class="text-right">
                                <?php echo f_number($remission, 2); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>


                <table class="table table-bordered hide">
                    <tr>
                        <th style="width: 20%;">Product</th>
                        <th style="width: 30%;">Product Model</th>
                        <th style="width: 15%;">Product Serial</th>
                        <th style="width: 8%;">Quantity</th>
                        <th style="width: 17%;">Price</th>
                        <th style="width: 20%; text-align: right;">Total (TK)</th>
                    </tr>

                    <?php
                    $total_sub = 0.0;
                    $where     = array('voucher_no' => $result->voucher_no);
                    $saleInfo  = $this->action->read('sapitems', $where);
                    foreach ($saleInfo as $key => $row) {
                        $where       = array('code' => $row->product_code);
                        $productInfo = get_row('stock', $where, ['subcategory', 'product_model']);
                        ?>
                        <tr>
                            <td>
                                <?php echo ($productInfo) ? filter($productInfo->subcategory) : 'N/A'; ?>
                            </td>
                            <td><?php echo ($productInfo) ? filter($productInfo->product_model) : 'N/A'; ?> &nbsp;</td>
                            <td><?php echo $row->product_serial; ?>&nbsp;</td>
                            <td class="text-right"><?php echo $row->quantity; ?>&nbsp;</td>
                            <td class="text-left">&nbsp; <?php echo $row->sale_price; ?></td>
                            <td class="text-right">
                                <?php
                                $subtotal  = $row->sale_price * $row->quantity;
                                $total_sub += $subtotal;
                                echo f_number($subtotal);
                                ?>&nbsp;
                            </td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="3" class="text-right">Total Quantity</th>
                        <td class="text-right"><?php echo $result->total_quantity; ?>&nbsp;</td>
                        <th>HMRP Value</th>
                        <td class="text-right"><?php echo f_number($total_sub); ?>&nbsp;</td>
                    </tr>

                    <tr>
                        <th rowspan="5" colspan="3" style="padding-top: 40px;">In Word : <span class="inword"></span>
                            Taka Only.
                        </th>
                    </tr>

                    <tr>
                        <th colspan="2">Total Hire Price</th>
                        <td class="text-right">
                            <?php
                            echo f_number($result->hire_price, 2);
                            ?>&nbsp;
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">Previous Balance</th>
                        <td class="text-right">

                            <?php
                            $where      = array('relation' => 'sales:' . $result->voucher_no);
                            $current_sl = get_row('partytransaction', $where, 'id');
                            if (!empty($current_sl)) {

                                $where = array(
                                    'party_code' => $result->party_code,
                                    'id <'       => $current_sl->id,
                                    'trash'      => 0
                                );

                                $transactionRec = $this->retrieve->read('partytransaction', $where);
                                $total_credit   = $total_debit = $total_remission = 0.0;

                                foreach ($transactionRec as $key => $row) {
                                    $total_credit    += $row->credit;
                                    $total_debit     += $row->debit;
                                    $total_remission += $row->remission;
                                }
                                $balance = $total_debit - $total_credit - $total_remission + $result->initial_balance;
                            } else {
                                $balance = $result->initial_balance;
                            }
                            $status2 = ($balance < 0) ? "-" : "";
                            echo $status2 . ' ' . f_number(abs($balance), 2);
                            ?>

                            &nbsp;
                        </td>
                    </tr>

                    <?php
                    $paid      = $result->paid;
                    $remission = 0.00;
                    ?>
                    <tr>
                        <th colspan="2">Down Payment</th>
                        <td class="text-right"><?php echo f_number($paid, 2); ?>&nbsp;</td>
                    </tr>

                    <tr>
                        <th colspan="2">Hire Outstanding</th>
                        <td class="text-right">
                            <?php
                            $gtotal = $total = $result->total_bill;
                            echo f_number($total, 2);
                            ?>&nbsp;
                        </td>
                    </tr>


                    <?php if ($remission > 0) { ?>
                        <tr>
                            <th colspan="2">Remission</th>
                            <td class="text-right">
                                <?php echo f_number($remission, 2); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>


                <!-- installment section start here -->
                <div class="table-responsive">
                    <table class="table table-bordered __table">
                        <tr>
                            <th width="100" rowspan="2">INSTALLMENT NUMBER</th>
                            <th colspan="3">SCHEDULE</th>
                            <th colspan="3">REPAYMENT</th>
                        </tr>
                        <tr>
                            <th>INSTALLMENT DATE</th>
                            <th>CASH <small>FOR ..... MONTHS</small></th>
                            <th>HIRE PRICE <small>FOR ..... MONTHS</small></th>
                            <th>REPAYMENT DATE</th>
                            <th>COLLECTED AMOUNT</th>
                            <th>DUE</th>
                        </tr>
                        <?php
                        $next_date = $result->sap_at;
                        $total     = 0.0;
                        for ($i = 0; $i < $result->installment_no; $i++) {

                            if ($result->installment_type == 'monthly') {
                                $next_date = date('Y-m-d', strtotime($next_date . ' + 30 days'));
                            } elseif ($result->installment_type == 'weekly') {
                                $next_date = date('Y-m-d', strtotime($next_date . ' + 7 days'));
                            }
                            ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo $next_date; ?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?php echo f_number($result->installment_amount, 2);
                                    $total += $result->installment_amount; ?></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th></th>
                            <th class="text-right"></th>
                            <th class="text-right">Total =</th>
                            <th class="text-right"><strong><?php echo f_number($total); ?> &nbsp;TK</strong></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">&nbsp;</div>

                <!--installment section end here-->
                <?php
                $info = $this->action->read("sapmeta", array("meta_key" => "sale_by", "voucher_no" => $result->voucher_no));
                ?>
                <style>.bi_border {
                        display: inline-block;
                        border: 1px solid #000;
                        border-radius: 10px;
                        padding: 3px 5px;
                        margin-bottom: -7px;
                    }</style>

                <div class="col-xs-4">
                    <h4 style="margin-top: 20px;" class="text-center print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>

                <div class="col-xs-4"> &nbsp;</div>

                <div class="col-xs-4">
                    <h4 style="margin-top: 20px;" class="text-center print-font">
                        ------------------------------ <br>
                        <?php echo $info[0]->meta_value; ?>
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
        $(".inword").html(inWorden(<?php echo $gtotal; ?>));
    });
</script>