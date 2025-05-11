<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
    	
<!-- Select Option 2 Stylesheet -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
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
    .wid-100{width: 100px;}
    #loading{text-align: center;}
    #loading img{display: inline-block;}

</style>

<script>

    function setTotalQuantity(quantity, key){
        $("#category_"+key).text(quantity)
    }
    
    function setQuantity(quantity){
        $("#all_quantity").text(quantity)
    }
    
</script>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Stock</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <div class="col-md-3">
                        <select name="search[code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Select Name --</option>
                            <?php if($productInfo != null){ foreach($productInfo as $key => $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="search[category]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Category --</option>
                            <?php if($category != null){ foreach($category as $key => $row){ ?>
                            <option value="<?php echo $row->category; ?>">
                                <?php echo filter($row->category); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="search[subcategory]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Sub Category --</option>
                            <?php if($subcategory != null){ foreach($subcategory as $key => $row){ ?>
                            <option value="<?php echo $row->subcategory; ?>">
                                <?php echo filter($row->subcategory); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php 
            if($show_condition == 'search'){
            $grand_total = 0;
            $grand_quantity = 0;
            foreach($category as $key => $cat){
                $where['category'] = $cat->category;
                $category_products = $this->action->readGroupBy('stock', 'name', $where);
                if(count($category_products) > 0){
                    $totalSellPrice = 0;
                    $total_pcs = 0;
                    $sell = 0;
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Search
                <h4 class="pull-left" style="font-weight: bold;"><?php echo $cat->category; ?> (<span id="category_<?php echo $key; ?>"></span>)</h4>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40px;">SL</th>
                            <th>Name</th>
                            <!--<th>Serial</th>-->
                            <!--<th>Category</th>-->
                            <th>Sub category</th>
                            <th>Quantity</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                            $totalPurchase = 0;
                            foreach($category_products as $product_key => $category_product){
                                $sell =  ($category_product->purchase_price * $category_product->quantity); 
                                    if($category_product->quantity > 0){
                        ?>
                        <tr>
                            <td><?php echo $product_key+1; ?></td>
                            <td><?php echo filter($category_product->name); ?></td>
                            <?php /**
                            <td>
                                <?php 
                                    $product_serials = $this->action->read('stock', array('product_model' => $category_product->product_model));
                                    $count = count($product_serials);
                                    foreach($product_serials as $product_serial){
                                        if($count == 1){
                                            echo $product_serial->product_serial;
                                        }
                                        else{
                                            echo $product_serial->product_serial.', ';
                                        }
                                        $count--;
                                    }
                                ?>
                            </td>
                            */ ?>
                            <!--<td><?php echo filter($category_product->category); ?></td>-->
                            <td><?php echo filter($category_product->subcategory); ?></td>
                            <td 
                            <?php 
                            // $where_p = array(
                            //     'product_model' => $category_product->product_model,
                            //     'quantity >=' => 1
                            // );
                            // $allProducts = (array) $this->action->read('stock', $where_p);
                            // $p_quantity = count($allProducts);
                            $p_quantity = $category_products[0]->quantity;
                            if($p_quantity < 1){ echo "class='red'";}else if($p_quantity > 0 && $p_quantity < 6){ echo "class='blue'";}; ?>>
                                <b><?php echo $p_quantity . " " . $category_product->unit; $total_pcs += $p_quantity; ?></b></td>
                            <td><?php echo f_number($category_product->purchase_price); $totalPurchase += $category_product->purchase_price; ?></td>
                            <td><?php echo f_number($category_product->sell_price); ?></td>
                            <td><?php echo f_number($category_product->sell_price * $p_quantity); $totalSellPrice += $category_product->sell_price * $p_quantity; ?></td>
                        </tr>
                        <?php
                                    }
                            }
                            $grand_total += $totalSellPrice;
                            $grand_quantity += $total_pcs;
                        ?>
                        <tr>
                            <th colspan="3" class="text-right">Total </th>
                            <th><?php echo f_number($total_pcs).' Pcs'; ?></th>
                            <th colspan="2"></th>
                            <th><?php echo f_number($totalSellPrice).' TK'; ?></th>
                        </tr>
                        <script>setTotalQuantity(<?php echo $total_pcs; ?>, <?php echo $key; ?>);</script>
                    </table>
                </div>
            </div>
        <div class="panel-footer">&nbsp;</div>
    </div>
        <?php 
                    }
                }
            }
        ?>
        
        <?php 
            if($show_condition == 'category'){
            $grand_total = 0;
            $grand_quantity = 0;
            foreach($category as $key => $cat){
                $where['category'] = $cat->category;
                $category_products = $this->action->readGroupBy('stock', 'name', $where);
                if(count($category_products) > 0){
                    $totalSellPrice = 0;
                    $total_pcs = 0;
                    $sell = 0;
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Category
                <h4 class="pull-left" style="font-weight: bold;"><?php echo $cat->category; ?> (<span id="category_<?php echo $key; ?>"></span>)</h4>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40px;">SL</th>
                            <th>Name</th>
                            <!--<th>Serial</th>-->
                            <!--<th>Category</th>-->
                            <th>Sub category</th>
                            <th>Quantity</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                            $totalPurchase = 0;
                            foreach($category_products as $product_key => $category_product){
                                $sell =  ($category_product->purchase_price * $category_product->quantity); 
                                    if($category_product->quantity > 0){
                        ?>
                        <tr>
                            <td><?php echo $product_key+1; ?></td>
                            <td><?php echo filter($category_product->name); ?></td>
                            <?php /**
                            <td>
                                <?php 
                                    $product_serials = $this->action->read('stock', array('product_model' => $category_product->product_model));
                                    $count = count($product_serials);
                                    foreach($product_serials as $product_serial){
                                        if($count == 1){
                                            echo $product_serial->product_serial;
                                        }
                                        else{
                                            echo $product_serial->product_serial.', ';
                                        }
                                        $count--;
                                    }
                                ?>
                            </td>
                            */ ?>
                            <!--<td><?php echo filter($category_product->category); ?></td>-->
                            <td><?php echo filter($category_product->subcategory); ?></td>
                            <td 
                            <?php 
                            // $where_p = array(
                            //     'product_model' => $category_product->product_model,
                            //     'quantity >=' => 1
                            // );
                            // $allProducts = (array) $this->action->read('stock', $where_p);
                            // $p_quantity = count($allProducts);
                            $p_quantity = $category_products[0]->quantity;
                            if($p_quantity < 1){ echo "class='red'";}else if($p_quantity > 0 && $p_quantity < 6){ echo "class='blue'";}; ?>>
                                <b><?php echo $p_quantity . " " . $category_product->unit; $total_pcs += $p_quantity; ?></b></td>
                            <td><?php echo f_number($category_product->purchase_price); $totalPurchase += $category_product->purchase_price; ?></td>
                            <td><?php echo f_number($category_product->sell_price); ?></td>
                            <td><?php echo f_number($category_product->sell_price * $p_quantity); $totalSellPrice += $category_product->sell_price * $p_quantity; ?></td>
                        </tr>
                        <?php
                                    }
                            }
                            $grand_total += $totalSellPrice;
                            $grand_quantity += $total_pcs;
                        ?>
                        <tr>
                            <th colspan="3" class="text-right">Total </th>
                            <th><?php echo f_number($total_pcs).' Pcs'; ?></th>
                            <th colspan="2"></th>
                            <th><?php echo f_number($totalSellPrice).' TK'; ?></th>
                        </tr>
                        <script>setTotalQuantity(<?php echo $total_pcs; ?>, <?php echo $key; ?>);</script>
                    </table>
                </div>
            </div>
        <div class="panel-footer">&nbsp;</div>
    </div>
        <?php 
                    }
                }
            }
        ?>
        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>&nbsp;</h1>
                </div>
            </div>

            <div class="panel-body">
                        <strong class="col-md-6 text-right"><?php echo 'Total '.$grand_quantity.' PCS'; ?></strong>
                        <strong class="col-md-6"><?php echo 'Total '.f_number($grand_total).' TK'; ?></strong>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<!-- Select Option 2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>