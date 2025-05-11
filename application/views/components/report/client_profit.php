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
<script src="<?php echo site_url('private/js/ngscript/clientProfitReportCtrl.js') ?>"></script>

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

        .title {
            font-size: 25px;
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
</style>

<div class="container-fluid" ng-controller="clientProfitReportCtrl">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1> Profit/Loss Report</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>

                <div class="form-group">

                    <?php
                    if (checkAuth('super')) {
                        $allGodown = getAllGodown();
                        ?>
                        <div class="col-md-2">
                            <select name="godown_code" id="godown_code" ng-model="select_godown_code"
                                    ng-change="getAllClientFn()" class="form-control">
                                <option value="" selected>-- Select Showroom --</option>
                                <option value="all">All Showroom</option>
                                <?php if (!empty($allGodown)) {
                                    foreach ($allGodown as $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" ng-model="godown_code"
                               ng-init="godown_code='<?php echo $this->data['branch']; ?>'" name="godown_code"
                               value="<?php echo $this->data['branch']; ?>" required>
                    <?php } ?>

                    <div class="col-md-3">
                        <select ui-select2="{ allowClear: true }" class="form-control" name="search[party_code]"
                                ng-model="party_code"
                                data-placeholder="Select Client">
                            <option value="" selected disable></option>
                            <option ng-repeat="client in clientList" value="{{client.code}}">{{
                                client.code+"-"+client.name +"-"+ client.mobile }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No.">
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
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


        <?php if (!empty($resultInfo)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title">
                        <h1 class=" pull-left"> Show Result </h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                    <!-- Print banner End Here -->

                    <div class="col-md-12 text-center hide">
                        <h3>Client Wise
                            Profit/Loss Report</h3>
                    </div>

                    <!--<h4 class="hide text-center" style="margin-top: 0px;"> </h4>-->

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40">SL</th>
                                <th>Client Name</th>
                                <th>Address</th>
                                <th>V.No</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">P. price</th>
                                <th class="text-center">S. Price</th>
                                <th class="text-center">Comm</th>
                                <th class="text-center">Profit</th>
                                <th class="text-center">Loss</th>
                            </tr>

                            <?php
                            $totalQuantity = $totalPurchase = $totalSale = $totalComm = $totalLoss = $totalProfit = 0;

                            foreach ($resultInfo as $key => $row) {
                                $totalQuantity += $row['total_quantity'];
                                $totalPurchase += $row['total_purchase_price'];
                                $totalSale     += $row['total_sale_price'];
                                $totalComm     += $row['total_discount'];
                                $totalProfit   += $row['profit'];
                                $totalLoss     += $row['loss'];
                                ?>
                                <tr>
                                    <td><?= (++$key) ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['voucher_no'] ?></td>
                                    <td class="text-center"><?= $row['total_quantity'] ?></td>
                                    <td class="text-center"><?= f_number($row['total_purchase_price']) ?></td>
                                    <td class="text-center"><?= f_number($row['total_sale_price']) ?></td>
                                    <td class="text-center"><?= f_number($row['total_discount']) ?></td>
                                    <td class="text-center"><?= f_number($row['profit']) ?></td>
                                    <td class="text-center"><?= f_number($row['loss']) ?></td>
                                </tr>
                            <?php } ?>

                            <tr class="bg-info" style="font-weight: bold;">
                                <td colspan="4" class="text-right">Total <small> (profit & loss)</small></td>
                                <td><?= f_number($totalQuantity) ?> Pc</td>
                                <td><?= f_number($totalPurchase) ?> Tk</td>
                                <td><?= f_number($totalSale) ?> Tk</td>
                                <td><?= f_number($totalComm) ?> Tk</td>
                                <td><?= f_number($totalProfit) ?> Tk</td>
                                <td><?= f_number($totalLoss) ?> Tk</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
    </div>
</div>


<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>