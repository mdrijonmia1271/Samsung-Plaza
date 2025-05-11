<div class="container-fluid">
    <div class="row">
        <!-- horizontal form -->
        <?php
        echo $confirmation;

        $attribute = array(
            'class' => 'form-horizontal'
        );

        echo form_open_multipart('', $attribute);
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Create New Profile</h1>
                </div>
            </div>

            <div class="panel-body no-padding">

            <div class="no-title">&nbsp;</div>
                <!-- left side -->
                <aside class="col-md-3">
                    <img id="img-view" src="<?php echo site_url("public/profiles/demo2017.jpg"); ?>" alt="Photo not found!" class="img-responsive img-thumbnail" style="width: 100%;">

                    <div class="profile-upload">
                        <label class="btn btn-primary" style="display: block;" for="img-input"><i class="fa fa-cloud-upload"></i> Upload</label>
                        <input type="file" name="image"  id="img-input" style="display: none;">
                    </div>
                    <br/>
                </aside>

                <div class="col-md-9">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Full Name</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="f_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Mobile Number</label>
                        <div class="col-md-7">
                            <input type="text" name="mobile" class="form-control">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Email</label>
                        <div class="col-md-7">
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Username </label>
                        <div class="col-md-7">
                            <input type="text" name="username" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Password</label>
                        <div class="col-md-7">
                            <input class="form-control" type="password" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Confirm Password</label>
                        <div class="col-md-7">
                            <input class="form-control" type="password" name="confirmPassword">
                        </div>
                    </div>
                    
                   <?php 
                   
                   $user = get_row('users', ['privilege' => 'super']);
                   if(!empty($user)){ ?>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Showroom</label>
                            <div class="col-md-7">
                                <select name="branch" class="form-control">
                                    <option value="">-- Select --</option>
                                    <!--<option value="godown">Head Office</option>-->
                                    <?php 
                                    if(!empty($showroomInfo)) {
                                        foreach ($showroomInfo as $key => $row) { ?>
                                            <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                                        <?php } 
                                    } ?>
                                </select>
                            </div>
                        </div>
                   <?php } ?>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Privilege</label>
                        <div class="col-md-7">
                            <select name="privilege" class="form-control">
                                <option value="">-- Select --</option>
                                <?php 
                                if(!empty($user)){
                                    if($this->data['privilege'] == 'super') { ?>
                                        <option value="super">Super Admin</option>
                                    <?php } 
                                }else{ ?>
                                <option value="super">Super Admin</option>
                                <?php } ?>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-primary" type="submit" name="createProfileBtn" value="Save">
                                <input class="btn btn-danger" type="reset" value="Clear">
                            </div>
                        </div>
                        <!--div class="col-sm-2 col-xs-2"></div-->
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var reader  = new FileReader();

        $("#img-input").change(function(ev) {
            var file = ev.target.files[0];

            if(file) { reader.readAsDataURL(file); }

            $(reader).load(function() {
                var imgURL = reader.result;

                $("#img-view").attr({ src: imgURL });
            });
        });
    });
</script>
