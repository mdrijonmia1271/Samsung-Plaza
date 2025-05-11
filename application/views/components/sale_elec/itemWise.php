<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style type="text/css">
@media print{
    aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
    .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
    .hide{display: block !important;}
    .print_banner_logo {width: 19%;float: left;}
    .print_banner_logo img {margin-top: 10px;}
	.print_banner_text {width: 80%; float: right;text-align: center;}
	.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
	.print_banner_text p {margin-bottom: 5px !important;}
	.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
}
.table-title{
    font-size: 20px;
    color: #333;
    background: #f5f5f5;
    text-align:center;
    border-left: 1px solid #ddd;
    border-top: 1px solid #ddd;
    border-right: 1px solid #ddd;
}
.select2-product_code-ji-container {height: 35px !important;}
.select2-selection__arrow, .select2-selection--single {height: 36px !important;}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View Item Wise Sale </h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <div class="form-group">
                     <?php if(checkAuth('super')) { ?>
                     <label class="col-md-1 control-label">Showroom </label>
                    <div class="col-md-2">
                        <select name="godown_code" class="form-control">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <?php } ?>
                    
                    
                    <label class="col-md-1 control-label">Products </label>
                    <div class="col-md-2">
                        <select name="product_code" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" reaquired>
                            <option value="">--Select--</option>
                            <?php if(!empty($products)){ foreach($products as $key => $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->product_model).'-'.filter($row->name); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>
                    
                    
                     <label class="col-md-1 control-label">Type </label>
                    <div class="col-md-2">
                        <select name="sale_type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" reaquired>
                            <option value="">--Select--</option>
                            <option value="cash" >Retail</option>
                            <option value="credit" >Hire</option>
                            <option value="weekly" >Weekly</option>
                            <option value="dealer" >Dealer</option> 
                            
                        </select>
                    </div>
                    
                    
                    <div class="col-md-2">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php  if($result != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result </h1>&nbsp;&nbsp;<small>(<?php echo filter($productInfo[0]->product_name); ?>)</small>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <h4 class="text-center hide" style="margin-top: 0px;">View Item Wise Sale</h4>
                <h5 class="text-center hide" style="margin-top: 5px;">Products : <?php echo filter($_POST['product_code']); ?></h5>
                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <?php if(checkAuth('super')) { ?>
                        <th>Showroom</th>
                        <?php } ?>
                        <th width="60" class="none">Action</th>
                    </tr>
                    
                    <?php $total = 0;
                    foreach($result as $key => $val){
                        $total += $val->quantity;
                        ?>

                        <tr>
                            <td style="width: 40px;"><?php echo $key+1; ?></td>
                            <td ><?php echo $val->sap_at; ?></td>
                            <td ><?php echo $val->voucher_no; ?></td>
                            <td>
                                <?php 
                                    if($val->sap_type == 'cash'){
                                        echo 'Retail';
                                    }elseif($val->sap_type == 'credit'){
                                         echo 'Hire';
                                    }elseif($val->sap_type == 'dealer'){
                                         echo 'Dealer';
                                    }else{
                                         echo 'Weekly';
                                    }
                                ?>
                            </td>
                            <td><?php echo $val->quantity; ?></td>
                            <?php if(checkAuth('super')) { ?>
                                <td><?php echo filter($val->godown_name); ?></td>
                            <?php } ?>
                            <td class="none">
                                <a title="View" class="btn btn-primary" href="<?php echo site_url('sale/viewSale?vno=' . $val->voucher_no); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>


                        <tr>
                            <th colspan="4" style="text-align: right; "> Total </th>
                            <td colspan="2"> <?php echo $total."&nbsp".$result[0]->unit; ?> </td>
                            <?php if(checkAuth('super')) { ?>
                                <td></td>
                            <?php } ?>
                         
                        </tr>


                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>