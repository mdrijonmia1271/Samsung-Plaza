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
                    <h1 class="pull-left">View Complain </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <!-- Print Banner -->
                <figure class="emp-photo">
                    <!-- Print banner -->
                    <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                </figure>

               <!-- <h4 class="text-center" style="margin-top: 0px;">Complain Information</h4>-->

                <div class="col-md-12">
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Date : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->date); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Customer Name : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->name); ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 no-padding ">
                        <label class="control-label col-xs-3 text-right">Mobile : </label>
                        <div class="col-xs-9">
                            <p><?php echo $complainInfo[0]->mobile; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Address : </label>
                        <div class="col-xs-9">
                            <p><?php echo $complainInfo[0]->address; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Sale Type : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->sale_type); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Product Name : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->product_name); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Complain : </label>
                        <div class="col-xs-9">
                            <p><?php echo $complainInfo[0]->complain; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 no-padding">
                        <label class="control-label col-xs-3 text-right">Status : </label>
                        <div class="col-xs-9">
                            <p><?php echo filter($complainInfo[0]->status); ?></p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
