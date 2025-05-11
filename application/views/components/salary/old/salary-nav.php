<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	

        <a 
            href="<?php echo site_url('salary/salary'); ?>" 
            class="btn btn-default" 
            id="salary">

            Basic
        </a>

        <a 
            href="<?php echo site_url('salary/salary/incentive'); ?>" 
            class="btn btn-default" 
            id="incentive">     

            Incentive
        </a>

        <a 
            href="<?php echo site_url('salary/salary/bonus'); ?>" 
            class="btn btn-default" 
            id="bonus">

            Bonus
        </a>

        <a 
            href="<?php echo site_url('salary/salary/deduction'); ?>" 
            class="btn btn-default" 
            id="deduction"> 

            Deduction
        </a>

        <a 
            href="<?php echo site_url('salary/payment'); ?>" 
            class="btn btn-default" 
            id="payment"> 

            Payment
        </a>

         <a 
            href="<?php echo site_url('salary/payment/all_payment'); ?>" 
            class="btn btn-default" 
            id="all_payment"> 

            All Payment
        </a>
        
        <a 
            href="<?php echo site_url('salary/salary/salary_sheet'); ?>" 
            class="btn btn-default" 
            id="sheet">

            Salary Sheet
        </a>

        <!-- <a 
            href="<?php echo site_url('salary/salary/report'); ?>" 
            class="btn btn-default" 
            id="report">    
        
            Report
        </a> -->
    </div>
</div>