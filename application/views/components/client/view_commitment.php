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
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered,
        .print-font {font-size: 16px;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Details </h1>
                    <a class="pull-right" onclick="window.print()" style="font-size: 14px; cursor: pointer;">
                        <i class="fa fa-print"></i>print
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="hide">
                    <h3 class="text-center">Customer Commitment Details</h3>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th width="150">Name</th>
                        <td><?php echo check_null($partyInfo->name); ?></td>
                        <th width="150">Commitment Date</th>
                        <td><?php echo check_null($partyInfo->date); ?></td>
                    </tr>
                     <tr>
                        <th>Mobile</th>
                        <td><?php echo check_null($partyInfo->mobile); ?></td>
                        <th>Showroom Name</th>
                        <td><?php echo check_null($partyInfo->godown_name); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo check_null($partyInfo->address); ?></td>
                        <th>User Name</th>
                        <td><?php echo check_null($partyInfo->user_name); ?></td>
                    </tr> 
                    
                    <tr>
                        <th>Commitment</th>
                        <td colspan="3"><?php echo check_null($partyInfo->commitment); ?></td>
                    </tr>
                                 
                </table>

                <div class="pull-right hide">
                    <h4 style="margin-top: 50px;" class="text-center print-font">
                    -------------------------------- <br>
                    Signature of authority
                    </h4>
                </div>
              </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#inword").html(inWorden(<?php echo $records[0]->credit; ?>));
    });
</script>
