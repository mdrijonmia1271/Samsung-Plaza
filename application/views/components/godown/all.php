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
        .panel .hide{
            display: block !important;
        }
    }
</style>

<div class="container-fluid">
    <?php echo $this->session->flashdata('confirmation'); ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">All Showroom </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i>Print</a>
                </div>
            </div>

            <div class="panel-body">
                
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
                
                <h4 class="text-center hide" style="margin-top: -10px;">All Showroom </h4>
                
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="55">SL</th>
                        <th>Name</th>
                        <th>Manager</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Prefix</th>
                        <th width="110" class="none">Action</th>
                    </tr>
                    <?php foreach ($godown as $key => $value) { ?>
                    <tr>
                        <td> <?php echo $key+1 ?> </td>
                        <td> <?php echo $value->name; ?> </td>
                        <td> <?php echo $value->manager; ?> </td>
                        <td> <?php echo $value->mobile; ?> </td>
                        <td> <?php echo $value->address; ?> </td>
                        <td> <?php echo $value->prefix; ?> </td>
                        <td class="none">
                            
                            <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                            ?>
                                <a class="btn btn-warning" href="<?php echo site_url('godown/godown/edit/'.$value->id); ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
    
                                <a class="btn btn-danger" onclick="return confirm('Are you sure delete this data!')" href="<?php echo site_url('godown/godown/delete/'.$value->id); ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            <?php  } ?>    
                            
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

