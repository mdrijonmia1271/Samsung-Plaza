<?php 	
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); 
    $time = time();
?>

<script src="<?php echo site_url('private/js/ngscript/allWeekliDueCtrl.js?'.$time); ?>"></script>

<style>
    @media print {

        aside,
        .panel-heading,
        .panel-footer,
        nav,
        .none {
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

        table tr th,
        table tr td {
            font-size: 12px;
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

    .action-btn a {
        margin-right: 0;
        margin: 3px 0;
    }
</style>

<div class="container-fluid" ng-controller="allWeekliDueCtrl" ng-cloak>
    <div class="row">
        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found" />
        </div>

        <div class="panel panel-default loader-hide" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Weekly Due</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3>All Weekly Due</h3>
                </div>

                <div class="row none">
                    <?php echo form_open('' , ['class' => 'form-horizontal']); ?>
                    
                    <?php if(checkAuth('super')) { ?>
                    <div class="col-md-3">
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
                    <?php } else { ?>
                    <input type="hidden" name="godown_code" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'"
                        ng-model="godown_code" required>
                    <?php } ?>
                    
                    
                    <div class="col-md-4">
                        <select ui-select2="{ allowClear: true}" class="form-control" name="code" ng-model="party_code" data-placeholder="Select Client">
                            <option value="" selected disable> </option>
                            <option ng-repeat="client in clientList" value="{{client.code}}">{{ client.code+"-"+client.name +"-"+ client.mobile}}</option>
                        </select>
                    </div>
                    
                    
                   <div class="col-md-3">
                        <select name="zone" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" >Select Zone&nbsp; </option>
                            <option value="zone_null" > Null Zone</option>
                            <?php 
                            $zone = $this->action->read('zone');
                            if(!empty($zone)){
                            foreach($zone as $zone){ ?>
                                <option value="<?php echo $zone->zone; ?>" ><?php echo filter($zone->zone); ?></option>
                            <?php } } ?>
                        </select>
                    </div>                    
                    
                    
                    <div class="col-md-2">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                    
                    <?php echo form_close(); ?>
                </div>

                <hr class="none">
                
                <?php if(!empty($allPartyInfo)) { ?>
                
                <table class="table table-bordered">

                    <tr>
                        <th width="50">SL</th>
                        <th width="75">C.ID</th>
                        <th width="60">Photo</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th width="120">Mobile</th>
                        <th width="115">Balance</th>
                        <th>Showroom</th>
                    </tr>
                    <?php
                    $counter = 1;
                    $totalDue = 0;
                    foreach($allPartyInfo as $item){
                        if($item['balance'] = 0){
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $item['code']; ?></td>
                        <td><img width="60" src="<?php echo site_url($item['photo']); ?>"></td>
                        <td> <?php echo $item['name']; ?> </td>
                        <td> <?php echo $item['address']; ?> </td>
                        <td> <?php echo $item['mobile']; ?> </td>
                        <td> <?php echo '-'.$item['balance']; $totalDue +=$item['balance'];  ?> </td>
                        <td> <?php echo $item['godown_name']; ?>  </td>
                    </tr>
                    <?php $counter++; } } ?>
                    <tr>
                        <th colspan="6" class="text-right">Total Amount </th>
                        <th> <?php echo '-'.$totalDue; ?>Tk </th>
                        <th> &nbsp;</th>
                    </tr>
                </table>
                <?php } else {
                    echo '<p class="text-center"> <strong> No data found....! </strong> </p>';
                }?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>