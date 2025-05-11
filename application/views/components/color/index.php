<?php
if (isset($meta->header)) {
    $header_info = json_decode($meta->header, true);
}
if (isset($meta->footer)) {
    $footer_info = json_decode($meta->footer, true);
}
$logo_data = json_decode($meta->logo, true);
?>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Color</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <!-- Print banner Start Here -->
                <?php $this->load->view('print', $this->data); ?>

                <!-- Print banner End Here -->
                <div class="col-md-12 text-center hide">
                    <h3>All Color</h3>
                </div>


                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Color Name</th>
                        <?php if (!checkAuth('user')) { ?>
                            <th class="none" style="width: 120px;">Action</th>
                        <?php } ?>
                    </tr>

                    <?php if (!empty($results)) {
                        foreach ($results as $key => $row) { ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $row->color; ?></td>
                                <?php if (!checkAuth('user')) { ?>
                                    <td class="none">
                                        <a class="btn btn-warning" title="Edit"
                                           href="<?php echo site_url('color/color/edit/' . $row->id); ?>"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a onclick="return confirm('Do you want to delete this data?');"
                                           class="btn btn-danger"
                                           title="Delete"
                                           href="<?php echo site_url('color/color/delete/' . $row->id); ?>"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>