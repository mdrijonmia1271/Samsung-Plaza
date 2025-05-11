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
        .panel .hide{
            display: block !important;
        }
        .title{
            font-size: 25px;
        }
    }
</style>

<div class="container-fluid" ng-controller="showroomCtrl">
    <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Showroom</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                
                <h4 class="text-center hide" style="margin-top: 0px;">All Showroom</h4>

                <div ng-cloak class="row none" style="margin-bottom:15px;">
                     <div class="col-md-4">
                         <input type="text" ng-model="search" placeholder="Search....." class="form-control">
                    </div>
                    <div class="col-md-5">&nbsp;</div>
                    <div class="col-md-3">
                        <div>
                             <span style="margin-left: 55px;line-height: 2.4;font-weight: bold;">Per Page &nbsp;:&nbsp;</span>
                             <select ng-model="perPage" class="form-control" style="width:92px;float:right;">
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
                        <th width="70px">ID</th>
                        <th>Showroom Name</th>
                        <th>Type</th>
                        <th>Manager</th>
                        <th>Mobile Number </th>
                        <th>Address </th>
                        <th>Opening Balance </th>
                        <th class="none" style="width: 115px;">Action</th>
                    </tr>

                    <tr dir-paginate="row in resultset|filter:search|itemsPerPage:perPage|orderBy: 'showroom_id'">
                        <td>{{row.showroom_id}}</td>
                        <td>{{row.name | textBeautify}}</td>
                        <td>
                            <span ng-repeat="type in row.types">
                                {{ type }}{{ $last ? '' : ', ' }}
                            </span>
                        </td>
                        <td>{{row.supervisor | textBeautify}}</td>
                        <td>{{row.mobile | textBeautify}}</td>
                        <td>{{row.address | textBeautify}}</td>
                        <td>{{row.balance | fNumber}}</td>
                        <td  class="none">
                           <a onclick="return confirm('Do you want to visit this Showroom?');" class="btn btn-info" title="Visit" href="<?php echo site_url('access/users/directAccess/{{row.showroom_id}}');  ?>" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
                           <a class="btn btn-warning" title="Edit" href="<?php echo site_url('showroom/showroom/edit/{{row.showroom_id}}'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                           <a onclick="return confirm('Do you want to delete this Showroom?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('showroom/showroom/deleteShowroom/{{row.showroom_id}}'); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							
			   <!-- <?php if(is_access("showroom","edit")){ ?><a class="btn btn-warning" title="Edit" href="<?php echo site_url('showroom/showroom/edit/{{row.showroom_id}}'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
                           <?php if(is_access("showroom", "delete")){ ?><a onclick="return confirm('Do you want to delete this Showroom?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('showroom/showroom/deleteShowroom/{{row.showroom_id}}'); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?> -->
                        </td>
                    </tr>
                </table>
                <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>