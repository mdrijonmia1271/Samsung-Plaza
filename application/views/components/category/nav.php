<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("category_menu","add-new")){ ?>
		<a href="<?php echo site_url('category/category'); ?>" class="btn btn-default" id="add-new">
			Add New
		</a>
        <?php } ?>

        <?php if(ck_action("category_menu","all")){ ?>
		<a href="<?php echo site_url('category/category/allCategory'); ?>" class="btn btn-default" id="all">
			View All
		</a>
		<?php } ?>
    </div>
</div>