<style type="text/css">
    .info-view {
        width: 100%;
        display: flex;
        align-items: center;
    }

    .info-view img {
        max-width: 190px;
        margin-right: 15px;
    }

    .info-view figcaption p {
        margin-bottom: 5px;
    }

    .customBtn {
        font-size: 22px !important;
        font-weight: bold !important;
        color: #555 !important;
    }

    .custom-table tr td {
        padding: 0 !important;
    }

    .custom-table tr td .form-control {
        border: transparent;
    }

</style>

<div class="container-fluid" ng-controller="PayrollCtrl" ng-cloak>
    <div class="row">
       <?= $this->session->flashdata('confirmation') ?>
        <!-- Basic Salary -->
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Basic Salary </h1>
                </div>
            </div>

            <div class="panel-body">

                <?= form_open('salary/salary/set_basic_salary', ['class' => 'form-horizontal']) ?>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Employee ID <span class="req">*</span></label>
                        <div class="col-md-8">
                            <select name="emp_id"
                                    class="selectpicker form-control" ng-model="data.eid"
                                    ng-change="getProfileFn();" data-show-subtext="true" data-live-search="true"
                                    required>
                                <option value="">&nbsp;</option>
                                <?php if (!empty($employee)) {
                                    foreach ($employee as $key => $value) {
                                        echo '<option value="' . $value->emp_id . '">' . get_filter($value->name) . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Amount <span class="req">*</span> </label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" name="employee_salary" ng-model="basic_salary" class="form-control" required>
                                <div class="input-group-addon"><i class="fa">৳</i></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="btn-group pull-right">
                                <input type="submit" id="submit_btn" name="save_data" value="Active"
                                       class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>

                <div class="col-md-6">
                    <figure class="info-view" ng-if="profile.active" ng-cloak>
                        <img class="img-responsive img-thumbnail" ng-src="{{ profile.image }}">

                        <figcaption>
                            <p><strong>Employee ID: </strong> {{ profile.eid }}</p>
                            <p><strong>Name: </strong> {{ profile.name }}</p>
                            <p><strong>Post: </strong> {{ profile.post | textBeautify}}</p>
                            <p><strong>Mobile: </strong> {{ profile.mobile }}</p>
                            <p><strong>Email: </strong> {{ profile.email }}</p>
                            <p><strong>Joining Date: </strong> {{ profile.joining }}</p>
                        </figcaption>
                    </figure>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
