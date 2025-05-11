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
<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Collection From Showroom</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                  echo $this->session->flashdata('confirmation');
                  $attribute = array('class' => 'form-horizontal');
                  echo form_open('', $attribute);
                ?>

                <div class="form-group">
                <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                  <div class="col-md-5">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" required class="form-control" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Showroom <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select class="form-control" name="showroom" required>
                            <option value="" selected disabled>&nbsp;</option>
                            <?php if($showrooms){ foreach ($showrooms as $key => $value) { ?>
                              <option value="<?php echo $value->showroom_id; ?>"><?php echo filter($value->name); ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Collected  Amount <span class="req">*</span></label>
                    <div class="col-md-5">
                      <input type="number" name="amount" class="form-control"  min="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Collected By<span class="req"></span></label>
                    <div class="col-md-5">
                      <input type="text" name="collected_by" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Remarks<span class="req"></span></label>
                    <div class="col-md-5">
                      <textarea name="remark" rows="4" cols="62"></textarea>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Collect" name="collect" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });

    });
</script>
