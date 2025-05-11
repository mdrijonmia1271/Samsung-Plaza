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
    }
    .table tr td{
        vertical-align: middle !important;
    }
   
</style>

<div class="container-fluid" ng-controller="showAllMaterials" ng-cloak>
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>

    <div id="loading">
        <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
    </div>

        <div class="panel panel-default loader-hide" id="data">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">View All Materials </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
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
                        <span style="margin-left: 55px;line-height: 2.4;font-weight: bold;">Per Page&nbsp;:&nbsp;</span>
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
            


                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>"/>

                <h4 class="text-center hide" style="margin-top: 0px;">All Materials</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">

                        <tr>
                            <th width="50" >SL</th>
                            <th>Name</th>
                            <th width="170" >Price (TK/kg)</th>
                            <th width="170" class="none">Status</th>
                            <th class="none" width="110">Action</th>
                        </tr>
                        <tr dir-paginate="row in allMaterials|filter:searchText|itemsPerPage:perPage|orderBy:sortField:reverse">
                            <td>{{ row.sl }}</td>
                            <td>{{ row.name | textBeautify }}</td>
                            <td class="text-right">{{ row.price }}</td>
                            <td class="none">{{ row.status | textBeautify}}</td>
                            <td class="none">
                                <a class="btn btn-warning" title="Edit" href="<?php echo site_url('material/material/edit/{{ row.id }}'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure to delete this data?');" href="<?php echo site_url('material/material/delete/{{ row.id }}') ;?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </table>
                    <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
                </div>

            </div>



            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
