<?php 	
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    $logo_data  = json_decode($meta->logo,true); 
?>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    @media print {

        aside,
        nav,
        .none,
        .panel-heading,
        .panel-footer {
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

        .title {
            font-size: 25px;
        }

        .print_banner_logo {
            width: 19%;
            float: left;
        }

        .print_banner_logo img {
            margin-top: 10px;
        }

        .print_banner_text {
            width: 80%;
            float: right;
            text-align: center;
        }

        .print_banner_text h2 {
            margin: 0;
            line-height: 38px;
            text-transform: uppercase !important;
        }

        .print_banner_text p {
            margin-bottom: 5px !important;
        }

        .print_banner_text p:last-child {
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Profit/Loss Report</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <?php
                $attribute = array('class' => 'form-horizontal');
                echo form_open('', $attribute);
                ?>

                <div class="form-group">

                        <?php 
                            if(checkAuth('super')) { 
                                $allGodown = getAllGodown();
                        ?>
                        <div class="col-md-2">
                            <select name="godown_code" class="form-control">
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <option value="all">All Showroom</option>
                                <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                                <option value="<?php echo $row->code; ?>">
                                    <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <?php }else { ?>
                        <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                        <?php } ?>

                    <div class="col-md-3">
                        <select name="search[product_code]" class="selectpicker form-control" data-show-subtext="true"
                            data-live-search="true">
                            <option value="" selected disabled>-- Product Name --</option>
                            <?php foreach ($allProducts as $key => $product) { ?>
                            <option value="<?php echo $product->product_code; ?>"><?php echo $product->product_name; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="search[voucher_no]" class="form-control" placeholder="Voucher No.">
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        <br>
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php if ($resultInfo !=null) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left"> Show Result </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="hide text-center" style="margin-top: 0px;"> </h4>-->
                <div class="col-md-12 text-center hide">
                    <h3> Product Wise
                        Profit/Loss Report</h3>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Voucher No</th>
                        <th>Showroom</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Purchase price</th>
                        <th>Sales Price</th>
                        <th>Profit</th>
                        <th>Loss</th>
                    </tr>

                    <?php 

                    $totalLoss = $totalProfit =  $totalQuantity = $totalPurchase = $totalSale = $loss  = $profit = 0;
                    foreach ($resultInfo as $key => $value) {
                        // read product name by code
                        $where          = ['product_code' =>$value->product_code];
                        $nameInfo       = get_row('products', $where, ['product_name', 'unit']);
                        $showroom       = get_row('godowns', ['code'=>$value->godown_code], ['name']);


                        // count profit loss
                        $purchase_sum   =  $value->purchase_price * $value->quantity;
                        $sale_sum       =  $value->sale_price * $value->quantity; 

                        // dectect profit or loss
                        if ($purchase_sum > $sale_sum) {
                            $loss   = $purchase_sum - $sale_sum;
                        }else{
                            $profit = $sale_sum - $purchase_sum;
                        }

                        // count total accounce
                        $totalLoss          += $loss;
                        $totalProfit        += $profit;
                        $totalPurchase      += $value->purchase_price;
                        $totalSale          += $value->sale_price;
                        $totalQuantity      += $value->quantity;

                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo $showroom->name; ?></td>
                        <td><?php echo (isset($nameInfo->product_name)) ? filter($nameInfo->product_name) : ''; ?></td>
                        <td><?php echo (isset($nameInfo->unit)) ? filter($nameInfo->unit) : ''; ?></td>
                        <td><?php echo $value->quantity; ?></td>
                        <td><?php echo f_number($value->purchase_price); ?></td>
                        <td><?php echo f_number($value->sale_price); ?></td>
                        <td><?php echo f_number($profit); ?></td>
                        <td><?php echo f_number($loss); ?></td>
                    </tr>
                    <?php } ?>

                    <tr class="bg-info" style="font-weight: bold;">
                        <td colspan="6" class="text-center">Total <small> (profit & loss)</small></td>
                        <td>
                            <?php echo f_number($totalPurchase);?> Tk
                        </td>
                        <td>
                            <?php echo  f_number($totalSale);?> Tk
                        </td>
                        <td>
                            <?php echo f_number($totalProfit);?> Tk
                        </td>
                        <td>
                            <?php echo f_number($totalLoss);?> Tk
                        </td>
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
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>