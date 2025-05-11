<?php
class Analytical_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="analytical_report_menu"';
    }

    public function index(){

        $this->data['subMenu'] = 'data-target="client_report"';
        $this->data['result']  = null;

        $whereClient = ['type'    => 'client','status'  => 'active','trash'   => 0];
        $this->data['allClients'] = get_result('parties', $whereClient, ['code', 'name', 'mobile']);

        //Today's Data
        
        $where = ['status' => 'sale','trash' =>0];

         if (isset($_POST['show'])) {

            foreach($_POST['search'] as $key => $val){
                if($val != null){
                    $where[$key] = $val;
                }
            }

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }
            
         }else{
            $where["godown_code"]    = $this->data['branch'];
            
         }

        $where['sap_type !='] = 'cash';
        $select                             = ['sap_at','party_code', 'sap_type', 'godown_code', 'sap_type'];
        $this->data['result']               = get_result('saprecords',$where, $select,'party_code');


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/analytical_report_nav', $this->data);
        $this->load->view('components/report/client_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }




public function client_collection(){
    
        $this->data['subMenu'] = 'data-target="client_collection"';
        $this->data['result']  = null;

        $whereClient = ['type'    => 'client','status'  => 'active','trash'   => 0];
        $this->data['allClients'] = get_result('parties', $whereClient, ['code', 'name', 'mobile']);

        //Today's Data
        
        $where = ['status' => 'sale','trash' =>0];
        
         if (isset($_POST['show'])) {

            foreach($_POST['search'] as $key => $val){
                if($val != null){
                    $where[$key] = $val;
                }
            }

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }
            
         }else{
            $where["godown_code"]    = $this->data['branch'];
            
         }

    
        $where['sap_type !='] = 'cash';
        $select                             = ['sap_at','party_code', 'sap_type', 'godown_code', 'sap_type'];
        $this->data['result']               = get_result('saprecords',$where, $select,'party_code');


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/analytical_report_nav', $this->data);
        $this->load->view('components/report/client_collection', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    
}





 public function supplier_purchase(){

        $this->data['subMenu'] = 'data-target="supplier_purchase"';
        $this->data['result']  = null;

        $whereClient = ['type'    => 'supplier','status'  => 'active','trash'   => 0];
        $this->data['allClients'] = get_result('parties', $whereClient, ['code', 'name', 'mobile']);

        //Today's Data
        
        $where = ['status' => 'purchase','trash' =>0];

         if (isset($_POST['show'])) {

            foreach($_POST['search'] as $key => $val){
                if($val != null){
                    $where[$key] = $val;
                }
            }

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }
            
         }else{
            $where["godown_code"]    = $this->data['branch'];
            
         }

    
        $select                             = ['sap_at','party_code', 'sap_type', 'godown_code', 'sap_type'];
        $this->data['result']               = get_result('saprecords',$where, $select,'party_code');


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/analytical_report_nav', $this->data);
        $this->load->view('components/report/supplier_purchase', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }



public function supplier_payment(){
    
        $this->data['subMenu'] = 'data-target="supplier_payment"';
        $this->data['result']  = null;

        $whereClient = ['type'    => 'supplier','status'  => 'active','trash'   => 0];
        $this->data['allClients'] = get_result('parties', $whereClient, ['code', 'name', 'mobile']);

        //Today's Data
        
        $where = ['status' => 'purchase','trash' =>0];

         if (isset($_POST['show'])) {

            foreach($_POST['search'] as $key => $val){
                if($val != null){
                    $where[$key] = $val;
                }
            }

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }
            
         }else{
            $where["godown_code"]    = $this->data['branch'];
            
         }

    
        $select                             = ['sap_at','party_code', 'sap_type', 'godown_code', 'sap_type'];
        $this->data['result']               = get_result('saprecords',$where, $select,'party_code');


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/analytical_report_nav', $this->data);
        $this->load->view('components/report/supplier_payment', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    
}



 }