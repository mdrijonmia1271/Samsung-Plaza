<style>
    .text-right{
        text-align: right;
        display: block;
    }
    @media screen and (max-width: 992px){
        .text-right{text-align: left !important;}
        .pull-right{float: left !important;}
    }
    .custom-label{
        margin-left: 0px !important;
        margin-right: 10px;
    }
</style>

<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Add Head Office Balance </h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
                $attr = array('class' =>'form-horizontal');
	            echo form_open('',$attr); ?>

                <div class="col-md-6">        
		  <div class="row form-group">
                        <div class="col-md-4">
                            <label class="row control-label text-right">Opening Balance <span class="req">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="input-group">
                                    <div class="input-group-addon">৳</div>
                                    <input type="number" name="balance" required class="form-control" min="0" step="any">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row form-group">
                        <div class="col-md-12">
                            <div class="row btn-group pull-right">
                                <input type="submit" name="save" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
              	   </div>             
		 <?php echo form_close(); ?>
               </div>              
                <h3>Opening Balance : ৳ <?php echo f_number($openingBalance); ?></h3>             
            <div class="panel-footer">&nbsp;</div>           
        </div>
    </div>
</div>
