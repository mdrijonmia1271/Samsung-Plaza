<style>
    .table tr td{
        vertical-align: middle !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
    <?php echo $confirmation; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Profile</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                if (!empty($profiles)) {
                ?>

                <table class="table table-bordered">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Privilege</th>
                        <th>Showroom</th>
                        <th style="width: 213px;">Action</th>
                    </tr>

                    <?php foreach ($profiles as $key => $value) { ?>
                    <tr>
                        <td><?php echo($key + 1); ?></td>
                        <td style="width: 55px; padding: 2px;"><img src="<?php echo site_url($value->image); ?>" alt="" style="width: 55px; height: 55px;"></td>
                        <td><?php echo filter($value->name); ?></td>
                        <td><?php echo $value->username; ?></td>
                        <td><?php echo filter($value->privilege); ?></td>
                        <td><?php echo filter($value->godown_name); ?></td>
                        <td style="width: 210px;">
                            <a class="btn btn-info" href="<?php echo site_url("settings/showProfile?id=" . $value->id); ?>">
                                <i class="fa fa-eye"></i>
                            </a>
                            <?php if($privilege=='super'|| $privilege=='admin'|| $value->username==$username){ ?>
                            <a class="btn btn-warning" href="<?php echo site_url("settings/editProfile?id=" . $value->id); ?>">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>

                            <?php } if($value->privilege!=$privilege && $value->username!=$username && $privilege=='super' || $privilege=='admin'){ ?>
                            <a class="btn btn-warning" href="<?php echo site_url("settings/editpass/index/" . $value->id); ?>">
                                <i class="fa fa-key"></i>
                            </a>

                            <?php } if($value->privilege!=$privilege && $value->username!=$username && $privilege=='super' || $privilege=='admin'){ ?>
                            <a onclick="return confirm('Are you sure want to delete this account permanently?')" class="btn btn-danger" href="<?php echo site_url("settings/allProfile?img_url=".$value->image."&id=" . $value->id); ?>">
                                <i class="fa fa-trash-o"></i>
                            </a>
			    <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </table>

                <?php
                } else {
                    echo "<h3 style='text-align:center;'>No Accounts Available !</h3>";
                }
                ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
