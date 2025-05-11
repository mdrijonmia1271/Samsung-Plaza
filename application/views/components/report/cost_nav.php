<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("report_menu","cost_report")){ ?>
		<a href="<?php echo site_url('report/cost_report'); ?>" class="btn btn-default" id="cost_report">
			Cost Report
		</a>
        <?php } ?>
    </div>
</div>
