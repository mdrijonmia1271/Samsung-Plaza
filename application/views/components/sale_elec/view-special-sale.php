<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
<style>
    .table>tbody>tr>td {padding: 2px;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
        border: 1px solid transparent;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .invoice {
        text-align: center;
        padding: 10px 0;
    }
    .invoice h4 {
        border: 1px solid #aaa;
        display: inline;
        padding: 6px 10px;
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
                <div class="col-md-12 invoice hide">
                    <h4>Cash Sale Invoice</h4>
                </div>
                <div class="row">
                    <div class="col-xs-4 print-font">
                        <?php
                            $address = "N/A";
                            $cdata = json_decode($result[0]->address, true);
                            $address = $cdata['address'];
                        ?>
                        
                        <label>Name : <?php echo filter($result[0]->party_code); ?></label><br>
                        <label>Mobile : <?php echo $cdata['mobile']; ?></label><br>
                        
                    </div>
                    
                    <div class="col-xs-4 print-font">
                        <label style="margin-bottom: 10px;">Voucher No : <?php echo $result[0]->voucher_no; ?> </label> <br>
                        <label>Address : <?php echo $address; ?> </label>
                    </div>
                    
                    <div class="col-xs-4 print-font">
                        <label>Date : <?php echo $result[0]->sap_at; ?></label> <br>
                    </div>
                    
                    <div class="col-xs-4 print-font">
                        <?php
                            $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result[0]->voucher_no));
                        ?>
                        
                    </div>
                    
                    
                    
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th style="width: 20%;">Product</th>
                        <th style="width: 20%;">Product Model</th>
                        <th style="width: 20%;">Product Serial</th>
                        <th style="width: 8%;">Quantity</th>
                        <th style="width: 17%;">Price</th>
                        <th style="width: 10%;">Total (TK)</th>
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
                                if($productInfo){ echo filter($productInfo[0]->category); }
                            ?>
                        </td>
                        <td><?php echo ($productInfo)? filter($productInfo[0]->product_model) : ''?>&nbsp;</td>
                        <td><?php echo $row->product_serial; ?>&nbsp;</td>
                        <td class="text-right"><?php echo $row->quantity; ?>&nbsp;</td>
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
                        <td class="text-right"><?php echo $result[0]->total_quantity; ?>&nbsp;</td>
                        <th>Sub Total</th>
                        <td class="text-right"><?php echo f_number($total_sub); ?> TK&nbsp;</td>
                    </tr>
                    <tr>
                        <th rowspan="6" colspan="5" style="padding-top: 55px;">In Word : <span id="inword"></span> Taka Only.</th>
                    </tr>
                    
                    <tr>
                        <th>
                            Commission ( <?php echo $result[0]->commission_percentage; ?> %)
                        </th>
                        <td class="text-right">
                            <?php
                                $total_discount = $result[0]->total_discount;
                                echo f_number($result[0]->total_discount);
                            ?> TK&nbsp;
                        </td>
                    </tr>
                    
                    
                    <?php  if($result[0]->sap_type != 'cash'){ ?>
                    
                    <!--tr>
                        <th>Previous Balance</th>
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
                    </tr-->

                    <?php } ?>
                    
                    
                    <tr>
                        <th>Grand Total</th>
                        <td class="text-right">
                            <?php
                                $gtotal = $total = $total_sub  - $total_discount;
                                echo f_number($total);
                            ?> TK&nbsp;
                        </td>
                    </tr>
                    
                    <?php
                        if($result[0]->sap_type == 'special'){
                            $due_paid = $due = 0.00;
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
                        <th>Paid</th>
                        <td class="text-right"><?php echo f_number($paid); ?> TK&nbsp;</td>
                    </tr>


                    <?php if ($remission > 0) { ?>

                    <tr>
                        <th>Remission</th>
                        <td class="text-right">
                            <?php echo f_number($remission); ?> TK
                        </td>
                    </tr>

                    <?php } ?>
                    
                   
                    <tr>
                        <th>Due</th>
                        <td class="text-right"><?php
                                $current_status = ($result[0]->due < 0 ) ? "Payable":"Receivable";
                                echo f_number(abs($due))." TK&nbsp"; 
                            ?>&nbsp;
                        </td>
                    </tr>
                </table>
                <?php
                    $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result[0]->voucher_no));
                ?>
                <style>.bi_border{ display: inline-block; border: 1px solid #000; border-radius: 10px; padding: 3px 5px; margin-bottom: -7px;}</style>
                
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
                        <?php echo $info[0]->meta_value; ?>
                    </h4>
                </div>
                <small class="insert_name hide">Software by Freelance iT Lab</small>
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
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $gtotal; ?>));});
</script>