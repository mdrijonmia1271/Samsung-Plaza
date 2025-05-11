<?php 	
    if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    $logo_data  = json_decode($meta->logo,true); 
?>
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

        .block-hide {
            display: none;
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

<div class="container-fluid block-hide">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <!-- horizontal form -->
        <?php
    $attribute = array(
        'name' => '',
        'class' => 'form-horizontal',
        'id' => ''
    );
    echo form_open_multipart('', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Income Report</h1>
                </div>
            </div>

            <div class="panel-body no-padding none">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-12">
                    <div class="form-group">
                    <?php 
                        if(checkAuth('super')) { 
                            $allGodown = getAllGodown();
                    ?>
                        <div class="col-md-2 text-right"><label for="" class="form-label">Showroom</label></div>
                        <div class="col-md-3">
                            <select name="godown_code" class="form-control">
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <option value="all">All Showroom</option>
                                <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                                <option value="<?php echo $row->code; ?>">
                                    <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <?php }else { ?>
                        <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                        <?php } ?>
                        <div class="col-md-1 text-right"><label for="" class="form-label">Year</label></div>
                        <div class="col-md-3">
                            <select name="year" class="form-control">
                                <option value="" disabled>&nbsp;</option>
                                <?php for($start=2018;$start<=date('Y');$start++) { ?>
                                <option <? if($start==date('Y')){echo"selected";} ?> value="<?php echo $start; ?>"><?php echo $start; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-1">
                            <div class="btn-group">
                                <input class="btn btn-primary" type="submit" name="show" value="Show">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>



<?php if(count($resultset) > 0) { ?>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Income Report</h1>
                </div>

                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;"
                    onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <div class="col-md-12 text-center hide">
                    <h3>Yearly Income Report
                        <?php echo $this->input->post('year'); ?></h3>
                </div>

                <span class="hide print-time text-center"
                    style="margin-bottom: 5px;"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>

                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Exp</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        <th>Total</th>
                    </tr>

                    <?php 
                    $sum = 0.00;
                    $allMonths = config_item('months');
                    foreach ($resultset as $row) { 
                    ?>
                    <tr>
                        <th><?php echo $row['sl']; ?></th>
                        <th><?php echo filter($row['field']); ?></th>
                        <?php 
                        foreach ($row['details'] as $month) { 
                            foreach ($allMonths as $value) {
                                if($month['month'] == $value) {
                                    $key = strtolower($value);
                                    $totalRec[$key] += $month['amount'];
                                }
                            }
                        ?>
                        <td><?php echo f_number($month['amount']); ?></td>
                        <?php } ?>

                        <td><?php echo f_number($row['total']);$sum += $row['total']; ?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <?php foreach ($totalRec as $key => $value) { ?>
                        <th><?php echo f_number($value); ?></th>
                        <?php } ?>

                        <th><?php echo f_number($sum); ?></th>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<?php } ?>


<?php if(count($resultset2) > 0) { ?>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Rent Report</h1>
                </div>

                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;"
                    onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <h3 class="hide text-center">Yearly Rent Report <?php echo date('Y'); ?></h3>

                <span class="hide print-time text-center"
                    style="margin-bottom: 5px;"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>

                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Exp</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        <th>Total</th>
                    </tr>

                    <?php 
                    $sum = 0.00;
                    $allMonths = config_item('months');
                    foreach ($resultset2 as $row) { 
                    ?>
                    <tr>
                        <th><?php echo $row['sl']; ?></th>
                        <th><?php echo filter($row['field']); ?></th>
                        <?php 
                        foreach ($row['details'] as $month) { 
                            foreach ($allMonths as $value) {
                                if($month['month'] == $value) {
                                    $key = strtolower($value);
                                    $totalRec[$key] += $month['amount'];
                                }
                            }
                        ?>
                        <td><?php echo f_number($month['amount']); ?></td>
                        <?php } ?>

                        <td><?php echo f_number($row['total']);$sum += $row['total']; ?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <?php foreach ($totalRec as $key => $value) { ?>
                        <th><?php echo f_number($value); ?></th>
                        <?php } ?>

                        <th><?php echo f_number($sum); ?></th>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<?php } ?>