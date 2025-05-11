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
        aside, .panel-heading, .panel-footer, nav, .none {
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

        table tr th, table tr td {
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
<div class="panel panel-default none">
    <div class="panel-heading">
        <div class="panal-header-title pull-left">
            <h1>Search</h1>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $attr = array("class" => "form-horizontal");
        echo form_open("", $attr);
        ?>
        <div class="form-group">
            <div class="col-md-3">
                <select name="search[person_code]" class="selectpicker form-control" data-show-subtext="true"
                        data-live-search="true">
                    <option value="" selected disabled>-- Select Person's Name --</option>
                    <?php foreach ($allClients as $key => $client) { ?>
                        <option value="<?php echo $client->person_code; ?>">
                            <?php echo $client->name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-3">
                <select name="search[type]" class="selectpicker form-control" data-show-subtext="true"
                        data-live-search="true">
                    <option value="" selected disabled>-- Select Type --</option>
                    <option value="paid">Paid</option>
                    <option value="Received">Received</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <select name="search[godown_code]" class="form-control">
                    <option value="" selected disabled>-- Select Showroom --</option>
                    <option value="all">All Showroom</option>
                    <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                    <option value="<?php echo $row->code; ?>" >
                        <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                    </option>
                    <?php } } ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-3">
                <div class="input-group date" id="datetimepickerFrom">
                    <input type="text" name="date[from]" class="form-control" placeholder="From">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-3">
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


<?php echo $this->session->flashdata("confirmation"); ?>
<div class="panel panel-default">
    <div class="panel-heading panal-header">
        <div class="panal-header-title pull-left">
            <h1>All Transaction</h1>
        </div>
    </div>


    <div class="panel-body">
        <?php if ($allInfo != null) { ?>
            <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
            <!-- Print banner End Here -->
            <div class="col-md-12 text-center hide">
                <h3>All Loan Transaction</h3>
            </div>
            <table class="table table-bordered">
                <tr>
                    <th width="50">SL</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Receive Amount</th>
                    <th>Paid Amount</th>
                    <!--<th>Remark</th>-->
                    <th>Showroom</th>
                    <th class="none">Action</th>
                </tr>

                <?php
                $totalReceiver = $totalPaid = 0;
                foreach ($allInfo as $key => $row) { ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $row->date; ?></td>
                        <td><?php echo get_name('loan_new', 'name', array('person_code' => $row->person_code)) ?></td>
                        <td><?php echo $row->mobile; ?></td>
                        <td><?php echo $row->address; ?></td>
                        <td><?php echo $row->type; ?></td>
                        <td><?php if ($row->type == "Received") {
                                echo $row->amount;
                                $totalReceiver += $row->amount;
                            } ?></td>
                        <td><?php if ($row->type == "Paid") {
                                echo $row->amount;
                                $totalPaid += $row->amount;
                            } ?></td>
                        <!--<td><?php //echo $row->remark; ?></td>-->
                        <td><?php echo $row->godown_name; ?></td>
                        <td class="none" width="110px">
                            <a class="btn btn-warning"
                               href="<?php echo site_url('loan_new/loan_new/edit_trx/' . $row->id); ?>"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this data?');"
                               href="<?php echo site_url('loan_new/loan_new/delete_trx/' . $row->id); ?>"><i
                                        class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="6" class="text-right">Total: </th>
                    <td><?php echo $totalReceiver; ?> TK</td>
                    <td><?php echo $totalPaid; ?> TK</td>
                    <td></td>
                    <td></td>
                </tr>


            </table>
        <?php } else { ?>
            <h1 class="text-center">No records found</h1>
        <?php } ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
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

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>