<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("subCategory_menu","add-new")){ ?>
		<a href="<?php echo site_url('subCategory/subCategory'); ?>" class="btn btn-default" id="add-new">
			Add New
		</a>
		<?php } ?>
		
        <?php if(ck_action("subCategory_menu","all")){ ?>
		<a href="<?php echo site_url('subCategory/subCategory/all_subcategory'); ?>" class="btn btn-default" id="all">
			View All
		</a>
        <?php } ?>
    </div>
</div>
