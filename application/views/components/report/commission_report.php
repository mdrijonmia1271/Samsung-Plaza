<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
        .block-hide{
            display: none;
        }
    }
</style>
<div class="container-fluid block-hide">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
    $attribute = array(
        'name' => '',
        'class' => 'form-horizontal',
        'id' => ''
    );
    echo form_open_multipart('', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Report</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-12">

                    <div class="form-group">
                        <!-- <label class="col-md-2 control-label">Voucher No</label> -->
                        <div class="col-md-3">
                            <input type="number" min="0" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                        </div>

                        <!-- <label class="col-md-2 control-label">Client's Name</label> -->
                        <div class="col-md-3">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                                <option value="" selected disabled>-- Select Client's Name --</option>
                                <?php foreach ($allClients as $key => $client) { ?>
                                <option value="<?php echo $client->code; ?>">
                                      <?php echo $client->name."(". $client->address.")"; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- <label class="col-md-2 control-label">From</label> -->
                        <div class="col-md-2">
                            <div class="input-group date" id="datetimepickerSMSFrom">
                                <input type="text" name="date[from]" class="form-control"  placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <!-- <label class="col-md-2 control-label">To</label> -->
                        <div class="col-md-2">
                            <div class="input-group date" id="datetimepickerSMSTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-1">
                            <input type="submit" value="Show" name="show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?php if($transaction != null){?>
<div class="container-fluid">
    <div class="row">
    <!--pre>
        <?php //print_r($transaction); ?>
    </pre-->
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Commission Report</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                 <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>"> 
                <h3 class="hide text-center">Commission Report <?php echo date('Y'); ?></h3>
		
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher</th>
                        <th>Total Quantity</>
                        <th>Amount</th>
                        <th>Commission</th>
                        <th>Com. Paid</th>
                        <th>Com. Due</th>
                    </tr>

                    <?php
                    $sum_quantity = array();
                    $sum_amount = array();
                    $sum_comm = array();
                    $sum_comm_paid = array();
                    $sum_comm_due = array();

                    foreach ($transaction as $key => $row) {
                        $commission = 0;
                        $remaining_commission = 0;


                        $info = sap_meta(array("voucher_no" => $row->voucher_no));
                        if(isset($info->commission)){
                            $commission = $info->commission;
                        }
                        if(isset($info->remaining_commission)){
                            $remaining_commission = $info->remaining_commission;
                        }

                        $total_commission = ($row->total_bill*6)/100;
                        $paid_commission = ($row->total_bill*$commission)/100;
                        //$due_commission = ($row->total_bill*$remaining_commission)/100;
                        $due_commission = $total_commission - $paid_commission;

                    ?>
                    <tr>
                        <th><?php echo $key+1; ?></th>
                        <td><?php echo $row->sap_at; ?></td>
                        <td><?php echo $row->voucher_no; ?></td>
                        <td><?php echo $sum_quantity[] = $row->total_quantity; ?></td>
                        <td><?php echo $sum_amount[] = $row->total_bill; ?></td>
                        <td><?php echo $sum_comm[] = $total_commission; ?></td>
                        <td><?php echo $sum_comm_paid[] = $paid_commission; ?></td>
                        <td><?php echo $sum_comm_due[] = $due_commission; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><?php echo array_sum($sum_quantity); ?> Kg</th>
                        <th><?php echo array_sum($sum_amount); ?> TK</th>
                        <th><?php echo array_sum($sum_comm); ?> TK</th>
                        <th><?php echo array_sum($sum_comm_paid); ?> TK</th>
                        <th><?php echo array_sum($sum_comm_due); ?> TK</th>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        
    </div>
</div>
<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
