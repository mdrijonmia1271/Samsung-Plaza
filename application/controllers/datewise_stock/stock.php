<?php

class Stock extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['colorList'] = get_result('colors', ['trash' => 0]);

        $this->data['meta_title'] = 'Stock';
        $this->data['active']     = 'data-target="raw_stock_menu_date"';
    }

    public function index()
    {

        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        // godown list
        $this->data['godownList'] = getAllGodown();

        $this->data['categoryList']    = get_result('category');
        $this->data['subcategoryList'] = get_result('subcategory', ['trash' => 0]);
        $this->data['brandList']       = get_result('brand', ['trash' => 0]);
        $this->data['colorsList']      = get_result('colors', ['trash' => 0]);

        $this->data['productList'] = get_result('stock', '', ['code', 'name', 'product_model', 'product_serial'], 'code');

        $where = [];

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
        $this->load->view('components/datewise_stock/stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

}