<style type="text/css">
    .info-view{
        width: 100%;
        max-width: 230px;
        max-height: 230px;
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    .custom-table tr td{
        padding: 0 !important;
    }

    .custom-table tr td .form-control{
        border: transparent;
    }
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
</style>

<div class="container-fluid" ng-controller="PaymentCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left"><h1>Payment </h1></div>
            </div>
            
            <?php if($employee != NULL){ ?>
            <div class="panel-body">
                
                <!--Print Banner Start Here-->
                
                <?php $banner_info = $this->action->read("banner"); ?>
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>" alt="">
                
                <!--Print Banner End Here-->
                
                <?php
                $attr = array("class"=>"form-horizontal");
                echo form_open('', $attr);
                ?>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>
                                    <input type="checkbox" checked id="check_all"> SL
                                </th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Mobile</th>
                                <th>Designation</th>
                                <th>Salary</th>
                                <th>Payment</th>
                            </tr>
                            
                            <?php 
                              foreach($employee as $key => $value) { 
                               $payment = 0.00;
                               $where = array(
                                 "emp_id"  => $value->emp_id,
                                 "month"   => date('m'),
                                 "year"    => date('Y'),
                                 "status"  => "active"
                               );
                               
                              $bonus = $this->action->read("bonus",$where);
                              $bonus = ($bonus) ? ($bonus[0]->bonus_percent * $value->employee_salary)/100 : 0.00;
                              $payment = $value->employee_salary;
                              
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" checked value="<?php echo $key; ?>" >&nbsp;&nbsp;<?php echo $key+1; ?>
                                    </td>
                                    <td>
                                        <?php echo $value->emp_id; ?>
                                        <input type="hidden" name="emp_id[]" value="<?php echo $value->emp_id; ?>">
                                    </td>
                                    <td><?php echo filter($value->name); ?></td>
                                    <td>
                                        <img class="img-responsive" src="<?php echo site_url($value->path);?>" width="50"  alt="">
                                    </td>
                                    <td> <input type="hidden" name="mobile[]" value="<?php echo $value->mobile; ?>" > <?php echo $value->mobile; ?></td>
                                    <td><?php echo filter($value->designation); ?></td>
                                    <td><?php echo $value->employee_salary; ?></td>
                                    <td>
                                        <?php echo $payment; ?>
                                        <input type="hidden" name="bonus[]" value="<?php echo $bonus; ?>">
                                        <input type="hidden" name="paid[]" value="<?php echo $payment; ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group ">
                            <label class="col-md-4 control-label">Payment Date<span class="req"> *</span></label>
                            <div class="input-group date col-md-8" id="datetimepicker1">
                                <input type="text" class="form-control" name="payment_date" required <?php if($privilege == "user"){ echo "readonly"; } ?> value="<?php echo date('Y-m-d'); ?>">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group pull-right">
                        <input type="submit" name="create" value="Paid" class="btn btn-info"/>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#check_all").on("change",function(){
			if($(this).is(":checked")==true){
				$('input[name="id[]"]').prop("checked",true);
			}else{
				$('input[name="id[]"]').prop("checked",false);
			}
		});
	});
</script>
