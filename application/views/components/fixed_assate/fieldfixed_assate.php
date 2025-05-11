<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

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
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
</style>
<div class="container-fluid block-hide">
    <div class="row">

    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
    $attribute = array(
        'name' => '',
        'class' => 'form-horizontal',
        'id' => ''
    );
    echo form_open('fixed_assate/fixed_assate/add', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Field of Fixed Assate</h1>
                </div>
            </div>

            <div class="panel-body no-padding none">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">                                
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Fixed Assate </label>
                        <div class="col-md-7">
                            <input type="text" name="field_fixed_assate" class="form-control" autocomplete="off">
                        </div>
                        <div>
                            <div class="btn-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Save">
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

<div class="container-fluid" >
    <div class="row" ng-controller="fixed_assateCtrl" ng-cloak>
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Field of Fixed Assate</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
            <!-- Print banner -->
            <?php //$this->load->view('components/print'); ?>
            <h4 class="text-center hide">Field Of Fixed Asset</h4>
            <table class="table table-bordered">
                <tr>
                    <th width="55" >SL</th>
                    <th>Field of Fixed Assate </th>
                    <th style="text-align:center; width: 115px;" class="block-hide">Action</th>
                </tr>
                <?php if($fixed_asset_filed){ foreach($fixed_asset_filed as $key => $value){ ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo filter($value->field_fixed_assate); ?></td>
                    <td class="none text-center" >                        
                        <a title="Edit" class="btn btn-warning" onclick="getFieldName('<?php echo $value->id;?>', '<?php echo $value->field_fixed_assate;?>')" data-toggle="modal" data-target="#myModal" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Field of Fixed Assate?');" href="<?php echo site_url('fixed_assate/fixed_assate/delete_field/'.$value->id); ?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php }} ?>
            </table>
             <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>
            
            <!--Modal section start here-->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Field Name</h4>
                  </div>
                    <div class="modal-body">
                        <div class="row">
                        <?php
                            $attr = array('class' => 'form-horizontal');
                            echo form_open('', $attr);
                        ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Field Name <span class="req"> *</span></label>
                                <div class="col-md-7">
                                    <input type="hidden" name="id" id="fieldId" class="form-control" >
                                    <input type="text" name="new_name" id="fieldName" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="btn-group pull-right">
                                    <input type="submit" value="Update" name="update" class="btn btn-info">
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <!--Modal section end here-->
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    function getFieldName(id, value){
        fieldId.value = id;
        fieldName.value = value;
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

