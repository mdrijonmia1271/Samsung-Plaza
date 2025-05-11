<style type="text/css">
    .info-view{
        width: 100%;
        max-width: 230px;
        max-height: 230px;
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    .custom-table tr td{
        padding: 0 !important;
    }

    .custom-table tr td .form-control{
        border: transparent;
    }
</style>

<div class="container-fluid" ng-controller="AdvancedPaymentCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left"><h1>Advanced Payment </h1></div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class"=>"form-horizontal");
                echo form_open('', $attr);
                ?>

                <div>
                	<h3 style="margin-top: 0;">Employee Information</h3>
	                <div class="row">
	                    <div class="col-md-offset-1 col-md-7">
	                        <div class="form-group">
	                            <label class="col-md-4 control-label">
	                            	Employee ID <span class="req">*</span>
	                            </label>

	                            <div class="col-md-8">
	                                <input
	                                	type="text"
	                                	name="id"
	                                	class="form-control"
	                                	ng-model="eid"
	                                	ng-change="getEmployeeInfoFn()"
	                                	required>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Name </label>
	                            <div class="col-md-8">
	                                <input type="text" ng-model="profile.name" class="form-control" readonly>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Post</label>
	                            <div class="col-md-8">
	                                <input type="text" ng-model="profile.post" class="form-control" readonly>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Mobile </label>
	                            <div class="col-md-8">
	                                <input type="text" name="mobile" ng-model="profile.mobile" class="form-control" readonly>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Joining Date</label>
	                            <div class="col-md-8">
	                                <input type="text" ng-model="profile.joining" class="form-control" readonly>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-md-4">
	                        <figure class="info-view" ng-if="profile.active">
	                            <img
	                            	class="img-responsive img-thumbnail"
	                            	ng-src="{{ profile.image }}"
	                            	alt="profile pic not found!">
	                        </figure>
	                    </div>
	                </div>
                </div>


				<div>
					<hr style="border: 1px dashed  #ddd;">
					<div class="row">
						<div class="col-md-offset-1 col-md-7">
                            <div class="form-group ">
                                <label class="col-md-4 control-label">Payment Date<span class="req"> *</span></label>
	                            <div class="input-group date col-md-8" id="datetimepicker1">
	                                <input type="text" class="form-control" name="payment_date" <?php if($privilege == "user"){ echo "readonly"; } ?> required value="<?php echo date('Y-m-d'); ?>">
	                                <span class="input-group-addon">
	                                    <span class="glyphicon glyphicon-calendar"></span>
	                                </span>
	                            </div>
                            </div>
							<div class="form-group">
			                    <label class="col-md-4 control-label">Total <span class="req"> *</span></label>
			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	class="form-control"
			                        	step="any" name="amount" required>
			                    </div>
			                </div>

			                <div class="pull-right">
			                    <input
			                    	type="submit"
			                    	name="create"
			                    	value="Paid"
			                    	class="btn btn-primary">
			                </div>
						</div>
					</div>
				</div>

                <?php echo form_close(); ?>
                
                <div ng-if="advanced_payment.length > 0" ng-cloak>
					<hr style="border: 1px dashed  #ddd;">
					<div class="row">
						<div class="col-md-12">
                          <h2>All Advanced Paid</h2>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th width="60">SL</th>
                                <th>Date</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th width="60">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr ng-repeat="row in advanced_payment">
                                <td>{{ $index+1 }}</td>
                                <td>{{ row.date |format_date}}</td>
                                <td>{{ row.year }}</td>
                                <td>{{ row.month }}</td>
                                <td>{{ row.amount }}</td>
                                <td>
                                    <a title="Delete" target="_blank" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Payment?');" href="?id={{ row.id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                              </tr>
                              <tr>
                                  <th class="text-right" colspan="4">Total</th>
                                  <th colspan="2"> {{ total_advanced_payment }} </th>
                              </tr>
                            </tbody>
                          </table>
						</div>
					</div>
				</div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
