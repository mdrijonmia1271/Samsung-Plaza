<script src="<?php echo site_url('private/js/ngscript/retailClientDueCtrl.js?').time(); ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<style>
    .action-btn a {margin-right: 0; margin: 3px 0;}
    .checkbox {margin: 0 !important;}
    .hide {display: none !important;}
    @media print {
        aside,.panel-heading,.panel-footer,nav,.none {display: none !important;}
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide {display: block !important;}
        table tr th,table tr td {font-size: 12px;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
        .print_banner_text {width: 80%;float: right;text-align: center;}
        .print_banner_text h2 {margin: 0;line-height: 38px;text-transform: uppercase !important;}
        .print_banner_text p {margin-bottom: 5px !important;}
        .print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
</style>
<div class="container-fluid" ng-controller="retailClientDueCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Retail Client</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <?php if (checkAuth('super')) { ?>
                    <div class="col-md-3">
                        <select class="form-control" name="godown_code" ng-change="getAllPartyFn()"
                                ng-init="godown_code='<?php echo $this->data['branch']; ?>'" ng-model="godown_code">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All showroom</option>
                            <?php if (!empty($allGodowns)) { foreach ($allGodowns as $row) { ?>
                                <option value="<?php echo $row->code; ?>">
                                    <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                </option>
                            <?php } } ?>
                        </select>
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="godown_code" ng-model="godown_code" value="<?php echo $this->data['branch']; ?>"
                       ng-init="godown_code = '<?php echo $this->data['branch']; ?>'" required>
                <?php } ?>
                <div class="form-group">
                    <div class="col-md-4">
                        <select name="client" ui-select2="{ allowClear: true}" class="form-control" ng-model='party'
                                data-placeholder="Select Client" ng-change="addNewProductFn()">
                            <option value="" selected disable></option>
                            <option ng-repeat="row in allParties" value="{{row.name}}">
                                {{ row.name | textBeautify }} - {{ row.mobile }}
                            </option>
                        </select>
                    </div>

                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Retail Due</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                
                <div class="col-md-12 text-center hide">
                    <h3>All Clients Due</h3>
                </div>
                
                <?php if (!empty($result)) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Promise Date</th>
                            <th width="120">Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Voucher</th>
                            <th>Grand Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th class="none" width="120px">Action</th>
                        </tr>
                        <?php
                        $total_due = 0.00;
                        $counter   = 1;
                        foreach ($result as $index => $value) {
                            $name    = $value['party_code'];
                            $obj     = json_decode($value['address']);
                            $mobile  = $obj->mobile;
                            $address = $obj->address;
                            if($value['due'] > 0) {
                        ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $value['sap_at']; ?></td>
                            <td><?php echo $value['promise_date']; ?></td>
                            <td><?php echo filter($name); ?></td>
                            <td><?php echo $mobile; ?></td>
                            <td><?php echo $address; ?></td>
                            <td><?php echo $value['voucher_no']; ?></td>
                            <td><?php echo f_number($value['total_bill']); ?></td>
                            <td><?php echo f_number($value['paid']); ?></td>
                            <td>
                            <?php
                                echo f_number($value['due']);
                                $total_due += $value['due'];
                            ?>
                            </td>
                            <td class="none text-center">
                                <a title="Collect" class="btn btn-primary"
                                   href="<?php echo site_url('due_list/due_list/due_collect?vno=' . $value['voucher_no']); ?>">
                                    Due Collect
                                </a>
                            </td>
                        </tr>
                        <?php } } ?>
                        <tr>
                            <td colspan="9" style="text-align: right"><strong>Total Due = </strong></td>
                            <td><b><?php echo f_number($total_due); ?> TK </b></td>
                            <td class="none">&nbsp;</td>
                        </tr>
                    </table>
                <?php } else { ?>
                    <h3 class="text-center text-danger">No records found.</h3>
                <?php } ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#check_all").on('change', function (event) {
            event.preventDefault();
            if ($(this).is(":checked") == true) {
                $('input[name="mobile[]"]').prop("checked", true);
            } else {
                $('input[name="mobile[]"]').prop("checked", false);
            }
        });
        $('#zilla').on('change', function (event) {
            var zila = $(this).val();
            $.ajax({
                url: '<?php echo site_url("client/client/ajax_return_upazila"); ?>',
                type: 'POST',
                data: {
                    zila: zila
                },
            }).done(function (response) {
                // alert(1);
                //console.log(response);
                $('#upazilla').html(response);
            });
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>