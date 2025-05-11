<!-- Select Option 2 Stylesheet -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }
    }

    .wid-100 {
        width: 100px;
    }

    #loading {
        text-align: center;
    }

    #loading img {
        display: inline-block;
    }

</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Datewise Stock</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open(); ?>

                <div class="row">
                    <?php if (!checkAuth('user')) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="godown_code" ng-init="godownCode=''" ng-model="godownCode"
                                        class="form-control">
                                    <option value="" selected>Select Showroom</option>
                                    <option value="all">All Showroom</option>
                                    <?php if (!empty($godownList)) {
                                        foreach ($godownList as $row) { ?>
                                            <option value="<?php echo $row->code; ?>">
                                                <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="text" name="godown_code"
                               ng-init="godownCode='<?php echo $this->data["branch"]; ?>'" ng-value="godownCode">
                    <?php } ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[code]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected>Select Product</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->product_model); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[category]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected disabled>Select Category</option>
                                <?php if (!empty($categoryList)) {
                                    foreach ($categoryList as $key => $row) { ?>
                                        <option value="<?php echo $row->category; ?>">
                                            <?php echo filter($row->category); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[subcategory]" class="selectpicker form-control"
                                    data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected disabled>Select Subcategory</option>
                                <?php if (!empty($subcategoryList)) {
                                    foreach ($subcategoryList as $key => $row) { ?>
                                        <option value="<?php echo $row->subcategory; ?>">
                                            <?php echo filter($row->subcategory); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[brand]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected disabled>Select Brand</option>
                                <?php if (!empty($brandList)) {
                                    foreach ($brandList as $key => $row) { ?>
                                        <option value="<?php echo $row->brand; ?>">
                                            <?php echo filter($row->brand); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerSMSFrom">
                                <input type="text" name="from" class="form-control" value="<?php echo date('Y-m-d'); ?>"
                                       placeholder="From">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Datewise Stock
                        <?php
                        $code = $this->input->post('godown_code');
                        if ($code != '' && $code != 'all') {
                            echo '-';
                            echo get_name('godowns', 'name', array('code' => $code));
                        }
                        ?>
                    </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <!-- <img class="img-responsive print-banner hide" src="<?php // echo site_url($banner_info[0]->path); ?>" > -->
                <?php $this->load->view('print', $this->data); ?>
                <?php if (!empty($results)) { ?>
                    <h4 class="hide text-center" style="margin-top: 0px;">
                        Stock
                        <?php
                        $code = $this->input->post('godown_code');
                        if ($code != '' && $code != 'all') {
                            echo '-';
                            echo get_name('godowns', 'name', array('code' => $code));
                        }
                        ?>
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40px;">SL</th>
                                <!-- <th>Name</th> -->
                                <th>Model</th>
                                <th>Category</th>
                                <th width="250">Subcategory</th>
                                <th width="80">Qty.</th>
                                <!--<th>Purchase Price</th>
                                <th>Sell Price</th>
                                <th>Purchase Amount</th>
                                <th>Sell Amount</th>-->
                                <?php if (checkAuth('super')) { ?>
                                    <th width="140" class="none">Showroom</th>
                                <?php } ?>
                            </tr>
                            <?php
                            $totalSellPrice        = $totalAmount = $totalPurchasePrice = 0.00;
                            $total_pcs             = 0.00;
                            $total_purchase_amount = $total_sale_amount = 0;
                            foreach ($results as $key => $value) {
                                $purchase = ($value->purchase_price * $value->quantity);
                                $sell     = ($value->sell_price * $value->quantity);
                                ?>
                                <style>.red {
                                        color: red;
                                        font-weight: bold;
                                    }</style>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <!-- <td><?php // echo filter($value->name);
                                    ?></td> -->
                                    <td><?php echo $value->product_model; ?></td>
                                    <td><?php echo filter($value->category); ?></td>
                                    <td><?php echo filter($value->subcategory); ?></td>
                                    <td <?php if ($value->quantity < 10) {
                                        echo "class='red'";
                                    }; ?>>
                                        <?php
                                        $where_purchase        = array();
                                        $where_sale            = array();
                                        $where_free            = array();
                                        $where_purchase_return = array();
                                        $where_sale_return     = array();
                                        $where_damage_product  = array();
                                        $total_qty             = 0;

                                        $purchase_qty = $sale_qty = $purchase_return_qty = $sale_return_qty = $damage_product_qty = $free_qty = 0;


                                        if (isset($_POST['godown_code'])) {
                                            if ($_POST['godown_code'] != 'all') {
                                                $where_purchase['godown_code']        = $_POST['godown_code'];
                                                $where_sale['godown_code']            = $_POST['godown_code'];
                                                $where_free['godown_code']            = $_POST['godown_code'];
                                                $where_purchase_return['godown_code'] = $_POST['godown_code'];
                                                $where_sale_return['godown_code']     = $_POST['godown_code'];
                                            }
                                        }


                                        if ((isset($_POST['from']))) {

                                            $from         = $_POST['from'];
                                            $product_code = $value->code;

                                            $where_purchase['sap_at <=']    = $from;
                                            $where_purchase['product_code'] = $product_code;
                                            $where_purchase['status']       = 'purchase';
                                            $where_purchase['trash']        = 0;

                                            $where_sale['sap_at <=']    = $from;
                                            $where_sale['product_code'] = $product_code;
                                            $where_sale['status']       = 'sale';
                                            $where_sale['trash']        = 0;

                                            $where_free['sap_at <=']    = $from;
                                            $where_free['product_code'] = $product_code;
                                            $where_free['status']       = 'free';
                                            $where_free['trash']        = 0;


                                            $where_purchase_return['date <=']      = $from;
                                            $where_purchase_return['product_code'] = $product_code;

                                            $where_sale_return['date <=']      = $from;
                                            $where_sale_return['product_code'] = $product_code;
                                            $where_sale_return['trash']        = 0;

                                            $where_damage_product['date <=']      = $from;
                                            $where_damage_product['product_code'] = $product_code;


                                        } else {

                                            $product_code = $value->code;

                                            $where_purchase['product_code'] = $product_code;
                                            $where_purchase['status']       = 'purchase';
                                            $where_purchase['trash']        = 0;


                                            $where_sale['product_code'] = $product_code;
                                            $where_sale['status']       = 'sale';
                                            $where_sale['trash']        = 0;

                                            $where_free['product_code'] = $product_code;
                                            $where_free['status']       = 'free';
                                            $where_free['trash']        = 0;


                                            $where_purchase_return['product_code'] = $product_code;


                                            $where_sale_return['product_code'] = $product_code;
                                            $where_sale_return['trash']        = 0;

                                            $where_damage_product['product_code'] = $product_code;

                                        }


                                        $purchase_qty        = get_sum('sapitems', 'quantity', $where_purchase);
                                        $sale_qty            = get_sum('sapitems', 'quantity', $where_sale);
                                        $free_qty            = get_sum('sapitems', 'quantity', $where_free);
                                        $purchase_return_qty = get_sum('purchase_return', 'quantity', $where_purchase_return);
                                        $sale_return_qty     = get_sum('sale_return', 'quantity', $where_sale_return);
                                        //$damage_product_qty = get_sum('damage_product', 'quantity', $where_damage_product); 

                                        echo $qty = ($purchase_qty + $sale_return_qty) - ($sale_qty + $purchase_return_qty + $damage_product_qty + $free_qty);
                                        $total_pcs += $qty;

                                        ?>
                                    </td>
                                    <!--<td><?php //echo $value->purchase_price;
                                    ?></td>
                            <td><?php //echo $value->sell_price;
                                    ?></td>
                            <td><?php //echo $purchase; $total_purchase_amount += $purchase;
                                    ?></td>
                            <td><?php //echo $sell; $total_sale_amount += $sell;
                                    ?></td>-->
                                    <?php if (checkAuth('super')) { ?>
                                        <td class="none"><?php echo filter($value->godown_name); ?></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $totalPurchasePrice += $value->purchase_price;
                                $totalSellPrice     += $value->sell_price;
                            } ?>
                            <tr>
                                <td colspan="4"><b class="pull-right">Total </b></td>
                                <td><b><?php echo $total_pcs . ' '; ?></b></td>
                                <!--<td>&nbsp;</td>
                            <td><b><?php //echo $totalPurchasePrice.' TK'; ?></b></td>
                            <td><b><?php //echo $total_purchase_amount.' TK'; ?></b></td>
                            <td><b><?php //echo $total_sale_amount.' TK'; ?></b></td>-->
                                <?php if (checkAuth('super')) { ?>
                                    <td class="none">&nbsp;</td>
                                <?php } ?>
                            </tr>
                        </table>
                    </div>
                <?php } else {
                    echo '<p class="text-center"> <strong> No data found! </strong> </p>';
                } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<!-- Select Option 2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
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