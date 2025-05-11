<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("zone_menu","add-new")){ ?>
		<a href="<?php echo site_url('zone/zone'); ?>" class="btn btn-default" id="add-new">
			Add New
		</a>
        <?php } ?>

        <?php if(ck_action("zone_menu","all")){ ?>
		<a href="<?php echo site_url('zone/zone/allzone'); ?>" class="btn btn-default" id="all">
			View All
		</a>
		<?php } ?>
    </div>
</div>