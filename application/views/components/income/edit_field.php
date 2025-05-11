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
        .block-hide{
            display: none;
        }
    }
</style>


<div class="container-fluid block-hide">
    <div class="row">

    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
    $attribute = array( 'name' => '', 'class' => 'form-horizontal', 'id' => '' );
    echo form_open('income/income/edit_field/'.$fields[0]->id, $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Field Of Income</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Income </label>
                        <div class="col-md-7">
                            <input type="text" name="field" class="form-control" value="<?php echo filter($fields[0]->field); ?>" placeholder="Enter maximum 100 characters">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-3">
                        <div class="btn-group pull-right">
                            <input class="btn btn-danger" type="reset" value="Clear">
                            <input class="btn btn-primary" type="submit" name="update" value="Update">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>




