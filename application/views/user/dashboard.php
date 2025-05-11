<style>
   .header {
   padding: 0 15px;
   }
   .hr {
   margin: 10px -15px;
   border: 0.5px solid rgba(0, 168, 255, 1);
   }
   .md15 {margin: 0;} 
</style>
<div class="container-fluid">
   <div class="row">
      <?php echo $this->session->flashdata('error'); ?>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h2 class="dashboard-title text-center" >Welcome To <strong> <?php echo filter(get_name('godowns', 'name', ['code' => $this->data['branch']])); ?> </strong> Dashboard.</h2>
         </div>
         <div class="panel-body">
            <!-- Today's Purchase Details -->
            <div class="row">
                
                <?php if(ck_action("dashboard","todays_purchase")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-2">
	                  <span>Today's Purchase</span>
	                  <h1><?php echo !empty($todays_purchase) ? $todays_purchase : 0; ?></h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
	            <?php if(ck_action("dashboard","todays_hire_sale")){ ?>
	            <div class="col-md-3">
	               <a href="<?php echo site_url('sale/searchSale/hireSale'); ?>" target="_blank">
    	               <div class="dash-box dash-box-1">
    	                    <span>Today's Sale</span>
    	                    <h1><?php echo !empty($todays_sale) ? $todays_sale : 0; ?> </h1>
    	               </div>
	                </a>
	            </div>
	            <?php } ?>
	            
	            
	            <?php /* if(ck_action("dashboard","todays_sale")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-1">
	                  <span>Today's Sale</span>
	                  <h1><?php if($total_sale[0]->total_bill !==null ){echo $total_sale[0]->total_bill;}else{ echo "0"; } ?></h1>
	               </div>
	            </div>
	            <?php } */ ?>
	            
	            
	            <?php if(ck_action("dashboard","todays_due")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-3">
	                  <span>Today's Due</span>
	                  <h1><?php echo !empty($todays_due) ? $todays_due : 0; ?> </h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
	            <?php if(ck_action("dashboard","todays_total_paid")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-4">
	                  <span>Today's Paid</span>
	                  <h1><?php echo !empty($totals_paid) ? $totals_paid : 0; ?></h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
	            <?php if(ck_action("dashboard","bank_to_tt")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-3">
	                  <span>Bank To TT</span>
	                  <h1><?php echo !empty($bankToTT) ? $bankToTT : 0; ?>  </h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
                <?php if(ck_action("dashboard","supplier_paid")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-4">
	                  <span>Supplier Paid</span>
	                  <h1><?php echo !empty($supplier_paid) ? $supplier_paid : 0; ?> </h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
	            <?php if(ck_action("dashboard","bank_withdraw")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-6">
	                  <span>Bank Withdraw</span>
	                  <h1><?php echo !empty($bank_withdraw) ? $bank_withdraw : 0; ?> </h1>
	               </div>
	            </div>
	            <?php } ?>
	            

	            <?php if(ck_action("dashboard","client_collection")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-7">
	                  <span>Client Collection</span>
	                  <h1><?php echo !empty($client_collection) ? $client_collection : 0; ?> </h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
	            <?php if(ck_action("dashboard","bank_deposit")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-5">
	                  <span>Bank Deposit</span>
	                  <h1><?php echo !empty($bank_diposit) ? $bank_diposit : 0; ?> </h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
	            <?php if(ck_action("dashboard","cash_to_tt")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-8">
	                  <span>Cash To T.T</span>
	                  <h1><?php echo !empty($cashToTT) ? $cashToTT : 0; ?> </h1>
	               </div>
	            </div>
	            <?php } ?>
	            
	            
	            <?php if(ck_action("dashboard","todays_cost")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-12">
	                  <span>Today's Cost</span>
	                  <h1><?php echo !empty($total_cost) ? $total_cost : 0; ?> </h1>
	               </div>
	            </div>
                <?php } ?>
                

                <?php if(ck_action("dashboard","todays_income")){ ?>
	            <div class="col-md-3">
	               <div class="dash-box dash-box-9">
	                  <span>Today's Income</span>
	                  <h1><?php echo !empty($total_income) ? $total_income : 0; + !empty($total_rent) ? $total_rent : 0; ?> </h1>
	               </div>
	            </div>
	            <?php } ?>
	            
            </div>
        </div>
        
        
        <?php if(ck_action("dashboard","todays_installment_list")){ ?>
        <div class="none">
            <div class="col-md-offset-2 col-md-6">
            	<table class="table table-bordered table-hover">
            	    <tr>
            	        <th colspan="7" class="text-center text-primary">Today Installment's List</th>
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
                                 $due = $credit - $debit + $previous_balance;
                                 echo number_format($due,2);
                            ?>
                        </td>            	        
            	    </tr>
            	    <?php } } ?>
            	</table>
            </div>
        </div>
        <?php } ?>
         
         
        <?php if(ck_action("dashboard","todays_commitment_list")){ ?>
        <div>
            <div class="col-md-offset-2 col-md-6">
            	<table class="table table-bordered table-hover">
            	    <tr>
            	        <th colspan="7" class="text-center text-primary">Today Commitment's List
            	        <a class="btn btn-primery pull-right none" style="font-size: 14px; margin-top: -10px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a></th>
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
        <?php } ?>
        
        
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
