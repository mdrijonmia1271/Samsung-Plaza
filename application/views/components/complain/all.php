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


<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Customer Complain</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">

                <h4 class="hide text-center">All Customer Complain</h4>
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
                        <td><?php echo $value->status; ?></td>
                        <td class="none text-center">
                            <a title="view" class="btn btn-info" href="<?php echo site_url('complain/complain/view/'.$value->id);?>" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                             <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>
                                <a title="Edit" class="btn btn-primary"  href="<?php echo site_url('complain/complain/edit/'.$value->id); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Income?');" href="<?php echo site_url('complain/complain/delete/'.$value->id);?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>                         
                             <?php  } ?>  
                        </td>
                    </tr>
                    <?php } ?>
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

