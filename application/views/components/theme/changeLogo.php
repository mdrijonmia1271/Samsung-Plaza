<div class="container-fluid">
    <div class="">
        <?php 
        	echo $confirmation; 
        	$logo = null;
        	$menu_icon = null;
            if (isset($meta->logo)) {
            	$logo=json_decode($meta->logo,true);
            }
            if (isset($meta->menu_icon)) {
            	$menu_icon=json_decode($meta->menu_icon,true);
            }
		?>
        <!-- ================================================================================ -->
        <!-- =============================Change Logo start here============================= -->
        <!-- ================================================================================ -->
        <!-- <div class="panel panel-default">
        
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Change Logo</h1>
                </div>
            </div>
        
            <div class="panel-body">
            
        	        	<div class="row">
        	        		<div class="col-xs-12">
        	        			<div class="col-md-4">
        			        		<figure>
        			        			<img src="<?php echo site_url($logo['logo']); ?>" alt="Image not found!" style="width: 150px; height: 150px; display: block; margin: 0 auto;">
        			        			<figcaption></figcaption>
        			        		</figure>
        			        	</div>
        
        
        			        	<div class="col-md-6">
        
        	        		<?php
        		        		$attr=array(
        							"class"=>"form-horizontal"
        		        		);
        		        		echo form_open_multipart('', $attr);
        	        		?>
        	        					<input type="hidden" value="<?php echo $logo['faveicon']; ?>" name="faveicon" />
        	        					<input type="hidden" value="<?php echo $logo['logo']; ?>" name="old_logo" />
        			            		<div class="form-group">
        								    <label class=" control-label" style="line-height: 4;">Logo</label>
        								    <input id="input-test" type="file" name="attachFile" class="form-control file" data-show-preview="false" data-show-upload="false" required data-show-remove="false">
        								</div>
        			                   
        			        <?php
                        $value='Save';
                        $name="submit_logo";
                        $class="btn-primary";
        
                        if ($logo!=null) {
                            $value= 'Update';
                            $name="update_logo";
                            $class="btn-success";
                        }
                    ?>
                    <div class="row">
        	                    <div class="btn-group pull-right">
        	                        <input type="submit" value="<?php echo $value; ?>" name="<?php echo $name; ?>" class="btn <?php echo $class; ?>">
        	                    </div>
                    </div>
                <?php echo form_close(); ?>
        			        	</div>
        	        		</div>
        	        	</div>
        	                  
        	        </div>
        
            <div class="panel-footer">&nbsp;</div>
        </div> -->
        <!-- ================================================================================ -->
        <!-- =============================Change Logo start here============================= -->
        <!-- ================================================================================ -->

        <!-- ================================================================================ -->
        <!-- ===========================Change Faveicon start here=========================== -->
        <!-- ================================================================================ -->

        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Change Faveicon</h1>
                </div>
            </div>

            <div class="panel-body">
            
	        	<div class="row">
	        		<div class="col-xs-12">
	        			<div class="col-md-4">
			        		<figure>
			        			<img src="<?php echo site_url($logo['faveicon']); ?>" alt="Image not found!" style="width: 150px; height: 150px; display: block; margin: 0 auto;">
			        			<figcaption></figcaption>
			        		</figure>
			        	</div>


			        	<div class="col-md-6">

	        		<?php
		        		$attr=array(
							"class"=>"form-horizontal"
		        		);
		        		echo form_open_multipart('', $attr);
	        		?>
	        					<input type="hidden" value="<?php echo $logo['logo']; ?>" name="logo" />
	        					<input type="hidden" value="<?php echo $logo['faveicon']; ?>" name="old_faveicon" />
			            		<div class="form-group">
								    <label class=" control-label" style="line-height: 4;">Faveicon</label>
								    <input id="input-test" type="file" name="attachFile" class="form-control file" data-show-preview="false" data-show-upload="false" required data-show-remove="false">
								</div>
			                   
			        <?php
                        $value='Save';
                        $name="submit_fevicon";
                        $class="btn-primary";

                        if ($logo!=null) {
                            $value='Update';
                            $name="update_fevicon";
                            $class="btn-success";
                        }
                    ?>
                    <div class="row">
	                    <div class="btn-group pull-right">
	                        <input type="submit" value="<?php echo $value; ?>" name="<?php echo $name; ?>" class="btn <?php echo $class; ?>">
	                    </div>
                    </div>
                <?php echo form_close(); ?>
			        	</div>
	        		</div>
	        	</div>
	                  
	        </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <!-- ================================================================================ -->
        <!-- ===========================Change Faveicon end here============================= -->
        <!-- ================================================================================ -->


<?php /*
        <!-- ================================================================================ -->
        <!-- ==========================Change Menu Icon start here=========================== -->
        <!-- ================================================================================ -->
	    <?php
	        $value='Save';
	        $name="submit_menu_icon";
	        $class="btn-primary";

	        if ($menu_icon != null) {
	            $value='Update';
	            $name="update_menu_icon";
	            $class="btn-success";
	        }
	    ?>
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Menu_Icon</h1>
                </div>
            </div>

            <div class="panel-body">
            
	        	<div class="row">
        			<?php
		        		$attr=array(
							"class"=>"form-horizontal"
		        		);
		        		echo form_open_multipart('', $attr);
	        		?>
	        		<div class="col-xs-12">
			        	<div class="col-md-6">
		                    <div class="form-group">
		                        <label class=" col-md-4 control-label">A Side Menu <span class="req"><i class="<?php echo $menu_icon['aside_menu'];?>"></i></span></label>
		                        <div class="col-md-8">
		                            <input type="text" value="<?php echo $menu_icon['aside_menu'];?>" placeholder="Only Fontawesome Class name here" name="aside_menu" class="form-control">
		                        </div>
		                    </div>
			        	</div>
			        	<div class="col-md-6">
		                    <div class="form-group">
		                        <label class=" col-md-4 control-label">Footer_Menu<span class="req"><i class="<?php echo $menu_icon['footer_menu'];?>"></i></span></label>
		                        <div class="col-md-8">
		                            <input type="text" value="<?php echo $menu_icon['footer_menu'];?>" placeholder="Only Fontawesome Class name here" name="footer_menu" class="form-control">
		                        </div>
		                    </div>
				                   
		                    <div class="btn-group pull-right">
		                        <input type="submit" value="<?php echo $value; ?>" name="<?php echo $name; ?>" class="btn <?php echo $class; ?>">
		                    </div>
			        	</div>
	        		</div>
	        		<?php echo form_close(); ?>
	        	</div>
	                  
	        </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <!-- ================================================================================ -->
        <!-- ==========================Change Menu Icon end here============================= -->
        <!-- ================================================================================ -->

        */ ?>
    </div>
</div>