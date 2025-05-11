<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php /* if(ck_action("purchase_menu","add-new")){ ?>
		<a href="<?php echo site_url('purchase/purchase'); ?>" class="btn btn-default" id="add-new">
			Add Elec Purchase
		</a>
		<?php } */ ?>
		
		
		 <?php if(ck_action("purchase_menu","add-new-mobile")){ ?>
    		<a href="<?php echo site_url('purchase/purchaseMobile'); ?>" class="btn btn-default" id="add-new-mobile">
    			Add Mobile Purchase
    		</a>
		<?php } ?>
		
		
        <?php if(ck_action("purchase_menu","all")){ ?>
		<a href="<?php echo site_url('purchase/purchase/show_Purchase'); ?>" class="btn btn-default" id="all">
			All Mobile Purchase
		</a>
		<?php } ?>
		
        <?php if(ck_action("purchase_menu","wise")){ ?>
		<a href="<?php echo site_url('purchase/purchase/itemWise'); ?>" class="btn btn-default" id="wise">
			Item Wise
		</a>
		<?php } ?>
		
		<?php if(ck_action("purchase_menu","createReturn")){ ?>
		<a href="<?php echo site_url('purchase/productReturn/create'); ?>" class="btn btn-default" id="createReturn">
			Purchase Return
		</a>
		<?php } ?>
		
		<?php if(ck_action("purchase_menu","allReturn")){ ?>
		<a href="<?php echo site_url('purchase/productReturn'); ?>" class="btn btn-default" id="allReturn">
			All Return
		</a>
		<?php } ?>
    </div>
</div>
