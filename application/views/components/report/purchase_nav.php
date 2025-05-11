<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("report_menu","purchase_report")){ ?>
		<a href="<?php echo site_url('report/purchase_report'); ?>" class="btn btn-default" id="purchase_report">
			Purchase Report
		</a>
		<?php } ?>
		
        <?php if(ck_action("report_menu","purchase_report_item")){ ?>
		<a href="<?php echo site_url('report/purchase_report_item'); ?>" class="btn btn-default" id="purchase_report_item">
			Purchase Item Report
		</a>
        <?php } ?>
    </div>
</div>
