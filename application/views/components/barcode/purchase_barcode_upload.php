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
        border-left: 0.5px solid #888;
        overflow: auto;
    }
    .barcode-contain {
        max-width: 100%;
        float: left;
        margin-bottom: 15px;
        border-bottom: 0.5px solid #888;
        border-right: 0.5px solid #888;
        border-top: 0.5px solid #888;
        overflow: hidden;
        padding: 0 7px;
    }
    .main-barcode {
        position: relative;
        text-align: center;
        font-weight: normal;
        padding: 15px 0;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>Generate All Barcode</h1>
                </div>
            </div>

           <?php  if($results != NULL) { ?>
           <div class="panel-body">
                <div class="table-responsive">
            		<table class="table table-bordered">
            			<tr>
            				<th>Product's Name</th>
            				<th>Product's Code</th>
            			</tr>

                        <?php foreach ($results as $key => $value) { 
                            $productInfo = $this->action->read("products", array("product_code" => $value->product_code));
                        ?>
                            <tr class="custom-row">
                                <td><input type="text" value="<?php echo isset($productInfo[0]->product_name) ? filter($productInfo[0]->product_name) : ''; ?>" placeholder="Product Name" readonly></td>
                                <td><input type="text" name="code[]" value="<?php echo isset($value->product_code) ? $value->product_code : ''; ?>" placeholder="Code" required readonly></td>
                            </tr>
                        <?php } ?>

            			<tr><td colspan="4">&nbsp;</td></tr>

            			<!--tr class="custom-submit-row">
            				<td colspan="3" class="text-right"><input type="submit" name="generateForm" value="Generate All" class="btn btn-success"></td>
                        </tr-->
            		</table>
                </div>
                <div class="row">
                    <div class="col-md-12 clearfix">
                        <button type="button" id="gen_barcode" class="btn btn-success" style="margin-bottom: 10px;">Generate All</button><br />
                        
                        <div class="clearfix">
                            <div class="pull-left">
                                <span id="now">0</span>/<span id="total"></span>
                            </div>
                            <div class="pull-right">
                                <span id="percent">0%</span>
                            </div>
                        </div>
                        
                        <div class="progress" style="height: 10px; box-shadow: 1px 3px 2px 0px #cccccc94; margin-top: 10px;">
                        <div id="progress" class="progress-bar progress-bar-striped" role="progressbar"></div>
                        </div>
                    </div>
                </div>
              </div>
            <div class="panel-footer">&nbsp;</div>
        <?php } ?>
    </div>

    <?php /*if($products != null){ ?>
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
                        <div class="barcode-contain">
	                        <div class="main-barcode">
	                            <span style="width: 100%; display: block; text-align: center; position: absolute; top: 7px; font-size: 9px;"><b>Grand Bazaar &nbsp; &nbsp;</b></span>
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
	                    </div>
	                        <?php }else { ?>
	                        <td>&nbsp;<?php // echo $count; ?></td>
	                        <?php } $count ++; } ?>
	                    <?php } ?>
	                </div>
                <?php } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php  } */?>
    </div>
</div>




<script>
        //Generate All Barcode Start here
        $(document).ready(function(){
            var product_codes = JSON.parse('<?php echo $codes; ?>');
            var len = product_codes.length;
            var now = 0;
            $("#total").html(len);
            
            $("#gen_barcode").on("click",function(){
            now = 0;
                $.each(product_codes,function(i,v){
                    //console.log(v);
                    //Sending Request Start
                $.ajax({
                    url: '<?php echo site_url("barcode/barcodeSetting/ajax_barcode_gen");?>',
                    type: 'POST',
                    data: {code: v},
                })
                .done(function(response) {
                    //console.log(response);
                    now+=1;
                    var complete=(now*100)/len;
                        $("#progress").css("width",complete+"%");
                        $("#percent").html(parseInt(complete)+"%");
                        $("#now").html(now);
                }); 
                    //Sending Request End
                });
            });
        });
        //Generate All Barcode End here
    </script>



