<div class="container-fluid">
    <div class="row">
        <?php //echo "<pre>"; print_r($emp_info); echo "</pre>"; ?>
        <?php echo $confirmation; ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Edit Employee </h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array(
                    "class" => "form-horizontal"
                );
                echo form_open_multipart("employee/employee/edit_employee?id=" . $this->input->get("id"), $attr); ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">&nbsp; </label>
                    <div class="col-md-5">
                        <img src="<?php echo base_url($emp_info[0]->path); ?>" width="80px" height="80px" alt="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">ID </label>
                    <div class="col-md-5">
                        <input type="text" name="emp_id" readonly placeholder="Type Employee ID"
                               value="<?php echo $emp_info[0]->emp_id; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Name </label>
                    <div class="col-md-5">
                        <input type="text" name="full_name" placeholder="Type Full Name"
                               value="<?php echo $emp_info[0]->name; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Joining Date </label>
                    <div class="input-group date col-md-5" id="datetimepicker">
                        <input type="text" name="joining_date" placeholder="YYYY-MM-YY" class="form-control"
                               value="<?php echo $emp_info[0]->joining_date; ?>" required>
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#datetimepicker').datetimepicker({
                            format: 'YYYY-MM-DD'
                        });
                    });
                </script>

                <div class="form-group">
                    <label class="col-md-2 control-label">Gender <span class="req">*</span></label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input <?php if ($emp_info[0]->gender == "Male") {
                                echo "checked";
                            } ?> type="radio" name="gender" value="Male"> Male
                        </label>
                        <label class="radio-inline">
                            <input <?php if ($emp_info[0]->gender == "Female") {
                                echo "checked";
                            } ?> type="radio" name="gender" value="Female"> Female
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile Number </label>
                    <div class="col-md-5">
                        <input type="text" name="mobile_number" placeholder="without +88"
                               value="<?php echo $emp_info[0]->mobile; ?>" class="form-control" required>
                    </div>
                </div>

                <?php /*
					<div class="form-group">
                        <label class="col-md-2 control-label">ইমেইল </label>
                        <div class="col-md-5">
                            <input type="email" name="email" placeholder="Type your Email" value="<?php echo $emp_info[0]->email; ?>" class="form-control">
                        </div>
                    </div>
					*/ ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Present Address </label>
                    <div class="col-md-5">
                        <textarea name="present_address" placeholder="Type Present Address" class="form-control"
                                  cols="30" rows="5" required><?php echo $emp_info[0]->present_address; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Permanent Address </label>
                    <div class="col-md-5">
                        <textarea name="permanent_address" placeholder="Type Permanent Address" class="form-control"
                                  cols="30" rows="5" required><?php echo $emp_info[0]->permanent_address; ?></textarea>
                    </div>
                </div>


                <div class="form-group teachers_option">
                    <label class="col-md-2 control-label">Designation </label>
                    <div class="col-md-5">
                        <select name="designation" class="form-control">
                            <option value="">-- Select --</option>
                            <?php foreach (config_item('desigation') as $value) { ?>
                                <option <?php if ($value == $emp_info[0]->designation) {
                                    echo "selected";
                                } ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Image </label>
                    <div class="col-md-5">
                        <input id="input-test" type="file" name="attachFile" class="form-control file"
                               data-show-preview="false" data-show-upload="false" data-show-remove="false">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update_emp" value="Update" class="btn btn-success">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
