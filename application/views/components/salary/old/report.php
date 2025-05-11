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
</style>

<div class="container-fluid" ng-controller="SalaryReportCtrl">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Report</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print </a>
                </div>
            </div>

            <div class="panel-body">
                <form class="form-horizontal none" ng-submit="getSalaryRecordFn()">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Year </label>
                                <div class="col-md-5">
                                    <select ng-model="where.year" class="form-control" required>
                                        <option value="">&nbsp;</option>
                                        <?php
                                        for($i=2016; $i <= date('Y'); $i++){
                                        ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Month </label>
                                <div class="col-md-5">
                                    <select ng-model="where.month" class="form-control" required>
                                        <option value="">&nbsp;</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-7">
                                    <input type="submit" name="read" value="Show" class="btn btn-info pull-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Print banner -->
                <!-- img class="hide img-responsive print-banner" src="<?php echo site_url('private/images/print-banner.jpg'); ?>" alt="" -->
                <img class="img-responsive hide" src="<?php echo site_url('private/images/te.jpg'); ?>" style="width:100%" alt="">
                <p class="text-center hide" style="margin:10px auto;">Report</p>
                <!-- <span class="hide print-time"><?php echo $this->data['name'] . ' | ' . date('Y, F j H:i a'); ?></span> -->

                <div ng-if="active" ng-cloak>
                    <hr class="none" style="border: 1px dashed  #ddd; margin-top: 5px;">
                    <input type="text" ng-model="search" class="form-control none" placeholder="Search ...">

                    <div class="none">&nbsp;</div>

                    <table class="table table-bordered" >
                        <tr>
                            <th width="40"> SL </th>
                            <th width="120"> ID </th>
                            <th> Name </th>
                            <th> Image </th>
                            <th> Post </th>
                            <th width="120"> Basic </th>
                            <th> Salary </th>
                            <th width="60"> Status </th>
                            <th class="none" width="60"> Action </th>
                        </tr>

                        <tr dir-paginate="row in resultset|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
                            <td> {{ row.sl }} </td>
                            <td> {{ row.eid }} </td>
                            <td> {{ row.name }} </td>

                            <td style="width: 60px;padding: 2px;">
                                <img
                                    ng-src="<?php echo site_url(); ?>{{ row.img }}"
                                    width="60px" height="60px"
                                    alt="Employee pic not found!">
                            </td>

                            <td> {{ row.post }} </td>
                            <td> {{ row.basic |fNumber }} </td>
                            <td> {{ row.total |fNumber }} </td>
                            <td> {{ row.status }} </td>

                            <td class="none">
                                <a title="View"
                                    class="btn btn-primary"
                                    href="<?php echo site_url('salary/payment/payment_view?id='); ?>{{ row.eid }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </table>

                    <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
                </div>
	        </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
