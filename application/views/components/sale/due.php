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

<div class="container-fluid" ng-controller="getDueCtrl">
    <div class="row">

        <?php echo $confirmation; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Search</h1>
                    <!-- a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a -->
                </div>
            </div>

            <div class="panel-body">
                    <?php
                    $attr = array("class" => "form-horizontal");
                    echo form_open('', $attr); ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Zone (Zilla) <span class="req"></span></label>
                        <div class="col-md-5">
                            <select
                               name="search[zone]"
                               ng-model="zilla"
                               class="form-control"
                               ng-change="getUpazillaFn()">
                                <?php foreach($zilla as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                <?php } ?>
                             </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Area (Upazilla) <span class="req"></span></label>
                        <div class="col-md-5">
                            <select
                                name="search[area]"
                                ng-model="upazilla"
                                class="form-control">                              
                                <option ng-repeat="row in upazilla" ng-value="row">{{row}}</option>
                             </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Brand <span class="req"></span></label>
                        <div class="col-md-5">
                            <select name="search[brand]" class="form-control">
                                <?php foreach ($allBrand as $value) { ?>
                                <option value="<?php echo $value->brand ?>"><?php echo ucwords(str_replace("-"," ",$value->brand)); ?></option>
                                <?php } ?>
                             </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-7">
                            <input type="submit" value="Show" class="btn btn-primary pull-right">
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>




        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Due List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <?php if($allDue != null){echo form_open(""); ?>
                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Name</th>
                        <th><label><input checked type="checkbox" id="allcheck"> Mobile</label></th>
                        <th>Address</th>
                        <th>Brand</th>
                        <th>Amount</th>
                    </tr>

                    <?php
                    $totalAmount = 0;
                    foreach($allDue as $key => $row) {
                        $totalAmount += $row->balance;
                    ?>
                    <tr>
                        <td><?php echo ($key + 1); ?></td>
                        <td><?php echo $row->name . "[" . $row->address . "]"; ?></td>
                        <td>
                            <label>
                                <input checked type="checkbox" name="mobiles[]" value="<?php echo $row->contact; ?>"> 
                                <?php echo $row->contact; ?>
                            </label>
                        </td>
                        <td><?php echo $row->address; ?></td>
                        <td><?php echo ucwords(str_replace("-", " ", $row->brand)); ?></td>
                        <td><?php echo  f_number(abs($row->balance)); ?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="5" class="text-right"><strong>Total</strong></td>
                        <td><strong><?php echo f_number(abs($totalAmount)); ?></strong></td>
                    </tr>
                </table>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <textarea name="message" class="form-control"></textarea>
                        </div>
                        <div class="col-md-2">
                            <input class="btn btn-primary" name="send" type="submit" value="Send">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#allcheck").on('change', function(event) {
            if($(this).is(":checked")==true){
                $('input[name="mobiles[]"]').prop("checked", true);
            }else{
                $('input[name="mobiles[]"]').prop("checked", false);
            }
        });
    });
</script>
