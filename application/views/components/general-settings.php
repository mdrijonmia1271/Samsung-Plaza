<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">General Settings</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
				echo $this->session->flashdata('confirmation');
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>

				<div class="form-group">
					<label for="" class="col-md-2">MD Mobile</label>
					<div class="col-md-5">
						<input type="text" name="meta[md_mobile]" class="form-control" value="<?php echo getSiteMeta('md_mobile'); ?>" required>
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-md-2">Director Mobile</label>
					<div class="col-md-5">
						<input type="text" name="meta[director_mobile]" class="form-control" value="<?php echo getSiteMeta('director_mobile'); ?>" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-7">
						<input type="submit" name="save" value="Save" class="btn btn-success pull-right">
					</div>
				</div>

				<?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
