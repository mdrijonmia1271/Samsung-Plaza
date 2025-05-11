<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
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
            <h2 class="dashboard-title text-center">Overall Report</h2>
         </div>
         <div class="panel-body none">
             
            <!-- Today's Purchase Details -->
            <div class="row">
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>

                <div class="col-md-3">
                    <div class="input-group date" id="datetimepickerSMSFrom">
                        <input type="text" name="date_from" class="form-control"  placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group date" id="datetimepickerSMSTo">
                        <input type="text" name="date_to" class="form-control"   placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                
                 <div class="col-md-3">
                    <select name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                        <option value="" selected disabled>-- Select Showroom --</option>
                        <option value="all">All Showroom</option>
                        <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                        <option value="<?php echo $row->code; ?>" <?php  if($this->data['branch'] == $row->code){  echo 'selected'; } ?>>
                            <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                        </option>
                        <?php } } ?>
                    </select>
                </div>
                
                
                <div class="col-md-2">
                    <input type="submit" value="Search" name="show" class="btn btn-primary">
                </div>
                
                <?php echo form_close(); ?>
            </div>
            <hr> <br>
            
            
            
            
            
            <div class="row">
                
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-1">
    	                  <span>Sales</span>
    	                  <h1><?php if(!empty($total_sale)){  echo $total_sale; }else{ echo '0'; }  ?></h1>
    	               </div>
	               </a>
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-2">
    	                    <span>Sale's Return</span>
    	                    <h1><?php if(!empty($total_sale_return)){  echo $total_sale_return; }else{ echo '0'; }  ?></h1>
    	               </div>
	                </a>
	            </div>

	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-3">
    	                  <span>Purchase</span>
    	                  <h1><?php if(!empty($total_purchase)){  echo $total_purchase; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-4">
    	                  <span>Purchase Return</span>
    	                  <h1><?php if(!empty($total_purchase_return)){  echo $total_purchase_return; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-5">
    	                  <span>Voucher Collection</span>
    	                  <h1><?php if(!empty($total_voucher_collection)){  echo   $total_voucher_collection; }else{ echo '0';  }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-6">
    	                  <span>Retail Collection</span>
    	                  <h1><?php if(!empty($total_retail_collection[0]->paid)){  echo $total_retail_collection[0]->paid; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <!--<div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-5">
    	                  <span>Installment Collection</span>
    	                  <h1><?php if(!empty($total_installment_collection)){  echo $total_installment_collection[0]->total_installment; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>-->
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-7">
    	                  <span>Transaction Collection</span>
    	                  <h1><?php if(!empty($total_transaction_collection)){  echo $total_transaction_collection[0]->total_transaction; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-8">
    	                  <span>Total Client Collection</span>
    	                  <h1>
    	                        <?php  
    	                           if(!empty($total_retail_collection[0]->paid)){
    	                               $total_retail_collection = $total_retail_collection[0]->paid;
    	                           }else{
    	                               $total_retail_collection = 0;
    	                           }
    	                           
    	                           if(!empty($total_transaction_collection[0]->paid)){
    	                               $total_transaction_collection = $total_transaction_collection[0]->paid;
    	                           }else{
    	                               $total_transaction_collection = 0;
    	                           }
    	                           
    	                          
    	                            echo $total_collection = $total_voucher_collection+$total_retail_collection+$total_transaction_collection;
    	                       ?>
    	                   </h1>
    	               </div>
    	            </a>    
	            </div>
	            

	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-9">
    	                  <span>Client Due</span>
    	                  <h1><?php echo $total_sale - $total_collection;  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-1">
    	                  <span>Supplier Payment</span>
    	                  <h1><?php if(!empty($total_supplier_payment)){  echo $total_supplier_payment; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-2">
    	                  <span>Supplier Due</span>
    	                  <h1><?php echo $total_purchase - $total_supplier_payment;  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-3">
    	                  <span>General Income</span>
    	                  <h1><?php if(!empty($total_income)){  echo $total_income; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-4">
    	                  <span>Cost</span>
    	                  <h1><?php if(!empty($total_cost)){  echo $total_cost; }else{ echo '0'; }  ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-5">
    	                  <span>Remission</span>
    	                  <h1><?php if(!empty($total_remission)){ echo $total_remission; }else{ echo '0'; } ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-6">
    	                  <span>Comission</span>
    	                  <h1><?php if(!empty($total_comission)){ echo $total_comission; }else{ echo '0'; } ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-7">
    	                  <span>Present Stock</span>
    	                  <h1><?php if(!empty($total_stock_value)){ echo $total_stock_value; }else{ echo '0'; } ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            

	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-8">
    	                  <span>Bank Balance</span>
    	                  <h1><h1><?php if(!empty($total_bank_balance)){ echo $total_bank_balance; }else{ echo '0'; } ?></h1></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-9">
    	                  <span>Fixed Assets</span>
    	                  <h1>
    	                    <?php
    	                        if(!empty($total_fixed_asset_val)){
    	                            $total_fixed_asset = 0;
    	                            foreach($total_fixed_asset_val as $value_amount){
    	                                $total_fixed_asset += $value_amount->amount*$value_amount->quantity;
    	                            }
    	                            echo $total_fixed_asset;
    	                        }else{
    	                            echo 0;
    	                        }
    	                    ?>
    	                  </h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-1">
    	                  <span>Sales Profit</span>
    	                  <h1><?php echo $calculate_profit_loss; ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-2">
    	                  <span>Net Profit</span>
    	                  <h1><?php echo number_format($calculate_profit_loss+$total_income-$total_cost,2); ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-3">
    	                  <span>Cash In Hand</span>
    	                  <h1><?php if(!empty($total_cash_in_hand)){ echo $total_cash_in_hand; }else{ echo '0'; } ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-4">
    	                  <span>Total Clients</span>
    	                  <h1><?php echo $total_client; ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-5">
    	                  <span>Total Product</span>
    	                  <h1><?php echo $total_product; ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	            
	            <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-6">
    	                  <span>Total Purchase Invoice</span>
    	                  <h1><?php echo $total_purchase_invoice; ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
	             <div class="col-md-3">
	               <a href="" target="_blank">
    	               <div class="dash-box dash-box-7">
    	                  <span>Total Sale Invoice</span>
    	                  <h1><?php echo $total_sale_invoice; ?></h1>
    	               </div>
    	            </a>    
	            </div>
	            
	            
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

