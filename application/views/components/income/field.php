<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
    	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="<?php echo site_url('private/js/ngscript/incomeCtrl.js'); ?>" type="text/javascript" charset="utf-8"></script>
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
    <?php $attribute = array( 'name' => '', 'class' => 'form-horizontal', 'id' => '' );
        echo form_open('income/income/add', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Field of Income</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Income </label>
                        <div class="col-md-7">

                            <input list="fields" name="income" class="form-control" autocomplete="off" >
                            <datalist id="fields">
                            <?php foreach(config_item('Income_purpose') as $key => $value) {?>
                                <option value="<?php echo filter($value); ?>" >
                            <?php } ?>
                            </datalist>
                        </div>

                        <div>
                            <input class="btn btn-primary" type="submit" name="submit" value="Save">
                        </div>
                    </div>
                        
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<div class="container-fluid" >
    <div class="row" ng-controller="incomeCtrl">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Field of Income</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <!--<h4 class="hide text-center"></h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Income Of Field</h3>
                </div>
                <div ng-cloak class="row none" style="margin-bottom:15px;">
                 <div class="col-md-4">
                     <input type="text" ng-model="search" placeholder="Search by Name..." class="form-control">
                </div>
                <div class="col-md-5">&nbsp;</div>
                <div class="col-md-3">
                    <div>
                         <span style="margin-left: 55px;line-height: 2.4;font-weight: bold;">Per Page&nbsp;:&nbsp;</span>
                         <select ng-model="perPage" class="form-control" style="width:90px;float:right;">
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
                    <th>SL</th>
                    <th>Field of Income </th>
                    <th style="text-align:center;" class="block-hide">Action</th>
                </tr>
                <tr dir-paginate="row in income|filter:search|itemsPerPage:perPage">
                    <td>{{row.sl}}</td>
                    <td>{{row.field | textBeautify}}</td>
                    <td class="none text-center " style="width: 160px;">                        
                            <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>   
                            <a title="Edit" class="btn btn-warning" href="<?php echo site_url('income/income/edit_field/{{row.id}}'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Field of Income?');" href="<?php echo site_url('income/income/delete_field/{{row.id}}'); ?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                         <?php } ?>
                    </td>
                </tr>
            </table>
             <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

