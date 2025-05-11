<style>
@media print{
    aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
    .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
    .hide{display: block !important;}
    .table-print tr th:last-child,
    .table-print tr td:last-child{
        display: none;
    }
}
</style>

<div class="container-fluid" ng-controller="commissionPaidCtrl">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Commission Paid</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>


                <div class="form-group">
                    <label class="col-md-2 control-label"> Client Name </label>
                    <div class="col-md-5">
                       <select name="party_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" ng-model="party_code" ng-change="getPartyInfo();">
                           <option value="" selected disabled>-- Select Client --</option>
                           <?php foreach ($info as $key => $value) { ?>
                                <option value="<?php echo $value->code ?> "> <?php echo $value->name; ?></option>
                           <?php } ?>
                       </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" name="show" value="Show" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                 <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <table class="table table-bordered table-print">
                    <tr>
                        <th width="30"> <input title="select All" type="checkbox" id="md13" checked></th>
                        <th width="50">SL</th>
                        <th>Voucher No</th>
                        <th>Total</th>
                        <th>Total Commission</th>
                        <th>Paid Commission</th>
                        <th>Total Due</th>
                        <th class="none" width="60">Action</th>
                    </tr>
                    <!-- <pre><?php //print_r($sapInfo); ?></pre> -->
                    <?php foreach ($sapInfo as $key => $value) { ?>
                        <tr>
                            <td> <input type="checkbox" id="md13" checked> </td>
                            <td> <?php echo $key+1; ?> </td>
                            <td> <?php echo $value->voucher_no; ?> </td>
                            <td> <?php echo $value->total_bill; ?> </td>
                            <td> <?php echo $value->total_discount; ?> </td>
                            <td> <?php echo $value->total_discount; ?> </td>
                            <td> <?php ?> </td> 
                            <td class="none">
                                <a class="btn btn-info" href="#">
                                <i class="fa fa-reply" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    
                    <tr>
                        <td colspan="6" class="text-right"><strong>Total</strong></td>
                        <td ><strong><?php //echo f_number($total); ?> TK</strong></td>
                        <td ></td>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>