<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        
        <?php if(ck_action("client_menu","add")){ ?>
		<a href="<?php echo site_url('client/client'); ?>" class="btn btn-default" id="add">
			Add New
		</a>
		<?php } ?>
		
        <?php if(ck_action("client_menu","all")){ ?>
		<a href="<?php echo site_url('client/client/view_all'); ?>" class="btn btn-default" id="all">
			View All
		</a>
		<?php } ?>
		
        <a href="<?php echo site_url('client/transaction/'); ?>" class="btn btn-default" id="transaction">
			Installment Collection
		</a>
		
		<a href="<?php echo site_url('client/all_transaction'); ?>" class="btn btn-default" id="all-transaction">
			All Installment Collection
		</a>
		
		<!--a href="<?php //echo site_url('client/client/commission_paid'); ?>" class="btn btn-default" id="paid">
			Commission Paid
		</a-->

    </div>
</div>
