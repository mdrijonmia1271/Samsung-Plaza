<style type="text/css">
@media print{
    aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}

    .panel{
        border: 1px solid transparent;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 100%;
    }

    .hide{display: block !important;}
}
</style>

<div class="container-fluid" ng-controller="ClientCommissionCtrl" ng-cloak>
    <div class="row">
	    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Customer Commission</h1>
                </div>
            </div>

            <div class="panel-body">
				<form class="form-horizontal" ng-submit="searchCommissionFn()">
                    <!-- <div class="form-group">
                        <label class="col-md-2 control-label">Zone (Zilla) </label>
                        <div class="col-md-5">
                            <select
    							ng-model="zilla"
    							class="form-control"
    							ng-change="getUpazillaFn()">
                                <?php foreach($zilla as $key => $value) { ?>
                                <option value="<?php echo $value->zone; ?>"><?php echo $value->zone; ?></option>
                                <?php } ?>
                             </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Area (Upazilla) </label>
                        <div class="col-md-5">
                            <select
    							ng-model="upazilla"
    							class="form-control"
    							ng-change="getAllClientFn()">
                                <option ng-repeat="row in allUpazilla" ng-value="row.area">{{row.area}}</option>
                             </select>
                        </div>
                    </div> -->

	                <div class="form-group">
	                    <label class="col-md-2 control-label"> Customer Name <span class="req">*</span></label>
	                    <div class="col-md-5">
	                        <input ng-model="query.party_code"  list="allClientList" class="form-control">
	                         <datalist id="allClientList">
                                      <option ng-repeat="row in allClients" ng-value="row.code">{{row.name}}</option>	                           
	                         </datalist>
	                    </div>
	                </div>


	                <div class="form-group">
	                    <label class="col-md-2 control-label"> Company <span class="req">*</span></label>
	                    <div class="col-md-5">
	                        <select ng-model="query.party_brand" class="form-control">
	                            <option value="">&nbsp;</option>
	                            <?php foreach ($allBrand as $key => $value) { ?>
	                                <option value="<?php echo $value->slug; ?>"><?php echo filter($value->subcategory); ?></option>
	                            <?php } ?>
	                        </select>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-2 control-label">From</label>
	                    <div class="col-md-5">
	                        <input type="text" ng-model="dateset.from" class="form-control" placeholder="YYYY-MM-DD">
	                    </div>
	                </div>

					<div class="form-group">
	                    <label class="col-md-2 control-label">To</label>
	                    <div class="col-md-5">
	                        <input type="text" ng-model="dateset.to" class="form-control" placeholder="YYYY-MM-DD">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <div class="col-md-7">
	                        <input type="submit" value="Show" class="btn btn-primary pull-right">
	                    </div>
	                </div>
                </form>
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

                <h4 class="text-center hide" style="margin-top: 0px;">Commission List</h4>

				<?php
				$attribute = array("class" => "");
				echo form_open("commission/client_commission/payment", $attribute);
				?>
                <table class="table table-bordered">
                    <tr>
                       <th width="45px">SL</th>
                       <th>Date</th>
                       <th>Customer Name</th>
                       <th>Company Name</th>
                       <th>Quantity</th>
                       <th>Commission</th>
                       <th>Amount</th>
                       <th width="60px" class="none">Action</th>
                    </tr>

                    <tr ng-repeat="row in resultset">
                       <td width="45px">{{ row.sl }}</td>
                       <td>{{ row.date }}</td>
                       <td>{{ row.name }}</td>
                       <td>{{ row.brand }}</td>
                       <td>{{ row.quantity }}</td>
                       <td>{{ row.amount }}</td>
                       <td>{{ row.total }}</td>
                       <td class="none">
                            <label class="btn btn-default">
                               	<input
									type="checkbox"
									name="action[]"
									ng-model="row.action"
									ng-value="row.id"
									ng-change="sumFn()">
                            </label>
                       </td>
                    </tr>
                </table>

                <div class="text-right none">
                    <span style="font-weight: bold;padding-right: 20px;line-height: 30px">
						Total: <strong>{{ total }}</strong>
					</span>

                    <input type="submit" name="payment" value="Paid" class="btn btn-primary pull-right">
                </div>
				<?php echo form_close(); ?>
            </div>

            <div class="panel-footer"> &nbsp; </div>
        </div>
    </div>
</div>
