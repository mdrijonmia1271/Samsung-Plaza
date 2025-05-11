<?php

class Search_sale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        // get all product model 
        $this->data['product_model'] = get_result('stock', [], ['product_model'], 'product_model'); 
        $this->data['brandList'] = get_result('brand', ['trash' => 0]);
    }

    public function index() {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu_elec"';
        $this->data['subMenu']    = 'data-target="all_elec"';
        $this->data['result']     = null;

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();
        
        
        // get all client
        $this->data['allClients'] = $this->getAllClient();

        //Today's Data
        $where = [];
        $where['saprecords.status'] = 'sale';
        //$where['saprecords.voucher_type'] = 'electronics';
        $where['saprecords.sap_type !='] = 'credit';
        $where['saprecords.trash']  = 0;
        if(isset($_POST['show'])){
            
            foreach($_POST['search'] as $key => $val) {
                if(!empty($val)){
                    $where["saprecords.$key"] = $val;
                }
            }

            if(!empty($_POST['product_model'])){
                $where['sapitems.product_model'] = $_POST['product_model'];
            }
              
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['saprecords.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['saprecords.godown_code'] = $this->data['branch'];
            }

            foreach($_POST['date'] as $key => $val) {
                if(!empty($val) && $key == 'from') {
                    $where['saprecords.sap_at >='] = $val;
                }

                if(!empty($val) && $key == 'to') {
                    $where['saprecords.sap_at <='] = $val;
                }
            }
            
        } else {
            $where['saprecords.sap_at'] = date("Y-m-d");
            $where['saprecords.godown_code'] = $this->data['branch'];
        }


        $tableTo                = ['godowns', 'sapitems'];
        $joinCond               = ['godowns.code=saprecords.godown_code', 'sapitems.voucher_no=saprecords.voucher_no'];
        $select                 = ['saprecords.*', 'godowns.name as godown_name', 'sapitems.product_model'];
        $this->data['result']   = get_join("saprecords", $tableTo, $joinCond, $where, $select, "voucher_no", "saprecords.id", "desc");
        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/all-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function search_sale() {
        $where = array();

        foreach($_POST['search'] as $key => $val) {
            if($val != null){
                $where[$key] = $val;
            }
        }

        foreach($_POST['date'] as $key => $val) {
            if($val != null && $key == 'from') {
                $where['sale_at >='] = $val;
            }

            if($val != null && $key == 'to') {
                $where['sale_at <='] = $val;
            }
        }

        $where['status'] = 'sale';
        $where['trash'] = 0;
        $where['sap_type !='] = 'credit';
        return $this->action->readGroupBy('saprecords', 'voucher_no', $where);
    }
    
    
    public function customer($party_code) {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();
        
        // get all client
        //$this->data['allClients'] = $this->getAllClient();
        $clientWhere = array('code' => $party_code, 'type' => 'client', 'trash' => 0);
        $this->data['allClients'] = get_result('parties', $clientWhere, ['code', 'godown_code', 'godown_code as showroom', 'name', 'address', 'mobile', 'credit_limit', 'initial_balance']);
        //print_r($this->data['allClients']);

        if(isset($_POST['show'])){
            
            foreach($_POST['search'] as $key => $val) {
                if(!empty($val)){
                    $where["saprecords.$key"] = $val;
                }
            }

            if(!empty($_POST['product_model'])){
                $where['sapitems.product_model'] = $_POST['product_model'];
            }
              
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['saprecords.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['saprecords.godown_code'] = $this->data['branch'];
            }

            foreach($_POST['date'] as $key => $val) {
                if(!empty($val) && $key == 'from') {
                    $where['saprecords.sap_at >='] = $val;
                }

                if(!empty($val) && $key == 'to') {
                    $where['saprecords.sap_at <='] = $val;
                }
            }
        } else {
            //$where['saprecords.godown_code'] = $this->data['branch'];
            $where['saprecords.party_code'] = $party_code;
            $where['saprecords.status'] = 'sale';
            $where['saprecords.trash']  = 0;
        }

        $tableTo              = ['godowns', 'sapitems'];
        $joinCond             = ['godowns.code=saprecords.godown_code', 'sapitems.voucher_no=saprecords.voucher_no'];
        $select               = ['saprecords.*', 'godowns.name as godown_name', 'sapitems.product_model'];
        $this->data['result'] = get_join("saprecords", $tableTo, $joinCond, $where, $select, "voucher_no", "saprecords.id", "desc");
        //print_r($this->data['result']);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/all-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    /**
     * Fetch all hire sale from the database table.
     **/
    public function hireSale(){
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu_elec"';
        $this->data['subMenu']    = 'data-target="hire-all"';
        $this->data['result']     = null;
        
        // read all client
        $partyWhere = array(
            'type'           => 'client',
            'customer_type'  => 'hire',
            'status'         => 'active',
            'trash'          => 0
        );
        $this->data['allClients'] = $this->getAllClient('hire');
    
        // get all godowns
        $this->data['allGodowns'] = getAllGodown();
        
       
        //Today's Data
        $where['saprecords.status'] = 'sale';
        $where['saprecords.trash']  = 0;
        $where['saprecords.sap_type'] = 'credit';
        if(isset($_POST['show'])){
            
            foreach($_POST['search'] as $key => $val) {
                if(!empty($val)){
                    $where["saprecords.$key"] = $val;
                }
            }

            if(!empty($_POST['product_model'])){
                $where['sapitems.product_model'] = $_POST['product_model'];
            }
              
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['saprecords.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['saprecords.godown_code'] = $this->data['branch'];
            }

            foreach($_POST['date'] as $key => $val) {
                if(!empty($val) && $key == 'from') {
                    $where['saprecords.sap_at >='] = $val;
                }

                if(!empty($val) && $key == 'to') {
                    $where['saprecords.sap_at <='] = $val;
                }
            }
            
        } else {
            $where['saprecords.sap_at'] = date("Y-m-d");
            $where['saprecords.godown_code'] = $this->data['branch'];
        }
        
        $tableTo                = ['godowns', 'sapitems'];
        $joinCond               = ['godowns.code=saprecords.godown_code', 'sapitems.voucher_no=saprecords.voucher_no'];
        $select                 = ['saprecords.*', 'godowns.name as godown_name', 'sapitems.product_model'];
        $this->data['result']   = get_join("saprecords", $tableTo, $joinCond, $where, $select, "voucher_no", "saprecords.id", "desc");

        

        
      
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/all-hire-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    // get all clients
    private function getAllClient($type = null){
        
        $clientWhere = array(
            'type'    => 'client',
            'status'  => 'active',
            'trash'   => 0
        );
        
        if(!empty($type)){
            $clientWhere['customer_type'] = 'hire';
        }else{
            $clientWhere['customer_type !='] = 'hire';
        }
        
        if(!checkAuth('super')){
            $clientWhere['godown_code'] = $this->data['branch'];
        }
        
        $result = get_result('parties', $clientWhere, ['code', 'name', 'mobile']);
        return $result;
    }


 public function client_godown_wise(){  
         $godown_code = $this->input->post('godown_code');
         if($godown_code == 'all'){
             $Parties = $this->action->read('parties',array('trash'=>0,'type'=>'client'));
         }else{
             $Parties = $this->action->read('parties',array('trash'=>0,'godown_code' => $godown_code,'type'=>'client'));
         }
         
         if(!empty($Parties)){
            echo '<option value="">Select Client</option>';
            foreach($Parties as $val){
                echo '<option value="'.$val->code.'" >'.$val->code.'-'.$val->name.'-'.$val->mobile.'</option>';
            }
         
         }
    } 


 public function hire_client_godown_wise(){  
         $godown_code = $this->input->post('godown_code');
         if($godown_code == 'all'){
             $Parties = $this->action->read('parties',array('trash'=>0,'type'=>'client','customer_type' => 'hire'));
         }else{
             $Parties = $this->action->read('parties',array('trash'=>0,'godown_code' => $godown_code,'type'=>'client','customer_type' => 'hire'));
         }
         
         if(!empty($Parties)){
            echo '<option value="">Select Client</option>';
            foreach($Parties as $val){
                echo '<option value="'.$val->code.'" >'.$val->code.'-'.$val->name.'-'.$val->mobile.'</option>';
            }
         
         }
    } 




}
