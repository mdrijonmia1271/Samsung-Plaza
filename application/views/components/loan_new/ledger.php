<?php 	
        
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
	$logo_data  = json_decode($meta->logo,true); 
    	
?>
<style>
    @media print{
        aside, nav, .panel-heading, .panel-footer, .none{
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
                <div class="panal-header-title">
                    <h1 class="pull-left">All Transaction</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php 
                $attr = array ('class' => 'form-horizontal');
                echo form_open('', $attr); 
                ?>
                <div class="form-group row">
                    <label class="col-md-2 control-label">Name </label>
                    <div class="col-md-5">
                        <select name="search[bank]" class="selectpicker form-control">
                            <option value="" selected disabled>&nbsp;</option>
                            <?php
                                foreach ($all as $key => $row) { ?>
                                  <option value=""></option>  
                            <?php }
                            ?>
                            
                          
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label">Account NO </label>
                    <div class="col-md-5">
                        <select name="search[account_number]" ng-model="account" class="form-control">
                            <option value="" selected disabled>&nbsp;</option>
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label">&nbsp;</label>
                    <div class="col-md-5">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Transaction</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>



          
            <!-- before -->
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
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">Loan Ledger</h3>
                </div>
                
                <!--<h3 class="text-center hide" style="margin-top: -10px;">All Bank Transaction</h3>-->

                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th> Bank Name </th>
                        <th> Account Number</th>
                        <th> Initial Balance</th>
                        <th> Total Withdraw</th>
                        <th> Total Payment</th>
                        <th> Amount </th>
                    </tr>

                   
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                   

                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>





            <!-- after -->
            <div class="panel-body">
              
                <h3 class="text-center hide" style="margin-top: -10px;">Ledger</h3>
                
                
                <table class="table table-bordered">
                    
                    <caption class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Account Number</th>
                                    <th>Initial Balance</th>
                                </tr>
                              
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                            </table>
                        </div>
                    </caption>
                    
                    
                    <tr>
                        <th> SL </th>
                        <th> Date </th>
                        <th> Transaction By </th>
                        <th> Debit </th>
                        <th> Credit </th>
                        <th> Balance </th>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                   

                    <tr>
                        <th class="text-right" colspan="3">Total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>

                </table>
            </div>
   

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
