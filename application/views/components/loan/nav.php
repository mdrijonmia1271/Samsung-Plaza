<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		<a href="<?php echo site_url('loan/loan'); ?>" class="btn btn-default" id="add-new">
			Received & Paid
		</a>


		<a href="<?php echo site_url('loan/loan/view_all'); ?>" class="btn btn-default" id="all">
			View All Loan
		</a>

		<a href="<?php echo site_url('loan/loan/transaction'); ?>" class="btn btn-default" id="trans">
			Transaction
		</a>

		<a href="<?php echo site_url('loan/loan/alltransaction'); ?>" class="btn btn-default" id="alltrans">
			View All Transaction
		</a>
    </div>
</div>
