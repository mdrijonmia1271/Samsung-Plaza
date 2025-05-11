<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}

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

        <?php echo $this->session->flashdata('confirmation'); ?>


      <div class="panel panel-default">
          <div class="panel-heading">
              <div class="panal-header-title">
                  <h1 class="pull-left">Search Collection</h1>
              </div>
          </div>

          <div class="panel-body none">
              <?php
              $attr = array('class' => 'form-horizontal');
              echo form_open('', $attr);
              ?>

              <div class="form-group">
                  <label class="col-md-2 control-label"> Showroom Name </label>
                  <div class="col-md-5">
                      <select name="search[showroom_id]" class="form-control" required>
                          <option value="" selected disabled>&nbsp;</option>
                          <?php if ($showrooms != null) {
                              foreach ($showrooms as $row) { ?>
                                 <option value="<?php echo $row->showroom_id; ?>"><?php echo $row->name; ?></option>
                          <?php } } ?>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">From</label>
                  <div class="col-md-5">
                      <div class="input-group date" id="datetimepickerFrom">
                          <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">To</label>
                  <div class="col-md-5">
                      <div class="input-group date" id="datetimepickerTo">
                          <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
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







<?php if($results != NULL){ ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Collection</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                
                <h4 class="hide text-center" style="margin-top: 0px;">All Collection</h4>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 35px;"> SL </th>
                        <th>Date</th>
                        <th>Showroom</th>
                        <th>Amount (Tk)</th>
                        <th>Collected By</th>
                        <th>Remarks</th>
                        <th class="none"> Action </th>
                    </tr>

                    <?php
                      foreach ($results as $key => $value) {
                        $info = $this->action->read("showroom",array('showroom_id' => $value->showroom_id));
                        if($info != NULL) { $name = filter($info[0]->name); }
                    ?>
                      <tr>
                          <td><?php echo $key+1; ?></td>
                          <td><?php echo $value->date; ?></td>
                          <td><?php echo $name; ?></td>
                          <td><?php echo $value->amount; ?></td>
                          <td><?php echo filter($value->collected_by); ?></td>
                          <td><?php echo $value->remarks;?></td>

                          <td class="none" style="width: 115px;">
                              <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure want to delete this Info?');" href="<?php echo site_url('sheet/showroom_collection/delete/'.$value->id); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          </td>
                      </tr>
                   <?php } ?>
                </table>
               </div>
          <div class="panel-footer">&nbsp;</div>
      </div>
    </div>
</div>
  <?php }  ?>
<script type="text/javascript">
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
