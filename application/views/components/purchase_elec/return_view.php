
    	
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,900" rel="stylesheet">
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
    .wid-100{
        width: 100px;
    }
    .custom-table>tbody>tr>th,
    .custom-table>tbody>tr>td{
        border: none;
        line-height: 18px;
        padding: 4px !important;
    }
    .custom-table>tbody>tr>th {
        width: 140px;
    }
    .view {
        font-family: 'Raleway', sans-serif;
    }
</style>
<div class="container-fluid">
    <?php echo $this->session->flashdata('confirmation'); ?>
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Purchase Return Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="row">
                    <div class="col-xs-6">
                        <?php
                        //fetch supplier info
                        $supplierInfo = $this->action->read('parties',array('code'=> $purchase_record[0]->party_code));
                        
                        ?>
                        
                        <table class="table custom-table view">
                            <tr>
                                <th>Supplier Name :</th>
                                <td><?php echo filter($supplierInfo[0]->name); ?></td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td><?php echo filter($supplierInfo[0]->address); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6">
                        <table class="table custom-table">
                            <tr>
                                <th>Mobile :</th>
                                <td><?php echo filter($supplierInfo[0]->mobile); ?></td>
                            </tr>
                            <tr>
                                <th width="200">Date :</th>
                                <td><?php echo $purchase_record[0]->date; ?></td>
                            </tr>
                            <!--tr>
                                <th>Voucher No :</th>
                                <td><?php echo $purchase_record[0]->voucher_no; ?></td>
                            </tr-->
                            <tr>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr class="view">
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th>Model</th>
                        <!--<th>Serial</th>-->
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Price (TK)</th>
                        <th>Total (TK)</th>
                    </tr>
                    <?php
                    $total_discount = array();
                    foreach($purchase_record as $key => $val){
                    
                        $productInfo = $this->action->read('stock',array('code' => $val->product_code));
                    
                    ?>
                    <tr>
                        <td style="width: 50px;"><?php echo ($key + 1); ?></td>
                        <td class="view"><?php echo filter($productInfo[0]->category); ?></td>
                        <td><?php echo $val->product_model; ?></td>
                        <!--<td><?php //echo $val->product_serial; ?></td>-->
                        <td style="width: 80px;"><?php echo filter($productInfo[0]->unit); ?></td>
                        <td class="wid-100 text-right"><?php echo $val->quantity; ?></td>
                        <td class="wid-100 text-right"><?php echo $val->purchase_price; ?></td>
                        <td class="wid-100 text-right"><?php echo $val->purchase_price*$val->quantity; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <div class="col-xs-offset-8 col-xs-4">
                    <div class="row">
                        <table class="table custom-table text-right">
                            <tr>
                                <th class="view" width="200">Total Amount :</th>
                                <td><b><?php echo f_number($purchase_record[0]->grand_total); ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>