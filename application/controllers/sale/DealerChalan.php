<?php
class DealerChalan extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="d_c"';
        
        // get all godowns
        $this->data['allGodowns'] = getAllGodown();
        // get all client
        $this->data['allClients'] = $this->getAllClient();

        //Today's Data
        $where['saprecords.status'] = 'sale';
        $where['saprecords.sap_type'] = 'dealer';
        $where['saprecords.trash']  = 0;
        if(isset($_POST['show'])){
            
            foreach($_POST['search'] as $key => $val) {
                if($val != null){
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
                if($val != null && $key == 'from') {
                    $where['saprecords.sap_at >='] = $val;
                }

                if($val != null && $key == 'to') {
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

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/DealerChalan', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function view() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="d_c"';
        
        $where = array(
            'voucher_no'    => $this->input->get('vou'),
            'status'        => 'sale',
            'trash'         => 0
        );

        $this->data['result'] = get_row('saprecords', $where);
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/DealerView', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    // get all clients
    private function getAllClient(){
        
        $clientWhere = array(
            'type'    => 'client',
            'status'  => 'active',
            'customer_type'  => 'dealer',
            'trash'   => 0
        );
        
        if(!checkAuth('super')){
            $clientWhere['godown_code'] = $this->data['branch'];
        }
        
        $result = get_result('parties', $clientWhere, ['code', 'name', 'mobile']);
        return $result;
    }
}
