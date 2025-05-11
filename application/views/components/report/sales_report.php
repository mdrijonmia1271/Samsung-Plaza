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
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Sales Report</h1>
                </div>
            </div>
            <div class="panel-body" ng-cloak>
                <?php   $attribute = array('class' => 'form-horizontal');
                        echo form_open('', $attribute); ?>
                <div class="form-group">
                    
            <?php   if(checkAuth('super')) { 
                    $allGodown = getAllGodown(); ?>
                    <div class="col-md-2">
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

                    <div class="col-md-3">
                        <select name="search[party_code]"  id="client_dropdown"  class="selectpicker form-control" data-show-subtext="true"
                            data-live-search="true">
                            <option value="" selected >-- Client's Name --</option>
                            <?php foreach ($allClients as $key => $client) { ?>
                            <option value="<?php echo $client->code; ?>">
                                <?php echo $client->code."-".filter($client->name)."-".$client->mobile; ?>
                            </option>
                            <?php } ?>
                        </select>
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
            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php if ($result !=null) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left"> Show Result </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <div class="col-md-12 text-center hide">
                    <h3>Sales Report</h3>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Showroom</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Due</th>
                    </tr>
                    <?php
                    $amount = 0.00;
                    $total_paid = $total_due = 0.00;
                    foreach($result as $key => $row){
                        $due = $row->total_bill - $row->paid;

                        if($row->sap_type == 'credit'){ $type = 'Hire';
                        }elseif($row->sap_type == 'dealer'){ $type = 'Dealer';
                        }elseif($row->sap_type == 'cash'){ $type = 'Retail';
                        }else{ $type = $row->sap_type; }
                        $party_name = get_row('parties', ['code'=>$row->party_code],['name', 'address']);
                        $showroom   = get_row('godowns', ['code'=>$row->godown_code], ['name']);
                    ?>
                    <tr>
                        <td style="width: 50px;"> <?php echo ($key + 1); ?> </td>
                        <td> <?php echo $row->sap_at; ?> </td>
                        <td> <?php echo $row->voucher_no; ?> </td>
                        <td> <?php echo $showroom->name; ?> </td>
                        <td> <?php echo (isset($party_name->name) ? $party_name->name." ( ".$type." ) " : ($row->party_code ? filter($row->party_code." ( ".$type." ) ") : 'N/A')) ?></td>
                        <td> <?php echo (isset($party_name->address) ? $party_name->address : 'N/A') ?></td>
                        <td> <?php $total =($row->total_bill); $amount += $total; echo  f_number($total); ?> </td>
                        <td><?php echo f_number($row->paid); $total_paid += $row->paid;?></td>
                        <td><?php echo f_number($due); $total_due += $due;?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="6" class="text-right"><strong>Total</strong> </td>
                        <td><strong><?php echo f_number($amount); ?> TK</strong> </td>
                        <td><strong><?php echo f_number($total_paid); ?> TK</strong> </td>
                        <td><strong><?php echo f_number($total_due); ?> TK</strong> </td>
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