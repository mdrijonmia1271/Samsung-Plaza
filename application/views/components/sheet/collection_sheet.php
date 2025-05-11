<style>
    .report tr th{
        text-align: center;
        vertical-align: middle !important;
    }

    .report tr td{
        text-align: right;
        vertical-align: middle;
    }

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
        .title{
            font-size: 25px;
        }
    }
</style>
<?php
    $post_brands = array();
    if ($this->input->post('brands')) {
        $post_brands = $this->input->post('brands');
    }
?>
<div class="container-fluid" ng-controller="collectionSheet" ng-cloak>
    <div class="row">

        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Filter </h1>
                </div>
                <!--pre><?php // print_r($results); ?></pre-->
            </div>

            <div class="panel-body">
                <?php
                echo $this->session->flashdata('confirmation');
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Zilla <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select
                        name="search[zone]"
                        ng-model="zilla"
                        class="form-control"
                        ng-change="getUpazillaFn()">
                            <?php foreach($zilla as $key => $value) { ?>
                            <option value="<?php echo $value->zone; ?>"><?php echo $value->zone; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group" ng-show="active">
                    <label class="col-md-2 control-label">Upazilla <span class="req">*</span></label>
                    <div class="col-md-5">
                        <?php /*<select class="form-control" name="areas[]" multiple>                          
                            <option ng-repeat="row in upazilla" ng-value="row">{{row}}</option>
                        </select>
                        */?>

                        <label ng-repeat="row in upazilla" class="checkbox-inline">
                            <input type="checkbox" name="areas[]" ng-value="row"> {{row}}
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Company <span class="req">*</span></label>
                    <div class="col-md-5">
                        <?php foreach ($brands as $brand) {
                        	
				//echo $brand->brand."<br>";                        
                            if($brand->brand !=null){
                        ?>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="brands[]" value="<?php echo $brand->brand ?>"> <?php echo filter($brand->brand); ?>
                        </label>
                        <?php }} ?>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<?php if($results!=null){ ?>
<div class="container-fluid" ng-controller="allClientCtrl">
    <div class="row">
    	<?php  echo $this->session->flashdata('confirmation'); ?>

        <!--div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div-->

    	<div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Collection Sheet</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				        </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                
                <div class="table-responsive">
                <table class="table table-bordered report">
                    <thead>
                        <tr>
                          <th>Month</th>
                          <th><?php echo date("F");?></th>
                          <th colspan="<?php echo count($post_brands)*2+1; ?>" style="border-top: 1px solid transparent !important; "></th>
                          <th colspan="3">
                            <?php 
                               echo date("jS F-Y"); 
                            ?>
                          </th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="width: 50px;">SL</th>
                            <th rowspan="2" >Date</th>
                            <th rowspan="2" width="200">Name</th>
                            <th rowspan="2" >Address</th>
                            <?php
                            $totals = array();
                            foreach ($post_brands as $brand) {
                                $totals[$brand]=0;
                            ?>
                            <th colspan="2"><?php echo filter($brand); ?></th>
                            <?php } ?>
                            <th rowspan="2" style="vertical-align:middle;">Total Balance</th>
                        </tr>

                        <tr>
                            <?php foreach ($post_brands as $brand) { ?>
                            <th>Payment</th>
                            <th>Balance</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <?php
                    $grand_total = array();
                    foreach ($results as $key => $result) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo $result->opening; ?></td>
                      <td><?php echo $result->name; ?></td>
                      <td><?php echo $result->address; ?></td>

                        <?php
                        $total = array();
                        foreach ($post_brands as $brand) {
                            $where = array(
                                "code"  => $result->code,
                                "brand" => $brand
                            );

                            $balance = $this->action->read("partybalance",$where);
                        ?>
                        <td>&nbsp;</td>
                        <td>
                      
                        <?php
                            if(count($balance)){
                                echo abs($balance[0]->balance); $total[] = $balance[0]->balance; $totals[$brand]+=$balance[0]->balance;
                            }
                         ?>

                        </td>
                        <?php } ?>

                      <td><?php echo abs(array_sum($total)); $grand_total[] = array_sum($total); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <?php foreach ($post_brands as $brand) { ?>
                        <td></td>
                        <td><strong><?php echo f_number(abs($totals[$brand])); ?></strong></td>
                        <?php } ?>
                        <td><strong><?php echo f_number(abs(array_sum($grand_total))); ?></strong></td>
                    </tr>
                </table>
                </div>
                <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>

            <div class="panel-footer">

                <!--select ng-model="perPage" class="form-control pull-right" style="width:100px;">
                    <option value="">All</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="500">500</option>
                </select-->
            </div>
        </div>
    </div>
</div>
<?php } ?>
