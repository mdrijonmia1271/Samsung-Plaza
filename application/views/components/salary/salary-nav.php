<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("salary_menu","salary")){ ?>
        <a href="<?php echo site_url('salary/salary'); ?>" class="btn btn-default" id="salary">
            Basic
        </a>
        <?php } ?>
        
        <?php if(ck_action("salary_menu","bonus")){ ?>
        <a href="<?php echo site_url('salary/salary/bonus'); ?>" class="btn btn-default" id="bonus">
            Bonus
        </a>
        <?php } ?>
        
        <?php if(ck_action("salary_menu","advanced")){ ?>
        <a href="<?php echo site_url('salary/salary/advanced'); ?>" class="btn btn-default" id="advanced">
            Advanced
        </a>
        <?php } ?>
        
        <?php if(ck_action("salary_menu","payment")){ ?>
        <a href="<?php echo site_url('salary/payment'); ?>" class="btn btn-default" id="payment">
            Payment
        </a>
        <?php } ?>
        
        <?php if(ck_action("salary_menu","all_payment")){ ?>
        <a href="<?php echo site_url('salary/payment/all_payment'); ?>" class="btn btn-default" id="all_payment">
            All Payment
        </a>
        <?php } ?>
    </div>
</div>
