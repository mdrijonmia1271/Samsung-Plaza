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

    .red {
        color: red;
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Stock</h1>
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
                            <select name="search[color]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected>Select Color</option>
                                <?php if (!empty($colorsList)) {
                                    foreach ($colorsList as $key => $row) { ?>
                                        <option value="<?php echo $row->color; ?>">
                                            <?php echo filter($row->color); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
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
                    <h1 class=" pull-left">Stock
                        <?php
                        $godownCode = '';
                        if (!empty($_POST['godown_code'])) {
                            if ($_POST['godown_code'] != 'all') {
                                $godownCode = $_POST['godown_code'];
                            }
                        } else {
                            $godownCode = $this->data['branch'];
                        }
                        if (!empty($godownCode)) {
                            echo '- ';
                            echo get_name('godowns', 'name', array('code' => $godownCode));
                        }
                        ?>
                    </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
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
                                <th>Product Model</th>
                                <th width="135">Category</th>
                                <th>Subcategory</th>
                                <th>Brand</th>
                                <th>Color</th>
                                <th>IMEI/Serial No</th>
                                <th width="70">Qty.</th>
                                <th>P.Price</th>
                                <th>S.Price</th>
                                <th>P.Amount</th>
                                <th>S.Amount</th>
                                <?php if (checkAuth('super')) { ?>
                                    <th width="130" class="none">Showroom</th>
                                <?php } ?>
                            </tr>
                            <?php
                            $totalPurchaseAmount = $totalSaleAmount = $totalQuantity = 0;
                            foreach ($results as $key => $value) {

                                $purchaseAmount = $value->purchase_price * $value->quantity;
                                $saleAmount     = $value->sell_price * $value->quantity;

                                $totalPurchaseAmount += $purchaseAmount;
                                $totalSaleAmount     += $saleAmount;
                                $totalQuantity       += $value->quantity;
                                ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('stock/stock/group_stock_single/'.$value->code);?>" target="_blank">
                                            <?php echo $value->product_model; ?>
                                        </a>
                                    </td>
                                    <td><?php echo filter($value->category); ?></td>
                                    <td><?php echo filter($value->subcategory); ?></td>
                                    <td><?php echo filter($value->brand); ?></td>
                                    <td><?php echo filter($value->color); ?></td>
                                    <td><?php echo $value->product_serial; ?></td>
                                    <td><?php echo $value->quantity; ?> </td>
                                    <td><?php echo $value->purchase_price; ?></td>
                                    <td><?php echo $value->sell_price; ?></td>
                                    <td> <?php 
                                              echo $value->purchase_price*$value->quantity;
                                          ?>
                                    </td>
                                    <td><?php 
                                               
                                                echo $value->sell_price*$value->quantity;
                                                
                                                ?>
                                    </td>
                                    <?php if (checkAuth('super')) { ?>
                                        <td class="none"><?php echo filter($value->godown_name); ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="7" class="text-right">Total</th>
                                <th><?php echo f_number($totalQuantity); ?></th>
                                <th></th>
                                <th></th>
                                <th><?php echo f_number($totalPurchaseAmount); ?></th>
                                <th><?php echo f_number($totalSaleAmount); ?></th>
                                <th class="none">&nbsp;</th>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<!-- Select Option 2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>