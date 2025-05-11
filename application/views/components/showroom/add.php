<style>
    .text-right{
        text-align: right;
        display: block;
    }
    @media screen and (max-width: 992px){
        .text-right{text-align: left !important;}
        .pull-right{float: left !important;}
    }
    .custom-label{
        margin-left: 0px !important;
        margin-right: 10px;
    }
</style>

<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Add New Showroom </h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
                $attr = array('class' =>'form-horizontal');
	            echo form_open('showroom/showroom/addShowroom',$attr); ?>

                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">ID <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="showroom_id" value="<?php echo $showroom_id; ?>" class="form-control" readonly  required pattern="[A-Za-z0-9]{4}">
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Showroom Name <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Manager <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="supervisor" class="form-control" repuired>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Type <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row" style="height: 132px; overflow: auto;">
                                <?php
                                $type = config_item('showroom_type');
                                foreach ($type as $key => $value) { ?>
                                <label class="checkbox-inline custom-label">
                                  <input type="checkbox" name="type[]" value="<?php echo $value; ?>"> <?php echo $value; ?>
                                </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Mobile Number <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="contact_number" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Opening Balance <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="input-group">
                                    <div class="input-group-addon">৳</div>
                                    <input type="number" name="balance" class="form-control" min="0" step="any">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Address <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <textarea name="address" rows="4" class="form-control" style="height: 83px !important;" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="row btn-group pull-right">
                                <input type="submit" name="save" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
