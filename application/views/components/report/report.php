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
        .hide{
            display: block !important;
        }
        .title{
            font-size: 25px;
        }
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .table .title{
        font-size: 15px;
        font-weight: bold;
        text-align: center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
        color: #333;
    }
    .table{font-size: 12px !important;}
    .table tr th, .table tr td{padding: 5px 6px !important;}
</style>

<div class="container-fluid">
    <div class="row">   
    
    <!--pre><?php // print_r($return_physical_cost);?></pre-->
    
    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Expenditure </h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">From</label>
                    <div class="input-group date col-md-5" id="datetimepickerSMSFrom">
                        <input type="text" name="date[from]" class="form-control" value="<?php echo date('Y-m-d');?>" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To</label>
                    <div class="input-group date col-md-5" id="datetimepickerSMSTo">
                        <input type="text" name="date[to]" class="form-control" value="<?php echo date('Y-m-d');?>"  placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Show" name="show" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left"> Show Result </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
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
                
                <h4 class="hide text-center" style="margin-top: 0px;">All Cost</h4>

                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">Date Range :</th>
                        <?php $data =  $this->input->post("date");?>
                        <th class="text-center"><?php echo $data['from'] . " To " . $data['to']; ?></th>
                        <th class="text-center">Date:</th>
                        <th class="text-center"><?php echo date("Y-m-d"); ?></th>
                    </tr>
                </table>
                <?php $totalDebit = $totalCredit = 0.00;  ?>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <caption class="title"> Debit</caption>
                            <tr>
                                <th colspan="8" class="text-center">&nbsp;</th>
                            </tr>
                            
                            <!-- previous cash -->   
                            <?php
                             $totalPreCash = $openCash = 0.00;
                             if($pre_cash != NULL){ ?>                        
                             <tr>
                                <th colspan="4" style="font-size: 14px;" class="text-center">Previous Cash :</th>
                                <th colspan="4" style="font-size: 14px;"><?php $totalPreCash =  $openCash = ($pre_cash) ? $pre_cash[0]->balance : 0.00;  echo f_number($openCash);?></th>
                               
                             </tr>
                            <?php } ?>
                            
                           
                            <!--  Cash Sale -->
                            <?php 
                             $totalPaid = array();
                             if($allSale != NULL){ ?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Cash Sale</th>
                            </tr>
                            <tr>
                                <th>Memo No </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Sale Rate</th>
                                <th>Amount </th>
                            </tr>

                            <?php                           
                            foreach ($allSale as $key => $row) {
                            $partyName = $this->action->read("parties", array("code" => $row->party_code));
                            if ($row->paid > 0) {
                            $proName = $quantity = $unit = $saleRate = array();
                            $proInfo = $this->action->read("sapitems", array("voucher_no" => $row->voucher_no));
                            foreach ($proInfo as $key => $value) {
                            $unit[] =  $value->unit;
                            $proName[] =  $value->brand;
                            $quantity[] =  $value->quantity;
                            $saleRate[] =  $value->sale_price;
                            } ?>
                            <tr>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td>
                                    <?php
                                    if ($partyName) {
                                        echo filter($partyName[0]->name);
                                    }else {
                                        echo $row->party_code;
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $attr = json_decode($row->address, true);
                                    if ($partyName) {
                                        echo filter($partyName[0]->address);
                                    }else {
                                        echo $attr["address"];
                                    }
                                    ?>
                                </td>
                                <td><?php echo implode(", ", $proName); ?></td>
                                <td><?php echo implode(", ", $quantity); ?></td>
                                <td><?php echo implode(", ", $unit); ?></td>
                                <td><?php echo implode(", ", $saleRate); ?></td>
                                <td><?php echo $totalPaid [] = $row->paid; ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right"><strong>Total</strong></td>
                                <td><?php echo f_number(array_sum($totalPaid)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <?php } ?>
                           



                            <!--  Credit Sale -->
                            <?php 
                              $totalDue = array();
                              if($allSale != NULL){ ?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Credit Sale</th>
                            </tr>
                            <tr>
                                <th>Memo No </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Sale Rate</th>
                                <th>Amount </th>
                            </tr>
                            <?php                           
                            foreach ($allSale as $key => $row) {
                            $partyName = $this->action->read("parties", array("code" => $row->party_code));

                            if (($row->total_bill - $row->paid) > 0) {
                            $proName = $quantity = $unit = $saleRate = array();
                            $proInfo = $this->action->read("sapitems", array("voucher_no" => $row->voucher_no));
                            foreach ($proInfo as $key => $value) {
                            $unit[] =  $value->unit;
                            $proName[] =  $value->brand;
                            $quantity[] =  $value->quantity;
                            $saleRate[] =  $value->sale_price;
                            } ?>
                            <tr>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td>
                                    <?php
                                    if ($partyName) {
                                        echo filter($partyName[0]->name);
                                    }else {
                                        echo $row->party_code;
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $attr = json_decode($row->address, true);
                                    if ($partyName) {
                                        echo filter($partyName[0]->address);
                                    }else {
                                        echo $attr["address"];
                                    }
                                    ?>
                                </td>

                                <td><?php echo implode(", ", $proName); ?></td>
                                <td><?php echo implode(", ", $quantity); ?></td>
                                <td><?php echo implode(", ", $unit); ?></td>
                                <td><?php echo implode(", ", $saleRate); ?></td>
                                <td><?php echo $totalDue [] = ($row->total_bill - $row->paid); ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right"><strong>Total</strong></td>
                                <td><?php echo f_number(array_sum($totalDue)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <?php } ?>


				
				
 


                            <!--  cash received -->
                            <?php 
                             $transactionTotal = array();
                             if($transactions != NULL){?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Cash Received</th>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th colspan="5">Address</th>
                                <th>Amount </th>
                            </tr>
                            <?php                           
                            foreach ($transactions as $key => $row) {
                            $partyName = $this->action->read("parties", array("code" => $row->party_code));
                            if ($row->paid > 0 && $row->party_code >0) {
                            ?>

                            <tr>
                                <td><?php echo $row->party_code; ?></td>
                                <td><?php if($partyName){echo filter($partyName[0]->name);}else{echo "N/A";} ?></td>
                                <td colspan="5"><?php if($partyName){echo filter($partyName[0]->address);}else{echo "N/A";} ?></td>
                                <td><?php echo $transactionTotal[] = $row->paid; ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right"><strong>Total</strong></td>
                                <td><?php echo f_number(array_sum($transactionTotal)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            
                            <?php } ?>


                           <!--  lone received -->
                           <?php 
                            $receivedtotal = array();
                            if($loanInfo != NULL){ ?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Loan Received</th>
                            </tr>
                            <tr>
                                <th>Loan Rec. No </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th colspan="4">Particulars</th>
                                <th>Amount </th>
                            </tr>
                            <?php                            
                            foreach ($loanInfo as $key => $row) {
                            if ($row->loan_type == "Received") {
                            ?>
                            <tr>
                                <td><?php echo $row->id ?></td>
                                <td><?php echo filter($row->name); ?></td>
                                <td><?php echo $row->address; ?></td>
                                <td colspan="4"><?php echo v_check($row->remarks); ?></td>
                                <td><?php echo $receivedtotal[] = $row->amount; ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right">Total</td>
                                <td><?php echo f_number(array_sum($receivedtotal)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <?php } ?>


                          
                        
                         <!--  withdraw from bank i.e debit -->
                         <?php 
                         $bankWithdraw = array();
                         if($bankInfo != NULL){ ?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Bank Withdraw</th>
                            </tr>
                            <tr>
                                <!--th>Trnx No </th-->
                                <th>Bank Name</th>
                                <th>Account No.</th>
                                <th colspan="5">Particulars</th>
                                <th>Amount </th>
                            </tr>
                            <?php                            
                            foreach ($bankInfo as $key => $row) {
                            if ($row->transaction_type == "Debit") {
                            ?>
                            <tr>
                                <!--td><?php echo $row->id; ?></td-->
                                <td><?php echo filter($row->bank); ?></td>
                                <td><?php echo $row->account_number; ?></td>
                                <td colspan="5"><?php echo v_check($row->remarks); ?></td>
                                <td><?php echo $bankWithdraw[] = $row->amount; ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right">Total</td>
                                <td><?php echo f_number(array_sum($bankWithdraw)); ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                        
                        
                         <!--  Showroom Collection Start -->
                         <?php 
                            $collection = array();
                            if($showroomCollection != NULL) { ?>                         
                          <table class="table table-bordered">
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Showroom Collection</th>
                            </tr>
                            <tr>
                                <th>Sl</th>
                                <th>Showroom Name</th>                               
                                <th colspan="7">Amount</th>                               
                            </tr>
                            <?php                            
                            foreach ($showroomCollection as $key => $row) { 
                            $info = $this->action->read("showroom",array("showroom_id" => $row->showroom_id));                           
                            ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo ($info) ? filter($info[0]->name) : ""; ?></td>                           
                                <td colspan="7"><?php echo $collection[] = $row->amount; ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="7" class="text-right">Total</td>
                                <td><?php echo f_number(array_sum($collection)); ?></td>
                            </tr>
                        </table>   
                        <?php } ?>
                         <!--  Showroom Collection End--> 
                    </div>













                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <caption class="title"> Credit</caption>
                            <tr>
                                <th colspan="8" class="text-center">&nbsp;</th>
                            </tr>                          
                           
                            
                          
                            <?php 
                            $totalDue = array();
                            if($allSale != NULL){?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Credit Sale</th>
                            </tr>
                            <tr>
                                <th>Memo No </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Sale Rate</th>
                                <th>Amount </th>
                            </tr>
                            <?php                            
                            foreach ($allSale as $key => $row) {
                            $partyName = $this->action->read("parties", array("code" => $row->party_code));

                            if (($row->total_bill - $row->paid) > 0) {
                            $proName = $quantity = $unit = $saleRate = array();
                            $proInfo = $this->action->read("sapitems", array("voucher_no" => $row->voucher_no));
                            foreach ($proInfo as $key => $value) {
                            $unit[] =  $value->unit;
                            $proName[] =  $value->brand;
                            $quantity[] =  $value->quantity;
                            $saleRate[] =  $value->sale_price;
                            } ?>
                            <tr>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td>
                                    <?php
                                    if ($partyName) {
                                        echo filter($partyName[0]->name);
                                    }else {
                                        echo $row->party_code;
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $attr = json_decode($row->address, true);
                                    if ($partyName) {
                                        echo filter($partyName[0]->address);
                                    }else {
                                        echo $attr["address"];
                                    }
                                    ?>
                                </td>
                                <td><?php echo implode(", ", $proName); ?></td>
                                <td><?php echo implode(", ", $quantity); ?></td>
                                <td><?php echo implode(", ", $unit); ?></td>
                                <td><?php echo implode(", ", $saleRate); ?></td>
                                <td><?php echo $totalDue [] = ($row->total_bill - $row->paid); ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right"><strong>Total</strong></td>
                                <td><?php echo f_number(array_sum($totalDue)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <?php } ?>

                            <!--  payment to company -->
                            <?php 
                              $totalpayment = array();
                              if($comPayment != NULL){?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Payment to Company</th>
                            </tr>

                            <tr>
                                <th>Trnx No </th>
                                <th>Company Name</th>
                                <th colspan="5">Particulars</th>
                                <th>Amount </th>
                            </tr>

                            <?php
                           
                            foreach ($comPayment as $key => $row) {
                            if ($row->paid > 0) {
                            ?>
                            <tr>
                                <td><?php echo $row->code; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td colspan="5"><?php echo filter($row->remark); ?></td>
                                <td><?php echo $totalpayment[] = $row->paid; ?></td>
                            </tr>
                            <?php }} ?>

                            <tr>
                                <td colspan="7" class="text-right"><strong>Total</strong></td>
                                <td><strong><?php echo f_number(array_sum($totalpayment)); ?></strong></td>
                            </tr>

                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <?php } ?>
                            
                            
                           

                            <!--  payment to employee -->
                            <?php 
                             $salary = $fields = array();
                             if($employee != NULL){?>
                            <tr><th colspan="8" class="text-center" style="font-size: 14px;">Payment to Employee</th></tr>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th colspan="5">Particulars</th>
                                <th>Amount </th>
                            </tr>
                            <?php
                            
                            foreach ($employee as $key => $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['employee_id']; ?></td>
                                <td><?php echo $row['employee_name']; ?></td>
                                <td colspan="5"><?php echo filter($row['particulars']); ?></td>
                                <td><?php echo $salary[] = $row['amount']; ?></td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="7" class="text-right">Total</td>
                                <td><?php echo f_number(array_sum($salary)); ?></td>
                            </tr>

                            <tr><td colspan="8">&nbsp;</td></tr>
                            
                            <?php } ?>
                            
                         



                            <!--  Loan Paid -->
                            <?php 
                            $paidTotal = array();
                            if($loanInfo != NULL){?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Loan Paid</th>
                            </tr>
                            <tr>
                                <th>Loan Rec. No </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th colspan="4">Particulars</th>
                                <th>Amount </th>
                            </tr>
                            <?php
                            
                            foreach ($loanInfo as $key => $row) {
                            if ($row->loan_type == "Paid") {
                            ?>
                            <tr>
                                <td><?php echo $row->id ?></td>
                                <td><?php echo filter($row->name); ?></td>
                                <td><?php echo $row->address; ?></td>
                                <td colspan="4"><?php echo v_check($row->remarks); ?></td>
                                <td><?php echo $paidTotal[] = $row->amount; ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right">Total</td>
                                <td><?php echo f_number(array_sum($paidTotal)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <?php } ?>


 			  <!-- previous Physical Cost --> 			                            
                             
                            <?php
                             $totalPrePhysicalCost = $prePhysicalCost = $totalReturnedPhysicalCost = 0.00;
                             if($return_physical_cost != NULL){
                                foreach($return_physical_cost as $row){
                                  $totalReturnedPhysicalCost += $row->return_amount;
                                }
                             }
                            
                             
                             if($pre_cash != NULL){ ?>                        
                             <tr>
                                <th colspan="4" style="font-size: 14px;" class="text-center">Previous Physical Cost:</th>
                                <th class="text-right" colspan="4" style="font-size: 14px;">
                                 <?php $totalPrePhysicalCost =  $prePhysicalCost  = ($pre_cash) ? ($pre_cash[0]->physical_cost - $totalReturnedPhysicalCost) : (0.00 - $totalReturnedPhysicalCost); 
                              	     echo f_number($prePhysicalCost );
                                  ?>
                                </th>
                               
                             </tr>
                            <?php } ?>
                            
                            

                            <?php                            
                            $costAmount = $costTotal = array();
                            $totalPhysicalCost = 0.00;
                            
                            if($allCost != NULL){
                            foreach($allCost as $key => $row){if($row->type == "physical_cost"){  $totalPhysicalCost += $row->amount; }}
                            
                            foreach ($costType as $key => $value) { ?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;"><?php echo filter($value->type); ?></th>
                            </tr>
                            <tr>
                                <th>Sl</th>
                                <th colspan="4">Particulars</th>
                                <th>Spender</th>
                                <th>Remarks</th>
                                <th>Amount </th>
                            </tr>
                            
                           
                           <?php   
                                                    
                           foreach ($allCost as $key => $row) {                            
                            if ($value->type == $row->type) {
                            ?>
                            <tr>
                                <td><?php echo $row->id; ?></td>
                                <td colspan="4"><?php echo $row->purpose; ?></td>
                                <td><?php echo $row->spender; ?></td>
                                <td><?php echo $row->remarks; ?></td>                               
                                <td><?php echo $costAmount[] = $row->amount;  $costTotal[] = $row->amount; ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right"><strong>Total</strong></td>
                                <td><strong><?php echo f_number(array_sum($costAmount)); ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <?php $costAmount = array(); } } ?>
                            
                           


                         
                        
                          <!--  deposit to bank i.e credit -->
                          <?php 
                          $bankPayment = array();
                          if($bankInfo != NULL) { ?>
                            <tr>
                                <th colspan="8" class="text-center" style="font-size: 14px;">Bank Payment</th>
                            </tr>
                            <tr>
                                <!--th>Trnx No </th-->
                                <th>Bank Name</th>
                                <th>Account No.</th>
                                <th colspan="5">Particulars</th>
                                <th>Amount </th>
                            </tr>
                            <?php
                            
                            foreach ($bankInfo as $key => $row) {
                            if ($row->transaction_type == "Credit") {
                            ?>
                            <tr>
                                <!--td><?php echo $row->id; ?></td-->
                                <td><?php echo filter($row->bank); ?></td>
                                <td><?php echo $row->account_number; ?></td>
                                <td colspan="5"><?php echo v_check($row->remarks); ?></td>
                                <td><?php echo $bankPayment[] = $row->amount; ?></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td colspan="7" class="text-right">Total</td>
                                <td><?php echo f_number(array_sum($bankPayment)); ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                        
			<?php
			$totalDebit = (array_sum($totalPaid) + array_sum($totalDue) + array_sum($transactionTotal) + array_sum($receivedtotal) +  array_sum($bankWithdraw ) + array_sum($collection) + $totalPreCash);
			
			//echo "<br/>";		
			//echo "<br/>";	
			
			
			$totalCredit = (array_sum($totalDue) + array_sum($totalpayment) + array_sum($salary) + array_sum($paidTotal) + array_sum($costTotal) + array_sum($bankPayment)); 
			
			?>
			
			
			
			
                        
                        
          <table class="table table-bordered">
            <tr>
                <th>Total Physical Cost: </th>
                <th>
                    <?php echo f_number(($totalPhysicalCost + $totalPrePhysicalCost)); ?>
                </th>
            </tr>
            
            <tr>
                <th>Balance : </th>
                <th>
                
                    <?php echo f_number(abs(($totalDebit - $totalCredit)-($totalPhysicalCost + $totalPrePhysicalCost))); ?>
                </th>
            </tr>
            
             <tr>
                <th>Total Cash Balance : </th>
                <th>
                    <?php echo f_number($totalDebit - $totalCredit); ?>
                </th>
            </tr>
        </table>
                      
                    </div>
                </div>
                
                
                
                
                <div class="row">
                	<div class="col-md-6">
                		 <table class="table table-bordered">
                            <tr>
                                <th>Total Debit : </th>
                                <th>
                                    <?php echo f_number($totalDebit); ?>
                                </th>
                            </tr>
                            
                        </table>
                	</div>
                	
                	
                	<div class="col-md-6">
                		 <table class="table table-bordered">
                            <tr>
                                <th>Total Credit : </th>
                                <th>
                                   <?php echo f_number($totalCredit + ($totalDebit - $totalCredit)); ?>
                                </th>
                            </tr>
                            
                        </table>
                	</div>
                	
                	
			<div class="col-md-12 none">
			<?php echo form_open();?>
			  <table class="table table-bordered">
			   <tr>
			      <th>Total Closing Balance:</th>
			      <th>
			         <?php 
			             //echo f_number(($totalDebit - $totalCredit) + ($totalPhysicalCost + $totalPrePhysicalCost)); 
			             echo f_number(($totalDebit - $totalCredit) + ($totalPhysicalCost)); 
			            
			            //echo f_number(($totalDebit - $totalCredit)); 
			         ?>
			      </th>
			      <th>
			        <input type="hidden" name="date" value="<?php if(isset($_POST['date'])){ echo $_POST['date']['to']; } else { echo date("Y-m-d");} ?>">
			        <!--input type="hidden" name="amount" value="<?php echo (($totalDebit - $totalCredit) + ($totalPhysicalCost + $totalPrePhysicalCost)); ?>"-->
			        <input type="hidden" name="amount" value="<?php echo (($totalDebit - $totalCredit) + ($totalPhysicalCost)); ?>">
			        <input type="hidden" name="physical_cost" value="<?php echo ($totalPhysicalCost + $totalPrePhysicalCost); ?>">
			        <input type="submit" name="close" value="Close" class="btn btn-success">
			      </th>
			   </tr>			
			  </table>
			  <?php echo form_close(); ?>
			</div>
                	
                	
                </div>
              </div>           
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>


</div>

<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });

</script>
