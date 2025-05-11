<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
        <?php if(ck_action("supplier-menu","add")){ ?>
		<a href="<?php echo site_url('supplier/supplier'); ?>" class="btn btn-default" id="add">
			Add supplier
		</a>
		<?php } ?>
		
		<?php if(ck_action("supplier-menu","all")){ ?>
		<a href="<?php echo site_url('supplier/supplier/view_all'); ?>" class="btn btn-default" id="all">
			All supplier
		</a>
		<?php } ?>
		
		<?php if(ck_action("supplier-menu","transaction")){ ?>
		<a href="<?php echo site_url('supplier/transaction/'); ?>" class="btn btn-default" id="transaction">
			Add Transaction
		</a>
		<?php } ?>
		
        <?php if(ck_action("supplier-menu","all-transaction")){ ?>
		<a href="<?php echo site_url('supplier/all_transaction'); ?>" class="btn btn-default" id="all-transaction">
			All Transaction
		</a>
        <?php } ?>
    </div>
</div>