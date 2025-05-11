<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<div class="container-fluid" ng-controller="AddClientCtrl">
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Customer</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open_multipart('client/client/test', $attr);
                
                ?>
                
                <!--<input type="hidden" name="code" class="form-control" value="<?php echo $party_id; ?>" readonly>-->
                 
                <div class="form-group">
                    <label class="col-md-3 control-label">Customer Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" >
                    </div>
                </div>

				<div class="form-group hide">
                    <label class="col-md-3 control-label">Contact Person</label>
                    <div class="col-md-5">
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="contact" class="form-control"  >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea name="address" cols="15" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">ID Card No. <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="id_card" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Guarantor Name</label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_name" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Guarantor Mobile<span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_mobile" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Guarantor Address</label>
                    <div class="col-md-5">
                        <textarea name="guarantor_address" cols="15" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">2<sup>nd</sup> Guarantor Name</label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_name2" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">2<sup>nd</sup> Guarantor Mobile<span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_mobile2" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">2<sup>nd</sup> Guarantor Address</label>
                    <div class="col-md-5">
                        <textarea name="guarantor_address2" cols="15" rows="3" class="form-control"></textarea>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-md-3 control-label">Initial Balance (TK) <span class="req">&nbsp;*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="balance" class="form-control" step="any" value="0.00" required>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="receivable" selected>Receivable</option>
                            <option value="payable">Payable</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Customer Type</label>
                    <div class="col-md-5">
                        <select name="customer_type" class="form-control">
                            <option value="customer" selected>Customer</option>
                            <option value="dealer">Dealer</option>
                        </select>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label class="col-md-3 control-label">Credit Limit <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="credit_limit" class="form-control" step="any" value="0.00" required>
                    </div>
                </div>-->
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Upload Photo <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input id="input-test" type="file" name="attachFile" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Take Photo </label>
                    <div class="col-md-5">
                        <input type="text" name="image" class="form-control" id="image-tag" readonly>
                    </div>
                    
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp;</label>
                    <div class="col-md-5">
                        <div id="my_camera"></div>
                        <br/>
                        <input type=button value="Take Snapshot" onClick="take_snapshot()">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp;</label>
                    <div class="row col-md-5">
                        <div id="results">Your captured image will appear here...</div>
                    </div>
                </div>
                
                <div id="capturePhoto" style="display:none">
                        Div here
                </div>
                
                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="add" value="Save" class="btn btn-primary">
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            
        </div>
            <div class="panel-footer">&nbsp;</div>
    </div>
</div>

<!--div class="modal fade" id="camera">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Capture Photo</h3>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
          </div>
          <div class="col-md-6">
                <div id="results">Your captured image will appear here...</div>
          </div>
        </div>                                                  
      </div>
      <div class="modal-footer">
        <button type="button" id="clear_img" class="btn btn-warning">Clear</button>
        <button type="button" id="capture" class="btn btn-primary">Capture</button>
      </div>
    </div>
  </div>
</div-->


<script>
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>



<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 390,
        height: 290,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            //$(".image-tag").val(data_uri);
            $("#image-tag").val(data_uri);
            //document.getElementById('capturePhoto').innerHTML = data_uri;
            //document.getElementsByClassName('image-tag').value = document.getElementById('capturePhoto').innerHTML;
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            document.getElementById('ttag').value = 'shesdadasdam';
        } );
    }
</script>
