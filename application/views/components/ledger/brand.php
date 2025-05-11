<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>
<style>
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

    .table tr th,
    .table tr td {
        font-size: 13px;
        padding: 4px !important;
    }

    .table tr td p {
        margin: 0;
        padding: 0;
    }
</style>
<div class="container-fluid" ng-controller="appController" ng-cloak>
    <div class="row">
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Brand Ledger</h1>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(); ?>

                <div class="row">
                    <?php
                    if (checkAuth('super')) {
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="godown_code" ng-init="godownCode='<?php echo $this->data["branch"]; ?>'" ng-model="godownCode"
                                        class="form-control" required>
                                    <option value="" selected disabled>Select Showroom</option>
                                    <option value="all">All Showroom</option>
                                    <?php if (!empty($godownList)) {
                                        foreach ($godownList as $row) { ?>
                                            <option value="<?php echo $row->code; ?>">
                                                <?php echo $row->code . '-' . filter($row->name) . '-' . $row->mobile; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="godown_code" ng-model="godownCode"
                               ng-init="godownCode = '<?php echo $this->data["branch"]; ?>'" ng-value="godownCode"
                               required>
                    <?php } ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select ui-select2="{ allowClear: true }" class="form-control" name="party_code"
                                    ng-model="partyCode" data-placeholder="Select Client">
                                <option value="" selected disable></option>
                                <option ng-repeat="client in clientList" value="{{client.code}}">{{
                                    client.code+"-"+client.name +"-"+ client.mobile }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="brand" class="form-control">
                                <option value="" selected>Select Brand</option>
                                <?php if ($brandList) {
                                    foreach ($brandList as $row) {
                                        echo '<option value="' . $row->brand . '">' . $row->brand . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
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
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>


        <?php if ($showResult) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title">
                        <h1 class="pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                    <!-- Print banner End Here -->

                    <div class="col-md-12 text-center hide">
                        <h3 class="text-center hide">Brand Ledger</h3>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Showroom</th>
                            <th>Client Name</th>
                            <th>Address</th>
                            <th>Brand</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Remission</th>
                            <th>Adjustment</th>
                            <th>Balance</th>
                        </tr>
                        <?php
                        $totalDebit = $totalCredit = $totalRemission = $totalAdjustment = $totalBalance = 0;
                        foreach ($results as $key => $row) {
                        $totalDebit     += $row->debit;
                        $totalCredit    += $row->credit;
                        $totalRemission += $row->remission;
                        $totalBalance   += $row->balance;
                        $totalAdjustment+= $row->adjustment;
                        ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $row->godown_name; ?></td>
                            <td><?php echo $row->code . ' - ' . $row->name; ?></td>
                            <td><?php echo $row->address; ?></td>
                            <td><?php echo $row->brand; ?></td>
                            <td><?php echo f_number($row->debit); ?></td>
                            <td><?php echo f_number($row->credit); ?></td>
                            <td><?php echo f_number($row->remission); ?></td>
                            <td><?php echo f_number($row->adjustment); ?></td>
                            <td><?php echo f_number($row->balance); ?></td>
                            <?php } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th><?php echo f_number($totalDebit); ?></th>
                            <th><?php echo f_number($totalCredit); ?></th>
                            <th><?php echo f_number($totalRemission); ?></th>
                            <th><?php echo f_number($totalAdjustment); ?></th>
                            <th><?php echo f_number($totalBalance); ?></th>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>




        <?php if (!$showResult) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title">
                        <h1 class="pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- Print banner Start Here -->

                    <div class="col-xs-12 hide"
                         style="border: 1px solid #ddd; padding:15px !important; margin-bottom: 15px;">
                        <div class="print_banner_logo">
                            <img class="img-responsive" src="<?php echo site_url($logo_data['faveicon']); ?>" alt="">
                        </div>
                        <div class="print_banner_text">
                            <h2><?php echo strtoupper($header_info['site_name']); ?></h2>
                            <p><?php echo $header_info['place_name']; ?></p>
                            <p><?php echo $footer_info['addr_moblile']; ?>
                                || <?php echo $footer_info['addr_email']; ?></p>
                        </div>
                    </div>

                    <!-- Print banner End Here -->
                    <h3 class="text-center hide">Brand Ledger</h3>

                    <div class="row">
                        <div class="col-xs-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%">Client ID :</th>
                                    <td><?php echo $partyInfo->code; ?></td>
                                </tr>
                                <tr>
                                    <th>Client :</th>
                                    <td><?php echo filter($partyInfo->name); ?></td>
                                </tr>
                                
                                <tr>
                                    <th> Father's Name :</th>
                                    <td>
                                        <?php
                                        $father_name = get_name('parties','father_name', ['code' => $partyInfo->code]);
                                        echo $father_name;
                                        ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th> Address :</th>
                                    <td> <?php echo $partyInfo->address; ?> </td>
                                </tr>
                                <tr>
                                    <th> Mobile :</th>
                                    <td> <?php echo $partyInfo->mobile; ?> </td>
                                </tr>

                                <tr>
                                    <th> Showroom :</th>
                                    <td>
                                        <?php echo $partyInfo->godown_name; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-offset-2 col-xs-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Date :</th>
                                    <td><?php echo (!empty($_POST['dateFrom']) ? $_POST['dateFrom'] . ' - ' : '') . (!empty($_POST['dateTo']) ? $_POST['dateTo'] : ''); ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Opening Balance :</th>
                                    <td><?php echo $partyInfo->initial_balance; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30px;">SL</th>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Voucher No</th>
                            <th>Brand</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Remission</th>
                            <th>Adjustment</th>
                            <th>Balance</th>
                        </tr>

                        <tr>
                            <td>1</td>
                            <td colspan="8">Previous Balance</td>
                            <td>
                                <?php echo $previousBalance; ?>
                            </td>
                        </tr>

                        <?php
                        $totalDebit = $totalCredit = $totalRemission = $totalAdjustment = 0;
                        $balance = $previousBalance;
                        foreach ($results as $key => $row) {
                            $totalDebit      += $row->debit;
                            $totalCredit     += $row->credit;
                            $totalRemission  += $row->remission;
                            $totalAdjustment += $row->adjustment;

                            $balance += $row->debit - ($row->credit + $row->remission) + $row->adjustment;
                            ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $row->date; ?></td>
                                <td><?php echo $row->remark; ?></td>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td><?php echo $row->brand; ?></td>
                                <td><?php echo f_number($row->debit); ?></td>
                                <td><?php echo f_number($row->credit); ?></td>
                                <td><?php echo f_number($row->remission); ?></td>
                                <td><?php echo f_number($row->adjustment); ?></td>
                                <td><?php echo f_number($row->balance); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th><?php echo f_number($totalDebit); ?></th>
                            <th><?php echo f_number($totalCredit); ?></th>
                            <th><?php echo f_number($totalRemission); ?></th>
                            <th><?php echo f_number($totalAdjustment); ?></th>
                            <th><?php echo f_number($balance); ?></th>
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

    app.controller('appController', function ($scope, $http) {

        $scope.clientList = [];

        $scope.$watch('godownCode', function (godownCode) {

            var where = {
                table: 'parties',
                cond: {type: 'client', trash: 0},
                select: ['code', 'name', 'mobile', 'address']
            }

            if (godownCode != 'all') {
                where.cond.godown_code = godownCode;
            }

            $http({
                method: 'post',
                url: url + 'result',
                data: where
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.clientList = response;
                }
            })
        })
    });
</script>