<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<style>
    .clearfix p{
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
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Custom SMS</h1>
                </div>
            </div>

            <div class="panel-body">

                <blockquote class="form-head">

                    <!--h4>Send Custom SMS</h4-->

                    <ol style="font-size: 14px;">
                        <li>Total SMS:  <strong><?php echo $total_sms; ?> </strong> &nbsp; Total Send SMS: <strong><?php echo $sent_sms; ?></strong> &nbsp;  Remaining SMS: <strong><?php echo $total_sms-$sent_sms; ?></strong></li>
                    </ol>

                </blockquote>

                <hr>

                <?php
                $attribute = array(
                    "class" => "form-horizontal",
                    "name" => ""
                );
                echo form_open("sms/sendSms/send_custom_sms", $attribute);
                ?>
                
                <div class="form-group">
                    <label for="" class="col-md-3 control-label">Showroom</label>
                    <div class="col-md-9">
                        <select name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>&nbsp;</option>
                            <?php foreach ($godowns as $key => $value) {?>
                            <option value="<?php echo $value->code; ?>"><?php echo filter($value->name); ?></option>
                            <?php } ?>                             
                        </select> 
                    </div>
                </div>                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile Number <span class="req">*</span></label>

                    <div class="col-md-9">
                        <textarea name="mobiles" class="form-control" placeholder="Without +88 And Use Comma(,) Separator" cols="30" rows="4" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Message <span class="req">*</span></label>

                    <div class="col-md-9">
                        <textarea
                            name="message" class="form-control"
                            placeholder="Type Your Message. Maximum Characters Length 1080"
                            cols="30" rows="4" ng-model="msgContant"
                            required></textarea>
                    </div>
                </div>

                <div class="clearfix">
                    <p>
                        <span>
                            <strong>Total Characters </strong>
                            <input name="total_characters" class="sms" type="text" ng-model="totalChar">
                        </span>
                        &nbsp;
                        <span>
                            <strong>Total Messages</strong>
                            <input class="sms" name="total_messages" type="text" ng-model="msgSize">
                        </span>
                    </p>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" value="Send SMS" name="sendSms" class="btn btn-primary">
                </div>
                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
