<?php 	
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
	$logo_data  = json_decode($meta->logo,true); 
    $time = time();
?>
<script src="<?php echo site_url('private/js/ngscript/allDealerDueCtrl.js?'.$time); ?>"></script>
<style>
    @media print {
        aside, .panel-heading, .panel-footer, nav, .none {display: none !important;}
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide {display: block !important;}
        table tr th, table tr td {font-size: 12px;}
        .print_banner_logo {width: 19%; float: left;}
        .print_banner_logo img {margin-top: 10px;}
        .print_banner_text {width: 80%;float: right;text-align: center;}
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
    .action-btn a {
        margin-right: 0;
        margin: 3px 0;
    }
</style>

<div class="container-fluid" ng-controller="allDealerDueCtrl" ng-cloak>
    <div class="row">
      

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Customer Due List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner Start Here -->
                 <?php $this->load->view('print', $this->data); ?>                
                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3>Dealer Due List</h3>
                </div>

                <div class="row none">
                    <?php echo form_open(); ?>
                    
                    <?php if(checkAuth('super')) { ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="godown_code" ng-init="godown_code='<?php echo $this->data['branch']; ?>'" ng-model="godown_code">
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <option value="all">All Showroom</option>
                                <?php $allGodowns = getAllGodown(); if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                                <option value="<?php echo $row->code; ?>">
                                    <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <?php } else { ?>
                    <input type="hidden" name="godown_code" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                        ng-model="godown_code" required>
                    <?php } ?>
                    
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <select ui-select2="{ allowClear: true}" class="form-control" name="code" ng-model="party_code" data-placeholder="Select Client">
                                <option value="" selected disable> </option>
                                <option ng-repeat="client in clientList" value="{{client.code}}">{{ client.code+"-"+client.name +"-"+ client.mobile}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="dealer_type" class="form-control">
                                <option value="" selected disable>-- Select Type --</option>
                                <?php
                                $dealer_type = config_item('dealer_type');
                                if (!empty($dealer_type)){
                                    foreach($dealer_type as $value) {
                                        echo '<option value="'.$value.'"> '. $value .' </option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="customer_type" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" >Select Client Type&nbsp; </option>
                                <option value="hire">Hire</option>
                                <option value="dealer">Dealer</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="zone" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" >Select Zone&nbsp; </option>
                                <option value="all">All Zone</option>
                                <?php
                                if(!empty($allZone)){
                                foreach($allZone as $row){ ?>
                                    <option value="<?php echo $row->zone; ?>" ><?php echo filter($row->zone); ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <hr class="none" style="margin-top: 0px;">
                
                <table class="table table-bordered">
                    <tr>
                        <th width="50">SL</th>
                        <th width="75">Code</th>
                        <th>Name</th>
                        <th>Father's Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th width="115">Balance</th>
                        <th>Showroom</th>
                    </tr>
                    <?php
                    $totalAmount = 0;
                    foreach($results as $key => $row){
                        $totalAmount += $row->balance;
                    ?>
                    <tr>
                        <td><?php echo ++$key; ?></td>
                        <td><?php echo $row->code; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo get_name('parties','father_name',['code' => $row->code]); ?></td>
                        <td><?php echo $row->mobile; ?></td>
                        <td><?php echo $row->address; ?></td>
                        <td><?php echo f_number($row->balance); ?></td>
                        <td><?php echo $row->godown_name; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="6" class="text-right">Total Amount </th>
                        <th> <?php echo f_number($totalAmount); ?>Tk </th>
                        <th>&nbsp;</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>