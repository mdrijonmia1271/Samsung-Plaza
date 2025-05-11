<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("fixed_assate_menu","field")){ ?>
		<a href="<?php echo site_url('fixed_assate/fixed_assate'); ?>" class="btn btn-default" id="field">
			Field of Fixed Assate 
		</a>
		<?php } ?>
		
		<?php if(ck_action("fixed_assate_menu","new")){ ?>
		<a href="<?php echo site_url('fixed_assate/fixed_assate/newfixed_assate'); ?>" class="btn btn-default" id="new">
			New Fixed Assate
		</a>
		<?php } ?>
		
        <?php if(ck_action("fixed_assate_menu","all")){ ?>
		<a href="<?php echo site_url('fixed_assate/fixed_assate/allfixed_assate'); ?>" class="btn btn-default" id="all">
			All Fixed Assate
		</a>
		<?php } ?>
    </div>
</div>