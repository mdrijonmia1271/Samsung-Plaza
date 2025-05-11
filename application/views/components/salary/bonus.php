<style type="text/css">
    .info-view {
        width: 100%;
        max-width: 230px;
        max-height: 230px;
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    .custom-table tr td {
        padding: 0 !important;
    }

    .custom-table tr td .form-control {
        border: transparent;
    }
</style>

<?php echo $this->session->flashdata('confirmation'); ?>

<div class="panel panel-default" ng-controller="BonusCtrl" ng-cloak>

    <div class="panel-heading panal-header">
        <div class="panal-header-title pull-left">
            <h1>Bonus </h1>
        </div>
    </div>

    <div class="panel-body">
        <?php
        $attr = array("class" => "form-horizontal");
        echo form_open('salary/salary/set_bonus', $attr);
        ?>

        <div class="form-group">
            <label class="col-md-3 control-label">Set Month <span class="req">*</span></label>
            <div class="col-md-8">
                <div class="col-md-3">
                    <div class="row">
                        <select name="year" ng-model="year" ng-init="year='<?= date('Y') ?>'"
                                ng-change="getAllAdvance(year)" class="form-control">
                            <option value="" selected disabled>-- Year --</option>
                            <?php
                            for ($y = date('Y') + 1; $y >= 2018; $y--) {
                                echo '<option value="' . $y . '"> ' . $y . ' </option>';
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="row">
                        <select name="month" ng-model="month" ng-init="month='<?= date('m') ?>'"
                                ng-change="getAllAdvance(month)" class="form-control">
                            <option value="" selected disabled>-- Month --</option>
                            <?php
                            if (!empty(config_item('all_months')))
                                foreach (config_item('all_months') as $_key => $m_value) {
                                    echo '<option value="' . $_key . '"> ' . $m_value . ' </option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($allEmployee)) { ?>

            <table class="table table-bordered table-hover">
                <tr>
                    <th width="60"><input type="checkbox" checked id="check_all">&nbsp; SL</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th width="200">Bonus (%)</th>
                </tr>

                <?php foreach ($allEmployee as $key => $row) { ?>

                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" checked
                                   value="<?php echo $key; ?>">&nbsp; <?php echo $key + 1; ?>
                        </td>
                        <td>
                            <input type="hidden" value="<?php echo $row->emp_id; ?>" name="emp_id[]">
                            <?php echo $row->emp_id; ?>
                        </td>
                        <td>
                            <?php echo filter($row->name); ?>
                        </td>
                        <td>
                            <?php echo filter($row->designation); ?>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="bonus[]" min="0" max="100" value="0">
                        </td>
                    </tr>

                <?php } ?>
            </table>

            <div class="col-md-12">
                <div class="row text-right">
                    <input type="submit" class="btn btn-success" style="margin-right: -5px;" value="Set Bonus"
                           name="set"/>
                </div>
            </div>

        <?php } ?>


        <?php echo form_close(); ?>
    </div>

    <div class="panel-footer">&nbsp;</div>
</div>

<?php if (!empty($results)) { ?>

    <div class="panel panel-default">

        <div class="panel-heading panal-header">
            <div class="panal-header-title pull-left">
                <h1>Result </h1>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <?php /* <pre><?php print_r($percent); ?></pre> */ ?>
                <table class="table table-bordered">
                    <tr>
                        <th width="50">SL</th>
                        <th width="150">Date</th>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Bonus</th>
                        <th width="110">Action</th>
                    </tr>
                    <?php
                    foreach ($results as $key => $row) {
                        ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= format_date($row->created) ?></td>
                            <td><?= filter($row->name) ?></td>
                            <td><?= $row->emp_id ?></td>
                            <td><?= get_date_format($row->bonus_date, 'Y') ?></td>
                            <td><?= get_date_format($row->bonus_date, 'F'); ?></td>
                            <td><?= $row->bonus; ?> %</td>
                            <td>
                                <a href="<?php echo site_url('salary/salary/edit_bonus/' . $row->id); ?>" title="Edit"
                                   class="btn btn-info"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo site_url('salary/salary/bonus_delete/' . $row->id); ?>"
                                   onclick="return confirm('Do you want to delete this Bonus Data?');" title="Delete"
                                   class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="panel-footer">&nbsp;</div>
    </div>
<?php } ?>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'MM/YYYY'
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#check_all").on("change", function () {
            if ($(this).is(":checked") == true) {
                $('input[name="id[]"]').prop("checked", true);
            } else {
                $('input[name="id[]"]').prop("checked", false);
            }
        });
    });
</script>
