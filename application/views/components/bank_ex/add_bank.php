<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Bank</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->

                <?php
	                $attr=array('class'=>'form-horizontal');
	                echo form_open('',$attr);
                ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="bank_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="btn-group pull-right">
                            <input type="submit" value="Save" name="add_bank" class="btn btn-primary">
                        </div>
                    </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php if($all_bank != NULL){ ?>
         <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Banks</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> <?php echo 'Print';?></a>
                </div>
            </div>
            
            <div class="panel-body">
            
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="65">SL </th>
                            <th width="150">Date</th>
                            <th>Bank Name </th>
                            <th width="60">Action</th>
                        </tr>
                        <?php foreach($all_bank as $key => $bank){?>
                        <tr>
                            <td> <?php echo $key+1; ?> </td>
                            <td> <?php echo $bank->date; ?> </td>
                            <td> <?php echo str_replace("_"," ",$bank->bank_name); ?>  </td>
                            
                            <td class="none">                          
                                    <a class="btn btn-danger" onclick="return confirm('Are You Sure Want To Delete This Data ?');" href="?id=<?php echo $bank->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
