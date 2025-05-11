<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("report_menu","sales_report")){ ?>
    		<a href="<?php echo site_url('report/analytical_report'); ?>" class="btn btn-default" id="client_report">
    			Sales Report
    		</a>
		<?php } ?>
		
        <?php if(ck_action("report_menu","client_collection")){ ?>
    		<a href="<?php echo site_url('report/analytical_report/client_collection'); ?>" class="btn btn-default" id="client_collection">
    		   Collection Report
    		</a>
		<?php } ?>
		
		<?php if(ck_action("report_menu","supplier_purchase")){ ?>
    		<a href="<?php echo site_url('report/analytical_report/supplier_purchase'); ?>" class="btn btn-default" id="supplier_purchase">
    			Purchase Report
    		</a>
		<?php } ?>
		
        <?php if(ck_action("report_menu","supplier_payment")){ ?>
    		<a href="<?php echo site_url('report/analytical_report/supplier_payment'); ?>" class="btn btn-default" id="supplier_payment">
    		    Payment Report
    		</a>
		<?php } ?>
    </div>
</div>
