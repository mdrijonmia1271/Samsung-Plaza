<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered,
        .print-font {font-size: 16px;}
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

        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <?php 
                foreach ($transactionInfo as $key => $row) {
                    $where          = array ('code'=>$row->party_code);
                    $info           = $this->action->read('parties', $where);
                    $balanceinfo    = $this->action->read('partybalance', $where);
                }
             ?>
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

                <div class="row">
                	<div class="col-xs-8 print-font">
                		<label style="margin-bottom: 10px;">
                            Voucher No : <?php echo $party_code . $transactionInfo[0]->id; ?>
                            
                        </label> <br>

                        <label style="margin-bottom: 10px;">
                            Name: <?php echo $info[0]->name; ?>
                        </label>
                     </div>

                	<div class="col-xs-4 print-font">
                		<label>Date : <?php echo $transactionInfo[0]->transaction_at; ?></label> <br>
                		<label>Print Time : <?php echo date("h:i:s A"); ?></label>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Paid</th>
                        <th>Transaction Type</th>
                        <th> <?php if($balanceinfo[0]->balance > 0){echo'Total Balance Tk';}else{echo'Total Due';} ?>  </th>
                        <th width="100">Remark</th>
                    </tr>
                    <tr>
                        <td><?php echo $transactionInfo[0]->paid; ?></td>
                        <td><?php echo ucfirst($transactionInfo[0]->transaction_via); ?></td>
                        <td><?php echo $balanceinfo[0]->balance; ?></td>
                        <td><?php echo ucfirst($transactionInfo[0]->remark); ?></td>
                    </tr>

                    <tr>
                        <td rowspan="7" colspan="4">In Word : <strong id="inword"></strong> Taka Only.</td>
                    </tr>              
                </table>

                <div class="pull-right hide">
                    <h4 style="margin-top: 50px;" class="text-center print-font">
                    -------------------------------- <br>
                    Signature of authority
                    </h4>
                </div>
              </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#inword").html(inWorden(<?php echo $transactionInfo[0]->paid; ?>));
    });
</script>
