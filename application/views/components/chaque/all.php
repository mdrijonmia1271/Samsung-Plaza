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
        .panel .hide{
            display: block !important;
        }
    }
    .table-bordered{
        vertical-align: middle;
    }
</style>

<div class="container-fluid" ng-controller="">
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Show Cheque Issue </h1>
                </div>
            </div>



            <div class="panel-body">
				<?php
				$attribute = array(
					"name" => "",
					"class" => "form-horizontal"
				);

				echo form_open("", $attribute);
				?>
                <div class="col-md-12 no-padding">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date</label>
                        <div class="input-group date col-md-5" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12no-padding">
                    <div class="form-group">
                        <label class="col-md-2 control-label">to</label>
                        <div class="input-group date col-md-5" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-7 no-padding">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

				<?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>



		<?php if($resultset != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">All Cheque Issue </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()">
                        <i class="fa fa-print"></i>
                        Print
                    </a>
                </div>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                
                <hr class="hide" style="border-bottom: 1px solid #ccc;">
                <h4 class="text-center hide" style="margin-top: -10px;">All Cheque Issue</h4>

                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Pass Date</th>
                        <th>Customer Name</th>
                        <th>Bank Name</th>
                        <th>Mobile No</th>
                        <th>Chaque No</th>
                        <th>Amount</th>
                        <th class="none">Action</th>
                    </tr>

                    <?php
                    foreach ($resultset as $key => $value) {
					$trInfo = $this->action->read('partytransaction', array('id' => $value["transaction_id"]));
                    $partyInfo = $this->action->read("parties", array("code" => $trInfo[0]->party_code));
					?>
                    <tr>
                        <td> <?php echo ($key + 1); ?> </td>

                        <td><?php echo $value["passdate"]; ?></td>

                        <td> <?php if($partyInfo){ echo filter($partyInfo[0]->name);}else{ echo "N/A";} ?> </td>

                        <td>
							<?php echo filter($value["bankname"]); 	?>
						</td>

                        <td> <?php if($partyInfo){ echo $partyInfo[0]->contact;}else{ echo "N/A";} ?> </td>

                        <td>
                            <?php echo filter($value["chequeno"]); 	?>
						</td>

                        <td> <?php echo $trInfo[0]->paid; ?> </td>

                        <td class="none" style="width: 115px;">
                            <a class="btn btn-warning" href="<?php echo site_url('chaque/chaque/changeStatus?id=' . $value["transaction_id"]); ?>">
                                <?php echo filter($value["status"]); 	?>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
		<?php } ?>
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
