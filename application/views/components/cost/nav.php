<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		
		<?php if(ck_action("cost_menu","all_cost_category")){ ?>
		<a href="<?php echo site_url('cost_category/cost_category'); ?>" class="btn btn-default" id="all_cost_category">
			Cost Category
		</a>
		<?php } ?>
		
        <?php if(ck_action("cost_menu","field")){ ?>
		<a href="<?php echo site_url('cost/cost'); ?>" class="btn btn-default" id="field">
			Field of Cost 
		</a>
		<?php } ?>		
		
		<?php if(ck_action("cost_menu","new")){ ?>
		<a href="<?php echo site_url('cost/cost/newcost'); ?>" class="btn btn-default" id="new">
			New Cost
		</a>
		<?php } ?>
		
        <?php if(ck_action("cost_menu","all")){ ?>
		<a href="<?php echo site_url('cost/cost/allcost'); ?>" class="btn btn-default" id="all">
			All Cost
		</a>
		<?php } ?>
    </div>
</div>