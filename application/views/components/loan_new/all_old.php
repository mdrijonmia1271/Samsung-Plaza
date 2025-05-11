<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>

<style>
    @media print {
        aside, .panel-heading, .panel-footer, nav, .none {
            display: none !important;
        }

        .panel {
            border  : 1px solid transparent;
            left    : 0px;
            position: absolute;
            top     : 0px;
            width   : 100%;
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
            width     : 80%;
            float     : right;
            text-align: center;
        }

        .print_banner_text h2 {
            margin        : 0;
            line-height   : 38px;
            text-transform: uppercase !important;
        }

        .print_banner_text p {
            margin-bottom: 5px !important;
        }

        .print_banner_text p:last-child {
            padding-bottom: 0 !important;
            margin-bottom : 0 !important;
        }
    }
</style>

<?php echo $this->session->flashdata("confirmation"); ?>
<div class="panel panel-default">
    <div class="panel-heading panal-header">
        <div class="panal-header-title pull-left">
            <h1>All Loan</h1>
        </div>
        <div class="pull-right">
            <a onclick="window.print()" style="font-size: 14px; cursor: pointer;"><i class="fa fa-print"></i>print</a>
        </div>
    </div>

    <div class="panel-body">
        <!-- Print banner Start Here -->
        <?php $this->load->view('print', $this->data); ?>
        <!-- Print banner End Here -->
        <div class="col-md-12 text-center hide"><h3>All Loan</h3></div>
        
        <?php if ($all != null) { ?>
            <table class="table table-bordered">
                <tr>
                    <th width="50">SL</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Balance</th>
                    <th>Showroom</th>
                    <!--<th>Current Balance </th>-->
                    <!--<th>Status </th>-->
                    <th class="none">Action</th>
                </tr>

                <?php 
                    $totalBalance = $totalReceived = $totalPaid = 0;
                    foreach ($all as $key => $row) {
    
                        // calculate current balances
                        $received = $paid = $total = 0.0;
                        $status = '';
    
                        // get total receiver amount
                        $r_where = array(
                            'person_code' => $row->person_code,
                            'type'        => 'Received'
                        );
                        $received = get_sum('add_trx', $r_where, 'amount');
    
                        // get total pending amount
                        $p_where = array(
                            'person_code' => $row->person_code,
                            'type'        => 'Paid'
                        );
                        $paid = get_sum('add_trx', $p_where, 'amount');
    
                        if ($row->type == "Received") {
                            $total = ($row->balance + $received) - $paid;
                            if ($total > 0) {
                                $status = 'Received';
                            } else {
                                $status = 'Paid';
                            }
                        } else {
                            $total = ($row->balance + $paid) - $received;
                            if ($total > 0) {
                                $status = 'Paid';
                            } else {
                                $status = 'Received';
                            }
                        }
    
                        if ($status == 'Received') {
                            $totalReceived += abs($total);
                        } else {
                            $totalPaid += abs($total);
                        }
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $row->date; ?></td>
                        <td><?php echo filter($row->name); ?></td>
                        <td><?php echo $row->mobile; ?></td>
                        <td><?php echo $row->type; ?></td>
                        <!--<td>--><?php //echo $row->balance; ?><!--</td>-->
                        <td><?php echo $status; ?></td>
                        <td><?php echo f_number(abs($total)); ?></td>
                        <td><?php echo $row->godown_name; ?></td>
                        <td class="none" width="110px">
                            <a class="btn btn-warning"
                                href="<?php echo site_url('loan_new/loan_new/edit/' . $row->id); ?>"><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this data?');"
                                href="<?php echo site_url('loan_new/loan_new/delete/' . $row->id); ?>"><i
                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="6" class="text-right">Total</th>
                    <th><?php
                        $status = '';
                        $totalBalance = $totalPaid - $totalReceived;
                        if ($totalBalance > 0) {
                            $status = 'Paid';
                        } else {
                            $status = 'Received';
                        }
                        echo f_number(abs($totalBalance)); ?> TK ( <?php echo $status; ?> )
                    </th>
                    <td>&nbsp;</td>
                    <td class="none">&nbsp;</td>
                </tr>
            </table>
        <?php } else { ?>
            <h1 class="text-center">No records found</h1>
        <?php } ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
</div>


<!--<script type="text/javascript">-->
<!--    $(function () {-->
<!--        $('#datepicker1').datetimepicker({-->
<!--        	format: 'YYYY/MM/DD'-->
<!--        });-->
<!--    });-->

<!--    $(function () {-->
<!--        $('#datepicker2').datetimepicker({-->
<!--        	format: 'YYYY/MM/DD'-->
<!--        });-->
<!--    });-->
<!--</script>-->