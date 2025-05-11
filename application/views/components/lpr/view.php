<?php 	
        
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
	$logo_data  = json_decode($meta->logo,true); 
    	
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
</style>
<div class="container-fluid">
    <div class="row">
        
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>View LPR</h1>
                </div>
                <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->

                <div class="col-xs-12 hide" style="border: 1px solid #ddd; padding:15px !important; margin-bottom: 15px;">
                    <div class="print_banner_logo">
                        <img class="img-responsive" src="<?php echo site_url($logo_data['faveicon']); ?>" alt="">
                    </div>
                    <div class="print_banner_text">
                    	<h2><?php echo strtoupper($header_info['site_name']); ?></h2>
                    	<p><?php echo $header_info['place_name'];?></p>
                    	<p><?php echo $footer_info['addr_moblile']; ?> || <?php echo $footer_info['addr_email']; ?></p>
                    </div>
                </div>

                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">LPR Invoice</h3>
                </div>
                <div class="col-md-12">
                    
                    <?php 
                        // read parties info
                        $partyInfo = $this->action->read('parties', array('code' => $info[0]->party_code));
                    ?>
                    <div class="row">
                        <div class="col-xs-4">
                            <label class="label-control">Invoice No : <span><?php echo $info[0]->lpr_code;?></span></label><br>
                            <label class="label-control"></label>
                        </div>
                        
                        <div class="col-xs-4">
                            <label class="label-control">Date : <span><?php echo $info[0]->date;?></span></label><br>
                            <label class="label-control">Customer Name : <span><?php echo ($partyInfo)? filter($partyInfo[0]->name)." ( ".$info[0]->party_code." )" : '' ;?></span></label>
                        </div>
                        
                        <div class="col-xs-4">
                            <label class="label-control">Mobile : <span><span><?php echo ($partyInfo)? ($partyInfo[0]->mobile) : '' ;?></span></label><br>
                            <label class="label-control">Address : <span><span><?php echo ($partyInfo)? ($partyInfo[0]->address) : '' ;?></span></label>
                        </div>
                    </div>
                </div>
                
                <p>&nbsp;</p>
                <div class="col-xs-4">
                    <table style="width: 100%;">
                        <tr>
                            <th>Down Payment</th>
                            <td class="text-right"><?php echo $info[0]->down_payment; ?></td>
                        </tr>
                        
                        <!--<tr>
                            <th>Sales Amount</th>
                            <td class="text-right"><?php echo $info[0]->total_bill; ?></td>
                        </tr>
                        <tr>
                            <th>Value Add</th>
                            <td class="text-right"><?php echo $info[0]->total_commission; ?></td>
                        </tr>-->
                        
                        <tr>
                            <th>Hire Price</th>
                            <td class="text-right"><?php echo ($info[0]->total_bill + $info[0]->total_commission); ?></td>
                        </tr>
                        
                        <tr>
                            <th>Total Paid</th>
                            <td class="text-right"><?php echo $info[0]->total_paid; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Payment</th>
                            <td class="text-right"><?php echo $info[0]->payment; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Remission</th>
                            <td class="text-right"><?php echo $info[0]->remission; ?></td>
                        </tr>
                        
                        <tr>
                            <th>Balance</th>
                            <td class="text-right"><?php echo $info[0]->balance; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });
</script>