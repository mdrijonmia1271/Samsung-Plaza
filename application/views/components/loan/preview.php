<style>
    @media print{
        aside, nav, .panel-heading, .panel-footer, .none{
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
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Loan Preview</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
                
                <h3 class="text-center hide" style="margin-top: 0px;">Loan Information</h3>

                <table class="table table-striped">
                    <?php
                    if ($allInfo != null) {
                    foreach ($allInfo[0] as $key => $value){
                    if ($value != null && $key != "id") {
                    ?>
                        <tr>
                            <th width="30%"><?php echo filter($key) ; ?></th>
                            <td><?php echo filter($value); ?></td>
                        </tr>
                    <?php }}} ?>

                </table>

            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
