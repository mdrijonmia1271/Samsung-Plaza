<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<div class="container-fluid" ng-controller="appController" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Sale</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(); ?>
                <div class="row">
                    <?php if (checkAuth('super')) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="godown_code" ng-init="godownCode=''" ng-model="godownCode"
                                        class="form-control">
                                    <option value="" selected>Select Showroom</option>
                                    <option value="all">All Showroom</option>
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
                    <?php } else { ?>
                        <input type="text" name="godown_code" ng-init="godownCode=''" ng-value="godownCode">
                    <?php } ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="product_serial" class="form-control" placeholder="IMEI No">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" ui-select2="{ allowClear: true}" class="form-control"
                                    ng-model="partyCode" data-placeholder="Select Client">
                                <option value="" selected></option>
                                <option ng-repeat="row in partyList" value="{{row.code}}">
                                    {{ row.name }} - {{ row.mobile }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[sap_type]" class="form-control">
                                <option value="" selected>Select Sale Type</option>
                                <option value="cash">Cash Sale</option>
                                <option value="dealer">Dealer Sale</option>
                                <option value="credit">Hire Sale</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="product_code" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected>Select Product</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $item) {
                                        echo '<option value="' . $item->product_code . '">' . filter($item->product_model) . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[brand]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected>Select Brand</option>
                                <?php if (!empty($brandList)) {
                                    foreach ($brandList as $item) {
                                        echo '<option value="' . $item->brand . '">' . filter($item->brand) . '</option>';
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


        <?php if (!empty($results)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result &nbsp;&nbsp; Total Invoice
                            Found(<?php echo count($results); ?>
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
                    <h4 class="text-center hide" style="margin-top: 0px;">All Sale</h4>
                    <table class="table table-bordered table2" id="dataTable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th width="90">Date</th>
                                <th>Client's Name</th>
                                <th width="100">Voucher No</th>
                                <th>Brand</th>
                                <th>Sale Type</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <!--<th>Discount</th>-->
                                <th>Paid</th>
                                <th>Due</th>
                                <?php if (checkAuth('super')) { ?>
                                    <th>Showroom</th>
                                <?php } ?>
                                <th>Type</th>
                                <th style="width: 140px;" class="none">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $total_bill     = 0.0;
                        $total_discount = 0.00;
                        $amount         = $total_paid = $total_due = 0.00;
                        foreach ($results as $key => $row) {
                            
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td>
                                    <?php
                                    if ($row->sap_type != "cash" && $row->sap_type != "special") {
                                        $where      = array('trash' => 0, 'code' => $row->party_code);
                                        $party_info = $this->action->read('parties', $where);
                                        if ($party_info != null) {
                                            echo filter($party_info[0]->name);
                                        } else {
                                            echo "N/A";
                                        }
                                    } else {
                                        echo filter($row->party_code);
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row->voucher_no; ?> </td>
                                <td><?php echo filter($row->brand); ?> </td>
                                <td>
                                    <?php

                                    if ($row->sap_type == 'credit') {
                                        echo "Hire";
                                    } else {
                                        echo filter($row->sap_type);
                                    } ?>
                                </td>
                                <td><?php echo $row->total_quantity; ?> </td>
                                <td>
                                    <?php
                                    $total      = $row->total_bill;
                                    $total_bill += $total;
                                    echo f_number($total);
                                    ?>
                                </td>
                               
                                <td>
                                    <?php
                                    if ($row->sap_type == 'cash') {
                                        $due_paid          = $due = 0.00;
                                        $where             = array('voucher_no' => $row->voucher_no);
                                        $due_paid_sum      = $this->action->read_sum('due_collect', 'paid', $where);
                                        $due_remission_sum = $this->action->read_sum('due_collect', 'remission', $where);

                                        $total_paid += $row->paid + $due_paid_sum[0]->paid;
                                        echo f_number($row->paid + $due_paid_sum[0]->paid);
                                    } else {
                                        $total_paid += $row->paid;
                                        echo f_number($row->paid);
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    if ($row->sap_type == 'cash') {
                                        $due = $row->total_bill - ($row->paid + $due_paid_sum[0]->paid + $due_remission_sum[0]->remission);
                                        echo f_number($due);
                                        $total_due += $due;
                                    } else {
                                        echo f_number($row->due);
                                        $total_due += $row->due;
                                    }
                                    ?>
                                </td>
                                <?php if (checkAuth('super')) { ?>
                                    <td><?php echo isset($row->godown_name) ? $row->godown_name : ''; ?></td>
                                <?php } ?>

                                <td><?php echo filter($row->voucher_type); ?></td>

                                <td class="none">

                                    <?php
                                    $viewBtn = $editBtn = $deleteBtn = '';
                                    if ($row->sap_type == 'credit') {
                                        
                                        $viewBtn = 'sale/viewHireSale?vno=' . $row->voucher_no;
                                        $editBtn   = 'sale/editHireSale?vno=' . $row->voucher_no;
                                        $deleteBtn = 'sale/deleteSale?vno=' . $row->voucher_no;
                                    }else{
                                        $viewBtn = 'sale/viewDealerSale?vno=' . $row->voucher_no;
                                        $editBtn   = 'sale/mobile_sale_edit?vno=' . $row->voucher_no;
                                        $deleteBtn = 'sale/mobile_sale/delete?vno=' . $row->voucher_no;
                                    }    
                                    
                                    ?>

                                    <?php if (!empty($viewBtn)) { ?>
                                        <a title="View" class="btn btn-primary"
                                           href="<?php echo site_url($viewBtn); ?>"> <i class="fa fa-eye"
                                                                                        aria-hidden="true"></i> </a>
                                    <?php } ?>

                                    <?php if (!checkAuth('user')) { ?>
                                        <?php if (!empty($editBtn)) { ?>
                                            <a title="Edit" class="btn btn-warning"
                                               href="<?php echo site_url($editBtn); ?>">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>
                                        <?php } ?>


                                        <?php if (!empty($deleteBtn)) { ?>
                                            <a onclick="return confirm('Are you sure want to delete this Sale?');"
                                               title="Delete"
                                               class="btn btn-danger"
                                               href="<?php echo site_url($deleteBtn); ?>">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        
                        <tfoot>
                        <tr>
                            <td colspan="7" class="text-right"><strong>Total</strong></td>
                            <th><?php echo f_number($total_bill); ?> TK</th>
                            <th><?php echo f_number($total_paid); ?> TK</th>
                            <td><strong><?php echo f_number($total_due); ?> TK</strong></td>
                            <th>&nbsp;</th>
                            <th class="none">&nbsp;</th>
                            <th class="none">&nbsp;</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>


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
    
    $(document).ready(function() {
        $('#dataTable').DataTable({
            paging: false,
            info: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, 'colvis'
            ]
        });
    } );

    app.controller('appController', function ($scope, $http) {

        $scope.partyList = [];

        $scope.$watch('godownCode', function (godownCode) {

            $scope.partyList = [];

            if (typeof godownCode !== 'undefined' && godownCode != '' && godownCode != 'all') {
                var where = {
                    table: 'parties',
                    cond: {type: 'client', status: 'active', trash: 0},
                    select: ['code', 'name', 'mobile', 'address']
                };

                if (godownCode != 'all') {
                    where.cond.godown_code = godownCode;
                }

                $http({
                    method: 'post',
                    url: url + 'result',
                    data: where
                }).success(function (response) {
                    if (response.length > 0) {
                        $scope.partyList = response;
                    }
                })
            }
        });
    });
</script>

<style>
    .dataTables_filter {
      float: right !important;
    }
    .dt-button-collection {
      width: 150px;
    }
</style>
