<?php
class Commission extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

        $this->data['meta_title'] = 'Commission';
        $this->data['active'] = 'data-target="cm-menu"';
        $this->data['clientInfo'] = $this->action->readGroupBy('parties','name');
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="monthly"';
        $this->data['confirmation'] =  null; 
        $this->data['result'] = false;
        
        if(isset($_POST['show'])){
          $this->data['result'] = true;
        }       


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cm/nav', $this->data);
        $this->load->view('components/cm/commission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function yearlyCommission() {
        $this->data['subMenu'] = 'data-target="yearly"';
        $this->data['confirmation']  = $this->data['quantity'] =   $this->data['result'] = null;        
       
        
        if(isset($_POST['show'])){         
          $where = array(
           "YEAR(sap_at)"  => $_POST['search']['year'],
           "party_code"    => $_POST['search']['party_code'],
           "status"        => "sale",
           "trash"         => 0
          );
          
          $this->data['quantity']  = $this->action->read_sum("saprecords","total_quantity",$where);
          $this->data['result']    = $this->action->read("saprecords",$where);
        }   


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cm/nav', $this->data);
        $this->load->view('components/cm/yearlyCommission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function saleCommission() {
        $this->data['subMenu'] = 'data-target="sale"';
        $this->data['confirmation'] = $this->data['result'] = null;
        $this->data['totalCommission'] = $this->data['totalPaid'] = $this->data['totalDue'] = NULL;

	
	    $where = array();

        if(isset($_POST['show'])){
        
         if(isset($_POST['search']['sap_at'])){
          $where['YEAR(sap_at)'] = $_POST['search']['sap_at'];
         }
         

            foreach($_POST['search'] as $key => $val) {
                if($val != null && $key != "sap_at"){
                    $where[$key] = $val;
                }   
            }

        }

        $where['status'] = 'sale';
        $where['trash']  = 0;
       
        $this->data['result'] = $this->action->readGroupBy('saprecords', 'voucher_no', $where);
        
        if(isset($_POST['show'])){
          foreach($this->data['result'] as $key=>$value){ 
            $commissionInfo = $this->action->read('sapmeta', array('voucher_no'=>$value->voucher_no,'meta_key'=>'saleCommission'));
            $this->data['totalCommission'] += ($value->total_bill*0.02);
            $this->data['totalPaid'] += (($commissionInfo) ? $commissionInfo[0]->meta_value : 0.00);                      
          }
          $this->data['totalDue'] = ($this->data['totalCommission'] -  $this->data['totalPaid']); 
        
        }
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cm/nav', $this->data);
        $this->load->view('components/cm/saleCommission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function salePaid() {
       $where = array('id' => $_GET['id']);
       $info = $this->action->read('saprecords', $where);
        
        
        
        $data = array(
                    'voucher_no'    => $info[0]->voucher_no,
                    'meta_key'      => 'saleCommission',
                    'meta_value'    => $_GET['amount'],
                );

        $this->action->add("sapmeta", $data);

          $options = array(
            'title' => 'Success',
            'emit'  => 'Successfully Payment!',
            'btn'   => true
        );

        $message = message("success", $options);

        $this->session->set_flashdata("confirmation", $message);

        redirect("cm/commission/saleCommission","refresh");
    }
    
    public function monthlyPaid() {     
        
        $data = array(
                    'date'        => date('Y-m-d'),
                    'party_code'  => $_GET['party_code'],
                    'year'        => $_GET['year'], 
                    'month'       => $_GET['month'],                    
                    'amount'      => $_GET['amount']
                );

        $this->action->add("monthly_commission_paid", $data);

          $options = array(
            'title' => 'Success',
            'emit'  => 'Successfully Payment!',
            'btn'   => true
        );

        $message = message("success", $options);

        $this->session->set_flashdata("confirmation", $message);

        redirect("cm/commission","refresh");
    }
    
    
     public function yearlyPaid() {     
        
        $data = array(
                    'date'        => date('Y-m-d'),
                    'party_code'  => $_GET['party_code'],
                    'year'        => $_GET['year'],                                       
                    'amount'      => $_GET['amount']
                );

        $this->action->add("yearly_commission_paid", $data);

          $options = array(
            'title' => 'Success',
            'emit'  => 'Successfully Payment!',
            'btn'   => true
        );

        $message = message("success", $options);

        $this->session->set_flashdata("confirmation", $message);

        redirect("cm/commission/yearlyCommission","refresh");
    }
    
    
    /*
    public function UpdateRemainCommission(){
        $allVoucher = $this->action->CommissionUsers();
        
        foreach($allVoucher as $value){
            $data = array(
                "meta_key" =>  "remaining_commission",
                "meta_value" => "6"
            );
            
            $where = array('meta_key'=> 'remaining_commission','voucher_no' => $value->voucher_no,'trash' => 0);
            $this->action->update('sapmeta',$data,$where);
        }
    }
    
    */
    
}
