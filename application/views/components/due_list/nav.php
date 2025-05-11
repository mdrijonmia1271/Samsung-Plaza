<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("due_list_menu","cash")){ ?>
		<a href="<?php echo site_url('due_list/due_list'); ?>" class="btn btn-default" id="cash">
			Retail Due
		</a>
		<?php } ?>

		<?php if(ck_action("due_list_menu","retail_due_collection")){ ?>
        <a href="<?php echo site_url('due_list/due_list/retail_due_collection'); ?>" class="btn btn-default" id="retail_due_collection">
            Retail Due Collections
        </a>
		<?php } ?>
		
		<?php if(ck_action("due_list_menu","dealer_list")){ ?>
		<a href="<?php   echo site_url('due_list/due_list/dealer_due'); ?>" class="btn btn-default" id="dealer_list">
			All Customer Due
		</a>
		<?php } ?>

		<?php if(ck_action("due_list_menu","supplier_list")){ ?>
		<a href="<?php echo site_url('due_list/due_list/supplier'); ?>" class="btn btn-default" id="supplier_list">
			Supplier Due
		</a>
		<?php } ?>
    </div>
</div>