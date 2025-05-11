<style>
    .view-site:hover {color: #333;}
    a:focus{border: none;}
    @media screen and (max-width: 480px) {
        .top-title{display:none;}
        .new-top-title{display:none;}
	}
	.new-top-title{

	}
</style>


<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="row">
        <nav class="col-xs-12 content-fixed-nav" style="background-color: #129576 !important;
    background: -webkit-radial-gradient(circle, #4fa600 0%, #009b54 100%);">
            <ul>
                <li>
                    <a href="#menu-toggle" id="menu-toggle">
                        <i class="fa fa-angle-left"></i>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>

            <ul class="nav-inner-right" style="font-size: 13px;">
                <!--<li style="width: auto;" class="top-title">
                    <a style="font-weight: bold;"><span style="color: #000;">Hello: </span> <span style="color: #00A8FF;"><?php echo $this->data['name']; ?></span></a>
                </li>-->

                <li class="new-top-title" style="width: auto;">
                    <a style="color: #fff;" href="<?php echo site_url('purchase/purchaseMobile'); ?>" target="_blank">
                        <i class="fa fa-plus-square" style="font-size: 14px;"></i>&nbsp; Mobile Purchase</a>
                </li>

                <li class="new-top-title" style="width: auto;">
                    <a style="color: #fff;" href="<?php echo site_url('stock/stock/'); ?>" target="_blank">
                        <i class="fa fa-plus-square" style="font-size: 14px;"></i>&nbsp; Stock</a>
                </li>

                <li class="new-top-title" style="width: auto;">
                    <a style="color: #fff;" href="<?php echo site_url('sale/mobile_sale'); ?>" target="_blank">
                        <i class="fa fa-plus-square" style="font-size: 14px;"></i>&nbsp; Mobile Sale</a>
                </li>

                <li class="user-menu dropdown" style="width: auto;">
                    <a class="dropdown-toggle" type="button" data-toggle="dropdown" style="color: #fff;">
                        <img class="nav-pic" src="<?php echo site_url($image); ?>"> &nbsp; <?php echo $this->data['name']; ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-menu-description"><a>Settings</a></li>
                        <li><a href="<?php echo site_url("settings/profile");?>">Profile</a></li>
                        <li><a href="<?php echo site_url('settings/createProfile'); ?>">Create Profile</a></li>
                        <li><a href="<?php echo site_url("settings/allProfile");?>">All Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url('access/users/logout'); ?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <!-- top navigation end -->

    <div class="main-area">&nbsp;</div>
