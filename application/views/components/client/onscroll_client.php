<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .action-btn a{
        margin-right: 0;
        margin: 3px 0;
    }
</style>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

    	<div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Customers</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
            </div>

            <div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <!--<h4 class="text-center hide" style="margin-top: 0px;">All Customers</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Customer</h3>
                </div>

           <?php
            $attribute = array(
                'name' => 'client/client/view_all',
                'class' => 'form-horizontal',
                'id' => ''
            );
            echo form_open_multipart('', $attribute);
            ?>
                <div class="row none">
                    <?php if($this->data['privilege'] == 'super') { ?>
                     <div class="col-md-2">
                        
                        <select  name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    
                    <?php }else{ ?>
                    
                         <input type="hidden" name="godown_code" value ='<?php echo $this->data['branch']; ?>' >
                    <?php } ?>
                    </div>
                  <!--  <div class="col-md-2" style="margin-bottom:15px;">
                        <select name="dealer_type" class="form-control">
                            <option value=""> All </option>
                            <?php 
                            $dealer_type = config_item('dealer_type');
                            if(!empty($dealer_type)){
                            foreach($dealer_type as $item){ ?>
                                <option value="<?= $item ?>" <?= (!empty($info) && $info[0]->dealer_type == $item ? "selected" : "")?>><?= $item ?></option>
                            <?php } } ?>
                        </select>
                    </div>-->
                    
                    
                    <?php if($this->data['privilege'] == 'super') { 
                     
                        $where =array();
                        $where['trash'] =0; 
                        $allClient = $this->action->read('parties',$where);
                    }else{ 
                         
                            $godown_code = $this->data['branch']; 
                            $where =array();
                            $where['trash'] =0;
                            $where['godown_code'] = $godown_code; 
                            $allClient = $this->action->read('parties',$where); 
                        
                     } 
                        
                        if(!empty($_POST['godown_code'])){ 
                            $godown_code = $_POST['godown_code'];
                            
                        }else{    
                             $godown_code;
                        }
                        
                    ?>
                     <div class="col-md-2">
                        <select  name="code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Select Client --</option>
                            <?php if(!empty($allClient)){ foreach($allClient as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo $row->code .'-'. $row->mobile .'-'. filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                             
                    <div class="col-md-2">
                        <select name="zone" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" >Select Zone&nbsp; </option>
                                <option value="zone_null" >NULL Zone </option>
                                <?php
                                $zone = $this->action->read('zone');
                                if(!empty($zone)){
                                foreach($zone as $zone){ ?>
                                    <option value="<?php echo $zone->zone; ?>" ><?php echo $zone->zone; ?></option>
                                <?php } } ?>
                        </select>
                    </div>
                    
                    
                    <div class="col-md-2">
                        <select name="brand" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" >Select Brand&nbsp; </option>
                                <option value="zone_null" >NULL Zone </option>
                                <?php
                                $brand = get_result('brand',['trash'=> 0]);
                                if(!empty($brand)){
                                foreach($brand as $brand){ ?>
                                    <option value="<?php echo $brand->brand; ?>" ><?php echo $brand->brand; ?></option>
                                <?php } } ?>
                        </select>
                    </div>
                    
                    
                    <div class="col-md-2">
                        <select name="customer_type" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected>-- Select Client Type ---</option>
                            <option value="dealer">Dealer</option>
                            <option value="hire">Hire</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                        
                    <div class="col-md-1">
                        <div class="btn-group mb15">
                            <input class="btn btn-primary" type="submit" name="find" value="Show">
                        </div>
                    </div>
                    
                </div>
                <?php echo form_close(); ?>
                <p class="none"> <span style="color: green;font-weight: bold;">Green = Receivable</span>&nbsp;<span style="color: red;font-weight: bold;">Red = Payable</span></p>
                
                <table class="table table-bordered">
                    
                    <tr>
                        <th width="50">SL</th>
                        <th width="75">C.ID</th>
                        <th width="60">Photo</th>
                        <th>Customer Name</th>
                        <th>Brand</th>
                        <th>Address</th>
                        <th width="120">Mobile</th>
                        <th width="115">Balance</th>
                        <th>Showroom</th>
                        <th class="none" style="width: 160px;">Action</th>
                    </tr>
                    <tbody id="data_table"></tbody>
                </table>
                <div style="text-align: center;display:none;" id="onscroll_loader"><img src="<?php echo site_url('public/images/loader.gif'); ?>" alt="" style="width: 30px;"></div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<!-- Select Option 2 Script -->



<script>
$(document).ready(function(){
    var currentPageNumber = 0,
        _pageSize         = 250;
    
    loadData(_pageSize,currentPageNumber);

    $(window).scroll(function(){
      if($(window).scrollTop() == ($(document).height() - $(window).height())){
          currentPageNumber += 1;
          loadData(_pageSize,currentPageNumber);
      }
    });
    
    function loadData(_pageSize,currentPage){
      var data_row          = '',
          total_installment_price  = 0;
        
      $.post("<?php echo site_url('client/client/onscroll_load_all_data'); ?>", 
        { 
            pageNumber: currentPage,
            pageSize :_pageSize,
            find:'<?php  if(!empty($_POST['find'])){ echo $_POST['find']; }else{ echo ''; } ?>',
            godown_code:'<?php   echo $godown_code;  ?>',
            code:'<?php  if(!empty($_POST['code'])){ echo $_POST['code']; }else{ echo ''; } ?>',
            zone:'<?php  if(!empty($_POST['zone'])){ echo $_POST['zone']; }else{ echo ''; } ?>',
            customer_type:'<?php  if(!empty($_POST['customer_type'])){ echo $_POST['customer_type']; }else{ echo ''; } ?>',
            brand:'<?php  if(!empty($_POST['brand'])){ echo $_POST['brand']; }else{ echo ''; } ?>', 
            
        }, 
        function(data,success){
          if(data!=0){
            var respons = JSON.parse(data);
            
            if(respons.length>=_pageSize){
                onscroll_loader.style.cssText = "display:block;text-align:center;";
            }
            
            for(key in respons){

              var single_record = respons[key];
              data_row += '<tr>';
              data_row += `
                          <td >${single_record['sl']}</td>
                          <td>${single_record['code']}</td>
                          <td>${single_record['photo']}</td>
                          <td>${single_record['name']}</td>
                          <td>${single_record['brand']}</td>
                          <td>${single_record['address']}</td>
                          <td>${single_record['mobile']}</td>
                          <td >${single_record['balance']} <span style="display:none" class="total_installment" > ${single_record['balance_real']} </span> </td>
                          <td>${single_record['showroom']}</td>
                          <td>      
                            <a title="View" class="btn btn-info"  href="<?php echo site_url('client/client/preview?partyCode='); ?>${single_record['party_code']}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            
                          <?php 
                                $privilege = $this->data['privilege'];
                                if($privilege != 'user'){
                          ?>    
                            
                            <a title="Edit" class="btn btn-warning"  href="<?php echo site_url('client/client/edit?partyCode='); ?>${single_record['party_code']}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete this Party Record ?');" href="<?php echo site_url('client/client/delete'); ?>/${single_record['party_code']}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          
                          <?php  } ?>      
                          </td>
                        `;
              data_row += '</tr>';
            }
            data_table.innerHTML+=data_row;
            
         var total_installment       = document.querySelectorAll('.total_installment');

            // calculate total sale price start
            Object.values(total_installment).forEach((value, index)=>{
              total_installment_price += (+1*value.innerHTML);
            });
            total_installment_price = total_installment_price.toFixed(2);
            
            // calculate total low level price end
            if(document.querySelector('#totalValusRow')){
              data_table.removeChild(totalValusRow);
            }
            data_table.innerHTML += `
                                    <tr id="totalValusRow">
                                      <th colspan="7" style="text-align: right;">Total</th>
                                      <th>${total_installment_price} TK.</th>
                                      <th colspan="2"></th>
                                    </tr>
                                  `; 
            //----------------------------------------------------------------            
          }
          
          if(data==''){
            onscroll_loader.style.cssText = "display:none;text-align:center;";
          }

        });
    }

   });


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>