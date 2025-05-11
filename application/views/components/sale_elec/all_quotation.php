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
</style>
<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Quotation</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <div class="form-group">

                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-2">
                            <select name="godown_code" id="godown_code" class="form-control">
                                <option value="" selected>-- Select Showroom --</option>
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
                    <?php } ?>

                    <div class="col-md-2">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                    </div>

                 
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>


        <?php if ($result != null) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result &nbsp;&nbsp; Total Invoice Found(<?php echo count($result); ?>
                            )
                        </h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                    <!-- Print banner End Here -->
                    <h4 class="text-center hide" style="margin-top: 0px;">All Quotation</h4>
                    <table class="table table-bordered table2">
                        <tr>
                            <th>SL</th>
                            <th width="90">Date</th>
                            <th>Client's Name</th>
                            <th width="100">Voucher No</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <?php if (checkAuth('super')) { ?>
                                <th>Showroom</th>
                            <?php } ?>
                            <th width="160px" class="none">Action</th>
                        </tr>
                        <?php
                        $total_bill     = 0.0;
                        $total_discount = 0.00;
                        $amount         = $total_paid = $total_due = 0.00;
                        foreach ($result as $key => $row) {
                            //$due = $row->total_bill - $row->paid;
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td>
                                    <?php
                                  
                                        echo filter($row->party_code);
                                    
                                    ?>
                                </td>
                                <td><?php echo $row->voucher_no; ?> </td>
                             
                                <td><?php echo $row->total_quantity; ?> </td>
                                <td>
                                    <?php
                                    $total      = $row->total_bill;
                                    $total_bill += $total;
                                    echo f_number($total);
                                    ?>
                                </td>
                                

                            
                                <?php if (checkAuth('super')) { ?>
                                    <td><?php echo isset($row->godown_name) ? $row->godown_name : ''; ?></td>
                                <?php } ?>
                                <td class="none">

                                            <a title="View" class="btn btn-primary"
                                               href="<?php echo site_url('sale/quotation/invoice?vno=' . $row->voucher_no); ?>">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>

                                             <?php
                                                if(!checkAuth('user')) {
                                            ?>            
                                                <a onclick="return confirm('Are you sure want to delete this Sale?');"
                                                   title="Delete"
                                                   class="btn btn-danger"
                                                   href="<?php echo site_url("sale/quotation/delete/$row->voucher_no"); ?>">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total</strong></td>
                            <th><?php echo f_number($total_bill); ?> TK</th>
                            <th class="none">&nbsp;</th>
                            <th class="none">&nbsp;</th>
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


    $('#client_dropdown').select2({
        matcher: function (term, text, option) {
            return text.toUpperCase().indexOf(term.toUpperCase()) >= 0 || option.val().toUpperCase().indexOf(term.toUpperCase()) >= 0;
        }
    });


    $("#godown_code").change(function () {
        var godown_code = $("#godown_code").val();
        $.post("<?php echo site_url('sale/search_sale/client_godown_wise');  ?>",
            {godown_code: godown_code},
            function (data, success) {
                $('#client_dropdown').empty();
                $('#client_dropdown').append(data);
            });
    });


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>