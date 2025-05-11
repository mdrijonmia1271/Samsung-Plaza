<style type="text/css">
    .profile-title{display: flex;}
    .profile-title img{
        width: 70px;
        height: 70px;
        margin-bottom:  10px;
    }

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

        .hide{display: block !important;}

    }  
</style>


<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">View Payment</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive hide print-banner" src="<?php echo site_url('private/images/print-banner.jpg'); ?>" alt="banner not found!">

                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>
                

                <div class="row">
                    <!-- left side -->
                    <div class="col-xs-3">
                        <div class="border-top">&nbsp;</div>
                        <figure class="profile-pic">
                            <img 
                                style="margin-bottom: 0;" 
                                src="<?php echo site_url($result['img']); ?>" 
                                alt="Pic not found!" class="img-responsive">
                        </figure>
                        <br/>
                    </div>

                    <div class="col-xs-9">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs none" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="profile">
                                <div class="row profile-title no-padding">
                                    <div class="col-xs-6">
                                        <div class="profile-title">
                                            <h3 class="pull-left img-show" 
                                                style="margin-bottom: 20px;">
                                                <?php echo $result['name']; ?>
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="col-xs-6">&nbsp;</div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">ID</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['eid']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Post</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['post']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Mobile</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['mobile']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Gender</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['gender']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Joining Date</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['joining']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php if(count($result['salary']) > 0){ ?>
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Basic</th>
                        <th>Incentive</th>
                        <th>Bonus</th>
                        <th>Deduction</th>
                        <th>Total Salary</th>
                    </tr>

                    <?php foreach($result['salary'] as $key => $val){ ?>
                    <tr>
                        <td><?php echo ($key + 1); ?></td>
                        <td><?php echo $val['date']; ?></td>
                        <td><?php echo $val['basic']; ?> ৳</td>
                        <td><?php echo $val['insentive']; ?> ৳</td>
                        <td><?php echo $val['bonus']; ?> ৳</td>
                        <td><?php echo $val['deduction']; ?> ৳</td>
                        <td><?php echo $val['total']; ?> ৳</td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>