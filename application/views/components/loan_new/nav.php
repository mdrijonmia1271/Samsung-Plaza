<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("loan-menu","add-new")){ ?>
		<a href="<?php echo site_url('loan_new/loan_new'); ?>" class="btn btn-default" id="add-new">
			New Loan
		</a>
        <?php } ?>

        <?php if(ck_action("loan-menu","all")){ ?>
		<a href="<?php echo site_url('loan_new/loan_new/all'); ?>" class="btn btn-default" id="all">
			All Loan
		</a>
		<?php } ?>
		
        <?php if(ck_action("loan-menu","trans")){ ?>
		<a href="<?php echo site_url('loan_new/loan_new/add_trx'); ?>" class="btn btn-default" id="trans">
			Add Transaction
		</a>
		<?php } ?>
		
		<?php if(ck_action("loan-menu","all_trx")){ ?>
		<a href="<?php echo site_url('loan_new/loan_new/all_trx'); ?>" class="btn btn-default" id="all_trx">
			All Transaction
		</a>
		<?php } ?>
		
        <!--<a href="--><?php //echo site_url('loan_new/loan_new/ledger'); ?><!--" class="btn btn-default" id="ledger">-->
        <!--	Ledger-->
        <!--</a>-->
		
    </div>
</div>
