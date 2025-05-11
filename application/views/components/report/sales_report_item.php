<?php if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true); ?>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
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
<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Sale Item Wise Report</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>
                <div class="form-group">
                    <?php
                    if (checkAuth('super')) {
                        $allGodown = getAllGodown();
                        ?>
                        <div class="col-md-4 mb_3">
                            <select name="godown_code" class="form-control">
                                <option value="" selected disabled>-- Select Showroom --</option>
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
                        <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                    <?php } ?>

                    <div class="col-md-4 mb_3">
                        <select name="product_code" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected>-- Select Model --</option>
                            <?php
                            if (!empty($allProduct)) {
                                foreach ($allProduct as $row) {
                                    echo '<option value="' . $row->product_code . '"> ' . $row->product_code . '-' . $row->product_model . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb_3">
                        <select name="product_cat" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected>-- Select Category --</option>
                            <?php
                            if (!empty($allCategory)) {
                                foreach ($allCategory as $row) {
                                    echo '<option value="' . $row->category . '"> ' . filter($row->category) . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb_3">
                        <select name="subcategory" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected>-- Select Subcategory --</option>
                            <?php
                            if (!empty($allSubCategory)) {
                                foreach ($allSubCategory as $row) {
                                    echo '<option value="' . $row->subcategory . '"> ' . filter($row->subcategory) . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb_3">
                        <select name="brand" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected>-- Select Brand --</option>
                            <?php
                            if (!empty($allBrand)) {
                                foreach ($allBrand as $row) {
                                    echo '<option value="' . $row->brand . '"> ' . filter($row->brand) . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>


                    <div class="col-md-4 mb_3">
                        <select name="product_serial" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected>--Serial--</option>
                            <?php
                            if (!empty($allProductSerial)) {
                                foreach ($allProductSerial as $row) {
                                    echo '<option value="' . $row->product_serial . '"> ' .filter($row->product_model).'-'. filter($row->product_serial) . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>


                    <div class="col-md-offset-2 col-md-3 mb_3">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '') ?>" class="form-control" placeholder="From ( YYYY-MM-DD )">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 mb_3">
                        <div class="input-group date" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : '') ?>" class="form-control" placeholder="To ( YYYY-MM-DD )">
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
        <?php if (!empty($results)){ ?>
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

                <!--<h4 class="hide text-center" style="margin-top: 0px;">All Sales Report</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>Sales Item Report</h3>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Showroom</th>
                        <th>Voucher No</th>
                        <th>Product Name</th>
                        <th>Product Serial</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Sale Price</th>
                        <th>Amount (TK)</th>

                    </tr>
                    <?php
                    $total_amount = 0;
                    $total_quantity = 0;
                    foreach ($results as $key => $value) {
                        $amount = $value->quantity * $value->sale_price;
                        $total_amount += $amount;
                        $total_quantity += $value->quantity;
                        ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value->godown_name ?></td>
                            <td><?= $value->voucher_no ?></td>
                            <td><?= filter($value->product_model) ?></td>
                            <td><?= $value->product_serial ?></td>
                            <td><?= $value->unit ?></td>
                            <td><?= $value->quantity ?></td>
                            <td><?= f_number($value->sale_price, 2) ?></td>
                            <td><?= f_number($amount, 2) ?></td>
                        </tr>
                        <?php } ?>
                    <tr>
                        <td colspan="6" class="text-right">Total</td>
                        <td><?= $total_quantity ?> </td>
                        <td></td>
                        <td><?= f_number($total_amount, 2) ?> Tk</td>
                    </tr>
                    <?php ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

    </div>
    <?php } ?>
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>