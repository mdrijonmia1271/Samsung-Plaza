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

<div class="container-fluid" ng-controller="PaymentCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left"><h1>Payment </h1></div>
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
	                                <input type="text" ng-model="profile.mobile" class="form-control" readonly>
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
					<h3>Basic</h3>
					<div class="row">
						<div class="col-md-offset-1 col-md-7">
							<div class="form-group">
			                    <label class="col-md-4 control-label">Basic Salary</label>
			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	name="fields_value[]"
			                        	ng-model="basic_salary"
			                        	class="form-control"
			                        	step="any" readonly>

			                        <input type="hidden" name="fields_name[]" value="basic">
			                        <input type="hidden" name="type[]" value="basic">
			                    </div>
			                </div>
		                </div>
					</div>
				</div>








				<div ng-if="profile.incentive" ng-cloak>
					<hr style="border: 1px dashed  #ddd;">
					<h3>Insentive</h3>

					<div class="row">
						<div class="col-md-offset-1 col-md-7">

							<div class="form-group" ng-repeat="insentive in insentives">
			                    <label class="col-md-4 control-label">
			                    	{{ insentive.fields }} ({{ insentive.percentage }}%)
			                    </label>

			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	name="fields_value[]"
			                        	ng-model="insentive.amount"
			                        	class="form-control"
			                        	step="any" readonly>

			                        <input type="hidden" name="fields_name[]" ng-value="insentive.fields">
			                        <input type="hidden" name="type[]" value="insentive">
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-4 control-label">Extra </label>
			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	name="fields_value[]"
			                        	ng-model="amount.insentives.extra"
			                        	class="form-control"
			                        	step="any">

			                        <input type="hidden" name="fields_name[]" value="Extra">
			                        <input type="hidden" name="type[]" value="insentive">
			                    </div>
			                </div>
		                </div>
					</div>
				</div>







				<div ng-if="profile.deduction" ng-cloak>
					<hr style="border: 1px dashed  #ddd;">
					<h3>Deduction</h3>
					<div class="row">
						<div class="col-md-offset-1 col-md-7">

							<div class="form-group" ng-repeat="deduction in deductions">
			                    <label class="col-md-4 control-label">
			                    	{{ deduction.fields }}
			                    </label>

			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	name="fields_value[]"
			                        	ng-model="deduction.amount"
			                        	class="form-control"
			                        	step="any" readonly>

			                        <input type="hidden" name="fields_name[]" ng-value="deduction.fields">
			                        <input type="hidden" name="type[]" value="deduction">
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-4 control-label">Extra </label>
			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	name="fields_value[]"
			                        	ng-model="amount.deductions.extra"
			                        	class="form-control"
			                        	step="any">

			                        <input type="hidden" name="fields_name[]" value="Extra">
			                        <input type="hidden" name="type[]" value="deduction">
			                    </div>
			                </div>

		                </div>
					</div>
				</div>






				<div ng-if="advanced_payment > 0 && advanced_payment < 0" ng-cloak>
					<hr style="border: 1px dashed  #ddd;">
					<h3>Advanced Paid</h3>
					<div class="row">
						<div class="col-md-offset-1 col-md-7">

							<div class="form-group">
			                    <label class="col-md-4 control-label">
			                    Total Advanced Paid
			                    </label>

			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	ng-value="advanced_payment"
			                        	class="form-control"
			                        	step="any" readonly>
			                    </div>
			                </div>
		                </div>
					</div>
				</div>




				<div ng-if="profile.bonus" ng-cloak>
					<hr style="border: 1px dashed  #ddd;">
					<h3>Bonus</h3>

					<div class="row">
						<div class="col-md-offset-1 col-md-7">

							<div class="form-group" ng-repeat="bonus in bonuses">
			                    <label class="col-md-4 control-label">
			                    	{{ bonus.fields }} ({{ bonus.percentage }}%)
			                    </label>

			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	name="fields_value[]"
			                        	ng-model="bonus.amount"
			                        	class="form-control"
			                        	step="any" readonly>

			                        <input type="hidden" name="fields_name[]" ng-value="bonus.fields">
			                        <input type="hidden" name="type[]" value="bonus">
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-4 control-label">Extra </label>
			                    <div class="col-md-8">
			                        <input
			                        	type="number"
			                        	name="fields_value[]"
			                        	ng-model="amount.bonuses.extra"
			                        	class="form-control"
			                        	step="any">

			                        <input type="hidden" name="fields_name[]" value="Extra">
			                        <input type="hidden" name="type[]" value="bonus">
			                    </div>
			                </div>

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
	                                <input type="text" class="form-control" name="payment_date"  required value="<?php echo date('Y-m-d'); ?>">
	                                <span class="input-group-addon">
	                                    <span class="glyphicon glyphicon-calendar"></span>
	                                </span>
	                            </div>
                            </div>
							<div class="form-group">
			                    <label class="col-md-4 control-label">Total </label>
			                    <div class="col-md-8">
			                        <input
			                        	type="hidden"
			                        	ng-value="totalFn()"
			                        	class="form-control"
                                        name="total"
			                        	step="any">
                                        <input
    			                        	type="number"
    			                        	ng-value="totalFn()"
    			                        	class="form-control"
                                            name="paid"
    			                        	step="any">
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
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
