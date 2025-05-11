<?php   if (isset($meta->header)) {$header_info = json_decode($meta->header, true);}
        if (isset($meta->footer)) {$footer_info = json_decode($meta->footer, true);}
        $logo_data = json_decode($meta->logo, true); ?>
<style>
    .table > tbody > tr > td {padding: 2px;}
    @media print {
        .print_hide, aside,nav,.none,.panel-heading, .panel-footer, .company_btn {display: none !important;}
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide {display: block !important;}
        .table-bordered,.print-font {font-size: 14px !important;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
        .print_banner_text {width: 80%;float: right;text-align: center;}
        .print_banner_text h2 {margin: 0;line-height: 38px;text-transform: uppercase !important;}
        .print_banner_text p {margin-bottom: 5px !important;}
        .print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .invoice {text-align: center;padding: 10px 0;}
    ._tbl tr th,._tbl tr td {vertical-align: text-top;padding: 3px 10px 3px 0;}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>
            </div>

            <div class="panel-body none">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 hide">
                    <h4>Dealer Sale Invoice</h4>
                </div>
                <div class="row">
                    <?php
                        $saleBy = get_name("sapmeta", "meta_value", ["meta_key" => "sale_by", "voucher_no" => $result[0]->voucher_no]);
                        
                        if ($result[0]->sap_type == "cash") {
                            $cdata   = json_decode($result[0]->address);
                            $name    = filter($result[0]->party_code);
                            $mobile  = $cdata->mobile;
                            $address = $cdata->address;
                        }else{
                          
                            $partyInfo = get_row('parties', ['code' => $result[0]->party_code], ['name', 'mobile', 'address']);
                            $name      = $partyInfo->name;
                            $mobile    = $partyInfo->mobile;
                            $address   = $partyInfo->address;
                        }
                    ?>
                        
                    <div class="col-xs-8 print-font">
                        <table class="_tbl">
                            <tr>
                                <th width="125">Name</th>
                                <th>:</th>
                                <td> <?php echo $name; ?> </td>
                            </tr>
                            
                            <tr>
                                <th>Mobile</th>
                                <th>:</th>
                                <td> <?php echo $mobile; ?> </td>
                            </tr>
                            
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td> <?php echo $address; ?> </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-4 print-font">
                        <table class="_tbl">
                            <?php if ($result[0]->sap_type != "cash") { ?>
                            <tr>
                                <th>Customer ID</th>
                                <th>:</th>
                                <td><?php echo $result[0]->party_code; ?></td>
                            </tr>
                            <?php } ?>
                            
                            <tr>
                                <th width="125">Voucher No</th>
                                <th>:</th>
                                <td><?php echo $result[0]->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>:</th>
                                <td><?php echo $result[0]->sap_at; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th class="print_hide text-center">SL</th>
                        <th>Product Name</th>
                        <th width="150">Product Model</th>
                        <!--<th>Serial</th>-->
                        <th class="text-center">Qty</th>
                        <th>Price</th>
                        <th width="100">Comm.(%)</th>
                        <th width="100">Commission</th>
                        <th width="100">Flat Dis.</th>
                        <th width="140">Total (TK)</th>
                    </tr>
                    <?php
                    $total_sub = $total_flat_discount = 0.0;
                    $where     = array('voucher_no' => $result[0]->voucher_no);
                    $saleInfo  = $this->action->read('sapitems', $where);
                    foreach ($saleInfo as $key => $row) {
                        ?>
                        <tr>
                            <td style="width: 50px;" class="print_hide text-center"><?php echo($key + 1); ?></td>
                            <td>
                                <?php
                                $where       = array('code' => $row->product_code);
                                $productInfo = $this->action->read('stock', $where);
                                if ($productInfo) {
                                    echo filter($productInfo[0]->subcategory);
                                }
                                ?>
                            </td>
                            <td><?php echo ($productInfo) ? filter($productInfo[0]->product_model) : '' ?>&nbsp;</td>
                            <!--<td><?php //echo $row->product_serial;
                            ?>&nbsp;</td>-->
                            <td class="text-center"><?php echo $row->quantity; ?>&nbsp;</td>
                            <td class="text-center"><?php echo $row->sale_price; ?>&nbsp;</td>
                            <td class="text-center"><?php echo f_number($row->discount_percentage); ?>&nbsp;</td>
                            <td class="text-right"><?php echo f_number($row->discount); ?>&nbsp;</td>
                            <td class="text-right">
                                <?php 
                                    echo f_number($row->flat_discount * $row->quantity); 
                                    $total_flat_discount += $row->flat_discount * $row->quantity;
                                ?>
                                &nbsp;
                            </td>
                            <td class="text-right">
                                <?php
                                $subtotal  = ($row->sale_price * $row->quantity - $row->discount -($row->flat_discount* $row->quantity));
                                $total_sub += $subtotal;
                                echo f_number($subtotal, 2);
                                ?>&nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-right">Total Qty</th>
                        <td class="text-center"><?php echo $result[0]->total_quantity; ?>&nbsp;</td>
                        <th>&nbsp;</th>
                        <th>Sub Total</th>
                        <th class="text-right">
                            <?php
                            $total_discount = $result[0]->total_discount;
                            echo f_number($result[0]->total_discount);
                            ?>
                        </th>
                        <td class="text-right"><?php echo f_number($total_flat_discount, 2); ?>&nbsp;</td>
                        <td class="text-right"><?php echo f_number($total_sub, 2); ?>&nbsp;</td>
                    </tr>
                    <tr>
                        <th rowspan="6" colspan="5" style="padding-top: 75px;">
                            In Word : <span class="inword"></span> Taka Only.
                        </th>
                    </tr>


                    <tr>
                        <th colspan="3">Previous Balance</th>
                        <td class="text-right">
                            <?php echo $previous_balance; ?>
                        </td>
                    </tr>


                    <tr>
                        <th colspan="3">Grand Total</th>
                        <td class="text-right">
                            <?php
                            $gtotal = $total = $previous_balance + $total_sub;
                            echo f_number($total, 2);
                            ?>&nbsp;
                        </td>
                    </tr>

                    <?php
                    if ($result[0]->sap_type == 'cash') {
                        $due_paid          = $due = 0.00;
                        $where             = array('voucher_no' => $result[0]->voucher_no);
                        $due_paid_sum      = $this->action->read_sum('due_collect', 'paid', $where);
                        $due_remission_sum = $this->action->read_sum('due_collect', 'remission', $where);

                        $paid      = $result[0]->paid + $due_paid_sum[0]->paid;
                        $remission = ($due_remission_sum[0]->remission != null) ? $due_remission_sum[0]->remission : 0.00;
                        $due       = $total - $paid - $remission;
                    } else {
                        $paid      = $result[0]->paid;
                        $remission = 0.00;
                    }
                    ?>
                    <tr>
                        <th colspan="3">Paid</th>
                        <td class="text-right"><?php echo f_number($paid, 2); ?>&nbsp;</td>
                    </tr>

                    <!--previous current Balance-->
                    <tr>
                        <th colspan="3">Due</th>
                        <td class="text-right">
                            <?php
                            $current_status = ($result[0]->party_balance < 0) ? "Payable" : "Receivable";
                            echo f_number(abs($result[0]->party_balance), 2);
                            //echo f_number(abs($result[0]->party_balance))." TK&nbsp;[ ".$current_status." ]";
                            ?>&nbsp;
                        </td>
                    </tr>

                </table>

                <?php
                $info = $this->action->read("sapmeta", array("meta_key" => "sale_by", "voucher_no" => $result[0]->voucher_no));
                ?>
                <style>
                    .bi_border {
                        display: inline-block;
                        border: 1px solid #000;
                        border-radius: 10px;
                        padding: 3px 5px;
                        margin-bottom: -7px;
                    }
                </style>

                <div class="col-sm-3 col-xs-3">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>
                <div class="col-sm-6 col-xs-6">
                    <!--<h6>&nbsp;</h6>
                    <h6 class="text-center"><span class="bi_border">বিঃ দ্রঃ বিক্রিত মাল ফেরত বা বদল করা হয় না ।  </span> </h6> 
                    <h6 class="text-center"><span class="bi_border">বিঃ দ্রঃ বন্ধ কোম্পানির মালের কোনো গ্যারান্টি নাই । </span> </h6>-->
                </div>
                <div class="col-sm-3 col-xs-3">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        <?php echo $saleBy; ?>
                    </h4>
                </div>
            </div>


            <!-- PRINT COPY START -->
            <div class="panel-body hide">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 invoice hide">
                    <h4>Dealer Sale Invoice</h4>
                </div>
                <div class="row">
                    <div class="col-xs-8 print-font">
                        <table class="_tbl">
                            <tr>
                                <th width="125">Name</th>
                                <th>:</th>
                                <td> <?php echo $name; ?> </td>
                            </tr>
                            
                            <tr>
                                <th>Mobile</th>
                                <th>:</th>
                                <td> <?php echo $mobile; ?> </td>
                            </tr>
                            
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td> <?php echo $address; ?> </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-4 print-font">
                        <table class="_tbl">
                            <?php if ($result[0]->sap_type != "cash") { ?>
                            <tr>
                                <th>Customer ID</th>
                                <th>:</th>
                                <td><?php echo $result[0]->party_code; ?></td>
                            </tr>
                            <?php } ?>
                            
                            <tr>
                                <th width="125">Voucher No</th>
                                <th>:</th>
                                <td><?php echo $result[0]->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>:</th>
                                <td><?php echo $result[0]->sap_at; ?></td>
                            </tr>
                            <tr>
                                <th>Print Time</th>
                                <th>:</th>
                                <td><?php echo(date("h:i:s A",time())); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Product Name</th>
                        <th width="150">Product Model</th>
                        <th width="90" class="text-center">Qty</th>
                        <th width="90">Price</th>
                        <th width="90">Comm.(%)</th>
                        <th width="90">Commission</th>
                        <th width="100">Flat Dis.</th>
                        <th width="110">Total (TK)</th>
                    </tr>
                    <?php
                    $total_sub = $total_flat_discount = 0.0;
                    $where     = array('voucher_no' => $result[0]->voucher_no);
                    $saleInfo  = $this->action->read('sapitems', $where);
                    foreach ($saleInfo as $key => $row) {
                        ?>
                        <tr>
                            <td>
                                <?php
                                $where       = array('code' => $row->product_code);
                                $productInfo = $this->action->read('stock', $where);
                                if ($productInfo) {
                                    echo filter($productInfo[0]->subcategory);
                                }
                                ?>
                            </td>
                            <td><?php echo ($productInfo) ? filter($productInfo[0]->product_model) : '' ?>&nbsp;</td>
                            <td class="text-center"><?php echo $row->quantity; ?>&nbsp;</td>
                            <td class="text-center"><?php echo $row->sale_price; ?>&nbsp;</td>
                            <td class="text-center"><?php echo f_number($row->discount_percentage); ?>&nbsp;</td>
                            <td class="text-right"><?php echo f_number($row->discount); ?>&nbsp;</td>
                            <td class="text-right">
                                <?php 
                                    echo f_number($row->flat_discount * $row->quantity); 
                                    $total_flat_discount += $row->flat_discount * $row->quantity;
                                ?>
                                &nbsp;
                            </td>
                            <td class="text-right">
                                <?php
                                $subtotal  = ($row->sale_price * $row->quantity - $row->discount);
                                $total_sub += $subtotal;
                                echo f_number($subtotal, 2);
                                ?>&nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="2" class="text-right">Total Qty</th>
                        <td class="text-center"><?php echo $result[0]->total_quantity; ?>&nbsp;</td>
                        <th>&nbsp;</th>
                        <th>Sub Total</th>
                        <th class="text-right">
                            <?php
                            $total_discount = $result[0]->total_discount;
                            echo f_number($result[0]->total_discount);
                            ?>
                        </th>
                        <td class="text-right"><?php echo f_number($total_flat_discount, 2); ?></td>
                        <td class="text-right"><?php echo f_number($total_sub, 2); ?></td>
                    </tr>
                    <tr>
                        <th rowspan="6" colspan="4" style="padding-top: 75px;">
                            In Word : <span class="inword"></span> Taka Only.
                        </th>
                    </tr>

                    <tr>
                        <th colspan="3">Previous Balance</th>
                        <td class="text-right">
                            <?php
                            $where      = array('relation' => 'sales:' . $result[0]->voucher_no);
                            $current_sl = get_row('partytransaction', $where, 'id');

                            $where = array(
                                'party_code' => $result[0]->party_code,
                                'id <'       => $current_sl->id,
                                'trash'      => 0
                            );


                            $transactionRec = $this->retrieve->read('partytransaction', $where);
                            $total_credit   = $total_debit = $total_remission = 0.0;
                            if ($transactionRec != null) {
                                foreach ($transactionRec as $key => $row) {
                                    $total_credit    += $row->credit;
                                    $total_debit     += $row->debit;
                                    $total_remission += $row->remission;
                                }
                                $balance = $total_debit - $total_credit - $total_remission + $result[0]->initial_balance;
                            } else {
                                $balance = $result[0]->initial_balance;
                            }
                            $status2 = ($balance < 0) ? "-" : "";
                            echo $status2 . ' ' . f_number($balance, 2);
                            ?>
                        </td>
                    </tr>


                    <tr>
                        <th colspan="3">Grand Total</th>
                        <td class="text-right">
                            <?php
                            $gtotal = $total = $total_sub + $balance;
                            echo f_number($total, 2);
                            ?>&nbsp;
                        </td>
                    </tr>

                    <?php
                    if ($result[0]->sap_type == 'cash') {
                        $due_paid          = $due = 0.00;
                        $where             = array('voucher_no' => $result[0]->voucher_no);
                        $due_paid_sum      = $this->action->read_sum('due_collect', 'paid', $where);
                        $due_remission_sum = $this->action->read_sum('due_collect', 'remission', $where);

                        $paid      = $result[0]->paid + $due_paid_sum[0]->paid;
                        $remission = ($due_remission_sum[0]->remission != null) ? $due_remission_sum[0]->remission : 0.00;
                        $due       = $total - $paid - $remission;
                    } else {
                        $paid      = $result[0]->paid;
                        $remission = 0.00;
                    }
                    ?>
                    <tr>
                        <th colspan="3">Paid</th>
                        <td class="text-right"><?php echo f_number($paid, 2); ?>&nbsp;</td>
                    </tr>

                    <!--previous current Balance-->
                    <tr>
                        <th colspan="3">Due</th>
                        <td class="text-right">
                            <?php
                            $current_status = ($result[0]->party_balance < 0) ? "Payable" : "Receivable";
                            echo f_number(abs($result[0]->party_balance), 2);
                            ?>
                        </td>
                    </tr>

                </table>


                <style>
                    .bi_border {
                        display: inline-block;
                        border: 1px solid #000;
                        border-radius: 10px;
                        padding: 3px 5px;
                        margin-bottom: -7px;
                    }
                </style>

                <div class="col-sm-3 col-xs-3">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>
                <div class="col-sm-6 col-xs-6">
                </div>
                <div class="col-sm-3 col-xs-3">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        <?php echo $saleBy; ?>
                    </h4>
                </div>
                <!--<small class="insert_name hide">Software by Freelance iT Lab</small>-->
            </div>
            <!-- PRINT COPY END -->
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<style>
@page {size: A4; margin: 11mm 17mm 17mm 17mm;}
@media print {
    .panel-body {position: relative; height: 97vh;}
    .insert_name {position: absolute; bottom: -53px; display: block; width: 100%; text-align: center;}
    .panel-body{page-break-inside: avoid;}
    html, body{width: 210mm; height: 297mm;}
}
</style>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".inword").html(inWorden( <?php echo $result[0]->total_bill; ?> ));
    });
</script>