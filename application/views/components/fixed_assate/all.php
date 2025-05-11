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
        echo form_open_multipart('', $attribute);
        ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title pull-left">
                        <h1>Search Fixed Assate</h1>
                    </div>
                </div>

                <div class="panel-body no-padding none">
                    <div class="no-title">&nbsp;</div>

                    <!-- left side -->
                    <div class="col-md-12"> 

                        <div class="form-group">
                            <div class="col-md-4">
                                 <?php $allGodowns = $this->action->read('godowns',array('trash' => 0)) ?>
                                 <select name="godown_code" id="godown_code"  class="form-control">
                                    <option value="" selected >-- Select Showroom --</option>
                                    <option value="all">All Showroom</option>
                                    <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                    </option>
                                    <?php } } ?>
                                </select>

                            </div>
                            
                            <div class="col-md-4">
                                <select name="search[field_fixed_assate]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                                  <option value="">-- Select Option --</option>
                                   <?php foreach ($fixed_assate_fields as $key => $value) {?>
                                     <option value="<?php echo $value->field_fixed_assate; ?>"><?php echo filter($value->field_fixed_assate); ?></option>
                                   <?php } ?>                                 
                                 </select> 
                            </div>
                               
                    
                            <!--<div class="col-md-3">
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
                            </div>-->


                            <div>
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

<?php if($fixed_assates != NULL) {?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Fixed Assate</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php //$this->load->view('components/print'); ?>
                
                <div class="col-md-12 text-center hide">
                    <h4>All Fixed Assate</h4>
                </div>

                <span class="hide print-time"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span>

                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Field of Fixed Assate </th>
                        <th>Description </th>
                        <th>Spender </th>
                        <th>Quantity </th>
                        <th>Amount </th>
                        <th class="block-hide" width="115">Action</th>
                    </tr>
                    <?php
                        $total=0;
                        foreach ($fixed_assates as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo filter($value->field_fixed_assate); ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td><?php echo $value->spend_by; ?></td>
                        <td><?php echo $value->quantity; ?></td>
                        <td><?php echo $value->amount; ?></td>
                        <td class="none text-center " style="width: 110px;">
                            <a title="edit" class="btn btn-warning" href="<?php echo site_url('fixed_assate/fixed_assate/edit/'.$value->id);?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Fixed Assate?');" href="<?php echo site_url('fixed_assate/fixed_assate/delete_fixed_assate/'.$value->id);?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <?php $total+=$value->amount; } ?>
                    <tr>
                        <th colspan="6"><span class="pull-right">Total</span> </th>
                        <th colspan="1" class="block-hide"><?php echo f_number($total); ?> TK</th>
                        <th>&nbsp;</th>
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

