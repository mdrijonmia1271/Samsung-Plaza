<?php 	
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    $logo_data  = json_decode($meta->logo,true);
?>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style type="text/css">
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

    .table-title {
        font-size: 20px;
        color: #333;
        background: #f5f5f5;
        text-align: center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Purchase</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                
                if(checkAuth('super')) {
                    $column = '2';
                }else{
                    $column = '3';
                }
                ?>
                <div class="form-group">

                    <?php if(checkAuth('super')) { ?>
                    <div class="col-md-2">
                        <select name="godown_code" class="form-control">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all"> All Showroom </option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <?php } ?>

                    <div class="col-md-2">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                    </div>

                    <div class="col-md-<?php echo $column; ?>">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                            data-live-search="true">
                            <option value="" selected disabled>-- Select Supplier Name --</option>
                            <?php if($allParty != null){ foreach($allParty as $key => $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>
                    
                    <div class="col-md-<?php echo $column; ?>">
                        <select name="product_model" class="selectpicker form-control" data-show-subtext="true"
                            data-live-search="true">
                            <option value="" selected disabled>-- Select Product Model --</option>
                            <?php if($allModel != null){ foreach($allModel as $key => $row){ ?>
                            <option value="<?php echo $row->product_model; ?>">
                                <?php echo filter($row->product_model); ?>
                            </option>
                            <?php }} ?>
                        </select>
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

                    <div class="col-md-12">
                        <br>
                        <div class="btn-group pull-right">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php  if($result != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="text-center hide" style="margin-top: 0px;">All Purchase</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Purchase</h3>
                </div>

                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Supplier Name</th>
                        <th>Mobile</th>
                        <th>Total (TK)</th>
                        <th>Paid (TK)</th>
                        <th>Due (TK)</th>
                        <?php if(checkAuth('super')) { ?>
                        <th>Showroom</th>
                        <?php } ?>
                        <th width="165" class="none">Action</th>
                    </tr>
                    
                    <?php
                    $purchaseTotal = $totalPaid = $totalDue = 0;
                          foreach($result as $key => $val){
                              
                              $purchaseTotal += $val->total_bill;
                              $totalPaid += $val->paid;
                              $totalDue += $val->total_bill - $val->paid;
                        ?>
                    <tr>
                        <td style="width: 40px;"><?php echo $key+1; ?></td>
                        <td><?php echo $val->sap_at; ?></td>
                        <td><?php echo $val->voucher_no; ?></td>
                        <td><?php echo filter($val->name); ?></td>
                        <td><?php echo $val->mobile; ?></td>
                        <td><?php echo f_number($val->total_bill); ?></td>
                        <td><?php echo f_number($val->paid); ?></td>
                        <td><?php echo f_number($val->total_bill - $val->paid); ?></td>
                        <?php if(checkAuth('super')) { ?>
                        <td><?php echo filter($val->godown_name); ?></td>
                        <?php } ?>

                        <td class="none">
                            <a title="View" class="btn btn-primary"
                                href="<?php echo site_url('purchase_elec/purchase/view?vno=' . $val->voucher_no); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            		
							<?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>
                            
                            <a title="Edit" class="btn btn-warning"
                                href="<?php echo site_url('purchase_elec/editPurchase?vno=' . $val->voucher_no); ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <!--<a title="Return" class="btn btn-info"
                                href="<?php /*echo site_url('purchase/returnPurchase?vno=' . $val->voucher_no); */?>">
                                <i class="fa fa-undo" aria-hidden="true"></i>
                            </a>-->

                            <a title="Delete" class="btn btn-danger"
                                onclick="return confirm('Are you sure want to delete this Data?');"
                                href="<?php echo site_url('purchase_elec/purchase/delete_purchase?vno=' . $val->voucher_no); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                            
                            <?php  } ?>      
                            
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="5" class="text-right">Total </th>
                        <th><?php echo f_number($purchaseTotal); ?> Tk</th>
                        <th><?php echo f_number($totalPaid); ?> Tk</th>
                        <th><?php echo f_number($totalDue); ?> Tk</th>
                        <th></th>
                        <th></th>
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

    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>