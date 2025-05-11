<script src="<?php echo site_url('private/js/ngscript/retailClientDueCtrl.js?').time(); ?>"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<style>
    .action-btn a {
        margin-right: 0;
        margin: 3px 0;
    }
    .checkbox {
        margin: 0 !important;
    }
    .hide {
        display: none !important;
    }
    @media print {
        aside,
        .panel-heading,
        .panel-footer,
        nav,
        .none {
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
        table tr th,
        table tr td {
            font-size: 12px;
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

<div class="container-fluid" ng-controller="retailClientDueCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Retail Due Collection List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
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
                            ng-init="godown_code='<?php echo $this->data['branch']; ?>'" ng-model="godown_code" >
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
                    <input type="hidden" name="godown_code"  ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                       ng-model="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                <?php } ?>
                <div class="form-group">
                    <div class="col-md-4">
                        <select name="search[party_code]" ui-select2="{ allowClear: true}" class="form-control" ng-model='party'
                                data-placeholder="Select Client" ng-change="addNewProductFn()">
                            <option value="" selected disable></option>
                            <option ng-repeat="row in allParties" value="{{row.name}}">
                                {{ row.name | textBeautify }} - {{ row.mobile }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="search[voucher_no]" placeholder="Enter voucher No." class="form-control">
                    </div>

                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <hr style="margin-top: 0">


            <div class="panel-body" ng-cloak>
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="text-center hide" style="margin-top: 0px;"></h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>Cash Client Transaction List</h3>
                </div>
                <?php if (!empty($result)) { ?>
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Voucher No</th>
                        <th>Total Bill</th>
                        <th>Paid</th>
                        <th>Remission</th>
                        <th>Due</th>
                        <th class="none" width="50px">Action</th>
                    </tr>
                    <?php
                    foreach ($result as $_key => $row){
                        if($row->due > 0){
                    ?>
                    <tr>
                        <td><?= (++$_key) ?></td>
                        <td><?= $row->date ?></td>
                        <td><?= check_null(filter($row->party_code)) ?></td>
                        <td><?= $row->voucher_no ?></td>
                        <td><?= $row->total_bill ?></td>
                        <td><?= $row->paid ?></td>
                        <td><?= $row->remission ?></td>
                        <td><?= $row->due ?></td>
                        <td>
                            <a title="Voucher" target="_blank" href="<?php echo site_url("due_list/due_list/due_voucher/$row->id");  ?>" class="btn btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } } ?>
                </table>
                <?php } else { ?>
                    <h3 class="text-center text-danger">No records found.</h3>
                <?php } ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>