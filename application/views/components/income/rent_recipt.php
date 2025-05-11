<style>
    .table>tbody>tr>td {padding: 2px;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
        border: 1px solid transparent;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Rent Recipt</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                <div class="row">
                    <div class="col-xs-8 print-font">
                        <label>Received By : <?php echo $rentInfo[0]->received_by; ?></label>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label>Given By : <?php echo $rentInfo[0]->remark; ?></label>
                    </div>
                </div><br>
                
                <table class="table table-bordered text-center">
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Amount (TK)</th>
                    </tr>

                    <tr>
                        <td><?php echo $rentInfo[0]->date; ?></td>
                        <td><?php echo $rentInfo[0]->year; ?></td>
                        <td><?php echo $rentInfo[0]->month; ?></td>
                        <td><?php echo $rentInfo[0]->amount.' TK'; ?></td>
                    </tr>
                </table>

                <div class="col-sm-6 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-left print-font">
                        ------------------------------ <br>
                        Signature of Proprietor
                    </h4>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-right print-font">
                        ------------------------------ <br>
                        Signature of Lessee
                    </h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $gtotal; ?>));});
</script>