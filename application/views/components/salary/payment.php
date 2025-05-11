<style type="text/css">
    .info-view {
        width: 100%;
        max-width: 230px;
        max-height: 230px;
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    .custom-table tr td {
        padding: 0 !important;
    }

    .custom-table tr td .form-control {
        border: transparent;
    }

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
</style>

<div class="container-fluid" ng-controller="PaymentCtrl" ng-cloak>

    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left"><h1>Payment </h1></div>
            </div>


            <div class="panel-body">

                <?= form_open('', ['class' => 'form-horizontal']) ?>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Date <span class="req">*</span> </label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date" class="form-control" value="<?= date('Y-m-d') ?>"
                                   placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Set Month <span class="req">*</span></label>
                    <div class="col-md-5">
                        <div class="col-md-6">
                            <div class="row">
                                <select name="year" class="form-control">
                                    <option value="" selected disabled>-- Year --</option>
                                    <?php
                                    for ($y = date('Y') + 1; $y >= 2018; $y--) {
                                        echo '<option value="' . $y . '" ' . (!empty($_POST['year']) && $_POST['year'] == $y ? "selected" : (empty($_POST['year']) && $y == date('Y') ? "selected" : "")) . ' > ' . $y . ' </option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <select name="month" class="form-control">
                                    <option value="" selected disabled>-- Month --</option>
                                    <?php
                                    if (!empty(config_item('all_months')))
                                        foreach (config_item('all_months') as $_key => $m_value) {
                                            echo '<option value="' . $_key . '" ' . (!empty($_POST['month']) && $_POST['month'] == $_key ? "selected" : (empty($_POST['month']) && date('m') == $_key ? "selected" : "")) . '> ' . $m_value . ' </option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 text-right">
                        <input type="submit" name="show" class="btn btn-primary" value="Search">
                    </div>
                </div>
                <?= form_close() ?>


                <!--Print Banner Start Here-->

                <?php $banner_info = $this->action->read("banner"); ?>
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>"
                     alt="">

                <!--Print Banner End Here-->

                <?php if (!empty($result)) { ?>

                    <?= form_open('salary/payment/store_payment') ?>


                    <input type="hidden" name="created"
                           value="<?= (!empty($_POST['date']) ? $_POST['date'] : date('Y-m-d')) ?>">

                    <input type="hidden" name="payment_date"
                           value="<?= ((!empty($_POST['year']) && !empty($_POST['month'])) ? date('Y-m-t', strtotime(($_POST['year'] . '-' . $_POST['month']))) : date('Y-m-t', strtotime('today'))) ?>">

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60">
                                        <input type="checkbox" checked id="check_all"> SL
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Mobile</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Bonus</th>
                                    <th>Overtime</th>
                                    <th>Deduction</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                </tr>

                                <?php
                                $grandTotalSalary = $totalSalary = $totalPaidAmount = $totalBonus = $totalOvertime = $totalAdvance = 0;
                                $sl_no            = 0;
                                foreach ($result as $key => $row) {

                                    $bonus         = (!empty($row->bonus) ? ($row->basic_salary * $row->bonus) / 100 : 0);
                                    $adjust_amount = (!empty($row->adjust_amount) ? $row->adjust_amount : 0);
                                    $overtime      = (!empty($row->overtime) ? abs($row->overtime) : 0);
                                    $previous_paid = (!empty($row->previous_paid) ? $row->previous_paid : 0);
                                    $advance_paid  = (!empty($row->advance_paid) ? $row->advance_paid : 0);

                                    $basic_salary = ($row->basic_salary + $adjust_amount);

                                    $totalSalary = ($basic_salary + $bonus + $overtime);
                                    $deduction   = ($previous_paid + $advance_paid);

                                    $totalBonus    += $bonus;
                                    $totalOvertime += $overtime;
                                    $totalAdvance  += $advance_paid;

                                    $payment         = $totalSalary - $deduction;
                                    $totalPaidAmount += $payment;

                                    $grandTotalSalary += $basic_salary;
                                    ?>

                                    <input type="hidden" name="total_salary[]" value="<?= $totalSalary ?>">
                                    <input type="hidden" name="deduction[]" value="<?= $deduction ?>">

                                    <tr>
                                        <td>
                                            <input type="checkbox" name="id[]" checked
                                                   value="<?= $key ?>">&nbsp;&nbsp;<?= ++$key ?>
                                        </td>
                                        <td>
                                            <?= $row->emp_id ?>
                                            <input type="hidden" name="emp_id[]" value="<?= $row->emp_id ?>">
                                        </td>
                                        <td><?= filter($row->name); ?></td>
                                        <td style="padding: 0 !important;">
                                            <img class="img-responsive" src="<?= site_url($row->path) ?>"
                                                 width="60" height="50" alt="">
                                        </td>
                                        <td>
                                            <?= $row->mobile ?>
                                            <input type="hidden" name="mobile[]" value="<?= $row->mobile ?>">
                                        </td>
                                        <td><?= filter($row->designation) ?></td>
                                        <td><?= get_number_format($basic_salary) ?></td>
                                        <td>
                                            <?= get_number_format($bonus) ?>
                                            <input type="hidden" name="bonus[]" value="<?= $bonus ?>">
                                        </td>
                                        <td>
                                            <?= get_number_format($overtime); ?>
                                            <input type="hidden" name="over_time[]" value="<?= $overtime ?>">
                                        </td>
                                        <td>
                                            <?= get_number_format(($deduction)) ?>
                                        </td>
                                        <td>
                                            <?= get_number_format($payment) ?>
                                        </td>

                                        <td style="padding: 0 !important;">
                                            <input type="text" name="paid[]"
                                                   value="<?= ($payment > 0 ? $payment : 0) ?>"
                                                   class="form-control">
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <th colspan="6" class="text-right">Total</th>
                                    <th><?= get_number_format($totalSalary) ?></th>
                                    <th><?= get_number_format($totalBonus) ?></th>
                                    <th><?= get_number_format($totalOvertime) ?></th>
                                    <th><?= get_number_format($totalAdvance) ?></th>
                                    <th><?= get_number_format($totalPaidAmount) ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            <input type="submit" name="create" value="Paid" class="btn btn-info"/>
                        </div>
                    </div>

                    <?= form_close() ?>
                <?php } ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#check_all").on("change", function () {
            if ($(this).is(":checked") == true) {
                $('input[name="id[]"]').prop("checked", true);
            } else {
                $('input[name="id[]"]').prop("checked", false);
            }
        });
    });
</script>
