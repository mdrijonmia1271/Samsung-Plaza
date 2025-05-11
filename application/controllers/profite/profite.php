<?php
class Profite extends Admin_Controller {

   function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index($emit = null) {
        $this->data['meta_title'] = 'Profite';
        $this->data['active'] = 'data-target="profite_menu"';
        $this->data['subMenu'] = 'data-target="product"';
        $this->data['confirmation'] = $this->data['result'] = null;

        $joinCond = "sapitems.product_code = products.product_code";
        $this->data["allProduct"] = $this->action->joinAndReadGroupby("sapitems", "products", $joinCond, array(), "sapitems.product_code");

        $where = array();
        if(isset($_POST['show'])){

            $where = array();
            foreach ($_POST["search"] as $key => $value) {
                if ($value != null) {
                    $where[$key] = $value;
                }
            }

            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['sap_at >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['sap_at <='] = $val;
                }
            }
        }

        $this->data['result'] = $this->action->readGroupBy("sapitems", "product_code, unit", $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/profite/nav', $this->data);
        $this->load->view('components/profite/profite', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }


    public function brand_wise($emit = null) {
        $this->data['meta_title'] = 'Profite';
        $this->data['active'] = 'data-target="profite_menu"';
        $this->data['subMenu'] = 'data-target="brand"';
        $this->data['confirmation'] = $this->data['result'] = null;

        $joinCond = "sapitems.product_code = products.product_code";
        $this->data["allProduct"] = $this->action->joinAndReadGroupby("sapitems", "products", $joinCond, array(), "products.subcategory");

        $where = array();
        if(isset($_POST['show'])){
           $where = array();
            foreach ($_POST["search"] as $key => $value) {
                if ($value != null) {
                    $where[$key] = $value;
                }
            }

            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['sap_at >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['sap_at <='] = $val;
                }
            }
        }
        $joinCond = "sapitems.product_code = products.product_code";
        $this->data["result"] = $this->action->joinAndReadGroupby("sapitems", "products", $joinCond, $where, "sapitems.product_code");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/profite/nav', $this->data);
        $this->load->view('components/profite/brand-wise', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

}
