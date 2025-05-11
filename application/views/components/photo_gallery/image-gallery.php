<style>
   .album-caption{
      display: block;
      float: left;
      width: 100%;
      padding: 0px 5px;
   }
   .album-caption h5,.album-caption h6{
    display: inline-block;
   }
   .album-caption h5{
    float: left;
    width: 150px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
   }
   .album-caption h6{
      float: right;
   }
   .right{
      position: relative;
      cursor: pointer;
   }
  .popup{
      position: absolute;
      display: none;
      right: -2px;
      min-width: 120px;
      border: 1px solid #ddd;
      background: #eee;
      margin-top: 5px;
  }
  .popup li{
      padding: 5px;
      display: block;
      text-align: right;
  }
  .popup li:hover{
      background: #ddd;
  }
  .popup li span{
      float: left;
      width: 25px;
  }

  .popup li i:nth-child(1){
      float: left;
  }
  .gallery figure img{
    height: 130px;
  }
</style>
<?php 
  if ($album_id!=null) {
    $allbum_info = $this->action->read("albums",array("id"=>$album_id));
    $title = $allbum_info[0]->album_title;
  }
?>
<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Photo Gallery</h1>
                </div>
            </div>

            <div class="panel-body">
               <div class="row">
                   <div class="col-sm-12">
                        <div id="sortable" class="gallery image-gallery">
                            <?php foreach ($gallery_data as $key => $gallery) { ?>
                                <figure id="id<?php echo $key+1; ?>" data-mainid="<?php echo $gallery->id; ?>" data-position="<?php echo $gallery->position; ?>">
                                    <img src="<?php echo site_url($gallery->gallery_path)?>" alt="" height="130px">
                                    <?php /*figcaption>
                                        <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this Data ?')" href="?delete_token=<?php echo $gallery->id; ?>"><?php echo caption('Delete');?></a>
                                    </figcaption*/ ?>
                                    <figcaption class="album-caption">
                                        <h5><?php echo $gallery->gallery_title; ?></h5>
                                        <h6 class="privacy">
                                            <span class="right">
                                                <i class="fa fa-gear" style="margin-right: 7px;"></i> <i class="fa fa-caret-down"></i>
                                                <ul class="popup">
                                                    <!--li class="edit" data-title="<?php echo $gallery->gallery_title; ?>" data-id="<?php echo $gallery->id; ?>"><i class="fa fa-pencil-square-o"></i> <?php echo "Change Title";//caption('Change_title'); ?> </li-->
                                                    <li><i class="fa fa-trash-o"></i> <a onclick="return confirm('Are you sure to delete this Data ?')" href="?delete_token=<?php echo $gallery->id; ?>"><?php echo "Delete";//caption('Delete');?></a></li>
                                                </ul>
                                            </span>
                                        </h6>
                                    </figcaption>
                                </figure>
                            <?php } ?>
                        </div>
                   </div>
               </div>
                
                
                <hr>

                <!-- horizontal form -->
                    
                <div class="col-xs-12 no-padding">
                    <?php
                    $attr=array(
                        "class"=>"form-horizontal"
                        );
                    echo form_open_multipart('', $attr);?>
                    <div id="dyn_form">
                        <!--div class="form-group">
                            <label class="col-md-2 control-label">Title <span class="req">*</span></label>
                            <div class="col-md-5">
                                <input type="text" name="galleryTitle[]" class="form-control file" required placeholder="Maximum_100_Character">
                            </div>
                        </div-->
                        <input type="hidden" name="galleryTitle[]" value="Image">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Image <span class="req">*</span></label>
                            <div class="col-md-5">
                                <input id="" type="file" name="gallery_image[]" required class="form-control file" data-show-preview="false" required data-show-upload="false" data-show-remove="false">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <a id="addmore_btn" class="btn btn-success" href="" style="margin-right: 5px;">Add More</a>
                        <input type="submit" name="gallery_Save" value="Save" class="btn btn-primary">
                    </div>
                    </div>

                <?php form_close();?>
                </div>
                
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

   <script>
    $( function() {
    $("#sortable").disableSelection();
    (function($) {
        var sortObj = {};

        $('#sortable').sortable({
            revert:true,
            cursor: "move",
            distance: 5,
            opacity: 0.8,
            stop: function(e, ui) {

                $.map($(this).find('figure'), function(el) {
                  var index = parseInt($(el).index()) + 1;
                  sortObj[$("#"+el.id).data('mainid')] = index;
                });

                //console.log(JSON.stringify(sortObj));
                var final_data=JSON.stringify(sortObj);

              $.ajax({
                  type: "POST",
                  url: "<?php echo site_url('photo_gallery/photo_gallery/ajax_img_sort'); ?>",
                  data: {finaldata:final_data}
                }).done(function(response){
                  console.log(response);
            });
                /*Sending Ajax Data End here*/
            }
        });
    })(jQuery);
  });

//===========================================================================
//==========================Add More start here==============================
//===========================================================================
  
$("#addmore_btn").on('click', function(event) {
  $("#dyn_form").after($("#dyn_form").html());
  event.preventDefault();
});
//===========================================================================
//===========================Add More end here===============================
//===========================================================================

//Setting Start here-----------------
  $(document).ready(function(){
    $(".privacy").on('click', function() {
      $(this).find(".popup").slideToggle();
    });

    //Editing title start here
    $(".edit").on('click', function() {
      var img_id=$(this).data('id');
      var img_title = $(this).data('title');
      var element_me=$(this);
      var edit_data=prompt("Enter new image title",img_title);
      if (edit_data!=null){

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('photo_gallery/photo_gallery/ajax_img_edit'); ?>",
            data: {id:img_id,title:edit_data}
          }).done(function(response){
            console.log(response);
            if (response=="success") {
              element_me.parents(".privacy").siblings('h5').html(edit_data);
              element_me.data('title', edit_data);
            }
        });
      }
    });
    //Editing title end here
  });
//Setting End here-----------------
  </script>