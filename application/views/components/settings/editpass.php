<div class="container-fluid">
    <div class="row">
    <?php
    echo $confirmation;
    $attribute = array('class' => 'form-horizontal');
    echo form_open_multipart('', $attribute);
    ?>
        <input type="hidden" name="img_url" value="<?php echo $profile[0]->image; ?>">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Password</h1>
                </div>
            </div>

            <div class="panel-body">

            <h2 style="padding: 0 15px; margin: 15px 0;">
                Profile: <strong><?php echo $profile[0]->name; ?></strong>
            </h2>
            <br>

                <!-- left side -->
                <aside class="col-md-3">
                    <img id="img-view" src="<?php echo site_url($profile[0]->image); ?>" alt="Photo not found!" class="img-responsive img-thumbnail" style="width: 100%;">
                </aside>


                <div class="col-md-9">

                    <div class="form-group">
                        <label for="" class="col-sm-3 col-xs-12 control-label">Full Name </label>
                        <div class="col-sm-7 col-xs-10">
                            <input type="text" name="f_name" class="form-control"  value="<?php echo $profile[0]->name; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 col-xs-12 control-label">User Name </label>
                        <div class="col-sm-7 col-xs-10">
                            <input type="text" name="username" value="<?php echo $profile[0]->username; ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 col-xs-12 control-label">Password </label>
                        <div class="col-sm-7 col-xs-10">
                            <input type="text" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label"></label>
                        <div class="col-sm-7 col-xs-10">
                            <div class="btn-group pull-right">
                                <input class="btn btn-success" type="submit" name="update" value="Update">
                            </div>
                        </div>
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
            var file=ev.target.files[0];
            if (file) {
                reader.readAsDataURL(file);
            }
            $(reader).load(function() {
                var imgURL=reader.result;
                $("#img-view").attr({
                    src: imgURL
                });
            });
        });
    });
</script>
