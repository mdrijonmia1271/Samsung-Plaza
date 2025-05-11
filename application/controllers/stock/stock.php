<?php

class Stock extends Admin_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model('action');
    }

    public function index(){
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="stock"';
        $this->data['confirmation'] = null;

        // get all data
        $this->data['godownList']      = getAllGodown();
        $this->data['categoryList']    = get_result('category');
        $this->data['subcategoryList'] = get_result('subcategory', ['trash' => 0]);
        $this->data['brandList']       = get_result('brand', ['trash' => 0]);
        $this->data['colorsList']      = get_result('colors', ['trash' => 0]);

        $this->data['productList'] = get_result('stock', '', ['code', 'name', 'product_model', 'product_serial'], 'code');

        $where = ['stock.quantity >' => 0];
        $where = ['stock.category' => 'mobile'];

        if (isset($_POST['show'])) {
            if (isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $val) {
                    if (!empty($val)) {
                        $where['stock.' . $key] = $val;
                    }
                }
            }
        }

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['stock.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['stock.godown_code'] = $this->data['branch'];
        }

        $this->data['results'] = get_left_join('stock', 'godowns', 'stock.godown_code=godowns.code', $where, ['stock.*', 'godowns.name as godown_name']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    public function stock_single($productCode=null){
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="stock"';
        $this->data['confirmation'] = null;

        $where = ['stock.code' => $productCode, 'stock.quantity >' => 0];
        $this->data['results'] = get_left_join('stock', 'godowns', 'stock.godown_code=godowns.code', $where, ['stock.*', 'godowns.name as godown_name']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/stock-single', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    
    
    public function group_stock(){
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="groupStock"';
        $this->data['confirmation'] = null;

        // get all data
        $this->data['godownList']      = getAllGodown();
        $this->data['categoryList']    = get_result('category');
        $this->data['subcategoryList'] = get_result('subcategory', ['trash' => 0]);
        $this->data['brandList']       = get_result('brand', ['trash' => 0]);
        $this->data['colorsList']      = get_result('colors', ['trash' => 0]);

        $this->data['productList'] = get_result('stock', ['category' => 'mobile'], ['code', 'name', 'product_model', 'product_serial'], 'code');

        $where = ['stock.quantity >' => 0];

        if (isset($_POST['show'])) {
            if (isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $val) {
                    if (!empty($val)) {
                        $where['stock.' . $key] = $val;
                    }
                }
            }
        }

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['stock.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['stock.godown_code'] = $this->data['branch'];
        }
        
        $where['stock.category']= 'mobile';
        
        $this->data['results'] = get_left_join('stock', 'godowns', 'stock.godown_code=godowns.code', $where, ['stock.*', 'SUM(stock.quantity) AS quantity', 'godowns.name as godown_name'], 'stock.code');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/group-stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    
    
    public function group_stock_single($productCode=null){
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="groupStock"';
        $this->data['confirmation'] = null;


        $where = ['stock.code' => $productCode, 'stock.quantity >' => 0];
        $this->data['results'] = get_left_join('stock', 'godowns', 'stock.godown_code=godowns.code', $where, ['stock.*', 'SUM(stock.quantity) AS quantity', 'godowns.name as godown_name'], 'stock.code');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/nav', $this->data);
        $this->load->view('components/stock/group-stock-single', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    
     public function stock_elec(){
        $this->data['meta_title']   = 'Stock';
        $this->data['active']       = 'data-target="raw_stock_menu_elec"';
        $this->data['subMenu']      = 'data-target="stock_elec"';
        $this->data['confirmation'] = null;

        // get all data
        $this->data['godownList']      = getAllGodown();
        $this->data['categoryList']    = get_result('category');
        $this->data['subcategoryList'] = get_result('subcategory', ['trash' => 0]);
        $this->data['brandList']       = get_result('brand', ['trash' => 0]);
        $this->data['colorsList']      = get_result('colors', ['trash' => 0]);

        $this->data['productList'] = get_result('stock', '', ['code', 'name', 'product_model', 'product_serial'], 'code');

        $where = ['stock.quantity >' => 0];
        $where = ['stock.category' => 'electronics'];

        if (isset($_POST['show'])) {
            if (isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $val) {
                    if (!empty($val)) {
                        $where['stock.' . $key] = $val;
                    }
                }
            }
        }

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['stock.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['stock.godown_code'] = $this->data['branch'];
        }

        $this->data['results'] = get_left_join('stock', 'godowns', 'stock.godown_code=godowns.code', $where, ['stock.*', 'godowns.name as godown_name']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
}