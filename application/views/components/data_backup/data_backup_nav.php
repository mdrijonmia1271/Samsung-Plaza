<div class="container-fluid" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("backup_menu","add-new")){ ?>	
		<a href="<?php echo site_url('data_backup'); ?>" class="btn btn-default" id="add-new">
			Export
		</a>
		<?php } ?>
    </div>
</div>