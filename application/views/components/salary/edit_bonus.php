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
            <h1>Edit Bonus </h1>
        </div>
    </div>

    <div class="panel-body">
        <?php
        $attr = array("class" => "form-horizontal");
        echo form_open('salary/salary/bonus_edit/' . $info->id, $attr);
        ?>

        <div class="form-group">
            <label class="col-md-3 control-label">Employee <span class="req"> *</span></label>
            <div class="col-md-5">
                <select name="emp_id" class="selectpicker form-control" data-show-subtext="true" data-live-search="true"
                        required>
                    <option value="" disabled>-- Select Employee --</option>
                    <?php if (!empty($employee)) {
                        foreach ($employee as $key => $value) {
                            echo '<option value="' . $value->emp_id . '" ' . (!empty($info) && $info->emp_id == $value->emp_id ? "selected" : "") . '>' . get_filter($value->name) . '</option>';
                        }
                    } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Date <span class="req">*</span></label>
            <div class="col-md-5">
                <div class="col-md-6">
                    <div class="row">
                        <select name="year" class="form-control">
                            <option value="" selected disabled>-- Year --</option>
                            <?php
                            for ($y = date('Y') + 1; $y >= 2018; $y--) {
                                echo '<option value="' . $y . '" ' . (get_date_format($info->bonus_date, 'Y') == $y ? "selected" : "") . '> ' . $y . ' </option>';
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <select name="month" class="form-control">
                            <option value="" selected disabled>-- Month --</option>
                            <?php
                            if (!empty(config_item('all_months')))
                                foreach (config_item('all_months') as $_key => $m_value) {
                                    echo '<option value="' . $_key . '" ' . (get_date_format($info->bonus_date, 'm') == $_key ? "selected" : "") . '> ' . $m_value . ' </option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 control-label">Bonus <span class="req">*</span></label>
            <div class="col-md-5">
                <div class="input-group">
                    <input type="text" name="bonus" value="<?php echo $info->bonus; ?>"  max="100"
                           placeholder="Set Your Bonus" class="form-control" required>
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="btn-group pull-right">
                <input type="submit" class="btn btn-success" style="margin-right: -5px;" value="Update" name="set"/>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>

    <div class="panel-footer">&nbsp;</div>
</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'MM/YYYY'
        });
    });
</script>