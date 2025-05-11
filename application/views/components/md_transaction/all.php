<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
    	

<style>
@media print{
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid block-hide">
    <div class="row">

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
                        <h1>Search Showroom Transaction</h1>
                    </div>
                </div>

                <div class="panel-body no-padding none">
                    <div class="no-title">&nbsp;</div>

                    <!-- left side -->
                    <div class="col-md-12"> 

                        <div class="form-group">
                            <!-- <label for="" class="col-md-3 control-label">Field of Fixed Assate </label> -->
                            
                            <?php if(checkAuth('super')) { ?>
                            <div class="col-md-3" >
                                <select name="godown_code" class="form-control" required>
                                    <option value="">-- Select Showroom --</option>
                                    <option value="all">All Showroom</option>
                                    <?php if(!empty($allGodown)){
                                        foreach($allGodown as $option){
                                            echo '<option value="'.$option->code.'">'. $option->name .' ( '. $option->address .' ) </option>';
                                        }   
                                    }?>
                                </select>
                            </div>
                            <?php }else{ ?>
                                <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>">
                            <?php } ?>

                            <div class="col-md-3">
                                  <?php 
                                    $all_investor = $this->action->read('add_new_md');
                                  ?>
                                <select name="name" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                    <option value="">-- Select --</option>
                                    <?php foreach ($all_investor as $value) { ?>
                                    <option value="<?php echo $value->field_fixed_assate; ?>"><?php echo $value->field_fixed_assate; ?></option>
                                    <?php } ?>
                                           
                                </select>
                            </div>
                            <div class="col-md-2">
                                  <?php 
                                        $all_investor = $this->action->read('add_new_md');
                                  ?>
                                <select name="type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                    <option value="">-- Select Type --</option>
                                    <?php foreach (config_item('md_transaction_type') as $value) { ?>
                                    <option value="<?php echo $value; ?>" <?= (!empty($_POST['type']) && $_POST['type'] == $value) ? 'selected':'' ?> ><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                    
                            <div class="col-md-2">
                                <!-- <label class="col-md-3 control-label">Form</label> -->
                                <div class="input-group" id="datetimepickerFrom">
                                    <input type="text" name="dateFrom" value="<?= !empty($_POST['dateFrom']) ? $_POST['dateFrom']:'' ?>" placeholder="From" class="form-control" >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>   

                            <div class="col-md-2">
                                <!-- <label class="col-md-3 control-label">To</label> -->
                                <div class="input-group date" id="datetimepickerTo">
                                    <input type="text" name="dateTo" value="<?= !empty($_POST['dateTo']) ? $_POST['dateTo']:'' ?>" placeholder="To" class="form-control" >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>  



                            <div class="col-md-2" style="margin-top: 15px;">
                                <input class="btn btn-primary" type="submit" name="show" value="Search">
                            </div>

                        </div>
                    </div>

            </div>
                <div class="panel-footer">&nbsp;</div>

            <?php echo form_close(); ?>
        </div>
    </div>
    
    <div class="row">
	    <?php  echo $this->session->flashdata('confirmation'); ?>
	    <!--<div id="loading">
            <img src="<?php //echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>-->
	    <div class="panel panel-default" id="data">
	        <div class="panel-heading">
	            <div class="panal-header-title">
	                <h1 class="pull-left">All Md Transaction</h1>
	                <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
	        </div>
	        <div class="panel-body"  ng-cloak>
	            <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                
	            <!--<h4 class="text-center hide" style="margin-top: 0px;">All Brand </h4>-->
	            <div class="col-md-12 text-center hide">
                    <h3>All Md Transaction</h3>
                </div>

	            <table class="table table-bordered">
	                <tr>
	                    <th style="width: 50px;">SL</th>
	                    <th>Date</th>
	                    <th>Type</th>
	                    <th>Name</th>
	                    <th class='text-center'>Received</th>
	                    <th class='text-center'>Paid</th>
	                    <th>Particulars</th>
	                    <th class="none" style="width: 120px;">Action</th>
	                </tr>
                    <?php $totalReceived=$totalPaid=$i=0; foreach($result as $key => $value){ ?>
	                <tr>
	                    <td><?php echo ++$i; ?></td>
	                    <td><?php echo $value->date; ?></td>
	                    <td><?= $value->type ?></td>
	                    <td><?= $value->name ?></td>
	                    <td class="text-success text-center"><?php echo $value->type == 'Received' ? $value->amount:'-'; ?></td>
	                    <td class="text-danger text-center"><?php echo $value->type == 'Paid' ? $value->amount:'-'; ?></td>
	                    <td><?php echo $value->particulars; ?></td>
	                    <td class="none">
	                        <a class="btn btn-warning"
								title="Edit" href="<?php echo site_url('md_transaction/md_transaction/edit/'.$value->id);?>">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							</a>
							<a onclick="return confirm('Do you want to delete this Sub Category?');"
								class="btn btn-danger" title="Delete"
								href="<?php echo site_url('md_transaction/md_transaction/delete/'.$value->id); ?>">
								<i class="fa fa-trash-o" aria-hidden="true"></i>
							</a>
	                    </td>
	                </tr>
	                <?php $value->type == 'Received' ? $totalReceived+=$value->amount:$totalPaid+=$value->amount;} ?>
	                <tr>
	                    <td colspan="4" class="text-right"><strong>Total: </strong></td>
	                    <td class="text-success text-center"><strong><?= $totalReceived ?></strong>TK</td>
	                    <td class="text-danger text-center"><strong><?= $totalPaid ?></strong>TK</td>
	                    <td class="alert-info text-left" colspan="2">Balance: <strong><?= $totalReceived - $totalPaid ?></strong>TK</td>
	                </tr>
	            </table>
	        </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
     $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

