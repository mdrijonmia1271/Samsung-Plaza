<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{ display: none !important; }
        .panel .hide{ display: block !important; }
        .title{ font-size: 25px; }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
    }
</style>

<?php  echo $this->session->flashdata('confirmation'); ?>
<?php if($exchange != null){ ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panal-header-title">
            <h1 class="pull-left">All Exchange Product</h1>
            <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="panel-body">
        <!-- Print banner -->
        <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

        <h4 class="text-center hide" style="margin-top: 0px;">All Exchange Product</h4>

        <table class="table table-bordered">
            <tr>
                <th style="width: 50px;">SL</th>
                <th>Receive Product</th>
                <th>Receive Quantity</th>
                <th>Given Product</th>
                <th>Given Quantity</th>
                <th class="none" width='115'>Action</th>
            </tr>
            
            <?php foreach($exchange as $key=>$value){ 
                $where = array('product_code'=>$value->receive_code);
                $where2 = array('product_code'=>$value->given_code);
                $receive = $this->action->read('products', $where);
                $given = $this->action->read('products', $where2);
            ?>
            <tr>
                <td> <?php echo $key+1; ?> </td>
                <td> <?php echo filter((isset($receive[0]->product_name) ? $receive[0]->product_name : '')); ?> </td>
                <td> <?php echo $value->receiveqty; ?> </td>
                <td> <?php echo filter((isset($given[0]->product_name) ? $given[0]->product_name : '')); ?> </td>
                <td> <?php echo $value->givenqty; ?> </td>
                <td  class="none">
                    <a class="btn btn-warning" title="Edit" href="<?php echo site_url('exchange/exchange/editExchange/'.$value->id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a onclick="return confirm('Do you want to delete this Category?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('exchange/exchange/delete/'.$value->id);?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <div class="panel-footer">&nbsp;</div>
</div>
<?php } ?>