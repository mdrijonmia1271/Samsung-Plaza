<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>
<script src="<?php echo site_url('private/js/ngscript/clientSearchCtrl.js?') . time(); ?>"></script>

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

    .mb-1 {
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid" ng-controller="clientSearchCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Client Wise</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <div class="form-group">

                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3 mb-1">
                            <select class="form-control" name="godown_code"
                                    ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                                    ng-model="godown_code">
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if (!empty($allGodowns)) {
                                    foreach ($allGodowns as $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                               ng-model="godown_code" required>
                    <?php } ?>

                    <div class="col-md-3 mb-1">
                        <select class="form-control" ng-model="customer_type">
                            <option value="" selected>-- Select Client Type ---</option>
                            <option value="dealer">Dealer</option>
                            <option value="hire">Hire</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-1">
                        <select name="party_code" ui-select2="{ allowClear: true}" class="form-control"
                                ng-model="party_code"
                                data-placeholder="Select Client" required>
                            <option value="" selected disable></option>
                            <option ng-repeat="client in clientList" value="{{client.code}}">{{
                                client.code+"-"+client.name +"-"+ client.mobile}}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-1">
                        <select name="product_cat" ui-select2="{ allowClear: true}" class="form-control"
                                ng-model="product_cat"
                                data-placeholder="Select Category">
                            <option value="" selected disable></option>
                            <?php
                            if (!empty($allCategory)) {
                                foreach ($allCategory as $value) {
                                    echo '<option value="' . $value->category . '">' . filter($value->category) . '</option>';
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-1">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="dateFrom" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 mb-1">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="dateTo" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php if (!empty($result)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result &nbsp;&nbsp; <small>Total Found (<?php echo count($result); ?>
                                ) Items</small>
                        </h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                    <!-- Print banner End Here -->
                    <h4 class="text-center hide" style="margin-top: 0px;">All Sale</h4>
                    <table class="table table-bordered table2">
                        <tr class="bg-info">
                            <th width="40">SL</th>
                            <th width="100">Date</th>
                            <th>Product name</th>
                            <th>Model</th>
                            <th>Quantity</th>
                            <th>Pur. Price</th>
                            <th>Sale Price</th>
                        </tr>
                        <?php
                        $totalQuantity = $totalPurchasePrice = $totalSalePrice = 0;
                        foreach ($result as $_key => $item) {
                            ?>
                            <tr>
                                <td><?= ++$_key ?></td>
                                <td><?= $item->sap_at ?></td>
                                <td><?= filter($item->category) ?></td>
                                <td><?= $item->product_model ?></td>
                                <td><?php echo $item->quantity;
                                    $totalQuantity += $item->quantity ?></td>
                                <td><?php echo get_number_format($item->purchase_price);
                                    $totalPurchasePrice += $item->purchase_price ?></td>
                                <td><?php echo get_number_format($item->sale_price);
                                    $totalSalePrice += $item->sale_price ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <th colspan="4" class="text-right"> Total</th>
                            <th> <?= $totalQuantity ?> </th>
                            <th> <?= get_number_format($totalPurchasePrice) ?> </th>
                            <th> <?= get_number_format($totalSalePrice) ?> </th>
                        </tr>
                        <tr class="bg-info">
                            <th colspan="4" class="text-right">Total profit</th>
                            <th></th>
                            <th colspan="2"
                                class="text-center"><?= get_number_format(($totalSalePrice - $totalPurchasePrice)) ?></th>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
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
</script>