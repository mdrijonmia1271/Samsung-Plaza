
    	
<style>
    @media print{
    aside{display: none !important;}
    nav{display: none;}
    .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
    .none{display: none;}
    .panel-heading{display: none;}
    .panel-footer{display: none;}
    .panel .hide{display: block !important;}
    .title{font-size: 25px;}
    table tr th,table tr td{font-size: 12px;}
    .print_banner_logo {width: 19%;float: left;}
    .print_banner_logo img {margin-top: 10px;}
	.print_banner_text {width: 80%; float: right;text-align: center;}
	.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
	.print_banner_text p {margin-bottom: 5px !important;}
	.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .table tr th {width: 22%;}
    .ml{
        margin-left: 8px;
    }
    .width-sl{
        width: 10px!important;
    }
    .width-cm{
        width: 50%!important;
    }
</style>
<div class="container-fluid" >
  <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panal-header-title">
          <h1 class="pull-left">Profile</h1>
          <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
      <div class="panel-body" ng-cloak>
                      <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->        
        <!--<h4 class="text-center hide" style="margin-top: 0px;">Profile</h4>-->
        <div class="col-md-12 text-center hide">
            <h3>Customer Profile</h3>
        </div>
        <table class="table table-bordered table-hover">
            
            <img style="width: 150px; margin: 10px; padding: 5px; border: 1px solid #ccc;" src="<?php echo site_url($partyInfo->path); ?>">
          
          <tr>
            <th>Customer Name</th>
            <td><?php echo filter($partyInfo->name); ?></td>
            
            <th>Opening Date</th>
            <td><?php echo $partyInfo->opening; ?></td>
          </tr>
          
          <tr>
            <th>Customer Code</th>
            <td><?php echo $partyInfo->code; ?></td>
            
            <th>ID Card No.</th>
            <td><?php echo $partyInfo->id_card; ?></td>
          </tr>
          
          <tr>
            <th>Contact Person</th>
            <td><?php echo filter($partyInfo->contact_person); ?></td>
            
            <th>Initial Balance </th>
            <td>
              <?php
              $init_balance = $partyInfo->initial_balance;
              //$status = ($init_balance < 0) ? " Payable" : " Receivable";
              $status = ($init_balance < 0) ? " - " : " ";
              echo  $status . abs($init_balance);
              ?>
            </td>
          </tr>
          
          <tr>
            <th>Mobile Number</th>
            <td><?php echo $partyInfo->mobile; ?></td>
            
            <th>Current Balance </th>
            <td>
              <?php
              
                $debit = $credit = $remission = $currentBalance = 0;
                $where = ['party_code' => $partyInfo->code, 'trash' => 0];
                $tranInfo = get_result('partytransaction', $where, ['debit', 'credit', 'remission']);
              
                if(!empty($tranInfo)){
                    
                    foreach($tranInfo as $value){
                        $debit += $value->debit;
                        $credit += $value->credit;
                        $remission += $value->remission;
                    }
                  
                    if($partyInfo->initial_balance < 0){
                        $currentBalance = $debit - (abs($partyInfo->initial_balance) + $credit + $remission);
                    }else{
                        $currentBalance = ($partyInfo->initial_balance + $debit) - ($credit + $remission);
                    }
                    
                    //$status = ($currentBalance < 0) ? " Payable" : " Receivable";   
                    $status = ($currentBalance < 0) ? " - " : " ";   
                    
                }else{
                    
                    $currentBalance = abs($partyInfo->initial_balance);
                    //$status = ($partyInfo->initial_balance < 0) ? " Payable" : " Receivable";
                    $status = ($partyInfo->initial_balance < 0) ? " - " : " ";
                }
             
              echo $status . abs($currentBalance) . ' TK';
              ?>
            </td>
          </tr>
          
          <tr>
            <th>Address</th>
            <td><?php echo filter($partyInfo->address); ?></td>
            
            <th>Status</th>
            <td colspan="3"><?php echo filter($partyInfo->status);?></td>
          </tr>
          <?php if($partyInfo->customer_type != 'dealer'){ ?>
          <tr>
            <!--<th>Credit Limit </th>
            <td><?php echo $partyInfo->credit_limit;?> TK</td>-->
            
            <th>1<sup>st</sup> Guarantor</th>
            <td>
                <?php echo filter($partyInfo->guarantor_name); ?>
                <br>
                <?php echo filter($partyInfo->guarantor_mobile); ?>
                <br>
                <?php echo filter($partyInfo->guarantor_address); ?>
            </td>
            <th>2<sup>nd</sup> Guarantor</th>
            <td>
                <?php echo filter($partyInfo->guarantor_name2); ?>
                <br>
                <?php echo filter($partyInfo->guarantor_mobile2); ?>
                <br>
                <?php echo filter($partyInfo->guarantor_address2); ?>
            </td>
          </tr>
          <?php } ?>
          <tr>
              <th>Customer Type</th>
              <td><?php echo filter($partyInfo->customer_type);?></td>
              <th>Showroom</th>
              <td><?php echo filter($partyInfo->godown_name);?></td>
          </tr>
          
          <tr>
            <th>Fathers Name Code</th>
            <td><?php echo get_name('parties','father_name',['code'=>$partyInfo->code]); ?></td>
            
            <th>Brand</th>
            <td><?php echo $partyInfo->brand; ?></td>
          </tr>
          
        </table>
      </div>
      <div class="panel-footer">&nbsp;</div>
    </div>
    
     
     <!--Sale-->
        
     <!--End Sale-->
     
     
    <!--Commitment-->
    <?php if(!empty($commitments)) { ?>
    <div class="panel panel-default none">
      <div class="panel-heading">
        <div class="panal-header-title">
          <h1 class="pull-left">Commitments</h1>
        </div>
      </div>
      
      <div class="panel-body">
          <table class="table table-bordered">
              <tr>
                    <th class="width-sl">SL</th>
                    <th>Customer Name </th>
                    <th>Date </th>
                    <th>Mobile </th>
                    <th class="width-cm">Commitment </th>
                    <th>Address </th>
                </tr>
                <?php
                    foreach ($commitments as $key => $commitment) {
                ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $partyInfo->name; ?></td>
                    <td><?php echo filter($commitment->date); ?></td>
                    <td><?php echo $partyInfo->mobile; ?></td>
                    <td width="40%"><?php echo $commitment->commitment; ?></td>
                    <td><?php echo $partyInfo->address; ?></td>
                </tr>
                <?php } ?>
          </table>
      </div>
      <div class="panel-footer">&nbsp;</div>
     </div>
     <?php } ?>
     <!--End Commitment-->
     
     <div class="row ml none">
         <a class="btn btn-success" href="<?php echo site_url('/sale/searchSale/customer/'.$partyInfo->code); ?>" target="_blank">View Sale</a>
         <a class="btn btn-danger" href="<?php echo site_url('/ledger/clientLedger/customer/'.$partyInfo->code); ?>" target="_blank">View Ledger</a>
     </div>
     
     <div>
         &nbsp;
     </div>
  </div>
</div>