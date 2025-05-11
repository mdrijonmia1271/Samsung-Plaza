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
        .emp-photo img:last-child{
            margin-top: 90px;
            width: 150px;
            margin-right: 0;
            right: 0;
        }
    }
    .emp-photo{
            position: relative;
    }
    .emp-photo img:last-child{
        position: absolute;
        top: 100px;
        right: 15px;
        width: 100px;
    }
</style>

<div class="container-fluid">
    <div class="row">
    <?php //echo "<pre>"; print_r($emp_info); echo "</pre>"; ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Employee Profile</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <!-- Print Banner -->
                <figure class="emp-photo">
                    <!-- Print banner -->
                    <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                    <img class="img-responsive img-thumbnail" src="<?php echo site_url($emp_info[0]->path); ?>" alt="Photo not found!">
                </figure>

                <h4 class="text-center" style="margin-top: 0px;">Employee Information</h4>

                <div class="row">
                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">ID</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->emp_id; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">Name</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->name; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">Joining Date</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->joining_date; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">Gender</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->gender; ?></p>
                        </div>
                    </div>

                    <?php /*
                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">ইমেইল</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->email); ?></p>
                        </div>
                    </div>
                    */ ?>

                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">Mobile Number</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->mobile; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">Present Address</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->present_address; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">Permanent Address</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->permanent_address; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 no-padding">
                        <label class="control-label col-xs-6">Designation</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->designation; ?></p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
