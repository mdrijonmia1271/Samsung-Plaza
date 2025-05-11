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
                                    <td><?php echo $value->product_model; ?></td>
                                    <td><?php echo filter($value->category); ?></td>
                                    <td><?php echo filter($value->subcategory); ?></td>
                                    <td><?php echo filter($value->brand); ?></td>
                                    <td><?php echo filter($value->color); ?></td>
                                    <td><?php echo $value->product_serial; ?></td>
                                    <td><?php echo $value->quantity; ?> </td>
                                    <td><?php echo f_number($value->purchase_price); ?></td>
                                    <td><?php echo f_number($value->sell_price); ?></td>
                                    <td><?php echo f_number($purchaseAmount); ?></td>
                                    <td><?php echo f_number($saleAmount); ?></td>
                                    <?php if (checkAuth('super')) { ?>
                                        <td class="none"><?php echo filter($value->godown_name); ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
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