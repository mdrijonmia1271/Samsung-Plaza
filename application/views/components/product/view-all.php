<?php 	
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    $logo_data  = json_decode($meta->logo,true); 
?>

<script src="<?php echo site_url('private/js/ngscript/showAllProductCtrl.js')?>"></script>
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

        .hide {
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

<div class="container-fluid">
    <div class="row" ng-controller="showAllProductCtrl" ng-cloak>

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found" />
        </div>


        <div class="panel panel-default loader-hide" id="data">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Products</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>

                </div>
            </div>

            <div class="panel-body">
                <div class="row none" style="margin-bottom:15px;">
                    <div class="col-md-4">
                        <input type="text" ng-model="searchText" placeholder="Search Here...." class="form-control">
                    </div>

                    <div class="col-md-5">&nbsp;</div>
                    <div class="col-md-3">
                        <div>
                            <span style="margin-left: 55px;line-height: 2.4;font-weight: bold;">Per
                                Page&nbsp;:&nbsp;</span>
                            <select ng-model="perPage" class="form-control" style="width:92px;float:right;">
                                <option value="">All</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="150">150</option>
                                <option value="200">200</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="hide text-center" style="margin-top: 0px;">All Products</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Product</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center">SL</th>
                            <th class="text-center">Code </th>
                            <!-- <th class="text-center">Name </th> -->
                            <th class="text-center">Model </th>
                            <th class="text-center">Category </th>
                            <th class="text-center">subcategory </th>
                            <th class="text-center">Brand </th>
                            <th class="text-center">Purchase Price</th>
                            <th class="text-center">Sale Price </th>
                            <th class="text-center">Status</th>
                            <th width="120" class="none"> Action </th>
                        </tr>

                        <tr
                            dir-paginate="row in products|filter:searchText|itemsPerPage:perPage|orderBy:sortField:reverse">
                            <td class="text-center"> {{ ($index + 1) }} </td>
                            <td class="text-center"> {{ row.product_code }}</td>
                            <!-- <td> {{ row.product_name | textBeautify }}</td> -->
                            <td class="text-center"> {{ row.product_model | uppercase }}</td>
                            <td class="text-center"> {{ row.product_cat | textBeautify }} </td>
                            <td class="text-center"> {{ row.subcategory | textBeautify }} </td>
                            <td class="text-center"> {{ row.brand | textBeautify }} </td>
                            <td class="text-center"> {{ row.purchase_price }} </td>
                            <td class="text-center"> {{ row.sale_price }} </td>
                            <td class="text-center"> {{ row.status | textBeautify }} </td>
                            <td class="none">
                                
                            <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>
                                <a class="btn btn-warning" title="Edit"
                                    href="<?php echo site_url('product/product/edit/{{ row.product_code }}');?>"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a class="btn btn-danger" title="Delete"
                                    onclick="return confirm('Are you sure want to delete this Product?');"
                                    href="<?php echo site_url('product/product/delete/{{ row.id }}') ;?>"><i
                                        class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php  } ?>            
                            </td>
                        </tr>
                    </table>
                    <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true"
                        class="none"></dir-pagination-controls>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>