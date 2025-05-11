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
<style>
    @media print{
        aside{display: none !important;}
        nav{display: none;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .none{display: none;}
        .panel-heading{display: none;}
        .panel-footer{display: none;}
        .panel .hide{display: block !important;}
        .title{font-size: 25px;}
        table tr th,table tr td{font-size: 12px;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
</style>
<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Complain</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">

                <?php echo $this->session->flashdata("confirmation"); ?>
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>                
                <!-- Print banner End Here -->
                <h4 class="hide text-center">All Complain</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="50">SL</th>
                        <th>Date</th>
                        <th>Customer Name </th>
                        <th>Mobile </th>
                        <th>Status </th>
                        <th class="block-hide" width="160">Action</th>
                    </tr>
                    <?php 
                        foreach ($complainInfo as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo filter($value->name); ?></td>
                        <td><?php echo $value->mobile; ?></td>
                        <td><?php echo filter($value->status); ?></td>
                        <td class="none text-center">
                            <a title="view" class="btn btn-info" href="<?php echo site_url('new_complain/new_complain/view/'.$value->id);?>" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a title="Edit" class="btn btn-primary"  href="<?php echo site_url('new_complain/new_complain/edit/'.$value->id); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Income?');" href="<?php echo site_url('new_complain/new_complain/delete/'.$value->id);?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>                         
                        </td>
                    </tr>
                    <?php }  ?>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
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

