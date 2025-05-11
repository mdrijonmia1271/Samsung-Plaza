<style type="text/css">
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }
    }

    .table tr td {
        vertical-align: middle !important;
    }

    .cap-border {
        border-top: 1px solid #ddd;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        background: #eee;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Search Payment</h1>

                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal none");
                echo form_open("", $attr);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Employee <span class="req"> *</span></label>
                            <div class="col-md-5">
                                <select name="search[emp_id]" class="selectpicker form-control" data-show-subtext="true"
                                        data-live-search="true"
                                        required>
                                    <option value="" disabled selected="">-- Select Employee --</option>
                                    <?php if (!empty($employee)) {
                                        foreach ($employee as $key => $value) {
                                            echo '<option value="' . $value->emp_id . '" ' . (!empty($emp_id) && $emp_id == $value->emp_id ? "selected" : "") . '>' . get_filter($value->name) . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo 'From'; ?></label>
                            <div class="input-group date col-md-5" id="datetimepickerFrom">
                                <input type="text" name="date[from]" value="<?= $from ?>" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo 'To'; ?></label>
                            <div class="input-group date col-md-5" id="datetimepickerTo">
                                <input type="text" name="date[to]" value="<?= $to ?>" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7">
                                <input type="submit" name="show" value="Show" class="btn btn-info pull-right">
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <?php /* if($result != NULL) { ?>
                <!-- Print banner -->
                <p class="text-center hide" style="margin:10px auto;">All Payments List</p>
                <span class="text-center hide print-time">
                    Employee :
                    <?php
                    $info = $this->action->read("employee",array('emp_id' => $_POST['search']['eid']));
                    echo ($info) ? filter($info[0]->name) : "";
                    ?>
                </span><br>
                <div>
                    <hr class="none" style="border: 1px dashed  #ddd; margin-top: 5px;">
                    <div class="none">&nbsp;</div>
                    <table class="table table-bordered" >
                        <tr>
                            <th width="40"> SL </th>
                            <th width="200"> Advanced Payment</th>
                            <th width="200"> Salary Payment</th>
                            <th>Remarks</th>
                            <th> Status </th>
                        </tr>
                        <?php
                        $totalAdvanced = $balance = 0.00;
                        $status = "";
                        $monthArray = config_item("all_months");
                        foreach ($result as $key => $value) {
                        $condition = array(
                        "emp_id"  => $value->eid,
                        "year"    => $value->year,
                        "month"   => $value->month,
                        );
                        $advanced = $this->action->read_sum("advanced_payment","amount",$condition);
                        $advanced = ($advanced) ? $advanced[0]->amount : 0.00;
                        $totalAdvanced += $advanced;
                        ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $advanced; ?></td>
                            <td><?php echo $value->paid; ?></td>
                            <td>The payment of  the month of
                                <?php
                                echo $monthArray[$value->month];
                                ?>&nbsp;has been Paid
                            </td>
                            <td>
                                <?php
                                $balance = $value->total - $value->paid;
                                $status = ($balance < 0) ? "Receivable" : "Payable";
                                echo abs($balance) . " TK  " . $status;
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } */ ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php
        $allMonths     = config_item('all_months');
        $totalAdvanced = $totalBonus = $totalSalary = 0.00;
        $emp_name = '';
        if (!empty($_POST['search']['emp_id'])){
            $emp_name = get_name('employee', 'name', ['emp_id' => $_POST['search']['emp_id']]);
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Payment
                        of <?php echo $emp_name; ?></h1>

                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <?php 
                if (!empty($_GET['i']) && !empty($_GET['f']) && !empty($_GET['t'])):
                    $i = $advanced_total = $salary_total = 0;
            ?>
            <div class="panel-body alert-info">
                <?php echo $this->session->flashdata("confirmation"); ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4" style="text-align: left;"><strong>Name: <?= $emp_this->name ?></strong></div>
                        <div class="col-md-4" style="text-align: center;">Joined: <?= $emp_this->joining_date ?></div>
                        <div class="col-md-4" style="text-align: right;">ID: <?= $emp_this->emp_id ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" style="text-align: left;">Designation: <?= $emp_this->designation ?></div>
                        <div class="col-md-4" style="text-align: center;">e-Mail: <?= $emp_this->email ?></div>
                        <div class="col-md-4" style="text-align: right">Mobile: <?= $emp_this->mobile ?></div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr style="text-align: center;" class="alert-info">
                                <td colspan="5"><strong style="font-size: large;">Advanced</strong></td>
                            </tr>
                            <tr>
                                <th width="60">SL</th>
                                <th>Date</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Amount</th>
                            </tr>
                            <?php 
                                foreach ($advances as $key => $value):
                                    $advanced_total += $value->amount;
                            ?>
                            <tr>
                                <td width="60"><?= ++$i; ?></td>
                                <td><?= $value->created; ?></td>
                                <td><?= date('Y',strtotime($value->payment_date)); ?></td>
                                <td><?= date('m',strtotime($value->payment_date)); ?></td>
                                <td><?= $value->amount; ?></td>
                            </tr>
                            <?php 
                                endforeach;
                            ?>
                            <tr>
                                <th colspan="4" style="text-align: right;">Total</th>
                                <th><?= $advanced_total; ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr style="text-align: center;" class="alert-info">
                                <td colspan="5"><strong style="font-size: large;">Salary</strong></td>
                            </tr>
                            <tr>
                                <th width="60">SL</th>
                                <th>Date</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Amount</th>
                            </tr>
                            <?php 
                                foreach ($salaries as $key => $value):
                                    $salary_total += $value->amount;
                            ?>
                            <tr>
                                <td width="60"><?= ++$i; ?></td>
                                <td><?= $value->created; ?></td>
                                <td><?= date('Y',strtotime($value->payment_date)); ?></td>
                                <td><?= date('m',strtotime($value->payment_date)); ?></td>
                                <td><?= $value->amount; ?></td>
                            </tr>
                            <?php 
                                endforeach;
                            ?>
                            <tr>
                                <th colspan="4" style="text-align: right;">Total</th>
                                <th><?= $salary_total; ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                </div>
            </div>
            <?php
                else:
            ?>
            <div class="panel-body">
                <?php echo $this->session->flashdata("confirmation"); ?>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="60">SL</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Mobile</th>
                                <th>Designation</th>
                                <th>Salary</th>
                                <th>Bonus</th>
                                <th>Overtime</th>
                                <th>Advanced Payment</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                            <?php
                                $i = 1;
                                $tot_salary = $tot_bonus = $tot_balance = $tot_overtime = $tot_advanced = $tot_paid = 0.00;
                                if(!empty($employee_history)):
                                    foreach ($employee_history as $k => $val):
                                        ?>
                                        <tr style="text-align: center; <?= empty(reset($val)['path']) ? 'display: none;':''; ?>" class="alert-info" id="<?= $k ?>">
                                            <td colspan="13"><strong><?= $k; ?></strong></td>
                                        </tr>
                                        <?php
                                        foreach ($val as $key => $value):
                                            // if(empty($emp_id)):
                                            //     $emp_id = $key;
                                            // endif;
                                            if(!empty($value['name'])):
                                                // if($emp_id == $key):
                                                    //bonus
                                                    if(!empty($bonus[$value['emp_id']])):
                                                        $this_bonus = $value['employee_salary']*$bonus[$value['emp_id']]->bonus/100;
                                                    else:
                                                        $this_bonus = '0.00';
                                                    endif;

                                                    //overtime_total_amount
                                                    if(!empty($value['overtime_total_amount'])):
                                                        $overtime_total_amount = $value['overtime_total_amount'];
                                                    else:
                                                        $overtime_total_amount = '0.00';
                                                    endif;

                                                    //advanced_payment_amount
                                                    if(!empty($value['advanced_payment_amount'])):
                                                        $advanced_payment_amount = $value['advanced_payment_amount'];
                                                    else:
                                                        $advanced_payment_amount = '0.00';
                                                    endif;
                                                    $this_paid = $value['total_salary'] + $value['adjust_amount'] - $advanced_payment_amount;
                                                    $this_balance = $value['total_salary'] + $value['adjust_amount'] - $advanced_payment_amount - $this_paid;

                                                    $tot_salary     +=  $value['total_salary'];
                                                    $tot_bonus      +=  $this_bonus;
                                                    $tot_overtime   +=  $overtime_total_amount;
                                                    $tot_advanced   +=  $advanced_payment_amount;
                                                    $tot_paid       +=  $this_paid;
                                                    $tot_balance    +=  $this_balance;
                                            ?>
                                            <tr class="<?= $k ?>">
                                                <td width="60"><?= $i++; ?></td>
                                                <td><?= $value['emp_id']; ?></td>
                                                <td><?= $value['name']; ?></td>
                                                <td style="text-align: center;" ><img height="60"src="<?= site_url($value['path']); ?>" alt="<?= $value['emp_id']; ?>"></td>
                                                <td><?= $value['mobile']; ?></td>
                                                <td><?= $value['designation']; ?></td>
                                                <td><?= $value['total_salary']; ?></td>
                                                <td><?= $this_bonus; ?></td>
                                                <td><?= $overtime_total_amount; ?></td>
                                                <td><?= $advanced_payment_amount; ?></td>
                                                <td><?= $this_paid; ?></td>
                                                <td><?= $tot_balance; ?></td>
                                                <td>
                                                    <a class="btn btn-info" title="History" href="<?= site_url('salary/payment/all_payment?i='.get_encode($value['emp_id'], 'urlencode').'&f='.get_encode($from, 'urlencode').'&t='.get_encode($to, 'urlencode')) ?>">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <a onclick="return confirm('Do you want to delete this data?');" class="btn btn-danger" title="Delete" href="<?= site_url('salary/payment/delete_payment?d='.get_encode($value['date'], 'urlencode').'&i='.get_encode($value['emp_id'], 'urlencode')) ?>">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                                // endif;
                                            endif;
                                        endforeach;
                                    endforeach;
                                endif;
                                ?>
                            <tr>
                                <th colspan="6" class="text-right">Total</th>
                                <th><?= get_number_format($tot_salary) ?> TK</th>
                                <th><?= get_number_format($tot_bonus) ?> TK</th>
                                <th><?= get_number_format($tot_overtime) ?> TK</th>
                                <th><?= get_number_format($tot_advanced) ?> TK</th>
                                <th><?= get_number_format($tot_paid) ?> TK</th>
                                <th><?= get_number_format($tot_balance) ?> TK</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php 

                endif;
            ?>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM',
        useCurrent: false
    });
</script>