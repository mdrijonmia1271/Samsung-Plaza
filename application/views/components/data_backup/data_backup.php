<style>
	.data-table th{
		background: #ccc;
	}
</style>
<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Export Data</h1>
                </div>
            </div>

            <div class="panel-body">

                <!--blockquote class="form-head">

                    <h4>Add New Employee</h4>

                    <ol style="font-size: 14px;">
                        <li>1. Fill all the required <mark>*</mark> fields</li>
                        <li>2. Click the <mark>Save</mark> button to Save data</li>
                    </ol>

                </blockquote>

                <hr-->

      		
               <div class="row">
               		<div class="col-md-2">
				<?php echo form_open(); ?>
                
		                    <div class="btn-group">
		                        <input style="margin-bottom: 15px;" name="export" class="btn btn-primary" type="submit" value="Export All Data" class="btn btn-primary">
		                    </div>
		                    
		
		                <?php echo form_close(); ?>
               		</div>
               		
               		<div class="col-md-10">
               			<table class="table table-bordered data-table">
               				<tr>
               					<th>SL</th>
               					<th>Download Data</th>
               					<th>Delete</th>
               				</tr>
               				<?php foreach ($database_list as $key => $data_list) { ?>
               				<tr>
               					<td><?php echo $key+1; ?></td>
               					<td><a href="<?php echo base_url($data_list); ?>" download>Download <?php $name=explode("/", $data_list); echo $name[2]; ?></a></td>
               					<td style="width: 70px">
               					     <?php 
                                        $privilege = $this->data['privilege'];
                                        if($privilege != 'user'){
                                    ?>
               					        <a href="?delete_token=<?php echo $data_list; ?>" class="btn btn-danger" onclick="return confirm('Do you want to delete this Database? ');">Delete</a></td>
               				        <?php }?>
               				</tr>
               				<?php }?>
               			</table>
               		</div>
               </div>
                
                

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

