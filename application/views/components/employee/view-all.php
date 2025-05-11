<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
    }
    .table tr td{
        vertical-align: middle !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
    <?php // echo "<pre>"; print_r($emp_info); echo "</pre>"; ?>
    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">View All Employee </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <div class="none">
                    <?php if($branch == "godown") {
                    $attr = array ('class' => 'form-horizontal');
                    echo form_open('', $attr); ?>
                    <div class="form-group row">
                        <label class="col-md-2 control-label">Showroom <span class="req">&nbsp;</span></label>
                        <div class="col-md-5">
                            <select name="showroom" class="form-control">
                                <option value="" ‍> All </option>
                                <option value="godown">Head Office</option>
                                <?php
                                    foreach ($showrooms as $key => $row) { ?>
                                    <option value="<?php echo $row->showroom_id; ?>"> <?php echo filter($row->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="submit" value="Show" name="show" class="btn btn-primary">
                        </div>
                    </div>
                    <hr>
                    <?php echo form_close(); } ?>
                </div>

                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

                <h4 class="text-center hide" style="margin-top: 0px;">All Employee</h4>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40px">SL</th>
                            <th>Joining Date</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Mobile Number</th>
                            <th class="none" width="160px">Action</th>
                        </tr>
                        <?php foreach ($emp_info as $key => $emp) { ?>

                        <tr>
                            <td> <?php echo $key+1; ?> </td>
                            <td style="width: 115px;"> <?php echo $emp->joining_date; ?> </td>
                            <td style="width: 50px; padding: 2px;";> <img src="<?php echo site_url($emp->path); ?>" width="50px" height="50px" alt=""></td>
                            <td> <?php echo filter($emp->name); ?> </td>
                            <td> <?php echo filter(str_replace("_"," ", $emp->designation)); ?></td>
                            <td> <?php echo $emp->mobile; ?></td>
                            <td class="none">
                                <a class="btn btn-primary" title="View" href="<?php echo site_url('employee/employee/profile?id='.$emp->id);?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-warning" title="Edit" href="<?php echo site_url('employee/employee/edit_employee?id='.$emp->id) ;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure to delete this data?');" href="<?php echo site_url('/employee/employee/delete/'.$emp->id) ;?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
