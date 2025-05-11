<style type="text/css">
     @media print{
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
    }
    .table tr td{
        vertical-align: middle !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Salary Sheet</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                
                <!--Print Banner Start Here-->
                
                <?php $banner_info = $this->action->read("banner"); ?>
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>" alt="">
                
                <!--Print Banner End Here-->
                
                      <div class="row hide">
                    <div class="view-profile">
                        <div class="col-xs-2">
                            <figure class="pull-left">
                                <img class="img-responsive" src="<?php echo site_url('public/logo/logo.png'); ?>" style="width: 100px; height: 100px;" alt="">
                            </figure>
                        </div>

                        <div class="col-xs-8">
                            <div class="institute">
                            	<?php
                            		$siteInfo = $this->config->item('header');
                            		$title = $siteInfo['title'];
                            		$place = $siteInfo['place'];
                            	?>
                                <h2 class="text-center title" style="margin-top: 10; font-weight: bold;"><?php echo $title; ?></h2>
                                <h3 class="text-center" style="margin: 0;"><?php echo $place; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="none">&nbsp;</div>

                    <table class="table table-bordered" >
                        <tr>
                            <th width="40"> SL </th>
                            <th>Name </th>
                            <th>Employee ID</th>
                            <th>Designation </th>
                            <th width="100">Basic </th>
                            <th width="100">H. Rent </th>
                            <th width="100">PF Add </th>
                            <th width="100">PF Deduct</th>
                            <th width="100">Net Salary </th>
                        </tr>
						
						<?php 
					    	$basicTotal = $houseRentTotal = $providentFundAddTotal = $providentFundDeductTotal = $grandTotalSalary = 0.00;
						    foreach ($salarySheet as $key => $value) { 
						    $basicInfo = $this->action->read("salary_structure",array("eid" => $value->emp_id));
						    
						    $houe_rent = $this->action->read("incentive_structure",array("eid" => $value->emp_id,"fields" => "HRA"));
						    $provident_fund_add = $this->action->read("incentive_structure",array("eid" => $value->emp_id,"fields" => "Provident Fund"));
						    
						    $deductionInfo = $this->action->read("deduction_structure",array("eid" => $value->emp_id,"fields" => "Provident Fund"));
						    
						    $basic_salary = ($basicInfo) ? $basicInfo[0]->basic : 0.00;
						    $basicTotal += $basic_salary;
						    
						    $house_rent   = $basic_salary * (($houe_rent) ? $houe_rent[0]->percentage/100 : 0.00);
						    $houseRentTotal += $house_rent;
						    
						    $provident_fund_add   = $basic_salary * (($provident_fund_add) ? $provident_fund_add[0]->percentage/100 : 0.00);
						    $providentFundAddTotal += $provident_fund_add;
						    
						    $provident_fund_deduct = ($deductionInfo) ? $deductionInfo[0]->amount : 0.00;
						    $providentFundDeductTotal += $provident_fund_deduct;
						    
						    
							
						?>
                        <tr>
                            <td> <?php echo $key+1; ?> </td>
                            <td> <?php echo filter($value->name); ?> </td>
                            <td> <?php echo $value->emp_id; ?> </td>
                            <td> <?php echo filter($value->designation); ?> </td>
                            <td> <?php echo $basic_salary; ?> </td>
                            <td> <?php printf("%.2f",$house_rent); ?></td>
                            <td> <?php printf("%.2f",$provident_fund_add); ?> </td>
                            <td> <?php echo $provident_fund_deduct; ?></td>
                            <td> <?php echo $salary = ($basic_salary + $house_rent + $provident_fund_add) - $provident_fund_deduct; $grandTotalSalary += $salary; ?></td>
                        </tr>
                        
                        <?php } ?>

                        <tr>
                            <td colspan="3"> </td>
                            <td class="pull-right" style="border: none;"><b> Total </b></td>
                            <td> <?php printf("%.2f",$basicTotal); ?> </td>
                            <td> <?php printf("%.2f",$houseRentTotal); ?> </td>
                            <td> <?php printf("%.2f",$providentFundAddTotal); ?> </td>
                            <td> <?php printf("%.2f",$providentFundDeductTotal); ?> </td>
                            <td> <?php printf("%.2f",$grandTotalSalary); ?></td>
                        </tr>
                    </table>
                </div>
                 <div class="panel-footer">&nbsp;</div>
	        </div>
        </div>
    </div>
</div>
