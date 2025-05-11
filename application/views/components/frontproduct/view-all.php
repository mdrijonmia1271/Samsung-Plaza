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
        <div class="panel panel-default" id="data">
            
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Product</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

        
            <div ng-cloak class="panel-body"">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">
               
                <h4 class="hide text-center" style="margin-top: 0px;">All Product</h4>

                <div class="row none" style="margin-bottom:15px;">
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 35px;"> SL </th>
                        <th>Category</th>
                        <th>Image</th>
                        <th class="none"> Action </th>
                    </tr>    
                    <?php foreach ($products as $key => $value) { ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->category; ?></td>
                        <td><img width="100" src="<?php echo site_url($value->image); ?>" alt=""></td>
                        <td class="none" style="width: 115px;">
                            <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure want to delete this Product?');" href="<?php echo site_url("frontproduct/product/delete/".$value->id); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>                                   
                    <?php } ?>
                </table>
                
               </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

