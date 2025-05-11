<style type="text/css">
    #sending-img{
        display: none;
        width: 40px;
        height: 40px;
    }
    #sms_report{
        display: none;
        color: #00A8FF;
        font-weight: bold;
        font-size: 16px;
    }
</style>
<div class="container-fluid">
    <div class="row">
    <?php echo $confirmation; ?>    
      <?php if($messages != NULL) { ?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Message</h1>
                </div>
            </div>

            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                <?php foreach ($messages as $key => $message) { ?>
                    <tr>
                        <td><?php echo $key+1; ?> </td>
                        <td><?php echo $message->name;?> </td>
                        <td><?php echo $message->email;?></td>
                        <td><?php echo $message->subject;?></td>
                        <td class="none" style="width: 160px;">
                            <a title="View" class="btn btn-primary" href="<?php echo base_url('visitors/comments/view_comments')?>?id=<?php echo $message->id; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a title="Delect" onclick="return confirm('Are you sure want to delete this Data?');" class="btn btn-danger" href="?id=<?php echo $message->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </table>

              </div>
            <div class="panel-footer">&nbsp;</div>
          </div>
        <?php } ?>    
    </div>
</div>
