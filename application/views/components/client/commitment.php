<script src="<?php echo site_url('private/js/ngscript/addCommitmentCtrl.js?'.time())?>"></script>
    	

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
        .block-hide{
            display: none;
        }
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
    	.print_banner_text {width: 80%; float: right;text-align: center;}
    	.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
    	.print_banner_text p {margin-bottom: 5px !important;}
    	.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
        }
        .mb-15{
            margin-bottom: 15px;
        }
        .mb-20{
            margin-bottom: 20px;
        }
        .mb-25{
            margin-bottom: 25px;
        }
    }
</style>


<div class="container-fluid" ng-controller="addCommitmentCtrl" ng-cloak>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Customer Commitments</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body none">
                <?php
                
                if(checkAuth('super')) {
                    $column = 3;
                } else {
                    $column = 2;
                }
                
                $attr = array("class" => "form-horizontal");
                echo form_open('client/commitment/view_all', $attr); ?>
               
               <?php if(checkAuth('super')) { ?>
                    <div class="col-md-3 mb-15">
                        <select class="form-control" name="godown_code" ng-init="godown_code='<?php echo $this->data['branch']; ?>'" ng-model="godown_code">
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-15" class="mb">
                        <select ui-select2="{ allowClear: true}" class="form-control" name="search[user_id]" ng-model="user_id" data-placeholder="Select User">
                            <option value="" selected disable> </option>
                            <option ng-repeat="user in userList" value="{{user.id}}">{{ user.name }}</option>
                        </select>
                    </div>
                <?php } else { ?>
                    <input type="hidden" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'" ng-model="godown_code">
                    <input type="hidden" name="search[user_id]" ng-init="user_id = '<?php echo $this->data['user_id']; ?>'" ng-model="user_id" value="<?php echo $this->data['user_id']; ?>">
                <?php } ?>
                
            
                <div class="col-md-3 mb-15">
                    <select ui-select2="{ allowClear: true}" class="form-control" name="search[party_code]" ng-model="party_code" ng-change="getUserInfoFn()" data-placeholder="Select Client">
                        <option value="" selected disable> </option>
                        <option ng-repeat="client in clientList" value="{{client.code}}">{{ client.code+"-"+client.name +"-"+ client.mobile}}</option>
                    </select>
                </div>
            
                <div class="col-md-2 mb-15">
                    <div class="input-group date" id="datetimepickerFrom">
                        <input type="text" name="date[from]" class="form-control" placeholder="From">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="col-md-<?php echo $column; ?>">
                    <div class="input-group date" id="datetimepickerTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="To">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="btn-group">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            
            <hr class="none">
            
            <?php if($commitments != null){  ?>  
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="hide">
                    <h3 class="text-center">All Customer Commitment</h3>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th width="50">SL</th>
                        <th>Customer ID </th>
                        <th>Customer Name </th>
                        <th>Date </th>
                        <th>Mobile </th>
                        <th>Commitment </th>
                        <th>Address </th>
                        <th>Due</th>
                        <th class="block-hide" width="160">Action</th>
                    </tr>
                    <?php
                   
                        foreach ($commitments as $key => $commitment) {
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $commitment->party_code; ?></td>
                        <td><?php echo $commitment->name; ?></td>
                        <td><?php echo filter($commitment->date); ?></td>
                        <td><?php echo $commitment->mobile; ?></td>
                        <td><?php echo $commitment->commitment; ?></td>
                        <td><?php echo $commitment->address; ?></td>
                        <td>
                            <?php 
                            $debit = $credit = $remission = $currentBalance = 0;
                            $where = ['party_code' => $commitment->party_code, 'trash' => 0];
                            $tranInfo = get_result('partytransaction', $where, ['debit', 'credit', 'remission']);
                            
                            if(!empty($tranInfo)){
                                
                                foreach($tranInfo as $value){
                                    $debit += $value->debit;
                                    $credit += $value->credit;
                                    $remission += $value->remission;
                                }
                              
                                if($commitment->initial_balance < 0){
                                    $currentBalance = $debit - (abs($commitment->initial_balance) + $credit + $remission);
                                }else{
                                    $currentBalance = ($commitment->initial_balance + $debit) - ($credit + $remission);
                                }
                                
                                //$status = ($currentBalance < 0) ? " Payable" : " Receivable";   
                                $status = ($currentBalance < 0) ? " - " : " ";   
                                
                            }else{
                                
                                $currentBalance = abs($commitment->initial_balance);
                                //$status = ($currentBalance->initial_balance < 0) ? " Payable" : " Receivable";
                                $status = ($commitment->initial_balance < 0) ? " - " : " ";
                            }
                           
                            echo $status . number_format($currentBalance, 2);
                            ?>
                        </td>
                        <td class="none text-center">
                            <a title="view" class="btn btn-info" href="<?php echo site_url('client/commitment/view/'.$commitment->id);?>" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                            
                            <?php 
                                /*$privilege = $this->data['privilege'];
                                if($privilege != 'user'){*/
                            ?>
                                <a title="Edit" class="btn btn-primary"  href="<?php echo site_url('client/commitment/edit/'.$commitment->id); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Commitment?');" href="<?php echo site_url('client/commitment/delete/'.$commitment->id);?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>                         
                            <?php  //} ?>      
                        </td>
                    </tr>
                    <?php }  ?>
                </table>
            </div>
            <?php } else {
                echo '<p class="text-center"> <strong>No data found....! </strong> </p>';
            } ?>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    
</script>


