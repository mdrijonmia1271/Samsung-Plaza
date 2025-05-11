<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
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
        .block-hide{
            display: none;
        }
    }
    a.disabled {
   pointer-events: none;
   cursor: default;
}
</style>

<div class="container-fluid block-hide">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
    $attribute = array(
        'name' => '',
        'class' => 'form-horizontal',
        'id' => ''
    );
    echo form_open_multipart('', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Year <span class="req">*</span></label>
                        <div class="col-md-7">
                            <select name="search[sap_at]" class="form-control" required>
                                <?php  for($start=2016;$start<=date('Y');$start++) { ?>
                                <option <?php if($start==date('Y')){echo"selected ";} ?>  value="<?php echo $start; ?>"><?php echo $start; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Client Name</label>
                        <div class="col-md-7">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>&nbsp;</option>
                                <?php foreach ($clientInfo as $key => $value) { ?>
                                 <option value="<?php echo $value->code;?>"><?php echo $value->name;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-primary" type="submit" name="show" value="Show">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
<?php if($result != NULL) { ?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Sale Commission</h1>
                </div>
                <?php if($totalCommission != NULL || $totalPaid != NULL || $totalDue != NULL){ ?>
                 <div class="panal-header-title" style="margin-top: 0px; text-align:center;">
                    <h1>
                    Commission : 
                    <?php printf("%.2f",$totalCommission);?> TK&nbsp;&nbsp;&nbsp;Paid : <?php printf("%.2f",$totalPaid);?>TK&nbsp;&nbsp;&nbsp;Due : <?php printf("%.2f",$totalDue);?>TK
                    </h1>
                </div> 
                <?php } ?>              
                 <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>"> 
                <h3 width="100%" class="hide text-center">Sale Commission <?php echo date('Y'); ?></h3>
		<hr class="hide">
                <table  width="100%"  class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Voucher No</th>
                        <th>Amount </th>
                        <th>Paid Commission </th>
                        <th>Remain Commission </th>
                        <th width="80" class="none">Payment</th>                        
                    </tr>
                    <?php $total = $totalPaidCom = $totalRemainCom = 0.00; foreach($result as $key=>$value){ 
                    
                    $total += $value->total_bill; 
                    $totalPaidCom += $value->total_discount;
                    
                    $remainPercent = 0;
                    $remainCom = 0.00;
                    
                    ?>
                    <tr> 
                        <td><?php echo ($key+1); ?></td>  
                        <td><?php echo $value->sap_at;?></td> 
                        <td>
                          <?php 
                              $partyInfo = $this->action->read('parties', array("code" => $value->party_code));
                              echo ($partyInfo) ? filter($partyInfo[0]->name) : "";
                          ?>
                         </td>
                        <td><?php echo $value->voucher_no;?></td>
                        <td><?php echo $value->total_bill;?></td>
                        <td><?php echo $value->total_discount;?></td>
                        
                        
                        <?php
                            // Calculate Remaining commission
                            $where = array("meta_key"=> "remaining_commission", "voucher_no" => $value->voucher_no);
                            $sapmetaInfo = $this->action->read("sapmeta",$where);
                            $remainPercent = $sapmetaInfo[0]->meta_value;
                            
                            $totalAmount = $value->total_bill + $value->total_discount;
                            $remainCom = ($totalAmount * $remainPercent) / 100;
                        
                        ?>
                        <td><?php echo $remainCom;?></td>
                        
                        <td class="none text-center">
                        	<?php 
                        	   $commissionInfo = $this->action->read('sapmeta', array('voucher_no'=>$value->voucher_no,'meta_key'=>'saleCommission'));
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php } else { ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/salePaid?id='.$value->id."&&amount=".$value->total_bill*0.02); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <?php
                    
                    $totalRemainCom += $remainCom;
                    
                    }?>
                    
                    <tr>
                    	<td colspan="4" class="text-right"><strong>Total</strong></td>
                    	<td><strong><?php printf("%.2f",$total);?> Tk</strong></td>
                    	<td ><strong><?php printf("%.2f",$totalPaidCom); ?> TK</strong></td>
                    	<td ><strong><?php printf("%.2f",$totalRemainCom); ?> TK</strong></td>
                    	<td class="none">&nbsp;</td>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js" ></script>
