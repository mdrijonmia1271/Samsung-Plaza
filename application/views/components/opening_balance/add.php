<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
    	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

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
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
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
    echo form_open('', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Set Opening Balance</h1>
                </div>
            </div>

            <div class="panel-body no-padding none">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Amount </label>
                        <div class="col-md-7">
                            <input type="number" name="opening_amount" class="form-control" autocomplete="off">
                        </div>

                        <div>
                            <div class="btn-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Save">
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


<?php if($openingInfo != null) { ?>

<div class="container-fluid" >
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Opening Balance</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
               <!-- Print banner Start Here -->

                <div class="col-xs-12 hide" style="border: 1px solid #ddd; padding:15px !important; margin-bottom: 15px;">
                    <div class="print_banner_logo">
                        <img class="img-responsive" src="<?php echo site_url($logo_data['faveicon']); ?>" alt="">
                    </div>
                    <div class="print_banner_text">
                    	<h2><?php echo strtoupper($header_info['site_name']); ?></h2>
                    	<p><?php echo $header_info['place_name'];?></p>
                    	<p><?php echo $footer_info['addr_moblile']; ?> || <?php echo $footer_info['addr_email']; ?></p>
                    </div>
                </div>

                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">Opening Balance</h3>
                </div>
                
                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>
            
                <table class="table table-bordered">
                    <tr>
                        <th width="55" >SL</th>
                        <th>Opening Balance </th>
                    </tr>
                    <?php foreach($openingInfo as $key => $value){ ?>
                    <tr>
                        <td><?php echo $key+1;?></td>
                        <td><?php echo f_number($value->opening_balance); ?></td>
                    </tr>
                    <?php } ?>
                </table>
                
            </div>
            
            <!--Modal section start here-->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update amount</h4>
                  </div>
                    <div class="modal-body">
                        <div class="row">
                        <?php
                            $attr = array('class' => 'form-horizontal');
                            echo form_open('', $attr);
                        ?>
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Amount</label>
                                <div class="col-md-7">
                                    <input type="text" name="new_amount" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="btn-group pull-right">
                                    <input type="submit" value="Update" name="update" class="btn btn-info">
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <!--Modal section end here-->
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
