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
                'name'  => '',
                'class' => 'form-horizontal',
                'id'    => ''
            );
            echo form_open_multipart('cost/cost/allcost', $attribute);
        ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title pull-left">
                        <h1>Search Cost</h1>
                    </div>
                </div>

                <div class="panel-body no-padding none">
                    <div class="no-title">&nbsp;</div>
                    <div class="col-md-12"> 
                        <?php 
                            $privilege = $this->session->userdata('privilege');
                            $branch = $this->session->userdata('branch');
                        ?>
                        <div class="form-group">
                            <div class="col-md-3">
                                <select name="godown_code" class="form-control">
                                    <option value="" selected disabled>-- Select Showroom --</option>
                                    <option value="all">All Showroom</option>
                                    <?php if(!empty($allGodown)){ foreach($allGodown as $row){ ?>
                                    <option value="<?php echo $row->code; ?>" >
                                        <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                    </option>
                                    <?php } } ?>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <select name="search[cost_category]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                                  <option value="">-- Select Cost Category --</option>
                                   <?php foreach ($cost_categories as $key => $value) {?>
                                     <option value="<?php echo $value->cost_category; ?>"><?php echo filter($value->cost_category); ?></option>
                                   <?php } ?>                                 
                                 </select> 
                            </div> 
                            
                            <div class="col-md-3">
                                <select name="search[cost_field]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                                  <option value="">-- Select Cost Field --</option>
                                   <?php foreach ($cost_fields as $key => $value) {?>
                                     <option value="<?php echo $value->cost_field; ?>"><?php echo filter($value->cost_field); ?></option>
                                   <?php } ?>                                 
                                 </select> 
                            </div>                            
                        </div>                            
                        
                        <div class="form-group">
                            <div class="col-md-3">
                                <div class="input-group" id="datetimepickerFrom">
                                    <input type="text" name="date[from]" placeholder="From" class="form-control" >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>   

                            <div class="col-md-3">
                                <div class="input-group date" id="datetimepickerTo">
                                    <input type="text" name="date[to]" placeholder="To" class="form-control" >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>  

                            <div class="col-md-2">
                                <div class="btn-group">
                                    <input class="btn btn-primary" type="submit" name="show" value="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="panel-footer">&nbsp;</div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php if($costs != NULL) {?>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Cost</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <div class="col-md-12 text-center hide">
                    <h3>All Cost</h3>
                </div>

                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>

                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Showroom</th>
                        <th>Field of Cost </th>
                        <th>Cost Category</th>
                        <th>Description </th>
                        <th>Spender </th>
                        <th>Amount </th>
                        <th class="block-hide" width="115">Action</th>
                    </tr>
                    <?php
                        $total=0;
                        foreach ($costs as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo filter($value->cost_field); ?></td>
                        <td><?php echo filter($value->cost_category); ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td><?php echo $value->spend_by; ?></td>
                        <td><?php echo $value->amount; ?></td>
                        <td class="none text-center " style="width: 110px;">
                             <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>
                                    <a title="edit" class="btn btn-warning" href="<?php echo site_url('cost/cost/edit/'.$value->id);?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Cost?');" href="<?php echo site_url('cost/cost/delete_cost/'.$value->id);?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        
                            <?php  } ?>   
                        </td>
                    </tr>
                    <?php $total+=$value->amount; } ?>
                    <tr>
                        <th colspan="7"><span class="pull-right">Total</span> </th>
                        <th colspan="1"><?php echo f_number($total); ?> TK</th>
                        <th class="none">&nbsp;</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<?php } ?>



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

