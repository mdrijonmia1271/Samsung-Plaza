<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("theme_menu","logo")){ ?>
		<a href="<?php echo site_url('theme/themeSetting'); ?>" class="btn btn-default" id="logo">
			 Banner / Icon
		</a>
		<?php } ?>
		
		<?php if(ck_action("theme_menu","tools")){ ?>
		<a href="<?php echo site_url('theme/themeSetting/theme_tools'); ?>" class="btn btn-default" id="tools">
			Theme Tools
		</a>
		<?php } ?>
		
        <!--<a href="<?php //echo site_url('theme/themeSetting/theme_basic'); ?>" class="btn btn-default" id="basic">
			Basic Option
		</a> -->
    </div>
</div>
