<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("brand_menu","add-new")){ ?>
		<a href="<?php echo site_url('brand/brand'); ?>" class="btn btn-default" id="add-new">
			Add New
		</a>
		<?php } ?>
		
        <?php if(ck_action("brand_menu","all")){ ?>
		<a href="<?php echo site_url('brand/brand/all_brand'); ?>" class="btn btn-default" id="all">
			View All
		</a>
        <?php } ?>
    </div>
</div>
