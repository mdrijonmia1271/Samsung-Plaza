<?php
$headerInfo = custom_query("SELECT * FROM `site_meta` WHERE meta_key='header'", true)->meta_value;
$headerInfo = json_decode($headerInfo);

$footerInfo = custom_query("SELECT * FROM `site_meta` WHERE meta_key='footer'", true)->meta_value;
$footerInfo = json_decode($footerInfo);

$siteLogo = custom_query("SELECT * FROM `site_meta` WHERE meta_key='logo'", true)->meta_value;
$siteLogo = json_decode($siteLogo);

$godownCode = $this->session->userdata('godown_code');
$godownInfo = get_row('godowns', ['code' => $godownCode]);
?>
<div class="__print-border hide">
    <div class="logo_create">
        <h3>NT</h3>
    </div>
    <div class="__info">
        <?php
        if (!empty($godownInfo)) {
            ?>
            <h2 class="site_name"><?php echo strtoupper($headerInfo->site_name); ?></h2>
            <p>Showroom: <?php echo $godownInfo->name; ?></p>
            <p><?php echo $godownInfo->mobile . '||' . $godownInfo->address; ?></p>
        <?php } else { ?>
            <h2 class="site_name"><?php echo strtoupper($headerInfo->site_name); ?></h2>
            <p><?php echo $headerInfo->place_name; ?></p>
            <p><?php echo $footerInfo->addr_moblile; ?> || <?php echo $footerInfo->addr_email; ?></p>
        <?php } ?>
    </div>
</div>

<style>
    .__print-border {
        border-bottom: 1px solid #515151;
        margin-bottom: 15px;
        padding: 10px 0;
    }

    .__logo img {
        margin-top: 10px;
    }

    .__info h2, .__info p {
        margin: 0;
    }

    .__info p {
        font-size: 14px;
    }

    .hide {
        display: none;
    }

    .logo_create h3 {
        font-weight: bold;
        font-size: 35px;
        margin: 0;
    }

    .logo_create {
        border-right: 6px solid #FF0000;
        border-top: 6px solid #FF0000;
        border-bottom: 6px solid #000;
        border-left: 6px solid #000;
        display: inline-block;
        padding: 10px 6px;
        margin: 0;
        display: flex;
        margin-right: 15px;
        align-items: center;
    }

    @page {
        margin: 0;
    }

    .site_name {
        color: red !important;
        font-weight: 700;
    }

    @media print {
        .__print-border {
            display: flex !important;
        }
    }
</style>