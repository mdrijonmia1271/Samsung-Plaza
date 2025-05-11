<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if (ck_action("ledger", "company-ledger")) { ?>
            <a href="<?php echo site_url('ledger/companyLedger'); ?>" class="btn btn-default" id="company-ledger">
                Supplier Ledger
            </a>
        <?php } ?>

        <?php if (ck_action("ledger", "client-ledger")) { ?>
            <a href="<?php echo site_url('ledger/clientLedger'); ?>" class="btn btn-default" id="client-ledger">
                Dealer Ledger
            </a>
        <?php } ?>

            <a href="<?php echo site_url('ledger/hireclientLedger'); ?>" class="btn btn-default" id="hireclient-ledger">
                Hire Ledger
            </a>
     
        
        <?php /*if(ck_action("ledger","dealer-ledger")){ ?>
		<a href="<?php echo site_url('ledger/clientLedger?type=dealer'); ?>" class="btn btn-default" id="dealer-ledger">
			Dealer Ledger
		</a>
		<?php }*/ ?>

        <?php if (ck_action("ledger", "ledger")) { ?>
            <a href="<?php echo site_url('ledger/brand'); ?>" class="btn btn-default" id="brand">
                Brand Ledger
            </a>
        <?php } ?>
    </div>
</div>
