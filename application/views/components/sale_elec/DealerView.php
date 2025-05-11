<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
<style>
    .table>tbody>tr>td { padding: 2px; }
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide { display: block !important;}
        .panel-body { height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }
        .print_banner_logo { width: 19%; float: left;}
        .print_banner_logo img { margin-top: 10px;}
		.print_banner_text { width: 80%; float: right; text-align: center;}
		.print_banner_text h2 { margin:0; line-height: 38px; text-transform: uppercase !important;}
		.print_banner_text p { margin-bottom: 5px !important;}
		.print_banner_text p:last-child { padding-bottom: 0 !important; margin-bottom: 0 !important;}
    }
    .invoice { text-align: center; padding: 10px 0;}
    .invoice h4 { border: 1px solid #aaa; display: inline; padding: 6px 10px;}
    ._tbl tr th, ._tbl tr td { vertical-align: text-top; padding: 3px 10px 3px 0;}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Dealer Sale Chalan</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 hide">
                    <h4 class="text-center">Dealer Chalan</h4>
                </div>
                <div class="row">
                    <div class="col-xs-4 print-font">
                        <?php
                        $where = array('code' => $result->party_code);
                        $party_info = get_row('parties', $where);
                        //print_r($party_info);
                       ?>
                        <table class="_tbl">
                            <tr>
                                <th width="125">Name</th>
                                <th>:</th>
                                <td><?php  echo check_null($party_info->name); ?></td>
                            </tr>
                            <tr>
                                <th>Customer ID </th>
                                <th>:</th>
                                <td><?php echo check_null($result->party_code); ?></td>
                            </tr>
                        </table> 
                    </div>
                    <div class="col-xs-4 print-font">
                        <?php
                          $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result->voucher_no));
                        ?>

                        <table class="_tbl">
                            <tr>
                                <th width="125">Mobile</th>
                                <th>:</th>
                                <td><?php echo check_null($party_info->mobile); ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <th>:</th>
                                <td><?php echo check_null($party_info->address); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-4 print-font">
                        <table class="_tbl">
                            <tr>
                                <th width="125">Voucher</th>
                                <th>:</th>
                                <td><?php echo $result->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>Print</th>
                                <th>:</th>
                                <td><?php echo date('Y-m-d h:i:s A'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered table2">
                    <tr>
                        <th width="60">SL</th>
                        <th>Product</th>
                        <th width="38%">Product Model</th>
                        <th width="120">Quantity</th>
                    </tr>
                    <?php
                        $totalQty = 0;
                        $where = array('voucher_no' => $result->voucher_no);
                        $saleInfo = get_result('sapitems', $where, ['product_code', 'product_serial', 'quantity', 'sale_price', 'discount', 'product_model']);
                        foreach($saleInfo as $key => $row){
                        $productInfo = get_row('stock', ['code' => $row->product_code], ['name', 'category', 'product_model']);
                    ?>
                    <tr>
                        <td><?php echo ++$key; ?></td>
                        <td><?php echo !empty($productInfo) ? filter(check_null($productInfo->category)) : ''; ?></td>
                        <td><?php echo check_null($row->product_model); ?></td>
                        <td><?php echo $row->quantity; $totalQty +=$row->quantity; ?></td>
                    </tr>
                    <?php } ?>
                    
                    <tr>
                        <th colspan="3" class="text-right"> Total </th>
                        <td> <?php echo $totalQty; ?> </td>
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
                <div class="col-sm-4 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>
                <div class="col-sm-4 col-xs-6">

                </div>
                <div class="col-sm-4 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        <?php echo $info[0]->meta_value; ?>
                    </h4>
                </div>
                <!--<small class="insert_name hide">Software by Freelance iT Lab</small>-->
            </div>
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
    $(document).ready(function(){$(".inword").html(inWorden(<?php echo $gtotal; ?>));});
</script>