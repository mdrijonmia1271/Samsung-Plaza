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
     <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                   <h1>Edit Showroom</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- category form start -->
                <?php  $attr=array('class' =>'form-horizontal');
                echo form_open(base_url('showroom/showroom/editShowroom/'.$s_id), $attr);?>

                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">ID  </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="showroom_id" value="<?php echo $info[0]->showroom_id; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Showroom Name  </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="name" class="form-control" value="<?php echo $info[0]->name; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Manager </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="supervisor" class="form-control" value="<?php echo $info[0]->supervisor; ?>">
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                    $types = array();
                    foreach ($info as $value) {
                        $types[] = $value->type;
                    }
                ?>

                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Type </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row" style="height: 132px; overflow: auto;">
                                <?php
                                $type = config_item('showroom_type');
                                foreach ($type as $key => $value) { ?>
                                <label class="checkbox-inline custom-label">
                                  <input <?php if(in_array($value, $types)){echo "checked";} ?> type="checkbox" name="type[]" value="<?php echo $value; ?>"> <?php echo $value; ?>
                                </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Mobile Number </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="contact_number" class="form-control" value="<?php echo $info[0]->mobile; ?>">
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
                                    <input type="number" name="balance" class="form-control" min="0" step="any" value="<?php echo $info[0]->balance; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Address </label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <textarea name="address" rows="4" class="form-control" style="height: 83px !important;"><?php echo $info[0]->address; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="row btn-group pull-right">
                                <input type="submit" name="update" value="Update" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>


               <?php  echo form_close();?>
                <!-- category form end -->
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
