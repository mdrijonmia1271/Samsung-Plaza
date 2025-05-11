<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("purchase_menu_elec","add-new")){ ?>
		<a href="<?php echo site_url('purchase_elec/purchase'); ?>" class="btn btn-default" id="add-new">
			Add Elec Purchase
		</a>
		<?php } ?>
		
        <?php if(ck_action("purchase_menu_elec","all")){ ?>
		<a href="<?php echo site_url('purchase_elec/purchase/show_Purchase'); ?>" class="btn btn-default" id="all">
			All Elec Purchase
		</a>
		<?php } ?>
		
        <?php if(ck_action("purchase_menu_elec","wise")){ ?>
		<a href="<?php echo site_url('purchase_elec/purchase/itemWise'); ?>" class="btn btn-default" id="wise">
			Item Wise
		</a>
		<?php } ?>
		
		<?php if(ck_action("purchase_menu_elec","return")){ ?>
		<a href="<?php echo site_url('purchase_elec/productReturn'); ?>" class="btn btn-default" id="return">
			Add Purchase Return
		</a>
		<?php } ?>
		
		<?php if(ck_action("purchase_menu_elec","all_return")){ ?>
		<a href="<?php echo site_url('purchase_elec/productReturn/allReturn'); ?>" class="btn btn-default" id="all_return">
			All Purchase Return
		</a>
		<?php } ?>
    </div>
</div>
