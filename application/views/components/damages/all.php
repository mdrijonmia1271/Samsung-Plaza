<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}

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

        .title{
            font-size: 25px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Damage Product</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>

                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
             <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>"> 

                <h4 class="hide text-center" style="margin-top: 0px;">All Damages Product</h4>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 45px;"> SL </th>
                        <th>Name </th>
                        <th>Quantity</th>
                        <th>Remark</th>
                    </tr>
                    <?php if($results !=null){
                        foreach ($results as $key => $value) {
                            $where = array("code" => $value->product_code);
                            $productInfo = $this->action->read('stock',$where);

                     ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo filter($productInfo[0]->name); ?> </td>
                        <td><?php echo $value->quantity." ( ".$value->unit." )"; ?></td>
                        <td><?php echo $value->remark; ?></td>
                       
                    </tr>
                    <?php } } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
