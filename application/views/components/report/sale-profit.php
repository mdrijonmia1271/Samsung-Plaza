<?php 	
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    $logo_data  = json_decode($meta->logo,true);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
@media print {
    aside,nav,.none,.panel-heading,.panel-footer {display: none !important;}
    .panel {border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
    .hide {display: block !important;}
    .title {font-size: 25px;}
    .print_banner_logo {width: 19%;float: left;}
    .print_banner_logo img {margin-top: 10px;}
    .print_banner_text {width: 80%;float: right;text-align: center;}
    .print_banner_text h2 {margin: 0;line-height: 38px;text-transform: uppercase !important;}
    .print_banner_text p {margin-bottom: 5px !important;}
    .print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
}
</style>
<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Sales Profit Report</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div class="panel-body none" ng-cloak>
                <?php   $attribute = array('class' => 'form-horizontal');
                        echo form_open('', $attribute); ?>
                <div class="form-group">
                    
                <?php   if(checkAuth('super')) { 
                    $allGodown = getAllGodown(); ?>
                    <div class="col-md-3">
                        <select name="godown_code"  id="godown_code"   class="form-control">
                            <option value="" selected >-- Select Showroom --</option>
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

                    <div class="col-md-2">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No.">
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

                    <div class="col-md-1">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            
            <hr class="none" style="margin-top: 0;">
            
            
            
            
            
            <?php if (!empty($results)) { ?>
            <div class="panel-body">
                
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <div class="col-md-12 text-center hide">
                    <h3>Sales Report</h3>
                </div>

                <table class="table table-bordered">
                    <tr class="bg-info">
                        <th width="30">SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Showroom</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Profit Amount</th>
                    </tr>
                    <?php
                    $total_bill = $total_paid = $total_due = $total_profit = 0;
                    foreach($results as $key => $row){
                        
                        $total_bill     += $row['total_bill'];
                        $total_paid     += $row['paid'];
                        $total_due      += $row['total_bill'] - $row['paid'];
                        $total_profit   += $row['profit'];
                    ?>
                            <tr>
                                <td> <?php echo ($key + 1); ?> </td>
                                <td> <?php echo $row['date']; ?> </td>
                                <td> <?php echo $row['voucher_no']; ?> </td>
                                <td> <?php echo $row['godown']; ?> </td>
                                <td> <?php echo check_null($row['name']); ?> </td>
                                <td> <?php echo check_null($row['address']); ?> </td>
                                <td> <?php echo f_number($row['total_bill']); ?> </td>
                                <td> <?php echo f_number($row['paid']); ?> </td>
                                <td> <?php echo f_number($row['profit']); ?> </td>
                            </tr>
                            <?php }?>
                            <tr class="bg-info">
                                <td colspan="6" class="text-right"><strong>Total</strong> </td>
                                <td><strong><?php echo f_number($total_bill); ?> TK</strong> </td>
                                <td><strong><?php echo f_number($total_paid); ?> TK</strong> </td>
                                <td><strong><?php echo f_number($total_profit); ?> TK</strong> </td>
                            </tr>
                        </table>
                    </div>
                <?php }else{
                    echo '<p class="text-center"> <strong> No data found...! </strong> </p>';
                } ?>
                
            <div class="panel-footer">&nbsp;</div>
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
    $('#client_dropdown').select2({
        matcher: function(term, text, option) {
            return text.toUpperCase().indexOf(term.toUpperCase())>=0 || option.val().toUpperCase().indexOf(term.toUpperCase())>=0;
        }
    });
    $("#godown_code").change(function(){
        var godown_code = $("#godown_code").val();
        $.post("<?php echo site_url('sale/searchSale/client_godown_wise');  ?>", 
        { godown_code: godown_code}, 
        function(data,success){
           $('#client_dropdown').empty();
           $('#client_dropdown').append(data);
        });
    });          
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>