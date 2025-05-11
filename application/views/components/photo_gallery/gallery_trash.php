<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation');?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <div class="pull-left">
                      <label class="btn2">Check All <input type="checkbox" name="" id="check-all"/></label>
                      <button onclick="return confirm('Are You Sure To Restore Selected Data?');" form="trash-form" value="restore_all" name="restore_all" class="btn1" id="restore-all"><i class="fa fa-undo" aria-hidden="true"></i></button>
                      <button onclick="return confirm('Are You Sure To Delete Selected Data?');" form="trash-form" value="delete_all" name="delete_all" class="btn1" id="delete-all"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </div>
                    <h1 class="pull-right">Trash</h1>
                </div>
            </div>

            <div class="panel-body">
               <div class="row">
                   <div class="col-sm-12">
                        <?php
                          $attr=array(
                            "id"=>"trash-form"
                          );
                         echo form_open("",$attr) ?>
                        <div id="sortable" class="gallery image-gallery">
                            <?php foreach ($gallery_data as $key => $gallery) { ?>
                                <figure id="id<?php echo $key+1; ?>" data-mainid="<?php echo $gallery->id; ?>" data-position="<?php echo $gallery->position; ?>">
                                  <label class="selectbox" for="trash_check<?php echo $key; ?>">
                                    <input type="checkbox" name="id[]" value="<?php echo $gallery->id; ?>" class="trash_check" id="trash_check<?php echo $key; ?>"/>
                                    <img src="<?php echo site_url($gallery->gallery_path)?>" alt="">
                                  </label>
                                    <figcaption style="display: flex;" >
                                        <a class="btn btn-primary" style="flex:1;" href="<?php echo site_url('photo_gallery/photo_gallery/restore/'.$gallery->id); ?>"><?php echo "Restore";//caption('Restore'); ?></a><a class="btn btn-danger" onclick="return confirm('Are you sure to delete this Data ?')" href="?delete_token=<?php echo $gallery->id; ?>&img_url=<?php echo $gallery->gallery_path; ?>"><?php echo "Delete";//caption('Delete');?></a>
                                    </figcaption>
                                </figure>
                            <?php } ?>
                        </div>
                        <?php echo form_close(); ?>
                   </div>
               </div>                
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

   <script>
   $(document).ready(function(){
    $( function() {
    $("#sortable").disableSelection();
    (function($) {
        var sortObj = {};

        $('#sortable').sortable({
            cursor: "move",
            distance: 5,
            opacity: 0.8,
            stop: function(e, ui) {

              /*
                console.log($.map($(this).find('p'), function(el) {
                  var index = parseInt($(el).index()) + 1;
                  return $("#"+el.id).data('mainid') + ' : ' + index;
                }));
              */

                $.map($(this).find('figure'), function(el) {
                  var index = parseInt($(el).index()) + 1;
                  sortObj[$("#"+el.id).data('mainid')] = index;
                });

                //console.log(JSON.stringify(sortObj));
                var final_data=JSON.stringify(sortObj);
                //console.log(final_data);
                $.map($(this).find('p'),function(el){
                  var index = parseInt($(el).index()) + 1;
                  $("#" + el.id).attr("data-position", index);
                });
                /*Sending Ajax Data Start here*/
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
//--------------------------------------------------------------
//-----------------------Check All Start here-------------------
//--------------------------------------------------------------
$(document).ready(function(){
  $("#check-all").on('change', function(event) {
      if($("#check-all").is(":checked")){
        $(".trash_check").prop("checked", true);
      }else{
        $(".trash_check").prop("checked", false);
      }
  });
});
//--------------------------------------------------------------
//-----------------------Check All End here---------------------
//--------------------------------------------------------------




   });


  </script>