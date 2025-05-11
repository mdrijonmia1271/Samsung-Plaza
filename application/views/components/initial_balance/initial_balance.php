<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}

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

        .title{
            font-size: 25px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Initial Balance</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                 <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open_multipart('', $attr);
                ?>

                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <h4 class="text-center hide" style="margin-top: 0px;">Initial Balance</h4>

                <div class="row">
                   <div class="form-group">
                        <label class="col-md-2 control-label">Initial Balance </label>
                        <div class="col-md-5">
                            <input type="text" value="<?php if(count($balance)) echo $balance[0]->meta_value; ?>" name="initial_balance" class="form-control" />
                        </div>
                    </div>

                     <div class="col-md-7">
                        <div class="btn-group pull-right">
                            <?php if(count($balance)){ ?>
                            <input type="submit" value="Update" name="update" class="btn btn-primary" />
                            <?php }else{ ?>
                            <input type="submit" value="Save" name="save" class="btn btn-primary" />
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="text-center">Initial Balance</h1>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-offset-3 col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th class="active" width="200">Initial Balance</th>
                            <td><?php if(count($balance)) echo f_number($balance[0]->meta_value); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
