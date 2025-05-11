<style>
    @media print{
        aside, nav, .panel-heading, .panel-footer, .none{
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

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Transaction</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php $attr = array ('class' => 'form-horizontal');
                echo form_open('', $attr); ?>

                <div class="form-group">

                    <div class="" ng-init="type='Person'">
                        <label class="col-md-2 control-label">Type <span class="req">*</span></label>
                        <div class="col-md-3">
                            <label class="radio-inline">
                                <input type="radio" name="type" ng-model="type" value="Bank" required>
                                <strong>Bank</strong>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" ng-model="type" value="Person"  required>
                                <strong>Person</strong>
                            </label>
                        </div>
                    </div>

                    <!-- Bank Info -->
                    <div ng-if="type == 'Bank'">

                        <div class="">
                            <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                            <div class="col-md-3">
                               <!--  <input type="text" name="account_no" class="form-control"> -->
                               <select class="form-control" name="search[loan_id]">
                                    <option value="" selected>-- Select --</option>
                                    <?php foreach ($banks as $bank) { ?>
                                    <option value="<?php echo $bank->id; ?>"><?php echo $bank->account_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <!-- Person -->
                    <div ng-if="type == 'Person'">
                        <div class="">
                            <label class="col-md-2 control-label">Person Name <span class="req">*</span></label>
                            <div class="col-md-3">
                                <!-- <input type="text" name="person_name" class="form-control"> -->
                                <select class="form-control" name="search[loan_id]">
                                    <option value="" selected>-- Select --</option>
                                    <?php foreach ($persons as $person) { ?>
                                    <option value="<?php echo $person->id; ?>"><?php echo $person->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="">
                        <label class="col-md-2 control-label">From</label>
                        <div class="col-md-3">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label class="col-md-2 control-label">To</label>
                        <div class="col-md-3">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>



                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php if ($transaction != null) { ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                
                <h3 class="text-center hide" style="margin-top: 0px;">All Loan Information</h3>
                <div class="col-md-3">
                    <div class="row">
                        <table class="table table-bordered">
                            <tr>
                                <th>Bank / Person Name</th>
                                <td><?php echo filter($info[0]->name); ?></td>
                            </tr>
                            <tr>
                                <th>Loan By</th>
                                <td><?php echo $info[0]->loan_by; ?></td>
                            </tr>
                            <tr>
                                <th>Contact Info</th>
                                <td><?php echo $info[0]->contact_info; ?></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><?php echo $info[0]->type; ?></td>
                            </tr>
                            <tr>
                                <th>Loan Type</th>
                                <td><?php echo $info[0]->loan_type; ?></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td><?php echo $info[0]->amount; ?></td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td><?php echo $info[0]->status; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th> Date </th>
                        <th> Amount </th>
                    </tr>
                   <?php
                   $total = array();
                   foreach($transaction as $key => $row){
                   ?>
                   <tr>
                       <td> <?php echo $key + 1; ?> </td>
                       <td> <?php echo $row->date; ?> </td>
                       <td> <?php echo f_number($total[] = $row->amount); ?> </td>
                   </tr>
                   <?php } ?>

                    <tr>
                        <th class="text-right" colspan="2">Total</th>
                        <th><?php echo f_number(array_sum($total)); ?></th>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    <?php } ?>
    </div>
</div>

<script type="text/javascript">
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>