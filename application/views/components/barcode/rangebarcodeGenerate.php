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
</style>

<div class="container-fluid">
    <div class="row">
      <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>Barcode Print(Serially)</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attribute = array(
                    'name' => '',
                    'class' => 'form-horizontal'
                );
                echo form_open('', $attribute);
                ?>



                <div class="form-group">
                    <label class="control-label col-md-2">From<span class="req">&nbsp;</span></label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="from" placeholder="Type Code"  required >
                    </div>

                    <label class="control-label col-md-1">To<span class="req">&nbsp;</span></label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="to" placeholder="Type Code"  required >
                    </div>
                </div>



                <div class="col-md-7">
                    <div class="pull-right">
                        <input type="submit" name="generateForm" value="Submit" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>


        <?php if($row != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Barcode</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <span class="none"><?php echo "Quantity : " . "<strong>". $quantity ."</strong>". " &nbsp;&nbsp;" ?></span>
	        <!--code here-->
	        <div style="margin-top:30px;">
	        <style>
		img {
		 width: 100%;
		 margin: 0 0 20px 20px;
		}
		@media screen and (max-width: 1200px){
		    .rangeImg{margin-left: 15% !important;}
		}
		@media print{
		    .rangeImg{margin-left: 10% !important;}
		}
        	</style>

	        <?php foreach($proInfo as $key => $product){ ?>
	        	<div class="col-xs-3" style="text-align: center;">
				<span style="width: 125%; display: block; text-align: center; margin-bottom: -3px; font-size: 11px;"><b>Grand Bazaar &nbsp; &nbsp;</b></span>
				<div style="margin-top: 0; font-size: 10px; position: relative; margin-bottom: -10px;">
					<span style="width: 120%; display: block; text-align: center;"><?php echo $product->product_name;?></span>
				</div>

				<figure>
					<img class="img-responsive rangeImg" style="height: 40px; max-width: 164px; margin-top: 3px; margin-left: 25%;" src="<?php echo site_url('public/uploaded_barcode/' . $product->product_code . '.png'); ?>">
				</figure>

				<div style="margin-top: -19px; font-size: 11px;">
					<span style="width: 125%; display: block; text-align: center;"><?php echo $product->bar_code;?></span>
					<span style="width: 125%; display: block; text-align: center; position: relative; margin-top: -4px; margin-bottom: -4px; font-size: 10px;"><?php echo $product->subcategory;?></span>
					<span style="width: 125%; display: block; text-align: center; font-size: 12px;"><b>TK-<?php echo $product->sale_price;?></b></span>
				</div><br>
			</div>
	        <?php } ?>
	        </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
