<script src="<?php echo site_url('private/js/ngscript/supplierLedgerCtrl.js?') . time(); ?>"></script>
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

    .table tr th,
    .table tr td {
        font-size: 13px;
        padding: 4px !important;
    }

    .table tr td p {
        margin: 0;
        padding: 0;
    }
</style>
<div class="container-fluid" ng-controller="supplierLedgerCtrl">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Supplier Ledger</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>
                <div class="form-group">
                <?php if (checkAuth('super')) { ?>
                        <div class="col-md-2">
                            <select class="form-control" name="godown_code" ng-model="godown_code" required>
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="godown_code" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                               ng-model="godown_code" ng-value="godown_code"
                               required>
                    <?php } ?>
                    
                    <div class="col-md-3">
                        <select ui-select2="{ allowClear: true}" ng-model="supplierCode" class="form-control" name="search[party_code]" required='required'>
                            <option value="" selected disable>--Select Supplier--</option>
                            <option ng-repeat="supplier in supplierList" value="{{supplier.code}}">{{ supplier.name }} - {{ supplier.address }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php if(empty(isset($_POST['search']))){ ?>
            <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result  </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3>Supplier Ledger</h3>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="45">SL</th>
                        <th>Supplier Name</th>
                        <th>Opening Balance</th>
                        <th>Credit </th>
                        <th>Debit </th>
                        <th>Balance</th>
                        <!-- <th class="text-center">Status</th> -->
                    </tr>
                    <?php
                        $totalDebit = $totalCredit = $total = $totalQuantity = $grandTotal = 0.00;
                        $counter = 1;
                        foreach ($defaultData as $key => $row) {
                    ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $row['code'].' - '.filter($row['name']); ?></td>
                        <td><?php echo f_number(abs($row['init'])).($row['init_status']=='Payable' ?  ' ' : ' - '); ?></td>
                        <td><?php echo f_number($row['credit']);$totalCredit += $row['credit']; ?></td>
                        <td><?php echo f_number($row['debit']);$totalDebit += $row['debit']; ?></td>
                        <td>
                            <?php
                                $balance    = 0.0;
                                $balance    = $row['debit'] - $row['credit'] + $row['init'];
                                //$status     = ($balance > 0 )? "Receivable": "Payable";
                                $status     = ($balance > 0 )? "- ": " ";
                                echo f_number(abs($balance));
                                $grandTotal += $balance;
                            ?>
                        </td>
                        <!-- <td class="text-center">
                            <?php // echo $status; ?>
                        </td> -->
                    </tr>
                    <?php }  ?>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><strong><?php echo f_number($totalCredit); ?></strong></th>
                        <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                        <th><strong><?php echo f_number(abs($grandTotal)); ?></strong></th>
                        <!-- <th class="text-center">
                            <strong><?php // echo ($grandTotal >= 0) ? "Receivable" : "Payable"; ?></strong>
                        </th> -->
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php }  ?>
        <!--Get data after submit result Start here-->
        <?php if (!empty($resultset && !empty(isset($_POST['search'])))) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->

                <div class="col-xs-12 hide"
                    style="border: 1px solid #ddd; padding:15px !important; margin-bottom: 15px;">
                    <!--<div class="print_banner_logo">
                        <img class="img-responsive" src="<?php echo site_url($logo_data['faveicon']); ?>" alt="">
                    </div>
                    <div class="print_banner_text">
                        <h2><?php echo strtoupper($header_info['site_name']); ?></h2>
                        <p><?php echo $header_info['place_name'];?></p>
                        <p><?php echo $footer_info['addr_moblile']; ?> || <?php echo $footer_info['addr_email']; ?></p>
                    </div>-->
                     <?php $this->load->view('print', $this->data); ?>
                </div>

                <!-- Print banner End Here -->

                <h4 class="text-center hide" style="margin-top: 0px;">Supplier Ledger</h4>
                <hr>
                <div class="row">
                    <div class="col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">Supplier ID :</th>
                                <td><?php echo $partyInfo->code; ?></td>
                            </tr>
                            <tr>
                                <th>Supplier :</th>
                                <td><?php echo filter($partyInfo->name); ?></td>
                            </tr>
                            <tr>
                                <th> Address :</th>
                                <td> <?php echo $partyInfo->address; ?> </td>
                            </tr>
                            <tr>
                                <th> Mobile :</th>
                                <td> <?php echo $partyInfo->mobile; ?> </td>
                            </tr>
                            <tr>
                                <th> Mobile :</th>
                                <td> <?php echo $partyInfo->mobile; ?> </td>
                            </tr>
                            
                        </table>
                    </div>
                    <div class="col-xs-offset-2 col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th>Date :</th>
                                <td>
                                    <?php
                                    if($fromDate != NULL || $toDate != NULL){
                                        echo $fromDate . ' To ' . $toDate;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th width="40%">Opening Balance :</th>
                                <td>
                                    <strong>
                                        <?php
                                            //$opening_status = ($partyInfo->initial_balance < 0)? "Payable":"Receivable";
                                            $opening_status = ($partyInfo->initial_balance < 0)? " ":" - ";
                                            echo $opening_status . f_number(abs($partyInfo->initial_balance));
                                            $opening_balance = $partyInfo->initial_balance;
                                        ?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Current Balance :</th>
                                <td>
                                    <strong>
                                        <?php
                                            // Calculate Balance from partytrasaction table.
                                            // Final balance = total_debit - total_credit + initial_balance.
                                            // Final Balance (+ve) = Receivable and (-ve) = Payable
                                            $where = [
                                                'party_code' => $partyInfo->code,
                                                'trash'      => 0
                                            ];

                                            if(isset($_POST['show'])) {

                                                if(!empty($_POST['godown_code'])){
                                                    if($_POST['godown_code'] != 'all'){
                                                        $where['godown_code'] = $_POST['godown_code'];
                                                    }
                                                }else{
                                                    $where['godown_code'] = $this->data['branch'];
                                                }
                            
                                            }else{
                                                $where["godown_code"] = $this->data['branch'];
                                            }

                                            $transactionRec     = get_result('partytransaction',$where, ['transaction_at', 'godown_code','credit', 'debit', 'relation', 'remark']);
                                            $total_credit       = $total_debit = 0.0;
                                            if ($transactionRec != null) {
                                                foreach ($transactionRec as $key => $row) {
                                                    $total_credit   += $row->credit;
                                                    $total_debit    += $row->debit;
                                                }
                                                $balance = $total_debit - $total_credit + $partyInfo->initial_balance;
                                            }else{
                                                $balance = $partyInfo->initial_balance;
                                            }
                                            // $status = ($balance < 0 ? " Payable" : " Receivable");
                                            $status = ($balance < 0 ? "  " : " - ");

                                            echo $status . f_number(abs($balance)) . ' &nbsp;';
                                            
                                            // calculate previous balance before from date
                                            $total_credit = $total_debit = 0.0;
                                            if ($transactionRec != null && $fromDate != NULL) {
                                                foreach ($transactionRec as $key => $row) {
                                                    if($row->transaction_at < $fromDate ){
                                                        $total_credit   += $row->credit;
                                                        $total_debit    += $row->debit;
                                                    }
                                                }
                                                $opening_balance = $total_debit - $total_credit + $partyInfo->initial_balance;
                                            }
                                            
                                        ?>

                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Discount :</th>
                                <td>
                                    <strong>
                                        <?php
                                            $total_discount = 0.00;
                                            foreach ($transactionRec as $key => $value) {
                                                if($value->remark == 'purchase'){
                                                    $relationList                   = explode(':', $value->relation);
                                                    $where                          = ['voucher_no' => $relationList[1],'trash' => 0];
                                                    $purchase_total_discount        = get_row('saprecords', $where, ['total_discount']);
                                                    if($purchase_total_discount){
                                                        $total_discount += $purchase_total_discount->total_discount;
                                                    }
                                                }
                                            }
                                            echo $total_discount;
                                            ?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30px;">SL</th>
                        <th>Date</th>
                        <th>Particular</th>
                        <th>Details</th>
                        <th>Paid By</th>
                        <th>Voucher No</th>
                        <th>Product</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Balance</th>
                        <!--<th class="none" style="width:40px;">Action</th>-->
                    </tr>
                    <!-- previous balance row start here -->
                    <?php $staus = ($resultset[0]->previous_balance > 0) ? "Receivable" : "Payable"; ?>
                    <tr>
                        <td>1</td>
                        <td colspan="2" class="text-center">
                        <strong>
                            Showroom :
                            <?php
                                $showroom = get_name('godowns', 'name', ['code'=>$resultset[0]->godown_code]);
                                echo (!empty($showroom) ?  $showroom : '');
                            ?>
                        </strong>
                        </td>
                        <td colspan="3" class="text-center">Previous Balance</td>
                        <td><?php echo $opening_status . abs($opening_balance)." &nbsp;"; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                    <!-- previous balance row end here -->

                    <?php
                        $totalDebit = $total = $totalCredit = $stepBalance = $grandtotalQuant = 0.00;
                        $stepBalance += $opening_balance;
                        foreach ($resultset as $key => $row) {
                            $voucher = '';
                            if($row->remark == 'purchase' || $row->remark == 'purchase return'){
                                $voucher = !empty($row->relation) ? explode(':', $row->relation)[1] : '';
                            }elseif($row->remark == 'installment'){
                                $voucher = !empty($row->relation) ? $row->relation : '';
                            }elseif($row->remark == 'transaction'){
                                $voucher = !empty($row->inc_code) ? $row->inc_code : '';
                            }else{
                                $voucher = '';
                            }
                    ?>
                    
                    
                    <tr>
                        <td><?php echo ($key + 2); ?></td>
                        <td><?php echo $row->transaction_at; ?></td>
                        <td>
                            <?php
                                // particular Section..
                                if($row->remark=='purchase'){
                                    // Get Purchase Product Code in sapitem table 
                                    $where                          = ['voucher_no' => (!empty($voucher[1]) ? $voucher[1] : '')];
                                    $purchases_product_code         = get_result('sapitems', $where, ['product_code']);

                                    $product_model  = [];
                                    foreach($purchases_product_code as $value){
                                        $products_model     = get_row('stock', ['code' => $value->product_code], ['product_model']);
                                        echo (isset($products_model->product_model) ? $products_model->product_model :"N/A")."</br>";
                                    }
                                }
                            ?>
                        </td>
                        <td><strong><?php echo filter($row->remark); ?></strong></td>
                        <td><?php echo ($row->remark == "transaction" ? filter($row->comment) : get_name('saprecords', 'comment', ['voucher_no' => $voucher])); ?></td>
                        <!--<td><?php //echo $vno = ($row->remark == 'purchase') ? $voucher[1] : ''; ?></td>-->
                        <td><?php echo $vno = isset($voucher) ? $voucher : ''; ?></td>
                        <td>
                            <?php 
                                if(!empty($voucher)){
                                    $product_info = get_result('sapitems', ['voucher_no' => $voucher]); 
                                    if(!empty($product_info)){
                                        $l=1;
                                        foreach($product_info as $val){
                                            echo $val->product_model; 
                                            echo ',';
                                            if($l%3==0){
                                                echo '<br>';
                                            }
                                            $l++;
                                        }
                                    }
                                }    
                                ?>
                            
                        </td>
                        <td><?php echo $credit = $row->credit; $totalCredit += $row->credit; ?></td>
                        <td><?php echo $debit = $row->debit; $totalDebit += $row->debit; ?></td>
                        <td>
                            <?php
                                $stepBalance    += ($debit - $credit);
                                //$step_status    = ($stepBalance < 0 )? "Payable":"Receivable";
                                $step_status    = ($stepBalance < 0 )? " ":" - ";
                                echo $step_status . f_number(abs($stepBalance))."  &nbsp";
                            ?>
                        </td>
                        <!--    <td class="none">-->
                        <!--    <?php if($row->remark == 'purchase'){ ?>-->
                        <!--    <a class="btn btn-info" title="Preview" target="_blank" href="<?php // echo site_url('purchase/purchase/view?vno=' . $voucher[1]); ?>">-->
                        <!--        <i class="fa fa-eye" aria-hidden="true"></i>-->
                        <!--    </a>-->
                        <!--    <?php }else{ ?>-->
                        <!--    &nbsp;-->
                        <!--    <?php } ?>-->
                        <!--</td>-->
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="7" class="text-right">Total</th>
                        <th><strong><?php echo f_number($totalCredit); ?></strong></th>
                        <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                        <th>
                            <strong>
                                <?php 
                                    $balance = $totalDebit - $totalCredit + $opening_balance;
                                    //$balance_status = ($balance < 0 )? "Payable":"Receivable";
                                    $balance_status = ($balance < 0 )? " ":" - ";
                                    echo $balance_status . f_number(abs($balance))."  &nbsp;";
                                ?>
                            </strong>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
        <!--Get data after submit result End here-->
    </div>
</div>
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
   
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>