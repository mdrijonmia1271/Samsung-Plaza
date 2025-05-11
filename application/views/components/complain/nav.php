<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("complain_menu","new")){ ?>
		<a href="<?php echo site_url('complain/complain/'); ?>" class="btn btn-default" id="new">
			Add Complain
		</a>
		<?php } ?>
		
        <?php if(ck_action("complain_menu","all")){ ?>
		<a href="<?php echo site_url('complain/complain/all'); ?>" class="btn btn-default" id="all">
			All Complain
		</a>
		<?php } ?>
    </div>
</div>