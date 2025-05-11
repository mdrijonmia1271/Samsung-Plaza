<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">		
		
		<?php if(ck_action("md_transaction_menu","field")){ ?>
    		<a href="<?php echo site_url('md_transaction/fixed_assate'); ?>" class="btn btn-default" id="field">
                <i class="fa fa-angle-right"></i>
                Add New
            </a>
		<?php } ?>
		
		<?php if(ck_action("md_transaction_menu","new")){ ?>
    		<a href="<?php echo site_url('md_transaction/md_transaction'); ?>" class="btn btn-default" id="new">
    			New Showroom Transaction
    		</a>
		<?php } ?>
		
        <?php if(ck_action("md_transaction_menu","all")){ ?>
    		<a href="<?php echo site_url('md_transaction/md_transaction/allMd_transaction'); ?>" class="btn btn-default" id="all">
    			All Showroom Transaction
    		</a>
		<?php } ?>
		
		<?php if(ck_action("md_transaction_menu","balance")){ ?>
    		 <a href="<?php echo site_url('md_transaction/md_transaction/balance_report'); ?>" class="btn btn-default" id="balance">
                <i class="fa fa-angle-right"></i>
                Balance Report
            </a>
        <?php } ?>    
    </div>
</div>