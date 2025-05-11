<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
<div class="__print-border hide">
    <?php 
        $this->load->helper('url');
        $module = $this->uri->segment(1);   
    ?>
    <div class="logo_create">
        <h3>CE</h3>
    </div>
    <div class="__info">
        <?php  
            $branch = $this->session->userdata('branch');
            if($branch){
                $branch_info =$this->action->read('godowns',array('code' => $branch));
                
            }
            if(!empty($branch_info)){
        ?>
            <h2 class="site_name"><?php echo strtoupper($header_info['site_name']); ?></h2>
            <p>All kinds of goods whole seller & retailer</p>
            <p>Showroom:<?php echo $branch_info[0]->name; ?></p>
            <p><?php if($module!= 'sale'){ echo $branch_info[0]->mobile;  echo '||'; } ?>  <?php echo $branch_info[0]->address; ?></p>
        <?php }else{ ?>
            <h2 class="site_name"><?php echo strtoupper($header_info['site_name']); ?></h2>
            <p><?php echo $header_info['place_name'];?></p>
            <p><?php echo $footer_info['addr_moblile']; ?> || <?php echo $footer_info['addr_email']; ?></p>
        <?php } ?>
    </div>
</div>

<style>
    .hide > h3, .hide > h4 {margin: 2px 0 10px 0;}
    .__print-border {
        margin-bottom: 15px;
        padding: 10px 0;
    }
    .__logo img {margin-top: 10px;}
    .__info h2, .__info p {margin: 0;}
    .__info p {font-size: 14px;}
    .hide {display: none;}
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
    @page {margin: 0;}
    .site_name {
        color: red !important;
        font-weight: 700;
    }
    @media print {
        .__print-border {display: flex !important;}
    }
</style>