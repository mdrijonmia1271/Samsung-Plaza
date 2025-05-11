<?php 
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    $logo_data  = json_decode($meta->logo,true);
?>

<!-- load Angular Controller -->
<script type="text/javaScript" src="<?php echo site_url('private/js/ngscript/showzoneCtrl.js'); ?>"></script>

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

        .panel .hide {
            display: block !important;
        }

        .title {
            font-size: 25px;
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
</style>

<div class="container-fluid" ng-controller="showzoneCtrl">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>

        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found" />
        </div>

        <div class="panel panel-default loader-hide" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Zone</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3>All Zone</h3>
                </div>

                <div class="row none" style="margin-bottom:15px;">
                    <div class="col-sm-4" style="margin-bottom:15px;">
                        <input type="text" ng-model="search" placeholder="Search.........." class="form-control">
                    </div>

                    <div class="col-sm-offset-4 col-sm-4">
                        <div style="display: flex;" class="pull-right">
                            <label style="line-height: 34px; padding-right: 5px;">Per Page</label>
                            <select ng-model="perPage" class="form-control" style="width:75px;">
                                <option value="">All</option>
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
                        <th style="width: 50px;">SL</th>
                        <th style="cursor:pointer;" ng-click="sortField='category'; reverse = !reverse;">Zone
                            &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>
                        <th class="none" style="width: 120px;">Action</th>
                    </tr>

                    <tr
                        dir-paginate="category in categories|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
                        <td>{{category.sl}}</td>
                        <td>{{category.zone | textBeautify}}</td>
                        <td class="none">
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('zone/zone/editzone/{{category.id}}');?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a onclick="return confirm('Do you want to delete this Zone?');" class="btn btn-danger"
                                title="Delete"
                                href="<?php echo site_url('zone/zone/deletezone/{{category.id}}');?>"><i
                                    class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                </table>
                <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none">
                </dir-pagination-controls>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>