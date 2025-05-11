<?php
    $footer_info = null;
    
    
    //Converting array to object
    $meta = $this->retrieve->read("site_meta");
    $meta_info=array();
    foreach ($meta as $meta_value) {
        $meta_info[$meta_value->meta_key] = $meta_value->meta_value;
    }
    $meta_data = (object) $meta_info;
    $this->data["meta"] = $meta_data;
    //Converting array to object
    
    if (isset($meta->footer)) {
        $footer_info = json_decode($meta->footer,true);
    }
?>

<style>
    @media print{
        aside{
            display: none !important;
        }
        nav{
            display: none;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .none{
            display: none;
        }
        .panel-heading{
            display: none;
        }

        .panel-footer{
            display: none;
        }
        .panel .hide{
            display: block !important;
        }
        .title{
            font-size: 25px;
        }
    }

    table tr.custom-row {}
    table tr.custom-row td {padding: 0;}
    table tr.custom-row td input{
    	width: 100%;
    	height: 34px;
    	border: none;
    	padding: 0 8px;
    }
    table tr.custom-submit-row td{
    	padding: 0;
    }
    .table-responsive {
        overflow-x: hidden;
    }
    .barcode-bar {
        overflow: auto;
    }
    .barcode-contain {
        max-width: 100%;
        float: left;
        margin-bottom: 15px;
        overflow: hidden;
        padding: 0 7px;
    }
    .main-barcode {
        position: relative;
        text-align: center;
        font-weight: normal;
        padding: 15px 0 5px 0;
    }
    .main-barcode .company {/*text-transform: uppercase;*/ padding:3px 5px;}
    .barcode-text {overflow: auto; margin-top: 8px;}
    .barcode-text small {display: block; float: left;}
</style>

<div class="container-fluid">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>Print Purchase Wise Barcode </h1>
                </div>
            </div>

           <?php  if($results != NULL) { ?>
           <div class="panel-body">
             <?php
                $attribute = array(
                    'name' => '',
                    'class' => 'form-horizontal'
                );
                echo form_open('barcode/barcodeGenerate/purchase_barocde?vno='.$results[0]->voucher_no, $attribute);
                ?>

                <div class="table-responsive">
            		<table class="table table-bordered">
            			<tr>
            				<th>Product's Name</th>
            				<th>Product's Code</th>
            				<th>Number of Barcode</th>
            			</tr>

                        <?php foreach ($results as $key => $value) { 
                            $productInfo = $this->action->read("products", array("product_code" => $value->product_code));
                        ?>
                            <tr class="custom-row">
                                <td><input type="text" value="<?php echo isset($productInfo[0]->product_name) ? filter($productInfo[0]->product_name) : ''; ?>" placeholder="Product Name" readonly></td>
                                <td><input type="text" name="code[]" value="<?php echo isset($value->product_code) ? $value->product_code : ''; ?>" placeholder="Code" required readonly></td>
                                <td><input type="number" name="quantity[]" value="<?php echo isset($value->quantity) ? $value->quantity : ''; ?>" placeholder="Quantity" required></td>
                            </tr>
                        <?php } ?>

            			<tr><td colspan="4">&nbsp;</td></tr>

            			<tr class="custom-submit-row">
            				<td colspan="3" class="text-right"><input type="submit" name="generateForm" value="Show" class="btn btn-primary"></td>
                        </tr>
            		</table>
                </div>
                <?php echo form_close(); ?>
              </div>
            <div class="panel-footer">&nbsp;</div>
        <?php } ?>
    </div>

    <?php if($products != null){ ?>
      <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Barcode</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
            	<!-- pre><?php // print_r($products); ?></pre -->

            	<?php foreach($products as $key => $product){ ?>
	        	<span class="none"><?php echo "Quantity : " . "<strong>". $product['quantity'] ."</stront>". " &nbsp;&nbsp;" ?></span>

	                <div class="barcode-bar">
	                <?php 	$count = 0;
	                    	for($i=0;$i<$product['row'];$i++){
	                        	for($j=0;$j<$product['column'];$j++){
	                           		if($count < $product['quantity']) { ?>
	                           	
	                        <div class="col-xs-2">
                               <div class="barcode-contain">
                                    <div class="main-barcode text-center">
                                        <small class="company"><b> <?php echo get_name('products','product_name',array('product_code' => $product['code'])); ?></small>
                                        <img class="barcode img-responsive" src="<?php echo $product['img']; ?>" style="max-width: 96%; margin: 0 auto; height: 96%;">
                                        <small class="company"><b> sale price:  <?php echo get_name('products','sale_price',array('product_code' => $product['code']));  ?> </b></small>
                                    </div>
                                </div> 
                            </div>
	                           		
	                           		
	                           		
	                           		
	                           		
                       <?php /* <div class="barcode-contain">
	                        <div class="main-barcode">
	                            <span style="width: 100%; display: block; text-align: center; position: absolute; top: 5px; font-size: 15px;"><b><?php echo $footer_info['header_txt']; ?> &nbsp; &nbsp;</b></span>
	                            <img class="barcode img-responsive" src="<?php echo $product['img']; ?>" style="max-width: 97%; margin: 0 auto; height: 97%;" >
	                            <div style="margin-top: 0; font-size: 11px;">

		                        <?php 	if($product['productInfo'] != null) {
		                            		if($product['productInfo'] != null) { ?>

				                    <span style="display: block; text-align: center; font-size: 9px; position: relative;">
				                    	<?php echo $product['productInfo']['product_name']; ?>
				                    </span>
				                    <?php } ?>
				                    <span style="display: block; text-align: center; font-size: 12px;">
				                    	<b>TK-<?php echo $product['productInfo']['sale_price']; ?></b>
				                    </span>
				                	<?php } ?>
	                            </div>
	                        </div>
	                    </div> */ ?>
	                    
	                    
	                    
	                        <?php }else { ?>
	                        <td>&nbsp;<?php // echo $count; ?></td>
	                        <?php } $count ++; } ?>
	                    <?php } ?>
	                </div>
                <?php } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
