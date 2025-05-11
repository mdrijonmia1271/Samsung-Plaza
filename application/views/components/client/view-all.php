
    	
<script src="<?php echo site_url('private/js/ngscript/allClientCtrl.js?'.time()); ?>"></script>
<style>
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .action-btn a{
        margin-right: 0;
        margin: 3px 0;
    }
</style>

<div class="container-fluid" ng-controller="allClientCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>

    	<div class="panel panel-default loader-hide" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Customers</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="text-center hide" style="margin-top: 0px;">All Customers</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Customer</h3>
                </div>

                <div class="row none">
                    <?php if($this->data['privilege'] == 'super') { ?>
                     <div class="col-md-3">
                        <select class="form-control" ng-init="godown_code='<?php echo $this->data['branch']; ?>'" ng-model="godown_code" ng-change="getAllProductsFn()">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <?php }else{ ?>
                         <input type="hidden" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'" ng-model="godown_code" ng-value="godown_code" required>
                    <?php } ?>
                    
                    <div class="col-md-3" style="margin-bottom:15px;">
                        <input type="text" ng-model="search" placeholder="Search...." class="form-control">
                    </div>
                    <div class="col-md-2" style="margin-bottom:15px;">
                        <select ng-model="dealerType.dealer_type" class="form-control">
                            <option value=""> All </option>
                            <?php
                            $dealer_type = config_item('dealer_type');
                            if(!empty($dealer_type)){
                            foreach($dealer_type as $item){ ?>
                                <option value="<?= $item ?>" <?= (!empty($info) && $info[0]->dealer_type == $item ? "selected" : "")?>><?= $item ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-offset-<?php echo ($this->data['privilege'] == 'super') ? '2' : '5'; ?> col-md-2">
                        <select ng-model="perPage" class="form-control pull-right" style="width:100px;">
                            <option value="">All</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                </div>
                <p class="none"> <span style="color: green;font-weight: bold;">Green = Receivable</span>&nbsp;<span style="color: red;font-weight: bold;">Red = Payable</span></p>
                
                <table class="table table-bordered">
                    
                    <tr>
                        <th width="50">SL</th>
                        <th width="75">C.ID</th>
                        <th width="60">Photo</th>
                        <th>Customer Name</th>
                        <th>Dealer Type</th>
                        <th>Address</th>
                        <th width="120">Mobile</th>
                        <th width="115">Balance</th>
z                        <!--<th width="115">Credit Limit</th>-->
                        <th>Showroom</th>
                        <th class="none" style="width: 160px;">Action</th>
                    </tr>
                    <tr dir-paginate="row in allParty|filter: search|filter: dealerType|orderBy:sortField:reverse|itemsPerPage:perPage">
                        <input type="hidden" ng-value="row.showroom_id">
                        <td>{{ row.sl }}</td>
                        <td>{{ row.code }}</td>
                        <td><img width="60" ng-if="row.path" src="<?php echo site_url('{{ row.path }}'); ?>" ></td>
                        <td>{{ row.name | textBeautify}} </td>
                        <td>{{ row.dealer_type }} </td>
                        <td>{{ row.address | textBeautify}} </td>
                        <td>{{ row.mobile }}</td>
                        <td style="{{ row.color}}">{{ row.balance | fNumber }}</td>
                        <td> {{ row.godown_name | textBeautify }} </td>
                        <!--<td>{{ row.credit_limit | fNumber }}</td>-->
                        <td class="none action-btn">
                            <a class="btn btn-info" title="Preview" href="<?php echo site_url('client/client/preview?partyCode={{row.code}}'); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('client/client/edit?partyCode={{row.code}}');?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <a onclick="return confirm('Do you want to delete this Client?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('client/client/delete/{{row.code}}'); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>