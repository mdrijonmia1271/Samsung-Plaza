<?php

class All_sale_return extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }  

    public function index()
    {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="all_sale_return"';
        $this->data['result']     = null;

        // get all godown
        $this->data['godownList'] = getAllGodown();

        // get product list
        $this->data['productList'] = get_result('products', ['status' => 'available', 'trash' => 0], ['product_code', 'product_name', 'product_model']);
        $this->data['brandList'] = get_result('brand', ['trash' => 0]);

        //Today's Data
        $where = [
            'saprecords.status' => 'sale_return',
            'saprecords.trash'  => 0,
        ];

        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if (!empty($val)) {
                    $where['saprecords.' . $key] = $val;
                }
            }

            if (!empty($_POST['product_code'])) {
                $where['sapitems.product_code'] = $_POST['product_code'];
            }

            if (!empty($_POST['dateFrom'])) {
                $where['saprecords.sap_at >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['saprecords.sap_at <='] = $_POST['dateTo'];
            }
        } else {
            $where['saprecords.sap_at'] = date("Y-m-d");
        }

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['saprecords.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['saprecords.godown_code'] = $this->data['branch'];
        }

        $tableTo  = ['godowns', 'sapitems'];
        $joinCond = ['godowns.code=saprecords.godown_code', 'sapitems.voucher_no=saprecords.voucher_no'];
        $select   = ['saprecords.*', 'godowns.name as godown_name', 'sapitems.product_model'];

        $this->data['results'] = get_left_join("saprecords", $tableTo, $joinCond, $where, $select, "voucher_no", "saprecords.id", "desc");

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/all_sale_return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

}
