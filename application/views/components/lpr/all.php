<?php 	
        
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
	$logo_data  = json_decode($meta->logo,true); 
    	
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
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
    .action-btn a{
        margin-right: 0;
        margin: 3px 0;
    }
</style>

<div class="container-fluid" >
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Search LPR</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open_multipart('', $attr); ?>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Customer</label>
                    <div class="col-md-4">
                        <select name="party_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>---Select---</option>
                            <?php foreach($allClients as $value){ ?>
                            <option value="<?php echo $value->party_code; ?>"><?php echo $value->party_name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" name="search" value="Search" class="btn btn-primary">
                    </div>
                </div>
                

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
        
    	<div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All LPR</h1>
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

                <!--<h4 class="text-center hide" style="margin-top: 0px;">All LPR</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">All LPR</h3>
                </div>


                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>LPR ID</th>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Sale Date</th>
                        <th>LPR Date</th>
                        <th width="110">Action</th>
                    </tr>
                    <?php
                        $total = 0.0;
                    foreach($results as $key => $value){ ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->lpr_code;?></td>
                        <td><?php echo $value->party_code;?></td>
                        <td><?php echo $value->party_name; ?></td>
                        <td><?php echo $value->payment; $total += $value->payment; ?></td>
                        <td></td>
                        <td><?php echo $value->date ;?></td>
                        <td class="none">
                            <a title="View" class="btn btn-primary" href="<?php echo site_url('lpr/lpr/view/'.$value->id); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            
                            <!--<a title="Edit" class="btn btn-warning" href="<?php echo site_url('lpr/lpr/edit'); ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>-->
                            
                            <a onclick="return confirm('Are you sure want to delete this Record?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('lpr/lpr/delete/'.$value->id); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>     
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" style="font-weight: 800; text-align: right">Total</td>
                        <td><?php echo f_number($total);?></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>