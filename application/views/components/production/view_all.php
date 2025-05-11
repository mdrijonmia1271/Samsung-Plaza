<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
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
    }
    .table tr td{
        vertical-align: middle !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search </h1>
                </div>
            </div>


            <div class="panel-body" ng-cloak>
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>


                <div class="form-group">
                    <label class="col-md-2 control-label">Product's Name</label>
                    <div class="col-md-5">
                        <select name="search[finish_product]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>&nbsp;</option>
                            <?php foreach ($finish_product as $key => $value) { ?>
                            <option value="<?php echo $value->code; ?>" >
                                  <?php echo filter($value->name); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">From</label>
                    <div class="input-group date col-md-5" id="datetimepickerSMSFrom">
                        <input type="text" name="date[from]" class="form-control"  placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To</label>
                    <div class="input-group date col-md-5" id="datetimepickerSMSTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Show" name="show" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
            
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left"> Show Result </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            
            <?php if($result != NULL) { ?>

            <div class="panel-body">
                <!-- Print banner -->
                 <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <h4 class="text-center hide" style="margin-top: 0px;">All Productions</h4>


                <div class="table-responsive">
                    <table class="table table-bordered">

                        <tr>
                            <th width="40">SL</th>
                            <th width="100">Date</th>
                            <th>Batch No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="none" width="165">Action</th>
                        </tr>
                        <?php
                          foreach ($result as $key => $value) {
                           $info = $this->action->read("materials",array("code" => $value->finish_product));
                           $product = ($info) ? $info[0]->name : "";
                        ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $value->date; ?></td>
                                <td><?php echo $value->batch_no; ?></td>
                                <td><?php echo filter($product); ?></td>
                                <td><?php echo $value->quantity. " ". $value->finish_unit; ?></td>
                                <td class="none">
                                    <a class="btn btn-primary" title="View"  href="<?php echo site_url('production/production/view/'.$value->batch_no); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a class="btn btn-warning" title="Edit"  href="<?php echo site_url('production/production/edit/'.$value->batch_no); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a class="btn btn-danger" title="Delete" href="<?php echo site_url('production/production/delete/'.$value->batch_no); ?>" onclick="return confirm('Are you sure want to delete this Data?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
               </div>
            <div class="panel-footer">&nbsp;</div>
          <?php } ?>
        </div>
    </div>
</div>




<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>