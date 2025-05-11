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

        .table-print tr th:last-child,
        .table-print tr td:last-child {
            display: none;
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Installment Collection</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php echo form_open(); ?>
                <div class="row">
                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="godown_code" id="godown_code" class="form-control">
                                    <option value="" selected disabled>-- Select Showroom --</option>
                                    <option value="all">All Showroom</option>
                                    <?php if (!empty($allGodowns)) {
                                        foreach ($allGodowns as $row) { ?>
                                            <option value="<?php echo $row->code; ?>">
                                                <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" id="client_dropdown" class=" form-control"
                                    ng-model="party_code" ng-change="getPartyInfo();">
                                <option value="" selected>-- Select Client --</option>
                                <?php
                                if (!empty($clientInfo)) {
                                    foreach ($clientInfo as $row) { ?>
                                        <option value="<?php echo $row->code; ?>"><?php echo $row->code . "-" . filter($row->name) . "-" . $row->mobile; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type='text' name='search[inc_code]' class='form-control' placeholder='Invoice No'>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="search[brand]" class="form-control">
                                <option value="" selected>Select brand</option>
                                <?php if (!empty($brandList)) {
                                    foreach ($brandList as $item) {
                                        echo '<option value="' . $item->brand . '">' . filter($item->brand) . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="To">
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
        <?php if ($transactionInfo != NULL) { ?>
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
                    <h4 class="text-center hide" style="margin-top: 0px;">All Installment Collection</h4>
                    <table class="table table-bordered table-print">
                        <tr>
                            <th style="width: 50px;">SL</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>C.ID</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Paid By</th>
                            <th>Paid</th>
                            <th>Adjustment</th>
                            <th class="none">Action</th>
                        </tr>
                        <?php
                        $totalAmount = $totalAdjustment = 0;
                        foreach ($transactionInfo as $key => $row) {
                            $where = array("code" => $row->party_code);
                            $info  = $this->action->read("parties", $where);
                            if ($info != null) {
                                if ($info[0]->type == 'client') {
                                    $totalAmount += $row->credit;
                                    $totalAdjustment += $row->adjustment;
                                    ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $row->transaction_at; ?></td>
                                        <td><?php echo $row->inc_code; ?></td>
                                        <td><?php echo $row->party_code; ?></td>
                                        <td><?php echo filter($info[0]->name); ?></td>
                                        <td><?php echo filter($row->brand); ?></td>
                                        <td><?php echo filter($row->transaction_via); ?></td>
                                        <td><?php echo f_number($row->credit); ?></td>
                                        <td><?php echo f_number($row->adjustment); ?></td>
                                        <td class="none" width="160px">
                                            <a class="btn btn-info"
                                               href="<?php echo site_url('client/all_transaction/view/' . $row->id); ?>"><i
                                                        class="fa fa-eye" aria-hidden="true"></i></a>

                                            <?php
                                            $privilege = $this->data['privilege'];
                                            if ($privilege != 'user') {
                                                ?>
                                                <a class="btn btn-warning" title="Edit"
                                                   href="<?php echo site_url('client/transaction/edit_transaction/' . $row->id); ?>"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="<?php echo site_url('client/all_transaction/delete_transaction/' . $row->id); ?>"
                                                   class="btn btn-danger"
                                                   onclick="return confirm('Are you sure to delete this ?')"><i
                                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                            }
                        } ?>
                        <tr>
                            <td colspan="7" class="text-right"><strong>Total</strong></td>
                            <td><strong><?php echo f_number($totalAmount); ?> TK</strong></td>
                            <td><strong><?php echo f_number($totalAdjustment); ?> TK</strong></td>
                            <td></td>
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

    $('#client_dropdown').select2({
        matcher: function (term, text, option) {
            return text.toUpperCase().indexOf(term.toUpperCase()) >= 0 || option.val().toUpperCase().indexOf(term.toUpperCase()) >= 0;
        }
    });


    $("#godown_code").change(function () {
        var godown_code = $("#godown_code").val();
        $.post("<?php echo site_url('client/all_transaction/client_info_godown_wise');  ?>",
            {godown_code: godown_code},
            function (data, success) {
                $('#client_dropdown').empty();
                $('#client_dropdown').append(data);
            });
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>