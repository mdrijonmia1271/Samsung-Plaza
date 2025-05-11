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
        .panel .hide{
            display: block !important;
        }
    }
    .table-bordered > tbody > tr > td{
        vertical-align: middle;
    }
</style>

<div class="container-fluid">
    <?php echo $this->session->flashdata('confirmation'); ?>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Cheque List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()">
                        <i class="fa fa-print"></i> 
                        প্রিন্ট
                    </a>
                </div>
            </div>

            <div class="panel-body">
                
                <!-- print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url("private/images/".$branch."_banner.jpg"); ?>" alt="photo not found..!">
                <hr class="hide" style="border-bottom: 1px solid #ccc;">
                <h4 class="text-center hide" style="margin-top: -10px;">Cheque List</h4>
                
                <!-- pre><?php // print_r($resultset); ?></pre -->

                <table class="table table-bordered">
                    <tr>
                        <th width="45">Sl</th>
                        <th>Custommer Name</th>
                        <th>Bank Name</th>
                        <th>Mobile No</th>
                        <th>Cheque No</th>
                        <th>Pass Date</th>
                        <th>Amount</th>
                        <th class="none">Action</th>
                    </tr>
                    
                    <?php 
                    foreach($resultset as $key => $row) { 
                        if($row['status'] == 'pending') {
                    ?>
                    <tr>
                        <td> <?php echo ($key + 1); ?> </td>
                        <td> <?php echo $row['customer_name']; ?> </td>
                        <td> <?php echo $row['bankname']; ?> </td>
                        <td> <?php echo $row['customer_mobile']; ?> </td>
                        <td> <?php echo $row['chequeno']; ?> </td>
                        <td> <?php echo $row['passdate']; ?> </td>
                        <td> <?php echo $row['amount']; ?> </td>
                        <td class="none text-center" style="width: 80px;">
                            <a 
                                class="btn btn-success" 
                                href="<?php echo site_url('cheque/payment?id=' . $row['id']); ?>">
                                Paid
                            </a>
                        </td>
                    </tr>
                    <?php }} ?>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

