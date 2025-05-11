<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
<style>
    .table>tbody>tr>td {padding: 2px;}
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide {display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .header_table, .header_table tr, .header_table tr th, .header_table tr td {
        border: 1px solid transparent !important;
        padding: 0 !important;
    }
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
            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">Sale Invoice</h3>
                </div>
                
                <div class="row">
                    <div class="col-xs-6 print-font">
                        <?php
                            $address = "N/A";
                            $cdata = json_decode($result[0]->address, true);
                            $address = $cdata['address'];
                            if($result[0]->sap_type != "cash" ) {
                                
                                $where = array('code' => $result[0]->party_code);
                                $party_info = $this->action->read('parties', $where);
                                $address = ($party_info)? $party_info[0]->address: " ";
                            
                                $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result[0]->voucher_no));
                        ?>
                        <table class="table header_table">
                            <tr>
                                <th width="105">Name</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td>
                                    <?php if ($party_info != null) { echo filter($party_info[0]->name);}else{echo "N/A";} ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Customer ID</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php echo $result[0]->party_code; ?> </td>
                            </tr>
                            
                            <tr>
                                <th>Address</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php echo $address; ?> </td>
                            </tr>
                            
                        <?php } else { ?>
                            <tr>
                                <th>Name</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td>
                                    <?php echo filter($result[0]->party_code); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php echo $cdata['mobile']; ?> </td>
                            </tr>
                        <?php } ?>
                        </table>
                        <br>
                    </div>
                    
                    <div class="col-xs-6 print-font">
                        <table class="table header_table">
                            <tr>
                                <th width="105">Voucher No</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php echo $result[0]->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php if ($party_info != null) { echo $party_info[0]->mobile;}else{echo "N/A";} ?> </td>
                            </tr>
                        <?php if($result[0]->sap_type == "cash" ) { ?>
                            <tr>
                                <th>Address</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php echo $address; ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <th>Print Time</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php echo $result[0]->sap_at; ?> - <?php echo date("h:i:s A"); ?></td>
                            </tr>
                        <?php } ?>
                        <?php if($result[0]->sap_type == "cash" ) { ?>
                            <tr>
                                <th>Print Time</th>
                                <th>:&nbsp;&nbsp;</th>
                                <td><?php echo $result[0]->sap_at; ?> - <?php echo date("h:i:s A"); ?></td>
                            </tr>
                        <?php } ?>
                        </table>
                        <br>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th style="width: 25%;">Product</th>
                        <th style="width: 20%;">Product Model</th>
                        <th style="width: 15%;">Product Serial</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 15%;">Total (TK)</th>
                    </tr>
                    <?php
                        $total_sub = 0.0;
                        $where = array('voucher_no' => $result[0]->voucher_no);
                        $saleInfo = $this->action->read('sapitems', $where);
                        foreach($saleInfo as $key => $row){
                    ?>
                    <tr>
                        <td style="width: 50px;"><?php echo ($key + 1); ?></td>
                        <td>
                            <?php
                                $where = array('code' => $row->product_code);
                                $productInfo = $this->action->read('stock', $where);
                                if($productInfo){ echo filter($productInfo[0]->name); }
                            ?>
                        </td>
                        <td><?php echo ($productInfo)? filter($productInfo[0]->product_model) : ''?>&nbsp;</td>
                        <td><?php echo $row->product_serial; ?>&nbsp;</td>
                        <td class="text-center"><?php echo $row->quantity; ?>&nbsp;</td>
                        <td class="text-right"><?php echo $row->sale_price; ?>&nbsp;</td>
                        <td class="text-right">
                            <?php
                                $subtotal = $row->sale_price * $row->quantity;
                                $total_sub += $subtotal;
                                echo f_number($subtotal);
                            ?>&nbsp;
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="4" class="text-right">Total Quantity</th>
                        <td class="text-center"><?php echo $result[0]->total_quantity; ?>&nbsp;</td>
                        <th>Sub Total</th>
                        <td class="text-right"><?php echo f_number($total_sub); ?> TK&nbsp;</td>
                    </tr>
                    <tr>
                        <th rowspan="6" colspan="4" style="padding-top: 55px;">
                            In Word : <span id="inword"></span> Taka Only.
                        </th>
                    </tr>
                    
                    <tr>
                        <th colspan="2">
                            Commission
                        </th>
                        <td class="text-right">
                            <?php
                                $total_discount = $result[0]->total_discount;
                                echo f_number($result[0]->total_discount);
                            ?> TK&nbsp;
                        </td>
                    </tr>
                    
                    
                    <?php  if($result[0]->sap_type != 'cash'){ ?>
                    
                    <tr>
                        <th colspan="2">Previous Balance</th>
                        <td class="text-right">
                            <?php 
                                //calculate previous balance and current balance
                                /**
                                ** strategy: 
                                **      Fetch previous record by serial from partytransaction
                                **      Calculate the balance and
                                **      add/substraction by the current transaction amount
                                **/
                                
                                $where = array('relation' => 'sales:'.$result[0]->voucher_no);
                                $current_sl = $this->action->read('partytransaction',$where);

                                $where = array(
                                    'party_code' => $result[0]->party_code,
                                    'serial <' => $current_sl[0]->serial,
                                    'trash' => 0
                                );
                                //print_r($where);
                                
                                $transactionRec = $this->retrieve->read('partytransaction',$where);
                                //print_r($transactionRec);
                                
                                $total_credit = $total_debit = 0.0;
                                if ($transactionRec != null) {
                                    foreach ($transactionRec as $key => $row) {
                                        $total_credit += $row->credit;
                                        $total_debit += $row->debit;
                                    }
                                    $balance = $total_debit -  $total_credit + $party_info[0]->initial_balance;
                                }else{
                                    $balance = $party_info[0]->initial_balance;
                                }
                                 $status = ($balance < 0) ? " Payable" : " Receivable";
                                 echo f_number(abs($balance)) . ' TK &nbsp; [' . $status . '&nbsp;]';
                            ?>
                        </td>
                    </tr>

                    <?php } ?>
                    
                    
                    <tr>
                        <th colspan="2">Grand Total</th>
                        <td class="text-right">
                            <?php
                                $gtotal = $total = $total_sub  + $total_discount;
                                echo f_number($total);
                            ?> TK&nbsp;
                        </td>
                    </tr>
                    
                    <?php
                        $due_paid = $due = 0.00;
                        if($result[0]->sap_type == 'cash'){
                            $where = array('voucher_no' => $result[0]->voucher_no);
                            $due_paid_sum = $this->action->read_sum('due_collect','paid',$where);
                            $due_remission_sum = $this->action->read_sum('due_collect','remission',$where);
                                    
                            $paid = $result[0]->paid + $due_paid_sum[0]->paid;
                            $remission = ($due_remission_sum[0]->remission !=null)? $due_remission_sum[0]->remission:0.00;
                            $due = $total - $paid - $remission;
                        }else{
                            $paid = $result[0]->paid;
                            $remission = 0.00;
                        }
                    ?>
                    <tr>
                        <th colspan="2">Paid</th>
                        <td class="text-right"><?php echo f_number($paid); ?> TK&nbsp;</td>
                    </tr>


                    <?php if ($remission > 0) { ?>

                    <tr>
                        <th colspan="2">Remission</th>
                        <td class="text-right">
                            <?php echo f_number($remission); ?> TK
                        </td>
                    </tr>

                    <?php } ?>
                    
                    <?php if ($result[0]->sap_type == 'credit') { ?>
                    
                    <!--<tr>
                        <th>Current Balance</th>
                        <td class="text-right">
                            <?php
                                //current balance = $balance + grand total -paid
                                $current_balance = $balance + $total - $result[0]->paid;
                                $current_status = ($current_balance < 0 ) ? "Payable":"Receivable";
                                echo f_number(abs($current_balance))." TK&nbsp;[ ".$current_status." ]"; 
                            ?>
                    </tr>-->
                    
                    
                    <!--previous current Balance-->
                    <tr>
                        <!--<th>Current Balance</th>-->
                        <th colspan="2">Due</th>
                        <td class="text-right">
                            <?php
                                $current_status = ($result[0]->party_balance < 0 ) ? "Payable":"Receivable";
                                echo f_number(abs($result[0]->party_balance))." TK&nbsp;[ ".$current_status." ]"; 
                            ?>&nbsp;
                        </td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <th colspan="2">Due</th>
                        <td class="text-right"><?php
                                $current_status = ($result[0]->due < 0 ) ? "Payable":"Receivable";
                                echo f_number(abs($due))." TK&nbsp"; 
                            ?>&nbsp;
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <?php
                    $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result[0]->voucher_no));
                ?>
                <style>.bi_border{ display: inline-block; border: 1px solid #000; border-radius: 10px; padding: 3px 5px; margin-bottom: -7px;}</style>
                
                <div class="col-sm-4 col-xs-6">
                    <h4 style="margin-top: 30px;" class="text-center print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>
                <div class="col-sm-4 col-xs-6"></div>
                <div class="col-sm-4 col-xs-6">
                    <h4 style="margin-top: 30px;" class="text-center print-font">
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
    .panel-body {position: relative; height: 96vh;}
    .insert_name {position: absolute; bottom: -53px; display: block; width: 100%; text-align: center;}
    .panel-body{page-break-inside: avoid;}
    html, body{width: 210mm; height: 297mm;}
}
</style>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $gtotal; ?>));});
</script>