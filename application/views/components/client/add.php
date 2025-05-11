<script src="<?php echo site_url('private/js/ngscript/AddClientCtrl.js') ?>"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

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
                echo form_open_multipart('', $attr);

                if ($this->data['privilege'] == 'super') {
                    $godown = 'yes';
                    $column = '2';
                } else {
                    $godown = 'no';
                    $column = '3';
                }
                ?>

                <input type="hidden" name="code" class="form-control" value="<?php echo clientUniqueId('parties'); ?>"
                       readonly>

                <?php if ($godown == 'yes') { ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Showroom<span class="req">&nbsp;*</span></label>
                        <div class="col-md-5">
                            <select name="godown_code" class="form-control" required>
                                <option value="" selected disabled>-- Select Showroom --</option>
                                <?php if (!empty($allGodowns)) {
                                    foreach ($allGodowns as $row) { ?>
                                        <option value="<?php echo $row->code; ?>" <?php echo ($this->data['branch'] == $row->code) ? 'selected' : ''; ?>>
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>" required>
                <?php } ?>

                <input type="hidden" name="customer_type" id="client_type" value="dealer">

                <div class="form-group">
                    <label class="col-md-3 control-label">Customer Type<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="customer_type" class="form-control" id="client_type" required>
                            <option value="" selected>-- Select Type ---</option>
                            <option value="dealer">Dealer</option>
                            <option value="hire">Hire</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                </div>


                <div class="form-group hide_column2">
                    <label class="col-md-3 control-label">Dealer Type<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="dealer_type" class="form-control">
                            <?php
                            $dealer_type = config_item('dealer_type');
                            if (!empty($dealer_type)) {
                                foreach ($dealer_type as $item) { ?>
                                    <option value="<?= $item ?>"><?= $item ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Customer Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Brand<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="brand" class="form-control">
                            <option value="">Select Brand &nbsp;</option>
                            <?php
                            $brand = get_result('brand',['trash' => 0]);
                            if (!empty($brand)) {
                                foreach ($brand as $brand) { ?>
                                    <option value="<?php echo $brand->brand; ?>"><?php echo $brand->brand; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-3 control-label">Customer Zone<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <select name="zone" class="form-control">
                            <option value="">Select Zone&nbsp;</option>
                            <?php
                            $zone = $this->action->read('zone');
                            if (!empty($zone)) {
                                foreach ($zone as $zone) { ?>
                                    <option value="<?php echo $zone->zone; ?>"><?php echo $zone->zone; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Father's Name<span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="father_name" class="form-control" required>
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
                        <input type="text" name="contact" class="form-control" required>
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

                <div class="form-group hide_column">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-11 col-md-offset-1">
                                <h3 class="text-left" style="margin: 20px 0 0 0;">1<sup>st</sup> Guarantor </h3>

                                <div style="margin-top: -30px;">
                                    <label class="col-md-4 control-label">&nbsp;Previous Client</label>
                                    <div class="col-md-5">
                                        <label class="radio-inline">
                                            <input type="radio" ng-model="previous_client" value="yes"> Yes
                                        </label>

                                        <label class="radio-inline">
                                            <input type="radio" ng-model="previous_client" value="no" checked
                                                   ng-click="removeGuarantorOneData()"> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <hr style="margin: 10px 0 10px 0;">
                    </div>
                </div>

                <div class="form-group hide_column" ng-show="previous_client=='yes'">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-5">
                        <select type="text" name="guarantor_code"
                                ng-model="guarantor_one" ng-change="getGuarantorInfoOne()"
                                class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled> -- Select Client --</option>
                            <?php foreach ($clientInfo as $key => $value) { ?>
                                <option value="<?php echo $value->code; ?>"><?php echo $value->code . ' - ' . $value->name; ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="previous_guarantor_one" ng-value="previous_guarantor_one"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group hide_column" ng-show="previous_client=='no'">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_name" class="form-control">
                    </div>
                </div>

                <div class="form-group hide_column">
                    <label class="col-md-3 control-label">Mobile<span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_mobile" ng-value="guarantor_mobile" class="form-control">
                    </div>
                </div>

                <div class="form-group hide_column">
                    <label class="col-md-3 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea name="guarantor_address" ng-bind="guarantor_address" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group hide_column">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-11 col-md-offset-1">
                                <h3 class="text-left" style="margin: 20px 0 0 0;">2<sup>nd</sup> Guarantor </h3>

                                <div style="margin-top: -30px;">
                                    <label class="col-md-4 control-label">&nbsp;Previous Client</label>
                                    <div class="col-md-5">
                                        <label class="radio-inline">
                                            <input type="radio" ng-model="previous_client2" value="yes"> Yes
                                        </label>

                                        <label class="radio-inline">
                                            <input type="radio" ng-model="previous_client2" value="no" checked
                                                   ng-click="removeGuarantorTwoData()"> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <hr style="margin: 10px 0 10px 0;">
                    </div>
                </div>

                <div class="form-group hide_column" ng-show="previous_client2=='yes'">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-5">
                        <select type="text" name="guarantor_code2"
                                ng-model="guarantor_two" ng-change="getGuarantorInfoTwo()"
                                class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled> -- Select Client --</option>
                            <?php foreach ($clientInfo as $key => $value) { ?>
                                <option value="<?php echo $value->code; ?>"><?php echo $value->code . ' - ' . $value->name; ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="previous_guarantor_two" ng-value="previous_guarantor_two"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group hide_column" ng-show="previous_client2=='no'">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_name2" class="form-control">
                    </div>
                </div>

                <div class="form-group hide_column">
                    <label class="col-md-3 control-label">Mobile<span class="req"></span></label>
                    <div class="col-md-5">
                        <input type="text" name="guarantor_mobile2" ng-value="guarantor_mobile2" class="form-control">
                    </div>
                </div>

                <div class="form-group hide_column">
                    <label class="col-md-3 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea name="guarantor_address2" ng-bind="guarantor_address2"
                                  class="form-control"></textarea>
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
                    <style>
                        #container {
                            width: 500px;
                            height: 375px;
                            border: 10px #333 solid;
                            position: relative;
                            overflow: hidden;
                            background: #666666;
                        }

                        #video {
                            width: 100%;
                            background-color: #666;
                            display: block;
                        }

                        .scale {
                            background: rgba(0, 0, 0, .5);
                            position: absolute;
                            width: 105px;
                            height: 100%;
                            top: 0;
                        }

                        .s-left {
                            left: 0;
                        }

                        .s-right {
                            right: 0;
                        }

                        .modal-header .close {
                            margin-top: -35px;
                        }
                    </style>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Photo <span class="req"></span></label>
                        <div class="col-md-5">
                            <input id="input-test" type="file" name="attachFile" class="form-control file"
                                   data-show-preview="false" data-show-upload="false" data-show-remove="false">
                        </div>
                        <!--input type="hidden" name="customer_photo_capture" />
                        <div class="col-md-1">
                            <a href="https://webcamtoy.com/" class="btn btn-primary" style="display:block;" target="__blank"><i class="fa fa-camera"></i></a>
                        </div-->
                    </div>


                    <div class="col-md-8">
                        <div class="btn-group pull-right">
                            <input type="submit" name="add" value="Save" class="btn btn-primary">
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>

            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>

    <div class="modal fade" id="camera">
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
                        <div class="col-md-8">
                            <div id="container">
                                <div class="scale s-left"></div>
                                <video autoplay="true" id="video"></video>
                                <div class="scale s-right"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!--p>Preview</p-->
                            <img src="https://placehold.it/200x200?text=Preview" id="image_preview"
                                 class="img-responsive img-thumbnail">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="clear_img" class="btn btn-warning">Clear</button>
                    <button type="button" id="capture" class="btn btn-primary">Capture</button>
                </div>
            </div>
        </div>
    </div>
    <audio id="cam_sound">
        <source src="<?php echo site_url("private/camera.mp3"); ?>" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>

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

    <script>
        var track;
        $('#camera').on('show.bs.modal', function (e) {
            //Streaming The video Start here
            var video = document.querySelector("#video");
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

            if (navigator.getUserMedia) {
                navigator.getUserMedia({video: true}, handleVideo, videoError);
            }

            function handleVideo(stream) {
                //video.src = window.URL.createObjectURL(stream);
                video.srcObject = stream;
                track = stream.getTracks()[0];
            }

            function videoError(e) {
                // do something
            }

            //Streaming The video End here    
        });

        $('#camera').on('hide.bs.modal', function (e) {
            track.stop();
        });
    </script>

    <script type="text/javascript">
        //Capturing The Image
        $(".hide_column2").hide();
        var video = $("#video").get(0);

        var captureImage = function () {
            var canvas = document.createElement("canvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            canvas.getContext('2d')
                .drawImage(video, 0, 0, canvas.width, canvas.height);

            //Cropping start here
            var crop_canvas = document.createElement("canvas");
            crop_canvas.width = 350;
            crop_canvas.height = 430;
            crop_canvas.getContext('2d')
                .drawImage(canvas, 140, 0, 360, 430, 0, 0, 360, 430);
            //document.body.append(crop_canvas);
            //Cropping end here
            var img_data = crop_canvas.toDataURL();
            $('input[name="customer_photo_capture"]').val(img_data);
            $("#image_preview").attr({src: img_data});
            document.getElementById("cam_sound").play();
        };

        $("#capture").click(captureImage);

        $("#clear_img").on("click", function () {
            $('input[name="customer_photo_capture"]').val("");
            $("#image_preview").attr({src: "https://placehold.it/200x200?text=Preview"});
        });

        $("#client_type").on("change", function () {
            clientType();
        });

        const clientType = () => {
            var client_type = $("#client_type").val();
            if (client_type == 'dealer') {
                $(".hide_column").hide();
                $(".hide_column2").show();
            } else {
                $(".hide_column").show();
                $(".hide_column2").hide();
            }
        }
        clientType();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
