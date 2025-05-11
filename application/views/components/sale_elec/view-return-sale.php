<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Return Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <h4 class="text-center hide">Return Voucher</h4>
                <div class="row">
                    <div class="col-xs-4 print-font">
                        <?php
                            
                            $where = array('code' => $result[0]->client_code);
                            $party_info = $this->action->read('parties', $where);
                            $address = ($party_info)? $party_info[0]->address: " ";
                        ?>
                        
                        <label>Name : <?php echo filter($party_info[0]->name); ?></label> <br>
                        <label>Mobile : <?php echo $party_info[0]->mobile; ?></label><br>
                      
                    </div>
                    <div class="col-xs-4 print-font">
                        <label style="margin-bottom: 10px;">
                        Voucher No : <?php echo $result[0]->voucher_no; ?>
                        </label> <br>
                        
                        <label style="margin-bottom: 10px;">
                         Address : <?php echo $address; ?>
                        </label>
                    </div>
                    <div class="col-xs-4 print-font">
                        <label>Print Time : <?php echo $result[0]->date; ?> - <?php echo date("h:i:s A"); ?></label> <br>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th style="width: 30%;">Product Name</th>
                        <th style="width: 30%;">Model</th>
                        <th style="width: 10%;" class="text-center">Qty.</th>
                        
                        <th style="width: 15%;" class="text-center">Price</th>
                        <th style="width: 15%;" class="text-center">Amount</th>
                    </tr>
                    
                    
                    <?php
                        $total_sub = 0.0;
                        $where = array('voucher_no' => $result[0]->voucher_no);
                        $saleInfo = $this->action->read('sale_return', $where);
                        $total = 0.00;
                        foreach($saleInfo as $key => $row){
                            $subtotal = 0.00;
                            $subtotal = $row->quantity * $row->product_price;
                            $productInfo = get_row('stock', ['code' => $row->product_code], ['name', 'product_model', 'category'])
                    ?>
                    <tr>
                        <td style="width: 50px;"><?php echo ($key + 1); ?></td>
                        <td><?php echo filter($productInfo->category); ?></td>
                        <td><?php echo $productInfo->product_model; ?></td>
                        <td class="text-center"><?php echo $row->quantity; ?>&nbsp;</td>
                        <td class="text-center"><?php echo $row->product_price; ?>&nbsp;</td>
                        
                        <td class="text-center"><?php echo $subtotal; $total += $subtotal; ?>&nbsp;</td>
                        
                    </tr>
                    <?php } ?>
                    
                    
                    
                    <tr>
                        <th colspan="5" class="text-right">
                            Total Quantity
                        </th>
                        <td class="text-right">
                            <?php
                                echo f_number($result[0]->totalQty);
                            ?> &nbsp;
                        </td>
                    </tr>
                    
                    <tr>
                        <th colspan="5" class="text-right">
                           Total Amount
                        </th>
                        <td class="text-right">
                            <?php
                                echo f_number($total);
                            ?> TK&nbsp;
                        </td>
                    </tr>
                    
                    <tr>
                        <th colspan="5" class="text-right">Return Amount</th>
                        <td class="text-right">
                            <?php
                                $gtotal = $total;
                                echo f_number($result[0]->return_amount);
                            ?> TK&nbsp;
                        </td>
                    </tr>
                    
                    
                </table>
                
                <style>.bi_border{ display: inline-block; border: 1px solid #000; border-radius: 10px; padding: 3px 5px; margin-bottom: -7px;}</style>
                
                <div class="col-sm-9 col-xs-9">
                    <h4 style="margin-top: 40px; margin-left: 60px;" class="print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>
                <!--<div class="col-sm-6 col-xs-6">
                    <h6>&nbsp;</h6>
                    <h6 class="text-center"><span class="bi_border">বিঃ দ্রঃ বিক্রিত মাল ফেরত বা বদল করা হয় না ।  </span> </h6> 
                    <h6 class="text-center"><span class="bi_border">বিঃ দ্রঃ বন্ধ কোম্পানির মালের কোনো গ্যারান্টি নাই । </span> h6>
                </div>-->
                <div class="col-sm-3 col-xs-3 text-right">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        <?php //echo $info[0]->meta_value; ?>
                        Signature of Authorized
                    </h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $gtotal; ?>));});
</script>