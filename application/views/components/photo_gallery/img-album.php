<style>
    .add-album {
        height: 190px;        
        border: 3px dashed #ddd;
        width: 195px;
        float: left;
        margin: 5px;
    }

    .add-album figcaption{
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;        
    }
    .add-album figcaption:hover{
        background: #ddd;
    }

    .add-album figcaption i{
        font-size: 30px;
    }

     .add-album figcaption h3:hover{
        text-decoration: underline;
     }
    
    .album-item{
        height: 190px;
    } 

    
  .gallery figure.album-item{
    padding: 3px;    
  }
  .gallery figure.album-item img{
    width: 50%;
    height: 65px;
    margin-bottom: 0px; 
    float: left;
    border: none;
  }

   .album-caption{
      display: block;
      float: left;
      width: 100%;
      padding: 0px 5px;
   }
   .album-caption h5{}
   .album-caption h6{
   }
   .album-caption h6 .right{
      float: right;
      display: block;
   }
   .right{
      position: relative;
      cursor: pointer;
   }
  .popup{
      position: absolute;
      display: none;
      right: -8px;
      width: 100px;
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

  .popup li span i:nth-child(1){
      float: left;
  }



  .light-box-form{
    max-width: 500px;
    width: 100%;
    margin: auto;
  }
  .light-box-form input,.light-box-form textarea,.light-box-form select{
    display: block;
    width: 100%;
    color: #000;
    padding: 8px 8px;
    margin: 5px 0px;
  }

  .light-box-form input[type="submit"]{
    width: 120px;
    background: none;
    border: 1px solid #ddd;
  } 

  .light-box-form input[type="submit"]:hover{
    
    background: #000;
    color: #fff;
    border: 1px solid #000;
  }

  .crop-content {
  max-width: 550px;  
  box-shadow: 0px 0px 10px #000; 
  padding: 20px 0;
}










</style>
<div class="container-fluid">
    <div class="row">
      <?php echo $confirmation; ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1><?php echo "Album"; //caption('photoGallery');?></h1>
                </div>
            </div>

            <div class="panel-body">
               <div class="row">
                   <div class="col-sm-12">
                      <figure id="add-album" class="add-album" data-mainid="" data-position="">
                          <figcaption>
                              <i class="fa fa-plus" style="display: block"></i>
                              <h3>Create Album</h3>
                          </figcaption>
                      </figure>
                        <div id="sortable" class="gallery image-gallery">
                        <?php
                          function img_fetch($var,$off,$field){
                              if (isset($var[$off])) {
                                  return $var[$off]->$field;
                              }
                          }

                          $icon=array(
                            "public" => "fa-globe",
                            "private"=> "fa-lock"
                          );

                          foreach ($albums as $al_key => $album) {

                          $private = $public = null;

                          if ($album->privacy == "private") {
                            $private = "fa-check";
                          }
                          else if($album->privacy == "public"){
                             $public = "fa-check";
                          }

                          $images = $this->action->read("gallery",array("album"=>$album->id));
                        ?>
                          <figure id="id-<?php echo $al_key;?>" class="album-item" data-mainid="<?php echo $album->id; ?>" data-position="<?php echo $album->position; ?>">
                              <img src="<?php echo image(img_fetch($images,0,"gallery_path")); ?>" alt="">
                              <img src="<?php echo image(img_fetch($images,1,"gallery_path")); ?>" alt="">
                              <img src="<?php echo image(img_fetch($images,2,"gallery_path")); ?>" alt="">
                              <img src="<?php echo image(img_fetch($images,3,"gallery_path")); ?>" alt="">
                              <figcaption class="album-caption">
                                  <h5><a href="<?php echo site_url("header/imageGallery/index/".$album->id); ?>"><?php echo $album->album_title; ?></a></h5>
                                  <h6 class="privacy"><?php echo count($images); ?> Photos 
                                      <span class="right">
                                          <i class="fa <?php echo $icon[$album->privacy] ?>" style="margin-right: 7px;"></i> <i class="fa fa-caret-down"></i>
                                          <ul class="popup" data-album="<?php echo $album->id; ?>">
                                              <li class="popup-item" data-privacy="public"><span><i class="active fa <?php echo $public; ?>"></i><i class="fa fa-globe"></i></span> Public </li>
                                              <li class="popup-item" data-privacy="private"><span><i class="active fa <?php echo $private; ?>"></i><i class="fa fa-lock"></i></span> Private </li>
                                          </ul>
                                      </span>
                                  </h6>
                              </figcaption>
                          </figure>
                        <?php } ?>

                        </div>
                   </div>
               </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<!--Light box content Start here-->
    <div id="lb_content" >
        <div class="crop-panel" >
            <div class="crop-body">
                <div class="crop-content">
                <span class="close-btn" onclick="lb_hide();  refresh_img();" >X</span>
                      <?php
                        $attr=array(
                          "class"=>"light-box-form"
                        );
                        echo form_open('', $attr);
                      ?>
                        <input type="text" name="album_title" placeholder="Album Title">
                        <textarea name="description" rows="5" placeholder="Description"></textarea>
                        <select name="privacy">
                          <option value="">Privacy</option>
                          <option value="public">Public</option>
                          <option value="private">Private</option>                          
                        </select>
                        <input type="submit" name="save_album" value="Save">

                      <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
<!--Light box content End here-->
<div id="lb_content">asdfasdf</div>
<script type="text/javascript" src="<?php echo site_url("private/plugins/mf_lightbox.js"); ?>"></script>
<script>
  $(document).ready(function(){

    //Privacy Popup
    $(".privacy").on('click', function() {
      $(this).find(".popup").slideToggle();
    });

    //Create Album Lightbox
    $("#add-album").on('click', function(){
      lb_show();
    });

    //Set Privace
    $(".popup-item").on('click', function() {
      var privacy = $(this).data("privacy");
      var album = $(this).parent(".popup").data("album");
      var privacy_icon = $(this).parent(".popup").siblings('i');

      $(this).find(".active").addClass("fa-check");
      $(this).siblings("li").find(".active").removeClass("fa-check");

      //chenging Icon start here
      if (privacy.match('public')) {
        privacy_icon.removeClass("fa-lock");
        privacy_icon.addClass("fa-globe");
      }
      else if (privacy.match('private')) {
        privacy_icon.removeClass("fa-globe");
        privacy_icon.addClass("fa-lock");
      }
      //chenging Icon end here

      //Sending Request start
      $.ajax({
        url: '<?php echo site_url("header/imageGallery/ajax_albam_privacy"); ?>',
        type: 'POST',
        data: {privacy: privacy, album:album}
      })
      .done(function(response) {
        console.log(response);
      });
      //Sending Request end
      
    });


  });
</script>

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
                url: "<?php echo site_url('header/imageGallery/ajax_album_sort'); ?>",
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
</script>