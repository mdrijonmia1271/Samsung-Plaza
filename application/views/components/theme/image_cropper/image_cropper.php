<style type="text/css" media="screen">
	.image-cropper img{
		width: 100%;
		height: 452px;
	}
	.input-group{
		width: 49%;
		float: left;
		margin-bottom: 10px;
	}
	.input-float{
		float: right;
	}
	.resize{
		width: 100%;
		height: 380px;
		overflow-y: auto;
	}
	.resize img{
		width: 100%;
		height: 111px;
		margin: 8px 0px;
	}
	.area{
		width: 100%;
		border: 1px solid #ccc;
		padding: 10px;
	}
	.area .btn-default{ 
		padding: 8px 20px;
		margin-right: 10px;
	 }
	 @media screen and (max-width: 992px){ 
	 	.image-cropper{
	 		margin-bottom: 20px;
	 	}
	  }
	  @media screen and (max-width: 767px){ 
	  	.area .btn-default{
	  		margin-bottom: 10px;
	  	}
	  }
	  

</style>

<!--Image Cropper Strart-->
<div class="row"> 

	<div class="col-md-9"> 

		<div class="image-cropper"> 
			<img class="main_img" src="http://placehold.it/180x180"alt="">
		</div>

	</div>

	<div class="col-md-3"> 

		<div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataX">X</label>
            <input class="form-control" id="dataX" placeholder="x" type="text">
            <span class="input-group-addon">px</span>
	    </div>

    	<div class="input-group input-group-sm input-float">
            <label class="input-group-addon" for="dataX">Y</label>
            <input class="form-control" id="dataX" placeholder="x" type="text">
            <span class="input-group-addon">px</span>
    	</div>

    	<div class="input-group input-group-sm">
            <label class="input-group-addon" for="dataX">W</label>
            <input class="form-control" id="dataX" placeholder="x" type="text">
            <span class="input-group-addon">px</span>
	    </div>

    	<div class="input-group input-group-sm input-float">
            <label class="input-group-addon" for="dataX">H</label>
            <input class="form-control" id="dataX" placeholder="x" type="text">
            <span class="input-group-addon">px</span>
    	</div>

    	<div class="resize">
    		<?php foreach ($slider_data as $key => $slider) { ?>
    		<img class="img-thumbnail thumb_image" src="<?php echo site_url($slider->slider_path);?>" alt="Not Found">
    		<?php } ?>
    	</div>
		
	</div>

</div>


	<div class="row"> 

		<div class="col-md-12"> 

			<div class="area">
				<a href="#" class="btn btn-default" title="">Save</a>
				<a href="#" class="btn btn-default" title="">Save</a>
				<a href="#" class="btn btn-default" title="">Save</a>
				<a href="#" class="btn btn-default" title="">Save</a>
				<a href="#" class="btn btn-default" title="">Save</a>

			</div>

		</div>

	</div>


<!--Image Cropper ende-->
<script type="text/javascript">
	$(document).ready(function(){
		$('.thumb_image').on('click', function(){
			var this_img=$(this).attr('src')
			$('.main_img').attr('src',this_img);
		});
	});
</script>