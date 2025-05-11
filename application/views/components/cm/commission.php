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
            width: 0%;
        }
        .hide{
            display: block !important;
        }
        .block-hide{
            display: none;
        }
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
                    <h1>Monthly Commission</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Year <span class="req">*</span></label>
                        <div class="col-md-7">
                            <select name="search[year]" class="form-control" required>
                               <?php  for($start=2016;$start<=date('Y');$start++) { ?>
                                <option <?php if($start==date('Y')){echo"selected ";} ?>  value="<?php echo $start; ?>"><?php echo $start; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Client Name <span class="req">*</span></label>
                        <div class="col-md-7">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
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

<?php if($result){ ?>
 <div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Monthly Commission</h1>
                </div>

                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <h3 class="hide text-center">Yearly Expenditure <?php echo date('Y'); ?></h3>

                <span class="hide print-time text-center" style="margin-bottom: 5px;"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>
		
                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Month</th>
                        <th>Quantity (Kg)</th>
                        <th>Commission Rate (Tk/Ton)</th>
                        <th>Commission Amount (Tk)</th>
                        <th width="80" class="none">Payment</th>                        
                    </tr>
                    <?php 
                        
                    	function commissionCal($x=NULL){
                    		if($x < 10){
                    			return 0;
                    		}
                    		if($x >=10 && $x <=25){
                    			return 200;
                    		}
                    		if($x >=26 && $x <=40){
                    			return 250; 
                    		}
                    		if($x >=41 && $x <=60){
                    			return 300; 
                    		}
                    		if($x >=61 && $x <=80){
                    			return 350; 
                    		}
                    		if($x >=81 && $x <=100){
                    			return 400; 
                    		}
                    		if($x >=101 && $x <=130){
                    			return 500; 
                    		}
                    		if($x >=131 && $x <=160){
                    			return 600; 
                    		}
                    		if($x >=161 && $x <=200){
                    			return 650; 
                    		}
                    		if($x >=200){
                    			return 700; 
                    		}          		          		
           
                    	}                    	
                      
                    
                    ?>
                    <tr> 
                        <td>1</td>  
                        <td><strong>January</strong></td>
                        <td><?php echo $january = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"01",$_POST['search']['party_code']) : 0;  ?></td>
                        <td><?php echo commissionCal($january/1000)? commissionCal(($january)/1000):0; ?></td>
                        <td> <?php echo (commissionCal($january/1000)*$january/1000); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "01"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($january/1000)*$january/1000)."&&year=".$_POST['search']['year']."&&month=01"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>2</td>  
                        <td><strong>February</strong></td>
                        <td><?php echo $February =(isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"02",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($February/1000)?commissionCal(($February)/1000):0; ?></td>
                        <td> <?php echo commissionCal($February/1000)*$February/1000; ?></td>
                         <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "02"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($February/1000)*$February/1000)."&&year=".$_POST['search']['year']."&&month=02"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>3</td>  
                        <td><strong>March</strong></td>
                        <td><?php echo $March = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"03",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($March/1000)?commissionCal(($March)/1000):0; ?></td>
                        <td> <?php echo commissionCal($March/1000)*$March/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "03"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($March /1000)*$March /1000)."&&year=".$_POST['search']['year']."&&month=03"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>4</td>  
                        <td><strong>April</strong></td>
                        <td><?php echo $April = (isset($_POST['search'])) ?  getSaleQuantity($_POST['search']['year'],"04",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($April/1000)?commissionCal(($April)/1000):0; ?></td>
                        <td> <?php echo commissionCal($April/1000)*$April/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "04"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($April /1000)*$April /1000)."&&year=".$_POST['search']['year']."&&month=04"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>5</td>  
                        <td><strong>May</strong></td>
                        <td><?php echo $May = (isset($_POST['search'])) ?  getSaleQuantity($_POST['search']['year'],"05",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($May/1000)?commissionCal(($May)/1000):0; ?></td>
                        <td> <?php echo commissionCal($May/1000)*$May/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "05"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($May /1000)*$May /1000)."&&year=".$_POST['search']['year']."&&month=05"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>6</td>  
                        <td><strong>June</strong></td>
                        <td><?php echo $June = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"06",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($June/1000)?commissionCal(($June)/1000):0; ?></td>
                        <td> <?php echo commissionCal($June/1000)*$June/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "06"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($June /1000)*$June /1000)."&&year=".$_POST['search']['year']."&&month=06"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>7</td>  
                        <td><strong>July</strong></td>
                        <td><?php echo $July = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"07",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($July/1000)?commissionCal(($July)/1000):0; ?></td>
                        <td> <?php echo commissionCal($July/1000)*$July/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "07"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($July /1000)*$July /1000)."&&year=".$_POST['search']['year']."&&month=07"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>8</td>  
                        <td><strong>August</strong></td>
                        <td><?php echo $August = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"08",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($August/1000)?commissionCal(($August)/1000):0; ?></td>
                        <td> <?php echo commissionCal($August/1000)*$August/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "08"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($August /1000)*$August /1000)."&&year=".$_POST['search']['year']."&&month=08"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>9</td>  
                        <td><strong>September</strong></td>
                        <td><?php echo $September = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"09",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($September/1000)?commissionCal(($September)/1000):0; ?></td>
                        <td> <?php echo commissionCal($September/1000)*$September/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "09"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($September /1000)*$September /1000)."&&year=".$_POST['search']['year']."&&month=09"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>10</td>  
                        <td><strong>October</strong></td>
                        <td><?php echo $October = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"10",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($October/1000)?commissionCal(($October)/1000):0; ?></td>
                        <td> <?php echo commissionCal($October/1000)*$October/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "10"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($October /1000)*$October /1000)."&&year=".$_POST['search']['year']."&&month=10"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>11</td>  
                        <td><strong>November</strong></td>
                        <td><?php echo $November = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"11",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($November/1000)?commissionCal(($November)/1000):0; ?></td>
                        <td> <?php echo commissionCal($November/1000)*$November/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "11"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($November /1000)*$November /1000)."&&year=".$_POST['search']['year']."&&month=11"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>12</td>  
                        <td><strong>December</strong></td>
                        <td><?php echo $December = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"12",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php echo commissionCal($December/1000)?commissionCal(($December)/1000):0; ?></td>
                        <td> <?php echo commissionCal($December/1000)*$December/1000; ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "12"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($December /1000)*$December /1000)."&&year=".$_POST['search']['year']."&&month=12"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <?php
                        $totalQ = 0.00;
                        
                        $totalQ = $january + $February + $March + $April + $May + $June + $July + $August + $September + $October + $November + $December ; 
                    
                    ?>
                        
                    <tr>
                        <th></th>
                        <th><span class="pull-right">Total</span></th>
                        <th colspan="3"><?php echo $totalQ; ?> Kg</th>
                        <th class="none"></th>
                    </tr>
                    
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
        
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js" ></script>
