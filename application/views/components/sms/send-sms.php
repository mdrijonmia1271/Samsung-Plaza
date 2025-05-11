<style>
    .right{
        display: inline-block;
        float: right;
    }
    p span .sms{
        border: 1px solid transparent;
        width: 40px;
    }
</style>

<div class="container-fluid" ng-controller="CustomSMSCtrl">
    <div class="row">

       <?php echo $confirmation;?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Send SMS</h1>
                </div>
            </div>


            <div class="panel-body">
                <?php $attr=array('class'=>'');
                echo form_open('', $attr); ?>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label text-right">Showroom</label>
                        <div class="col-md-4">
                            <select name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>&nbsp;</option>
                                <?php foreach ($godowns as $key => $value) { ?>
                                <option value="<?php echo $value->code; ?>"><?php echo filter($value->name); ?></option>
                                <?php } ?>                             
                            </select> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-1 control-label text-right">Type</label>
                        <div class="col-md-4">
                            <select name="type" class="form-control">
                                <option value="hire">Client</option>
                                <option value="supplier">Supplier</option>
                                <option value="dealer">Dealer</option>
                            </select>
                        </div>
                    </div>

                     <div class="col-md-1">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>

            <div class="panel-footer">&nbsp;</div>
        </div>




        <?php if($receivers != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Mobile Number And SMS</h1>
                </div>
            </div>

            <div class="panel-body">
                <blockquote class="form-head">
                    <ol style="font-size: 14px;">
                        <li>Select mobile number and click <mark>send</mark> button</li>
                        <li>Total SMS:  <strong><?php echo $total_sms; ?> </strong>  &nbsp; Total Send SMS: <strong><?php echo $sent_sms; ?></strong> &nbsp;  Remaining SMS: <strong><?php echo $total_sms-$sent_sms; ?></strong></li>
                    </ol>

                </blockquote>

                <?php $attr = array ('class' => 'form-horizontal');
                echo form_open('', $attr); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile Number <span class="req">*</span></label>
                   
                    <div class="col-md-9">
                        <div class="form-element" style="height: 130px;">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                            </tr>
                            <?php foreach ($receivers as $key => $receiver) { ?>
                            <tr>
                                <td><?php echo ucfirst($receiver->name); ?></td>
                                <td>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="mobile[]" value="<?php echo $receiver->mobile; ?>" checked /><?php echo $receiver->mobile; ?></label>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $receiver->address; ?>
                                </td>
                            </tr>
                            <?php } ?>

                        </table>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3">Message <span class="req">*</span></label>
                    <div class="col-md-9">
                        <textarea name="message" ng-model="msgContant" class="form-control" cols="30" rows="5" placeholder="Type your message....." required></textarea>
                        <input type="hidden" name="godown_code" value="<?php echo $godown_code; ?>" >
                    </div>
                </div>

                <div class="clearfix">
                    <p class="right">
                        <span><strong>Total Characters: </strong>
                            <input name="total_characters" ng-model="totalChar" class="sms" type="text" >
                        </span>
                        &nbsp;
                        <span><strong>Total Messages: </strong>
                            <input class="sms" name="total_messages" ng-model="msgSize" type="text" >
                        </span>
                    </p>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" name="sendSms" value="Send SMS" class="btn btn-primary">
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('input[name="type"]').on('change', function(event) {
            if($(this).val()=="member"){
                $('#member_name').slideDown();
            }else{
                $('#member_name').slideUp();
            }
        });
    });
</script>
