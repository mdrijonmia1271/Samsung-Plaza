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
                    <h1>Yearly Commission</h1>
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

<?php if($result != NULL){ ?>
 <div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Yearly Commission</h1>
                </div>

                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <h3 class="hide text-center">Yearly Expenditure <?php echo date('Y'); ?></h3>

                <span class="hide print-time text-center" style="margin-bottom: 5px;"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>
		
                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Year</th>
                        <th>Quantity (Kg)</th>
                        <th>Commission Rate (Tk/Ton)</th>
                        <th>Commission Amount (Tk)</th>
                        <th width="80">Payment</th>                        
                    </tr>
                    <?php 
                        
                    	function commissionCal($x=NULL){
                    		if($x < 101){
                    			return 0;
                    		}
                    		if($x >=101 && $x <=200){
                    			return 150;
                    		}
                    		if($x >=201&& $x <=400){
                    			return 200; 
                    		}
                    		if($x >=401 && $x <=600){
                    			return 250; 
                    		}
                    		if($x >=601 && $x <=800){
                    			return 300; 
                    		}
                    		if($x >=801 && $x <=1000){
                    			return 400; 
                    		}
                    		if($x >=1001 && $x <=1200){
                    			return 550; 
                    		}
                    		if($x >=1201 && $x <=1500){
                    			return 600; 
                    		}
                    		if($x >=1501 && $x <=2000){
                    			return 650; 
                    		}
                    		        		          		
           
                    	}                    	
                      
                    
                    ?>
                    <tr> 
                        <td>1</td>  
                        <td><strong><?php echo $_POST["search"]["year"]; ?></strong></td>
                        <td><?php echo $quantity = ($quantity) ? $quantity[0]->total_quantity : 0; ?></td>
                        <td><?php echo ($quantity) ? commissionCal($quantity/1000):0; ?></td>
                        <td> <?php echo (commissionCal($quantity/1000)*$quantity/1000); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year']                        	     
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('yearly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/yearlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($quantity/1000)*$quantity/1000)."&&year=".$_POST['search']['year']); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>                   
                    
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
        
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js" ></script>
