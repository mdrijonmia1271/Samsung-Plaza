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
    }
</style>

<div class="container-fluid" >
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Order</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                
                <h4 class="text-center hide" style="margin-top: 0px;">Order</h4>

                <table class="table table-bordered table-hover">

                     <tr>
                      <td width="250">Name</td>
                      <td><?php echo $order[0]->name; ?></td>
                    </tr>

                    <tr>
                       <td>Company</td>
                       <td><?php echo $order[0]->company; ?></td>
                    </tr>

                    <tr>
                       <td>Products</td>
                       <td><?php echo $order[0]->products; ?></td>
                    </tr>

                   <tr>
                       <td>Price</td>
                       <td><?php echo $order[0]->price; ?></td>
                   </tr>

                   <tr>
                       <td>Amount</td>
                       <td><?php echo $order[0]->amount; ?></td>
                   </tr>

                   <tr>
                       <td>Mobile Number</td>
                       <td><?php echo $order[0]->mobile_number; ?></td>
                   </tr>

                   <tr>
                       <td>District</td>
                       <td><?php echo $order[0]->district; ?></td>
                   </tr>

                   <tr>
                       <td>Upazila</td>
                       <td><?php echo $order[0]->upazila; ?></td>
                   </tr>

                   <tr>
                       <td>Delivary Date</td>
                       <td><?php echo $order[0]->delivary_date; ?></td>
                   </tr>

                   <tr>
                       <td>Order By</td>
                       <td><?php echo $order[0]->order_by; ?></td>
                   </tr>

                   <tr>
                       <td>Address</td>
                       <td><?php echo $order[0]->address; ?></td>
                   </tr>

                   <tr>
                       <td>Remark</td>
                       <td><?php echo $order[0]->remark; ?></td>
                   </tr>

                    <tr>
                        <td>Status</td>
                        <td><?php echo filter($order[0]->status); ?></td>
                    </tr>
                    <?php $info = $this->action->read("showroom",array("showroom_id" => $order[0]->showroom_id)); ?>

                    <?php if($info != NULL){ ?>
                    <tr>
                        <td>Showroom Name </td>
                        <td><?php  echo filter($info[0]->name); ?></td>
                    </tr>
                  <?php } ?>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
