
<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Banner</h1>
                </div>
            </div>

            <div class="panel-body">

                <div class="col-md-12">
                   <?php 
                        if(!empty($banner_info)) {
                            foreach($banner_info as $banner){
                                $showroom = $this->action->read('godowns',array('code' => $banner->godown_code));
                                echo '<h3>'.$showroom[0]->name.'</h3>';
                                echo'<img width="100%"  src="'.base_url($banner->path).'" />';
                            }
                        }
                    ?>
                </div>
                <h1>&nbsp;</h1>

               <?php
                   $attribute=array(
                        "name"=>"",
                        "class"=>"form-horizontal"
                    );
                    echo form_open_multipart("banner/banner",$attribute);
                ?>
                    <div class="col-md-12">
	            		<div class="form-group">
						    <label class="col-md-4 control-label">Showroom</label>
						     <?php 
						        $godowns = $this->action->read('godowns',array('trash' => 0));
						        
						     ?>
                            <div class="col-md-5">
                                <select name="godown_code"   class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  required >
                                    <option value="">-- Select Show Room --</option>
                                     <?php foreach($godowns as $godown){ ?>
                                        <option value="<?php echo $godown->code; ?>" <?php echo ($this->data['branch'] == $godown->code) ? 'selected' : ''; ?>>
                                            <?php echo $godown->name; ?>
                                        </option>
                                     <?php } ?>
                                </select>
                            </div>						     
						</div>     
					</div>


                    <div class="col-md-12">
	            		<div class="form-group">
                            <label class="col-md-4 control-label">Upload Banner Size(795 x 150)<span class="req">*</span></label>
        
                            <div class="col-md-5">
                                <input id="input-test" type="file" name="banner_image" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false" required>
                            </div>
        
                            <input type="hidden" name="banner_id" value="<?php if($banner_info!=null) { echo $banner_info[0]->id;}?>">
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="btn-group pull-right">
                            <input type="submit" name="banner_save" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                </div> 
                <?php echo form_close(); ?>
                <div class="panel-footer">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
