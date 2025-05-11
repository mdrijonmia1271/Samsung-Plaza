<div class="container-fluid">
    <div class="row">
    <?php echo $confirmation; ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Order</h1>
                </div>
            </div>

            <div class="panel-body">


                <!-- horizontal form -->
                <?php
                $attr=array("class"=>"form-horizontal");
                echo form_open_multipart('', $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Customer Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-md-2 control-label">Company <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="company" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Products <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="products" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Price <span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="price" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Quantity <span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="quantity" class="form-control" required>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label class="col-md-2 control-label">Amount <span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="amount" class="form-control" required>
                    </div>
                </div> -->

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile Number <span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="mobile_number" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">District <span class="req"></span></label>
                    <div class="col-md-5" >
                        <select name="district" class="form-control" >
                            <option value="">-- Select --</option>
                            <?php foreach (config_item('dist_upozila') as $key=>$value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Upazila <span class="req"></span></label>
                    <div class="col-md-5" >
                        <select name="upazila" class="form-control" >
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Delivery Date <span class="req"></span></label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="delivary_date" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address <span class="req"></span></label>
                    <div class="col-md-5">
                        <textarea name="address" id="address" class="form-control" cols="30" rows="3" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Remark <span class="req"></span></label>
                    <div class="col-md-5">
                        <textarea name="remark" id="address" class="form-control" cols="30" rows="2" required></textarea>
                    </div>
                </div>
                <?php if ($privilege != "field_officer") { ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Order By <span class="req"></span></label>
                    <div class="col-md-5">
                        <select name="order_by" class="form-control" >
                            <option value="">-- Select --</option>
                            <?php foreach ($fo as $value) { ?>
                            <option value="<?php echo $value->name; ?>"><?php echo $value->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } else{ ?>
                <input type="hidden" name="order_by" value="<?php echo $name; ?>" />
                <?php } ?>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="save" value="Save" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('select[name="district"]').on('change',function() {
            var dis = $(this).val();
            $.ajax({
                url: '<?php echo site_url("order/order/ajax_dis_upazilla"); ?>',
                type: 'POST',
                data: {dis: dis}
            })
            .done(function(response) {
                console.log(response);
                $('select[name="upazila"]').html(response);
            });

        });
    });
</script>
