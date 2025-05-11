<style>
   .header {
   padding: 0 15px;
   }
   .hr {
   margin: 10px -15px;
   border: 0.5px solid rgba(0, 168, 255, 1); 
   }
   .md15 {margin: 0;}
   
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
      <?php echo $this->session->flashdata('error'); ?>
      <div class="panel panel-default">
         <div class="panel-heading none">
            <h2 class="dashboard-title text-center">Welcome To <strong> <?php echo filter(get_name('godowns', 'name', ['code' => $this->data['branch']])); ?> </strong> Dashboard.</h2>
         </div>
         <div class="panel-body none">
            <!-- Today's Purchase Details -->
            <div class="row">
                
	            <div class="col-md-3">
	               <a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>" target="_blank">
    	               <div class="dash-box dash-box-2">
    	                  <span>Today's Purchase</span>
    	                  <h1><?php echo !empty($todays_purchase) ? $todays_purchase : 0; ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="<?php echo site_url('sale/searchSale/hireSale'); ?>" target="_blank">
    	               <div class="dash-box dash-box-1">
    	                    <span>Today's Sale</span>
    	                    <h1><?php echo !empty($todays_sale) ? $todays_sale : 0; ?> </h1>
    	               </div>
	                </a>
	            </div>

	            
	            
	            <div class="col-md-3">
	               <a href="<?php echo site_url('due_list/due_list/credit'); ?>" target="_blank">
    	               <div class="dash-box dash-box-3">
    	                  <span>Today's Due</span>
    	                  <h1><?php echo !empty($todays_due) ? $todays_due : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="<?php //echo site_url('purchase/purchase/show_purchase'); ?>" target="_blank">
    	               <div class="dash-box dash-box-4">
    	                  <span>Today's Paid</span>
    	                  <h1><?php echo !empty($totals_paid) ? $totals_paid : 0; ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="<?php //echo site_url('bank/bankInfo/ledger'); ?>" target="_blank">
    	               <div class="dash-box dash-box-3">
    	                  <span>Bank To TT</span>
    	                  <h1><?php echo !empty($bankToTT) ? $bankToTT : 0; ?>  </h1>
    	               </div>
    	            </a>    
	            </div>
	            

	            <div class="col-md-3">
	               <a href="<?php echo site_url('supplier/all_transaction'); ?>" target="_blank">
    	               <div class="dash-box dash-box-4">
    	                  <span>Supplier Paid</span>
    	                  <h1><?php echo !empty($supplier_paid) ? $supplier_paid : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>" target="_blank">
    	               <div class="dash-box dash-box-6">
    	                  <span>Bank Withdraw</span>
    	                  <h1><?php echo !empty($bank_withdraw) ? $bank_withdraw : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-8">
	                  <span>Cash To Bank</span>
	                  <h1><?php // if($cash_to_bank[0]->amount !== null){ echo $cash_to_bank[0]->amount;}else{echo "0";} ?> </h1>
	               </div>
	            </div-->
	            
	            
	            <div class="col-md-3">
	               <a href="<?php echo site_url('client/all_transaction'); ?>" target="_blank">
    	               <div class="dash-box dash-box-7">
    	                  <span>Client Collection</span>
    	                  <h1><?php echo !empty($client_collection) ? $client_collection : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>" target="_blank">
    	               <div class="dash-box dash-box-5">
    	                  <span>Bank Deposit</span>
    	                  <h1><?php echo !empty($bank_diposit) ? $bank_diposit : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="<?php //echo site_url('purchase/purchase/show_purchase'); ?>" target="_blank">
    	               <div class="dash-box dash-box-8">
    	                  <span>Cash To T.T</span>
    	                  <h1><?php echo !empty($cashToTT) ? $cashToTT : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="<?php echo site_url('cost/cost/allcost'); ?>" target="_blank">
    	               <div class="dash-box dash-box-12">
    	                  <span>Today's Cost</span>
    	                  <h1><?php echo !empty($total_cost) ? $total_cost : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-12">
	                  <span>Cash To Suplier</span>
	                  <h1>0.000 </h1>
	               </div>
	            </div-->


	            <div class="col-md-3">
	               <a href="<?php echo site_url('income/income/all'); ?>" target="_blank">
    	               <div class="dash-box dash-box-9">
    	                  <span>Today's Income</span>
    	                  <h1><?php echo !empty($total_income) ? $total_income : 0; + !empty($total_rent) ? $total_rent : 0; ?> </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-3">
	                  <span>Today's Sale Return</span>
	                  <h1><?php //echo $totalSaleReturn; ?></h1>
	               </div>
	            </div-->

	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-1">
	                  <span>Bank To Cash</span>
	                  <h1><?php //if($bank_to_cash[0]->amount !== null){ echo $bank_to_cash[0]->amount;}else{echo "0";} ?> </h1>
	               </div>
	            </div-->
	            
	            
	            <!--div class="col-md-3">
	               <div class="dash-box dash-box-5">
	                  <span>Today's Purchase Return</span>
	                  <h1>0.000</h1>
	               </div>
	            </div-->
	            <?php
	            /*$return_amount = 0.00;
	            foreach($sale_return  as $row){
	            $return_amount += $row->return_amount;
	            }*/
	            ?>
            </div>
        </div>
         
        
        
        <div id='printMe'>
            <div class="col-md-offset-2 col-md-8">
            	<table class="table table-bordered table-hover">
            	    <tr>
            	        <th colspan="7" class="text-center text-primary">Today Installment's List
            	        <a class="btn btn-primery pull-right none" style="font-size: 14px; margin-top: -10px;" id="printBtn" onclick="printDiv('printMe')"><i class="fa fa-print"></i> Print</a></th>
            	    </tr>
            	    <tr>
            	        <th width="45px">SL</th>
            	        <th>Name</th>
            	        <th>Customer Id</th>
            	        <th>Mobile</th>
            	        <th>Address</th>
            	        <th>Amount</th>
            	        <th>Due</th>
					</tr>
            	    <?php if(!empty($todaysInstallment)) { foreach($todaysInstallment as $key => $value){ ?>
            	    <tr>
            	        <td><?php echo $key+1; ?></td>
            	        <td><?php echo filter($value->name); ?></td>
            	        <td><?php echo $value->party_code; ?></td>
            	        <td><a href="tel:<?php echo $value->mobile;?>"><?php echo $value->mobile;?></a></td>
            	        <td><?php echo $value->address;?></td>
            	        <td><?php echo f_number($value->installment_amount); ?></td>
                        <td>
                            <?php 
                                 $credit = get_sum('partytransaction', 'credit', ['trash' => 0,'party_code' => $value->party_code ]);
                                 $debit = get_sum('partytransaction', 'debit', ['trash' => 0,'party_code' => $value->party_code ]);
                                 $previous_balance = get_name('parties','initial_balance',['trash' => 0,'code' => $value->party_code]);
                                 $due = ($debit + $previous_balance) - $credit;
                                 echo number_format($due,2);
                            ?>
                        </td>            	        
            	    </tr>
            	    <?php } } ?>
            	</table>
            </div>
        </div>
         
         
        <div id='printMe2'>
            <div class="col-md-offset-2 col-md-8">
            	<table class="table table-bordered table-hover">
            	    <tr>
            	        <th colspan="7" class="text-center text-primary">Today Commitment's List
            	        <a class="btn btn-primery pull-right none" style="font-size: 14px; margin-top: -10px;" id="printBtn2" onclick="printDiv2('printMe2')"><i class="fa fa-print"></i> Print</a></th>
            	    </tr>
            	    <tr>
            	        <th width="45px">SL</th>
            	        <th>Name</th>
            	        <th>Customer Id</th>
            	        <th>Mobile</th>
            	        <th>Commitment</th>
            	        <th>Address</th>
            	        <th>Due</th>            	        
            	    </tr>
            	    
            	    <?php foreach($todaysCommitment as $key => $comm_value){ ?>
            	    <tr>
            	        <td><?php echo $key+1;?></td>
            	        <td><?php echo  filter($comm_value->name); ?></td>
            	        <td><?php echo $comm_value->party_code;?></td>
            	        <td><a href="tel:<?php echo $comm_value->mobile;?>"><?php echo $comm_value->mobile;?></a></td>
            	        <td><?php echo $comm_value->commitment;?></td>
            	        <td><?php echo $comm_value->address;?></td>
                        <td>
                            <?php 
                            $debit = $credit = $remission = $currentBalance = 0;
                            $where = ['party_code' => $comm_value->party_code, 'trash' => 0];
                            $tranInfo = get_result('partytransaction', $where, ['debit', 'credit', 'remission']);
                            
                            if(!empty($tranInfo)){
                                
                                foreach($tranInfo as $value){
                                    $debit += $value->debit;
                                    $credit += $value->credit;
                                    $remission += $value->remission;
                                }
                              
                                if($comm_value->initial_balance < 0){
                                    $currentBalance = $debit - (abs($comm_value->initial_balance) + $credit + $remission);
                                }else{
                                    $currentBalance = ($comm_value->initial_balance + $debit) - ($credit + $remission);
                                }
                                
                                //$status = ($currentBalance < 0) ? " Payable" : " Receivable";   
                                $status = ($currentBalance < 0) ? " - " : " ";   
                                
                            }else{
                                
                                $currentBalance = abs($comm_value->initial_balance);
                                //$status = ($currentBalance->initial_balance < 0) ? " Payable" : " Receivable";
                                $status = ($comm_value->initial_balance < 0) ? " - " : " ";
                            }
                           
                            echo $status . number_format($currentBalance, 2);
                            ?>
                        </td>             	        
            	    </tr>
            	    <?php } ?>
            	</table>
            </div>
        </div>
         
         
        <div class="row">
            <div id="chart-container">
            	&nbsp;
            </div>
        </div>
        <div class="panel-footer">&nbsp;</div>
      </div>
   </div>
</div>
</div>
</div>
<!-- /#page-content-wrapper -->

<!-- PIE CHART -->
<!-- <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Browser', 'Number']]);

        var options = {
            title       : '',
            is3D        : true,
            'width'     : 450,
            'height'    : 400,
            'chartArea' : {'width': '100%', 'height': '80%'},
            'legend'    : {'position': 'bottom'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script> -->

<!-- PIE CHART 2 -->
<!-- <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Device', 'Number']]);

        var options = {
            title       : '',
            is3D        : true,
            'width'     : 450,
            'height'    : 400,
            'chartArea' : {'width': '100%', 'height': '80%'},
            'legend'    : {'position': 'bottom'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d2'));
        chart.draw(data, options);
    }
</script> -->


<script>
function printDiv(divName){
    var printBtn = document.getElementById('printBtn').style.display = 'none';
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	window.location.reload(true);
	document.body.innerHTML = originalContents;
}
function printDiv2(divName2){
    var printBtn2 = document.getElementById('printBtn2').style.display = 'none';
	var printContents2 = document.getElementById(divName2).innerHTML;
	var originalContents2 = document.body.innerHTML;
	document.body.innerHTML = printContents2;
	window.print();
	window.location.reload(true);
	document.body.innerHTML = originalContents2;
}
</script>
