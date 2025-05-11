<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("report_menu","product_profit")){ ?>
        <a href="<?php echo site_url('report/report/Profit_loss_report'); ?>" class="btn btn-default" id="product_profit">
			Product Wise
		</a>
		<?php } ?>
		
		<?php if(ck_action("report_menu","client_profit")){ ?>
		<a href="<?php echo site_url('report/client_profit/'); ?>" class="btn btn-default" id="client_profit">
			Client Wise
		</a>
        <?php } ?>
    </div>
</div>
