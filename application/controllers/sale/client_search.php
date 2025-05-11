<?php

class Client_search extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="client_search"';
        $this->data['result'] = null;

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        // get all category
        $this->data['allCategory'] = get_result('category');

        if(isset($_POST['show'])){
            
            // filter party code
            if(!empty($_POST['party_code'])){
                $where['saprecords.party_code'] = $_POST['party_code'];
            }

            // filter party code
            if(!empty($_POST['product_cat'])){
                $where['products.product_cat'] = $_POST['product_cat'];
            }
            
            // filter godown
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] !== 'all'){
                    $where['saprecords.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['saprecords.godown_code'] = $this->data['branch'];
            }
            
            // filter date
            if(!empty($_POST['dateFrom'])){
                $where['saprecords.sap_at >='] = $_POST['dateFrom'];
            }
            if(!empty($_POST['dateTo'])){
                $where['saprecords.sap_at <='] = $_POST['dateTo'];
            }
            
            $where['saprecords.status'] = 'sale';
            
            $tableTo  = ['sapitems', 'products'];
            $joinCond = ['sapitems.voucher_no=saprecords.voucher_no', 'products.product_code=sapitems.product_code'];
            $select   = ['saprecords.sap_at', 'sapitems.product_code', 'sapitems.product_model', 'sapitems.godown_code', 'sapitems.quantity', 'sapitems.purchase_price', 'sapitems.sale_price', 'products.product_cat as category'];
            $this->data['result'] = get_join('saprecords', $tableTo, $joinCond, $where, $select);
        }
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale/client-search', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
}
