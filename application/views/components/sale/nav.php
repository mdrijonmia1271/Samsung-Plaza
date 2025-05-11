<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		<?php if(ck_action("sale_menu","mobile_sale")){ ?>
    		<a href="<?php echo site_url('sale/mobile_sale'); ?>" class="btn btn-default" id="mobile_sale">
    			Mobile Sale
    		</a>
		<?php } ?>
		
		<a href="<?php echo site_url('sale/hire_sale'); ?>" class="btn btn-default" id="hire_sale">
    			Mobile Hire Sale
    	</a>
		
		<?php if(ck_action("sale_menu","all")){ ?>
		<a href="<?php echo site_url('sale/search_sale'); ?>" class="btn btn-default" id="all">
			All Mobile Sale
		</a>
		<?php } ?>
		
	   <?php if(ck_action("sale_menu","wise")){ ?>
		<a href="<?php echo site_url('sale/sale/itemWise'); ?>" class="btn btn-default" id="wise">
			Search Item Wise
		</a>
        <?php } ?>
        
        <?php if(ck_action("sale_menu","mobile_sale_return")){ ?>
		<a href="<?php echo site_url('sale/mobile_sale_return'); ?>" class="btn btn-default" id="mobile_sale_return">
			Mobile Sale Return
		</a>
		<?php } ?>
		
		<?php if(ck_action("sale_menu","all")){ ?>
		<a href="<?php echo site_url('sale/all_sale_return'); ?>" class="btn btn-default" id="all_sale_return">
			All Sale Return
		</a>
		<?php } ?>
    </div>
</div>
