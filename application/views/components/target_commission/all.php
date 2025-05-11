<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}

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

        .title{
            font-size: 25px;
        }
    }
</style>

<div class="container-fluid">

    <div class="row" ng-controller="allTargetCommissionCtrl">
    
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Target commission</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>" alt="photo not found..!">
                <h4 class="hide text-center" style="margin-top: 0px;">All Target commission</h4>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 35px;"> SL </th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Brand</th>
                        <th>Commission</th>
                        <th>Status</th>
                        <th class="none"> Action </th>
                    </tr>

                    <tr ng-repeat="row in dataset">
                        <td>{{row.sl}}</td>
                        <td>{{row.month}}</td>
                        <td>{{row.year}}</td>
                        <td>{{row.brand}}</td>
                        <td>{{row.amount}}</td>
                        <td>{{row.status}}</td>

                        <td class="none" style="width: 115px;">
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('target_commission/target_commission/update/{{row.id}}') ;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure want to delete this Info?');" href="?id={{row.id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                </table>
               </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
