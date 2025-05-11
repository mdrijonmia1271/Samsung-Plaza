<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
@media print{
aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
.panel{border: 1px solid transparent; left: 0px; position: absolute; top: 0px; width: 100%;}
.hide{display: block !important;}
.print_banner_logo {width: 19%;float: left;}
.print_banner_logo img {margin-top: 10px;}
.print_banner_text {width: 80%; float: right;text-align: center;}
.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
.print_banner_text p {margin-bottom: 5px !important;}
.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
}
</style>
<div class="container-fluid">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Transaction</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>
                <div class="form-group">
                    <!-- <label class="col-md-2 control-label"> Supplier Name </label> -->
                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>-- Select Supplier --</option>
                            <?php
                            if ($info != null) {
                            foreach ($info as $row) {
                            ?>
                            <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <?php if($this->data['privilege'] == 'super') { ?>
                     <div class="col-md-3">
                        
                        <select  name="search[godown_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    
                    <?php }else{ ?>
                    
                         <input type="hidden" name="search[godown_code]" value ='<?php echo $this->data['branch']; ?>' >
                    <?php } ?>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    <?php if ($transactionInfo != NULL) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                
                <div class="col-md-12 text-center hide">
                    <h3>All Transaction</h3>
                </div>

                
                <!--<h4 class="text-center hide" style="margin-top: 0px;">All Transaction</h4>-->
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Showroom</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Transaction By</th>
                        <th class="text-center">Paid</th>
                        <th class="text-center">Paid By</th>
                        <th class="none" width="160px">Action</th>
                    </tr>
                    <?php
                    $total = 0.00;
                    foreach ($transactionInfo as $key => $row) {
                            $where = array("code" => $row->party_code);
                            $info  = $this->action->read("parties", $where);
                            $total += $row->debit;
                            $showroom = get_name('godowns', 'name', ['code'=>$row->godown_code]);
                    ?> 
                    
                    <tr>
                        <td class="text-center"><?php echo $key + 1; ?></td>
                        <td class="text-center"><?php echo $row->transaction_at; ?></td>
                        <td class="text-center"><?php echo (!empty($showroom) ? $showroom : ''); ?></td>
                        <td class="text-center"><?php echo filter($info[0]->name); ?></td>
                        <td class="text-center"><?php echo filter($row->transaction_via); ?></td>
                        <td class="text-center"><?php echo f_number($row->debit); ?></td>
                        <td><?php echo $row->comment; ?></td>
                        <td class="none">
                            <a class="btn btn-info" href="<?php echo site_url('supplier/all_transaction/view/'.$row->id);?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            
                            <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>
                                <a class="btn btn-warning" title="Edit" href="<?php echo site_url('supplier/transaction/edit_transaction/'.$row->id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="<?php echo site_url('supplier/all_transaction/delete_transaction/'.$row->id);?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete this ?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <?php  } ?>    
                        </td>
                    </tr>
                    <?php  } ?>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Total</strong></td>
                        <td class="text-center"><strong><?php echo f_number($total); ?> Tk</strong></td>
                        <td></td>
                        <td class="none"></td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    <?php } ?>
    </div>
</div>
<script type="text/javascript">
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
    format: 'YYYY-MM-DD',
    useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
    format: 'YYYY-MM-DD',
    useCurrent: false
    });
    $("#datetimepickerFrom").on("dp.change", function (e) {
    $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerTo").on("dp.change", function (e) {
    $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>