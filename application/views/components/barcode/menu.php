<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("barcode","barcode_setting")){ ?>
    	<a href="<?php echo site_url('barcode/barcodeSetting'); ?>" class="btn btn-default" id="setting">
			Barcode Setting
		</a>
		<?php } ?>
		
		<?php if(ck_action("barcode","barcode_print")){ ?>
		<a href="<?php echo site_url('barcode/barcodeGenerate'); ?>" class="btn btn-default" id="barcodegen">
			Barcode Print
		</a>
		<?php } ?>

		<?php if(ck_action("barcode","purchase_wise_barcode_print")){ ?>
		<a href="<?php echo site_url('barcode/barcodeGenerate/show_purchase'); ?>" class="btn btn-default" id="purchase_barcode_upload">
			Barcode Genarate
		</a>
		<?php } ?>
		
		<?php if(ck_action("barcode","purchase_wise_barcode_print")){ ?>
		<a href="<?php echo site_url('barcode/barcodeGenerate/purchase_wise'); ?>" class="btn btn-default" id="purchase_barcode">
			Purchase Wise Barcode Print
		</a>
		<?php } ?>
		
		<!--<a href="<?php echo site_url('barcode/barcodeGenerate/rangeBarcode'); ?>" class="btn btn-default" id="range">-->
		<!--	Barcode Print Serially-->
		<!--</a> -->
			
	
		
    </div>
</div>