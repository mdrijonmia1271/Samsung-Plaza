<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        
		<?php if(ck_action("sale_menu", "special")){ ?>
		<a href="<?php echo site_url('lpr/lpr'); ?>" class="btn btn-default" id="add">
			New LPR
		</a>
		<?php } ?>
		
        <?php if(ck_action("sale_menu","all")){ ?>
		<a href="<?php echo site_url('lpr/lpr/all'); ?>" class="btn btn-default" id="all">
			All LPR
		</a>
		<?php } ?>
		
    </div>
</div>
