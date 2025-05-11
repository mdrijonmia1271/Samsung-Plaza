<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
    
        <a href="<?php echo site_url('bank/bankInfo/add_bank'); ?>" class="btn btn-default" id="add-bank">
			Add Bank 
		</a>
		
		<a href="<?php echo site_url('bank/bankInfo'); ?>" class="btn btn-default" id="add-new">
			Add Account 
		</a>
		
		<a href="<?php echo site_url('bank/bankInfo/all_account'); ?>" class="btn btn-default" id="all-acc">
			 All Account
		</a>
			
		<a href="<?php echo site_url('bank/bankInfo/transaction'); ?>" class="btn btn-default" id="add">
			Add Transaction
		</a>
		
		<a href="<?php echo site_url('bank/bankInfo/allTransaction'); ?>" class="btn btn-default" id="all">
			All Transaction
		</a>
		
		<a href="<?php echo site_url('bank/bankInfo/searchViewTransaction'); ?>" class="btn btn-default" id="search">
			Search Transactions
		</a>
    </div>
</div>