<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">

        <?php if(ck_action("dashboard","add-new-mobile")){ ?>
            <a href="<?php echo site_url('purchase/purchaseMobile'); ?>" class="btn btn-default" id="add-new-mobile" target="_blank">
                Mobile Purchase
            </a>
        <?php } ?>

        <?php if(ck_action("dashboard","stock")){ ?>
            <a href="<?php echo site_url('stock/stock/'); ?>" class="btn btn-default" id="stoke">
                Stock</a>
        <?php } ?>

        <?php if(ck_action("dashboard","mobile_sale")){ ?>
            <a href="<?php echo site_url('sale/mobile_sale'); ?>" class="btn btn-default" id="mobile_sale" target="_blank">
                Mobile Sale
            </a>
        <?php } ?>

        <?php /* if(ck_action("dashboard","purchase")){ ?>
		<a href="<?php echo site_url('purchase/purchase'); ?>" class="btn btn-default" id="add-new">
			Purchase
		</a>
		<?php } */ ?>

        <!-- <a href="<?php // echo site_url('production/production'); ?>" class="btn btn-default" id="add-new">
			Production
		</a> -->

        <?php /* if(ck_action("dashboard","retail_sale")){ ?>
		<a href="<?php echo site_url('sale/retail_sale/retail_sale'); ?>" class="btn btn-default" id="add-new">
			Retail Sale
		</a>
		<?php } ?>

		<?php if(ck_action("dashboard","hire_sale")){ ?>
		<a href="<?php echo site_url('sale/hire_sale/hire_sale'); ?>" class="btn btn-default" id="add-new">
			Hire Sale
		</a>
		<?php } ?>

		<?php if(ck_action("dashboard","weekly_sale")){ ?>
		<a href="<?php echo site_url('sale/weekly_sale/weekly_sale'); ?>" class="btn btn-default" id="add-new">
			Weekly Sale
		</a>
		<?php } ?>

		<?php if(ck_action("dashboard","dealer_sale")){ ?>
		<a href="<?php echo site_url('sale/dealerSale'); ?>" class="btn btn-default" id="add-new">
			Dealer Sale
		</a>
		<?php } */ ?>
    </div>
</div>
