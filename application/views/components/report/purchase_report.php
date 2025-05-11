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
                    <h1>Search Purchase Report</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                    echo $this->session->flashdata('deleted');
                    $attr = array("class" => "form-horizontal");
                    echo form_open("", $attr);
                ?>
                <div class="form-group">

                    <?php 
                        if(checkAuth('super')) { ?>
                    <div class="col-md-2">
                        <select name="godown_code" class="form-control">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <?php }else { ?>
                    <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>"
                        required>
                    <?php } ?>

                    <div class="col-md-2">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                    </div>
                    <div class="col-md-3">
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

                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
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

                <div class="col-md-12 text-center hide">
                    <h3>Purchase Report</h3>
                </div>

                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Showroom</th>
                        <th>Voucher No</th>
                        <th>Supplier Name</th>
                        <th>Mobile</th>
                        <th>Total (TK)</th>
                        <th>Paid (TK)</th>
                        <th>Due (TK)</th>
                    </tr>

                    <?php
                        $total_grandTotal = 0;
                        $total_paid       = 0;
                        $total_due        = 0;
                        $total_quantity   = 0;

                        $grandTotal       = 0.00;
                        foreach($result as $key => $val){
                        $grandTotal     = $val->total_bill;
                        $due            = $grandTotal - $val->paid;
        
                        $total_quantity += $val->total_quantity;
                    ?>
                    <tr>
                        <td style="width: 40px;"><?php echo $key+1; ?></td>
                        <td><?php echo $val->sap_at; ?></td>
                        <td><?php echo filter($val->godwon_name); ?></td>
                        <td><?php echo $val->voucher_no; ?></td>
                        <td><?php echo filter($val->name); ?></td>
                        <td><?php echo $val->mobile; ?></td>
                        <td><?php echo f_number($grandTotal); ?></td>
                        <td><?php echo f_number($val->paid); ?></td>
                        <td><?php echo f_number($due); ?></td>
                    </tr>
                    <?php 
                        $total_grandTotal += $grandTotal;
                        $total_paid       += $val->paid;
                        $total_due        += $due;
                    } ?>
                    <tr>
                        <td colspan="6"><span class="pull-right"><strong>Total</strong></span></td>
                        <th><?php echo $total_grandTotal; ?></th>
                        <th><?php echo $total_paid; ?></th>
                        <th><?php echo $total_due; ?></th>
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>