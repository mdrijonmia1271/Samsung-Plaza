<style>
    .col-md-4 {margin-bottom: 15px;}
    .btn-group button {padding: 5px 13px;}
</style>
<div class="container-fluid" ng-controller="editProductionCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Production</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr=array("class"=>"form-horizontal");
                echo form_open('', $attr);
                ?>

                <div class="form-group">
                    <div class="col-md-6">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" class="form-control" readonly  value="<?php echo ($production) ? $production[0]->date : ""; ?>" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="batch_no" class="form-control" value="<?php echo ($production) ? $production[0]->batch_no : ""; ?>" readonly placeholder="Batch No.">
                    </div>
                </div>

                <table class="table table-hover">
                    <tr>
                        <th width="55">SL</th>
                        <th>Raw Material</th>
                        <th width="25%">Quantity</th>
                    </tr>
                    <?php
                      if($production){
                       foreach ($production as $key => $value) {
                      $info = $this->action->read("materials" ,array("code" => $value->raw_material));
                      $raw_mat = ($info) ? filter($info[0]->name) : "";

                    ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td>
                                 <?php echo $raw_mat; ?>
                                 <input type="hidden" name="raw_code[]" value="<?php echo $value->raw_material; ?>">
                             </td>
                            <td><input type="text" class="form-control" readonly name="raw_quantity[]" value="<?php echo $value->raw_quantity; ?>"></td>
                        </tr>
                    <?php } } ?>
                </table>

                <div class="form-group" ng-init="product_name='<?php echo ($production) ? $production[0]->name : ""; ?>'">
                    <label class="control-label col-md-3">Finish Product</label>
                    <div class="col-md-5" ng-init="finish_product_code='<?php echo ($production) ? $production[0]->finish_product : ""; ?>'">
                        <select class="form-control" ng-change="getProductInfoFn()" ng-model="finish_product_code" name="finish_product_code" required>
                          <option value="" selected disabled> Select Finish Product </option>
                            <?php foreach ($result as $value) {  ?>
                              <option value="<?php echo $value->code; ?>"> <?php echo filter($value->name); ?></option>
                           <?php }  ?>
                        </select>
                        <input type="hidden" name="finish_product" ng-value="product_name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Quantity</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="number" name="finish_quantity" required min="0" value="<?php echo ($production) ? $production[0]->quantity : 0; ?>" class="form-control" step="any">
                            <input type="hidden" name="old_finish_quantity"  value="<?php echo ($production) ? $production[0]->quantity : 0; ?>">
                        <div class="input-group-addon">KG</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="edit" value="Update" class="btn btn-info">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>



<script>
    // linking between two date
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>
