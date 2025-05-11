<?php if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true); ?>
<style>
    .table > tbody > tr > th,
    .table > tbody > tr > td {padding: 2px 6px;}
    .header_info {
        margin-bottom: 15px;
        flex-wrap: wrap;
        display: flex;
        width: 100%;
    }
    .header_info li {
        min-width: 300px;
        font-size: 15px;
        width: 33%;
        margin: 5px 0;
        display: flex;
    }
    .header_info li strong {
        display: inline-block;
        min-width: 75px;
    }
    .signature_box {
        justify-content: space-between;
        display: flex;
        align-items: center;
    }
    .signature_box h4 {
        border-top: 2px dashed #000;
        display: inline-block;
        padding-top: 7px;
        color: #000;
        font-size: 16px;
        margin: 40px 0 0;
        text-align: center;
    }
    .invoice_title {text-align: center;}
    .invoice_title h4 {
        border: 1px solid #000;
        display: inline-block;
        border-radius: 15px;
        padding: 5px 20px;
        font-size: 15px;
        text-align: center;
    }
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {display: none !important;}
        .panel {
            border: 1px solid transparent;
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%;
        }
        .hide {display: block !important;}
        .panel-body {
            padding: 25px 35px 0;
            height: 98vh;
        }
        @page {margin: 0;}
        .header_info {
            border-top: 1px solid #eee;
            margin-top: 10px;
            padding-top: 10px;
        }
        .header_info li {
            font-size: 15px !important;
            min-width: 240px;
        }
        .table tr th,
        .table tr td {
            border: 1px solid #000 !important;
            font-size: 14px !important;
        }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="invoice_title hide">
                    <h4>Cash Sale Invoice</h4>
                </div>
                <?php
                    $address  = "N/A";
                    $patyInfo = json_decode($info->address);
                ?>
                <ul class="header_info">
                    <li><strong>Name</strong> : <span><?php echo filter($info->party_code);?></span></li>
                    <li><strong>Mobile</strong> : <span><?php echo $patyInfo->mobile;?></span></li>
                    <li><strong>Voucher No</strong> : <span><?php echo $info->voucher_no;?></span></li>
                    <li><strong>Date</strong> : <span><?php echo $info->sap_at;?></span></li>
                    <li><strong>Address</strong> : <span><?php echo $patyInfo->address;?></span></li>
                </ul>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40px;">SL</th>
                            <th style="white-space: nowrap;">Product Model</th>
                           <?php if($info->voucher_type == "mobile"){ ?>
                                <th style="width: 100px;">IMEI No</th>    
                            <?php }else{ ?>
                                 <th style="width: 1202px">Product Serial</th>
                            <?php } ?>
                            <th style="width: 65px; text-align:center">Qty</th>
                            <th style="width: 80px; text-align: right;">Price</th>
                            <th style="width: 70px; text-align: right;">Dis(%)</th>
                            <th style="width: 80px; text-align: right;">Dis(Tk)</th>
                            <th style="width: 90px; text-align: right;">Total (TK)</th>
                        </tr>
                        <?php
                            $total_sub = $total_dis = 0;
                            $where     = [
                                'sapitems.voucher_no' => $info->voucher_no,
                                'sapitems.trash'      => 0,
                            ];
                            $select = ['sapitems.*', 'products.product_name', 'products.product_cat',  'products.subcategory', 'products.brand'];
                            $saleInfo  = get_join('sapitems', 'products', 'sapitems.product_code=products.product_code', $where, $select);

                            foreach ($saleInfo as $key => $row) {

                            $total_dis += $row->discount;
                            $subtotal  = ($row->sale_price * $row->quantity) - $row->discount;
                            $total_sub += $subtotal;
                        ?>
                        <tr>
                            <td style="width: 50px;"><?php echo($key + 1); ?></td>
                            <td> <?php echo filter($row->product_model); ?> </td>
                            <td><?php echo $row->product_serial; ?></td>
                            <td class="text-center"><?php echo number_format($row->quantity, 0); ?></td>
                            <td class="text-right"> <?php echo $row->sale_price; ?></td>
                            <td class="text-right"> <?php echo $row->discount_percentage; ?></td>
                            <td class="text-right"> <?php echo $row->discount; ?></td>
                            <td class="text-right"> <?php echo f_number($subtotal, 2); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-right">Total Qty</th>
                            <td class="text-center"><?php echo $info->total_quantity; ?></td>
                            <th colspan="2" class="text-right">Sub Total</th>
                            <td class="text-right"><?php echo f_number($total_dis); ?></td>
                            <td class="text-right"><?php echo f_number($total_sub, 2); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="6" colspan="5" style="vertical-align: middle;">In Word : <span id="inword"></span> Taka Only.</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Discount(%)</th>
                            <td class="text-right">
                                <?php
                                    $total_discount = $info->total_discount;
                                    echo f_number($info->total_discount, 2);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Grand Total</th>
                            <td class="text-right">
                                <?php
                                    $total = $info->total_bill;
                                    echo f_number($total, 2);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Paid</th>
                            <td class="text-right"><?php echo f_number($info->paid);?></td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Due</th>
                            <td class="text-right"><?php echo f_number($info->due);?></td> 
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Remark</th>
                            <td class="text-right">
                                <?php echo $info->comment;?>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
                    $userName = get_name("sapmeta", "meta_value", ["meta_key" => "sale_by", "voucher_no" => $info->voucher_no]);
                ?>
                <div class="signature_box">
                    <h4>Signature of Customer</h4>
                    <h4>Signature of Manager</h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#inword").html(inWorden(<?php echo $gtotal; ?>));
    });
    $(document).ready(function () {
        $("#inwords").html(inWorden(<?php echo $gtotal; ?>));
    });
</script>