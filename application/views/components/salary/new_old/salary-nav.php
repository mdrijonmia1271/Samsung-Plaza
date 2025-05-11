<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php //if(ck_action("salary","basic")){ ?>
        <a
            href="<?php echo site_url('salary/salary'); ?>"
            class="btn btn-default"
            id="salary">

            Basic
        </a>
        <?php //} ?>
        

        <!--<a-->
        <!--    href="<?php echo site_url('salary/salary/incentive'); ?>"-->
        <!--    class="btn btn-default"-->
        <!--    id="incentive">-->

        <!--    Incentive-->
        <!--</a>-->
        <?php //if(ck_action("salary","bonus")){ ?>
        <a
            href="<?php echo site_url('salary/salary/bonus'); ?>"
            class="btn btn-default"
            id="bonus">

            Bonus
        </a>
        <?php //} ?>
        

        <!--<a-->
        <!--    href="<?php echo site_url('salary/salary/deduction'); ?>"-->
        <!--    class="btn btn-default"-->
        <!--    id="deduction">-->

        <!--    Deduction-->
        <!--</a>-->
        <?php //if(ck_action("salary","advanced")){ ?>
        <a
            href="<?php echo site_url('salary/salary/advanced'); ?>"
            class="btn btn-default"
            id="advanced">

            Advanced
        </a>
        <?php //} ?>
        
        <?php //if(ck_action("salary","payment")){ ?>
        <a
            href="<?php echo site_url('salary/payment'); ?>"
            class="btn btn-default"
            id="payment">

            Payment
        </a>
        <?php //} ?>
        
        <?php //if(ck_action("salary","all_payment")){ ?>
         <a
            href="<?php echo site_url('salary/payment/all_payment'); ?>"
            class="btn btn-default"
            id="all_payment">

            All Payment
        </a>
        <?php //} ?>
        
        <!-- 
        <a
            href="<?php echo site_url('salary/salary/salary_sheet'); ?>"
            class="btn btn-default"
            id="sheet">

            Salary Sheet
        </a> -->

        <!-- <a
            href="<?php echo site_url('salary/salary/report'); ?>"
            class="btn btn-default"
            id="report">

            Report
        </a> -->
    </div>
</div>
