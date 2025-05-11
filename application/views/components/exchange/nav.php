<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("exchange_menu","add-new")){ ?>
		<a href="<?php echo site_url('exchange/exchange'); ?>" class="btn btn-default" id="add-new">
			New Exchange
		</a>
		<?php } ?>
		
        <?php if(ck_action("exchange_menu","all")){ ?>
		<a href="<?php echo site_url('exchange/exchange/all'); ?>" class="btn btn-default" id="all">
			All Exchange
		</a>
		<?php } ?>
    </div>
</div>