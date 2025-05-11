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
        .emp-photo img:last-child{
            margin-top: 90px;
            width: 150px;
            margin-right: 0;
            right: 0;
        }
    }
    .emp-photo{
            position: relative;
    }
    .emp-photo img:last-child{
        position: absolute;
        top: 100px;
        right: 15px;
        width: 100px;
    }
</style>
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
</style>
<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View Complain </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <div class="col-md-12">
                    
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
                
               <h4 class="text-center" style="margin-top: 0px;">Complain Information</h4>
               
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Date : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->date); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Customer Name : </label>
                        <div class="col-xs-9">
                            <p><?php  echo filter($complainInfo[0]->name); ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 no-padding ">
                        <label class="control-label col-xs-3 text-right">Mobile : </label>
                        <div class="col-xs-9">
                            <p><?php echo $complainInfo[0]->mobile; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding ">
                        <label class="control-label col-xs-3 text-right">Service Mobile : </label>
                        <div class="col-xs-9">
                            <p><?php echo $complainInfo[0]->service_mobile; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Address : </label>
                        <div class="col-xs-9">
                            <p><?php echo $complainInfo[0]->address; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Brand : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->brand); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Product Name : </label>
                        <div class="col-xs-9">
                            <?php 
                                $getProductName = $this->action->read('products',array('product_code'=>$complainInfo[0]->product));
                            ?>
                            <p><?php echo filter($getProductName[0]->product_name); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Model: </label>
                        <div class="col-xs-9">
                            <p><?php  echo filter($complainInfo[0]->model); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Problem : </label>
                        <div class="col-xs-9">
                            <p><?php echo $complainInfo[0]->problem; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Status : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->status); ?></p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
