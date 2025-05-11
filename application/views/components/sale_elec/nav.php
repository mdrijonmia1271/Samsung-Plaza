<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">

		
		<?php if(ck_action("sale_menu_elec","retail")){ ?>
    		<a href="<?php echo site_url('sale_elec/retail_sale'); ?>" class="btn btn-default" id="retail">
    			Retail Sale
    		</a>
		<?php } ?>	
		
		<?php if(ck_action("sale_menu_elec","hire")){ ?>
    		<a href="<?php echo site_url('sale_elec/hire_sale'); ?>" class="btn btn-default" id="hire">
    			Hire Sale
    		</a>
		<?php } ?>
		
	

		
		<?php if(ck_action("sale_menu_elec", "dealer")){ ?>
    		<a href="<?php echo site_url('sale_elec/dealerSale'); ?>" class="btn btn-default" id="dealer">
    			Dealer Sale
    		</a>
		<?php } ?>
		<?php if(ck_action("sale_menu_elec", "dealer_chalan")){ ?>
    		<a href="<?php echo site_url('sale_elec/DealerChalan'); ?>" class="btn btn-default" id="dealer_chalan">
    			Dealer Chalan
    		</a>
		<?php } ?>
		
		
        <?php if(ck_action("sale_menu_elec","all_elec")){ ?>
		<a href="<?php echo site_url('sale_elec/search_sale'); ?>" class="btn btn-default" id="all_elec">
			All Sale
		</a>
		<?php } ?>
		
		<?php if(ck_action("sale_menu_elec","hire-all")){ ?>
		<a href="<?php echo site_url('sale_elec/search_sale/hireSale'); ?>" class="btn btn-default" id="hire-all">
			All Hire Sale
		</a>
		<?php } ?>
		
		
		
        <?php if(ck_action("sale_menu_elec","wise")){ ?>
		<a href="<?php echo site_url('sale_elec/sale/itemWise'); ?>" class="btn btn-default" id="wise">
			Item Wise
		</a>
        <?php } ?>
        
        <?php if(ck_action("sale_menu_elec","client_search")){ ?>
		<a href="<?php echo site_url('sale_elec/client_search'); ?>" class="btn btn-default" id="client_search">
			Client Wise
		</a>
		<?php } ?>
        
        <?php if(ck_action("sale_menu_elec","return")){ ?>
        <a href="<?php echo site_url('sale_elec/saleReturnCtrl'); ?>" class="btn btn-default" id="return">
			Sale Return
		</a>
		<?php } ?>
		
		<?php if(ck_action("sale_menu_elec","return-all")){ ?>
		<a href="<?php echo site_url('sale_elec/multiSaleReturn/all'); ?>" class="btn btn-default" id="return-all">
			All Sale Return
		</a>
        <?php } ?>
		
		<!--<a href="<?php //echo site_url('sale/deleted_sale'); ?>" class="btn btn-default" id="all-deleted">
			Deleted Sale
		</a>-->
		
    </div>
</div>
