<style>
@media print{
    aside, nav, .panel-heading, .none, .panel-footer{
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
</style>

<div class="container-fluid">
    <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Product Wise Profit/Loss </h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name </label>
                    <div class="col-md-4" >
                        <select name="search[product_code]" class="form-control">
                            <option value="">&nbsp;</option>
                            <?php
                            foreach ($allProduct as $key => $row) { ?>
                            <option value="<?php echo $row->product_code; ?>"><?php echo filter($row->product_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">From </label>
                    <div class="input-group date col-md-4" id="datetimepickerFrom">
                        <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To </label>
                    <div class="input-group date col-md-4" id="datetimepickerTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close();?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <?php if($result != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a></div>
            </div>

            <div class="panel-body">
				<!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <h4 class="text-center hide" style="margin-top: 0px;">Product Wise Profit/loss </h4>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Product Name</th>
                        <th width="130px">Purchase Quantity</th>
                        <th width="130px">Sale Quantity</th>
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                        <th>Profit</th>
                        <th>Loss</th>
                    </tr>

                    <?php
                    $counter = 0;
                    $grandtotalSell = $grandtotalPurchase = $totalProfit = $totalLoss = 0.00;
                    foreach($result as $key => $row){

                        $where = array( "product_code" => $row->product_code, "unit" => $row->unit);
                        $sapInfo = $this->retrieve->read("sapitems", $where);

                        $sellQuantity = $purchaseQuantity = $totalSell = $totalPurchase = $profit_loss = $sellPurchase = 0.00;

                        foreach ($sapInfo as $key => $val) {
                            if ($val->status == "purchase") {
                                $purchaseQuantity += $val->quantity;
                            }

                            if ($val->status == "sale") {
                                $sellQuantity += $val->quantity;
                                $sellPurchase += ($val->purchase_price * $val->quantity);
                                $totalSell += ($val->sale_price * $val->quantity);
                            }
                        }

                        $profit_loss = $totalSell - $sellPurchase;
                        if ($profit_loss > 0) {
                            $totalProfit += $profit_loss;
                        }
                        if ($profit_loss < 0) {
                            $totalLoss += $profit_loss;
                        }
                        $grandtotalPurchase += $sellPurchase;
                        $grandtotalSell += $totalSell;

                        $productInfo = $this->action->read("products", array("product_code" => $row->product_code));

                        $counter++;
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php if($productInfo) echo filter($productInfo[0]->product_name); ?></td>
                        <td><?php echo $purchaseQuantity . " " . $row->unit; ?></td>
                        <td><?php echo $sellQuantity . " " . $row->unit; ?></td>
                        <td><?php echo f_number($sellPurchase); ?></td>
                        <td><?php echo f_number($totalSell); ?></td>
                        <td><?php if ($profit_loss > 0) {echo f_number($profit_loss);}else{echo "0";} ?></td>
                        <td><?php if ($profit_loss < 0) {echo f_number(abs($profit_loss));}else{echo "0";} ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th><?php echo f_number($grandtotalPurchase); ?></th>
                        <th><?php echo f_number($grandtotalSell); ?></th>
                        <th><?php echo f_number($totalProfit); ?></th>
                        <th><?php echo f_number(abs($totalLoss)); ?></th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>


<script>
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
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
