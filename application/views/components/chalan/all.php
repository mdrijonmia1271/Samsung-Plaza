<script src="<?php echo site_url('private/js/ngscript/chalanCtrl.js')?>"></script>
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
    }
</style>

<div class="container-fluid" >
    <div class="row" ng-controller="chalanCtrl" ng-cloak>
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Chalan</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                 <img class="img-responsive hide print-banner" src="<?php echo site_url($banner_info[0]->path); ?>">


                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>

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


            <table class="table table-bordered">
                <tr>
                    <th width="40">SL </th>
                    <th width="200">Date </th>
                    <th>Client Name</th>
                    <th>Chalan No</th>
                    <th style="text-align:center;" class="block-hide">Action</th>
                </tr>
                <tr dir-paginate="row in chalan|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
                    <td class="text-center">{{row.sl}}</td>
                    <td>{{row.date}}</td>
                    <td>{{row.party | textBeautify}}</td>
                    <td>{{row.chalan_no}}</td>
                    <td class="none text-center" style="width: 160px;">
                        <a
                            title="View"
                            class="btn btn-primary"
                            href="<?php echo site_url('chalan/chalan/sigleView/{{row.chalan_no}}'); ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>

                        <a title="Edit" class="btn btn-success"  href="<?php echo site_url('chalan/chalan/edit/{{row.chalan_no}}'); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this?');" href="<?php echo site_url('chalan/chalan/delete/{{row.chalan_no}}'); ?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
            </table>
             <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
