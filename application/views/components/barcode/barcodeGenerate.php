<script src="<?php echo site_url('private/js/ngscript/barcodeCtrl.js')?>"></script>
<?php
    //Converting array to object
    $meta = $this->retrieve->read("site_meta");
    $meta_info=array();
    foreach($meta as $meta_value){$meta_info[$meta_value->meta_key] = $meta_value->meta_value;}
    $meta_data = (object) $meta_info;
    $this->data["meta"] = $meta_data;
    
    //Converting array to object
    $footer_info = null;
    if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
?>
<style>
    table tr.custom-row td {padding: 0;}
    table tr.custom-row td input{
    	width: 100%;
    	height: 34px;
    	border: none;
    	padding: 0 8px;
    }
    table tr.custom-submit-row td {padding: 0;}
    .table-responsive {overflow-x: hidden;}
    .hide {display: none;}
    .barcode-contain {
        justify-content: center;
        align-items: center;
        display: flex;
        height: 100%;
        width: 100%;
        padding: 0;
    }
    .main-barcode {
        text-transform: uppercase;
        font-weight: normal;
        position: relative;
        text-align: center;
        padding: 3px 5px;
        color: #000 !important;
    }
    .barcode-bar {
        justify-content: flex-start;
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        box-sizing: border-box;
    }
    .my_dpi {
        margin: 5px 9px 5px 0px;
        border: 1px solid #eee;
        text-align: center;
        width: 210;
        padding: 5px 0;
        float:left;
    }
    .my_dpi img {margin: 0 auto;}
    .main-barcode h5.small {
        text-transform: capitalize;
        font-size: 14px;
    }
    .main-barcode h5 {
        font-weight: bold;
        font-size: 15px;
        margin: 0
    }
    @page {margin: 0;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }
        .panel {
            border: 1px solid transparent;
            position: absolute;
            width: 100%;
            left: 0px;
            top: 0px;
        }
        .barcode_body .barcode-bar:nth-child(2) {margin-top: -16px !important;}
        .hide {display: block !important;}
        .barcode-bar {
            justify-content: center !important;
            box-sizing: border-box;
        }
        .my_dpi {
            border: none !important;
            margin: 0 !important;
            height: 96px;
            width: 144px;
            overflow: hidden;
            float:left;
        }
        .my_dpi img {
            max-height: 50px !important;
            height: 50px !important;
            max-width: 120% !important;
            width: 110% !important;
            margin: 0 0 0 -5%;
        }
        .my_dpi h5.small {
            font-size: 10px !important;
            line-height: 11px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .my_dpi h5 {
            line-height: 12px;
            margin: 0;
            color: #000;
            font-size: 11px;
        }
        .my_dpi h5.price {
            line-height: 13px;
            font-size: 12px;
            white-space: nowrap;
        }
        .main-barcode {padding-left: 12px !important;}
    }
</style>

<div class="container-fluid" ng-controller="PrintBarcodeCtrl" ng-cloak>
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>Print Barcode</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php   $attribute = array('name' => '','class' => 'form-horizontal');
                        echo form_open('', $attribute);?>
               
                <div class="table-responsive">
                     <div col-md-2>
                     <div col-md-4>
                        <?php 
                            $privilege = $this->session->userdata('privilege');
                            $allGodowns = get_result('godowns',['trash' => 0]);
                            if($privilege == 'super'){
                        ?>
                        <select class="form-control" name="godown_code" width="150px" required>
                            <option value="" selected disabled>-- Select Showroom --</option>
                         <?php if (!empty($allGodowns)) {
                                        foreach ($allGodowns as $row) { ?>
                                            <option value="<?php echo $row->code; ?>">
                                                <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                            </option>
                                        <?php }
                                    } ?>
                        </select>
                        <?php }else{ ?>
                        <?php   $branch = $this->session->userdata('branch'); ?>
                        <input type="hidden" name="godown_code" value="<?php echo $branch; ?>">
                        <?php } ?>
                </div>
                <div col-md-8>
                </div>    
                </div>
            		<table class="table table-bordered">
            			<tr>
            				<th>Product's Code</th>
            				<th>Number of Barcode</th>
            				<th>Sale Price</th>
            				<th>Action</th>
            			</tr>
            			<tr class="custom-row" ng-repeat="row in codes">
            				<td>
            				    
            				    <input type="text" list="allProductCodes" name="code[]" ng-model="row.code" ng-change="getSalePriceFn($index,row.code);"   required>
            				    <datalist id="allProductCodes">
            				        <?php  if($allProducts != NULL){ foreach($allProducts as $key=>$value) { ?>
                                    <option value="<?php echo $value->product_code; ?>"><?php echo filter($value->product_code).'-'.$value->product_model.' ('.$value->purchase_price.')';?></option>
                                    <?php } } ?>
                                </datalist>
            				</td>
            				<td><input type="number" name="quantity[]" ng-model="row.quantity"  required></td>
            				<td><input type="number" name="sale_price[]" ng-model="row.sale_price" readonly></td>
            				<td><a href="#" ng-click="removeRowFn($index)" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
            			</tr>
            			<tr><td colspan="4">&nbsp;</td></tr>
            			<tr class="custom-submit-row">
            				<td colspan="3" class="text-right"><input type="submit" name="generateForm" value="Show" class="btn btn-primary"></td>
            				<td><a href="#" class="btn btn-info" ng-click="addCodeFn()"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
            			</tr>
            		</table>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Barcode</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="barcode_body">
                	<?php foreach($products as $key => $product){ ?>
    	        	<!--<span class="none" style="margin-bottom: 25px;"><?php //echo "Quantity : " . "<strong>". $product['quantity'] ."</strong>". " &nbsp;&nbsp;" ?></span>-->
                    <!--<div class="barcode-bar">-->
                        <?php
                        
                        //print_r($_POST);
                        $style =1;
                        $code = $leftCode = null;
                        $count = 0;
                        for($i=0;$i<$product['row'];$i++){
                            for($j=0;$j<$product['column'];$j++){
                                if($count < $product['quantity']) { ?>
                                <div class="my_dpi">
                                   <div class="barcode-contain">
                                        <div class="main-barcode">
                                            <h5 class="small"><?php echo get_name('godowns','name',array('code' => $_POST['godown_code'])); ?></h5>
                                            <h5 class="small"><?php echo get_name('products','product_model',array('product_code' => $product['code'])); ?></h5>
                                            <img class="barcode img-responsive" src="<?php echo $product['img']; ?>">
                                            <?php $sale_price = get_name('products','sale_price',array('product_code' => $product['code']));  ?>
                                            <h5 class="price">Price: <?php echo round($sale_price, 0);?> Tk</h5>
                                        </div>
                                    </div> 
                                </div>
                                
                            <?php }$count ++; }  ?>
                        <?php } ?>
                    <!--</div>-->
                    <?php } ?>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php //} ?>
    </div>
</div>
