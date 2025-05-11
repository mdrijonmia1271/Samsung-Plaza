<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style type="text/css">
    @media print {

        aside,
        nav,
        .none,
        .panel-heading,
        .panel-footer {
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

        .print_banner_logo {
            width: 19%;
            float: left;
        }

        .print_banner_logo img {
            margin-top: 10px;
        }

        .print_banner_text {
            width: 80%;
            float: right;
            text-align: center;
        }

        .print_banner_text h2 {
            margin: 0;
            line-height: 38px;
            text-transform: uppercase !important;
        }

        .print_banner_text p {
            margin-bottom: 5px !important;
        }

        .print_banner_text p:last-child {
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
        }
    }

    .table-title {
        font-size: 20px;
        color: #333;
        background: #f5f5f5;
        text-align: center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
</style>

<div class="container-fluid" ng-controller="appController" ng-cloak>
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Return</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open(); ?>
                <div class="row">

                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="godown_code" ng-init="godownCode=''" ng-model="godownCode" class="form-control">
                                    <option value="" selected disabled>Select Showroom</option>
                                    <option value="all"> All Showroom</option>
                                    <?php if (!empty($godownList)) {
                                        foreach ($godownList as $row) { ?>
                                            <option value="<?php echo $row->code; ?>">
                                                <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <input type="hidden" name="godown_code" ng-init="godownCode='<?php echo $this->data["branch"]; ?>'" ng-value="godownCode">
                    <?php } ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select ui-select2="{ allowClear: true}" class="form-control" name="search[party_code]" ng-model="partyCode">
                                <option value="" selected disable>Select Supplier</option>
                                <option ng-repeat="row in partyList" value="{{row.code}}">{{ row.name
                                    }} -
                                    {{ row.address }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="text-center hide" style="margin-top: 0px;">All Purchase Return</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Purchase Return
                    </h3>
                </div>

                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Supplier Name</th>
                        <th>Mobile</th>
                        <th>Total Amount</th>
                        <?php if (checkAuth('super')) { ?>
                            <th>Showroom</th>
                        <?php } ?>
                        <th class="none" width="125">Action</th>
                    </tr>

                    <?php
                    $totalAmount = $totalQuantity = 0;
                    if (!empty($results)) {
                        foreach ($results as $key => $row) {
                            $totalAmount   += $row->total_bill;
                            $totalQuantity += $row->total_quantity;
                            ?>
                            <tr>
                                <td style="width: 40px;"><?php echo $key + 1; ?></td>
                                <td><?php echo $row->sap_at; ?></td>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->mobile; ?></td>
                                <td><?php echo $row->total_bill; ?></td>
                                <?php if (checkAuth('super')) { ?>
                                    <td><?php echo $row->godown_name; ?></td>
                                <?php } ?>
                                <td class="none text-center">
                                    <?php if ($row->voucher_no != null) { ?>
                                        <a title="View" class="btn btn-primary"
                                           href="<?php echo site_url('purchase/productReturn/show?vno=' . $row->voucher_no); ?>">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>

                                    <?php if (!checkAuth('user')) { ?>
                                        <a title="Delete" class="btn btn-danger"
                                           onclick="return confirm('Are you sure want to delete this Data?');"
                                           href="<?php echo site_url('purchase/productReturn/delete?vno=' . $row->voucher_no); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
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

    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });

    app.controller('appController', function ($scope, $http) {

        $scope.partyList = [];
        $scope.$watch('godownCode', function (godownCode) {

            $scope.partyList = [];
            if (typeof godownCode !== 'undefined' && godownCode != ''){

                var where = {
                    table: 'parties',
                    cond: {type: 'supplier', trash: 0},
                    select: ['code', 'name', 'mobile', 'address']
                };

                if (godownCode != 'all'){
                    where.cond.godown_code = godownCode;
                }

                $http({
                    method: 'post',
                    url: url + 'result',
                    data: where
                }).success(function (response) {
                    if (response.length > 0){
                        $scope.partyList = response;
                    }
                })
            }
        })
    })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>