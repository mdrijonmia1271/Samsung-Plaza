<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
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
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Purchase</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
                echo $this->session->flashdata('deleted');

                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="col-sm-5">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Voucher Number </label>
                        <div class="col-md-8">
                            <input type="text" name="search[voucher_no]" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Supplier Name </label>
                        <div class="col-md-8">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled></option>
                                <?php if($allVendors != null){ foreach($allVendors as $key => $row){ ?>
                                <option value="<?php echo $row->id; ?>">
                                    <?php echo filter($row->name); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Product Name</label>
                        <div class="col-md-8">
                            <select name="search[product_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled></option>
                                <?php if($allProduct != null){ foreach($allProduct as $key => $row){ ?>
                                <option value="<?php echo $row->product_code; ?>">
                                    <?php echo filter($row->product_name); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    
            <?php /* <div class="form-group">
                        <label class="col-md-4 control-label">Category</label>
                        <div class="col-md-8">
                            <select name="search[category]" class="form-control">
                                <option value="" selected disabled></option>
                                <?php if($allCategory != null){ foreach($allCategory as $key => $row){ ?>
                                <option value="<?php echo $row->category; ?>">
                                    <?php echo filter($row->category); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>*/ ?>
                </div> 
                
                <div class="col-sm-5">
                    <div class="form-group">
                    <label class="col-md-4 control-label">From</label>
                        <div class="input-group date col-md-8" id="datetimepickerFrom">
                            <input type="text" name="date[from]"   class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">To </label>
                        <div class="input-group date col-md-8" id="datetimepickerTo">
                            <input type="text" name="date[to]"   class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    
                    <?php /* <div class="form-group">
                        <label class="col-md-4 control-label">Subcategory</label>
                        <div class="col-md-8">
                            <select name="search[subcategory]" class="form-control">
                                <option value="" selected disabled></option>
                                <?php if($allSubCategory != null){ foreach($allSubCategory as $key => $row){ ?>
                                <option value="<?php echo $row->subcategory; ?>">
                                    <?php echo filter($row->subcategory); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div> */ ?>
                </div>
                   
                <div class="col-md-10">
                    <div class="btn-group pull-right">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                    
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
     

        <?php if($result != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Result</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print Banner -->
    
                <div class="row hide">
                    <div class="view-profile">

                        <div class="institute">
                            <h2 class="text-center title" style="margin-top: 10px; font-weight: bold;">
                                <?php $print_header = config_item('heading'); echo $vheaderInfo[0]->name; ?>
                            </h2>
                            <h4 class="text-center" style="margin: 0;">
                                <?php $print_header = config_item('heading'); echo $vheaderInfo[0]->address; ?>
                            </h4>
                            <div class="col-md-12">&nbsp;</div>
                            <h5 class="text-center" style="margin: 0;">
                              Mobile: <?php $print_header = config_item('heading'); echo $vheaderInfo[0]->mobile; ?>
                            </h5>
                            <div class="col-md-12">&nbsp;</div>
                        </div>                           
                      
                    </div>
                </div>
                
                <hr class="hide" style="border-bottom: 2px solid #ccc; margin-top: 5px;">

                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher Number</th>
                        <th>Supplier Name</th>                      
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th class="none text-center">Action</th>
                    </tr>
                    
                    <?php 
                     $total = $totalPaid = $totalDue =$transport_total =  0;
                     foreach($result as $key => $val){ 
                    ?>
                    <tr>
                        <td style="width: 50px;"><?php echo ($key + 1); ?></td>
                        <td><?php echo $val->sap_at; ?></td>
                        <td><?php echo $val->voucher_no; ?></td>

                        <td>
                        <?php 
                        $where = array('code' => $val->party_code); 
                        $info = $this->action->read('parties', $where);
                        if(count($info)>0){
                        	 echo filter($info[0]->name);
                        }else{
                        	echo "N/A";
                        }
                   
                        ?>
                        </td>	
		
            			<td><?php echo $val->total_bill;  $total += $val->total_bill; ?></td>
            			<td><?php echo $val->paid; $totalPaid +=$val->paid; ?></td>

                        <td class="none" style="width: 70px;">
                            <a href="<?php echo site_url('barcode/barcodeGenerate/barcode_generate?vno='.$val->voucher_no);?>" class="btn btn-primary" style="font-size: 14px; margin-top: 0;">
                                Details
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>

    </div>
</div>

<script>
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>