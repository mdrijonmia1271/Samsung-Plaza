<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
    	
<script src="<?php echo site_url('private/js/ngscript/costCtrl.js')?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

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
</style>
<div class="container-fluid block-hide">
    <div class="row">

    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
        $attribute = array(
            'name' => '',
            'class' => 'form-horizontal',
            'id' => ''
        );
        echo form_open('cost/cost/add', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Field of Cost</h1>
                </div>
            </div>

            <div class="panel-body no-padding none">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Cost Category </label>
                        <div class="col-md-7">
                            <select type="text" name="cost_category" class="form-control" autocomplete="off">
                                    <option value="">-- Select Cost Category --</option>
                                <?php foreach($cost_categories as $key => $value){ ?>
                                    <option value="<?php echo $value->cost_category; ?>"><?php echo filter($value->cost_category); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Cost </label>
                        <div class="col-md-7">
                            <input type="text" name="field_cost" class="form-control" autocomplete="off">
                        </div>
                        
                        <input class="btn btn-primary" type="submit" name="submit" value="Save">
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<div class="container-fluid" >
    <div class="row" ng-controller="costCtrl" ng-cloak>
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Field of Cost</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
               <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3>All Field Of Cost</h3>
                </div>
                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>
            
                <div ng-cloak class="row none" style="margin-bottom:15px;">
                 <div class="col-md-4">
                     <input type="text" ng-model="search" placeholder="Search by Name..." class="form-control">
                </div>
                <div class="col-md-5">&nbsp;</div>
                <div class="col-md-3">
                    <div>
                         <span style="margin-left: 55px;line-height: 2.4;font-weight: bold;">Per Page&nbsp;:&nbsp;</span>
                         <select ng-model="perPage" ng-init="perPage='50'"; class="form-control" style="width:90px;float:right;">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                         </select>
                     </div>
                </div>
            </div>

            <table class="table table-bordered" ng-cloak>
                <tr>
                    <th width="55" >SL</th>
                    <th>Cost Category</th>
                    <th>Field of Cost </th>
                    <th style="text-align:center; width: 115px;" class="block-hide">Action</th>
                </tr>
                <tr dir-paginate="row in fields|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
                    <td>{{row.sl}}</td>
                    <td>{{row.cost_category | textBeautify}}</td>
                    <td>{{row.cost_field | textBeautify}}</td>
                    <td class="none text-center" >                        
                         <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                         ?>
                        
                                <a title="Edit" class="btn btn-warning" ng-click="editCostFieldFn(row.id)" data-toggle="modal" data-target="#myModal" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Field of Cost?');" href="<?php echo site_url('cost/cost/delete_field/{{row.id}}'); ?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    
                        <?php  } ?>   
                    </td>
                </tr>
            </table>
             <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>
            
            <!--Modal section start here-->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Field Name</h4>
                  </div>
                    <div class="modal-body">
                        <div class="row">
                        <?php
                            $attr = array('class' => 'form-horizontal');
                            echo form_open('', $attr);
                        ?>
                            <input type="hidden" name="id" ng-value="id">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Cost Category <span class="req"> *</span></label>
                                <div class="col-md-7">
                                    <select type="text" name="cost_category" class="form-control" ng-model="category">
                                        <option value="">-- Select Cost Category --</option>
                                        <?php foreach($cost_categories as $key => $value){ ?>
                                            <option value="<?php echo $value->cost_category; ?>"><?php echo filter($value->cost_category); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Field Name <span class="req"> *</span></label>
                                <div class="col-md-7">
                                    <input type="text" name="cost_field" class="form-control" value="{{ field | textBeautify}}" >
                                </div>
                            </div>
                            
                            <div class="col-md-10">
                                <div class="btn-group pull-right">
                                    <input type="submit" value="Update" name="update" class="btn btn-info">
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <!--Modal section end here-->
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

