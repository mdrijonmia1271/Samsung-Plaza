<?php if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style type="text/css">
    table tr td {word-break: break-all;}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Item Wise Search</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(); ?>
                <div class="row">
                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="godown_code" class="form-control">
                                    <option value="" selected disabled>Select Showroom</option>
                                    <option value="all"> All Showroom</option>
                                    <?php if (!empty($godownList)) {
                                        foreach ($godownList as $row) { ?>
                                            <option value="<?php echo $row->code; ?>" <?php echo ($this->data['branch'] == $row->code) ? 'selected' : ''; ?>>
                                                <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                    <?php } ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="product_code" class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" reaquired>
                                <option value="">Select Product</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->product_code; ?>">
                                            <?php echo filter($row->product_model); ?>
                                        </option>
                                    <?php }
                                } ?>
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
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php if (!empty($results)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result</h1>&nbs
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                    <!-- Print banner End Here -->

                    <div class="col-md-12 text-center hide">
                        <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">Item Wise Purchase</h3>
                    </div>
                    <h5 class="text-center hide" style="margin-top: 5px;">Item Report</h5>
                    <table class="table table-bordered table2">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Voucher No</th>
                            <th>Model</th>
                            <th>Serial</th>
                            <th>Quantity</th>
                            <?php if (checkAuth('super')) { ?>
                                <th>Showroom</th>
                            <?php } ?>
                            <th width="60" class="none">Action</th>
                        </tr>
                        <?php
                        $total = 0;
                        foreach ($results as $key => $val) {
                            $total += $val->quantity;
                            ?>
                            <tr>
                                <td style="width: 40px;"><?php echo $key + 1; ?></td>
                                <td><?php echo $val->sap_at; ?></td>
                                <td><?php echo $val->voucher_no; ?></td>
                                <td><?php echo $val->product_model; ?></td>
                                <td><?php echo $val->product_serial; ?></td>
                                <td><?php echo $val->quantity; ?></td>
                                <?php if (checkAuth('super')) { ?>
                                    <td><?php echo filter($val->godown_name); ?></td>
                                <?php } ?>
                                <td class="none">
                                    <a title="View" class="btn btn-primary"
                                       href="<?php echo site_url('purchase/purchase/view?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="5" style="text-align: right; "> Total</th>
                            <td colspan="3"> <?php echo $total . "&nbsp;" ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script>
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

    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>