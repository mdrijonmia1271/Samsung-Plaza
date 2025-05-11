<?php

class Sales_report extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');

        $this->data['meta_title'] = 'Report';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index()
    {

        $this->data['subMenu'] = 'data-target="sales_report"';
        $this->data['result']  = null;

        $whereClient              = ['type' => 'client', 'status' => 'active', 'trash' => 0];
        $this->data['allClients'] = get_result('parties', $whereClient, ['code', 'name', 'mobile']);

        //Today's Data

        $where = ['status' => 'sale', 'trash' => 0];

        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if ($val != null) {
                    $where[$key] = $val;
                }
            }

            if (!empty($_POST['godown_code'])) {
                if ($_POST['godown_code'] != 'all') {
                    $where['godown_code'] = $_POST['godown_code'];
                }
            } else {
                $where['godown_code'] = $this->data['branch'];
            }

            foreach ($_POST['date'] as $key => $value) {
                if ($value != NULL && $key == "from") {
                    $where['sap_at >='] = $value;
                }
                if ($value != NULL && $key == "to") {
                    $where['sap_at <='] = $value;
                }
            }

        } else {
            $where["godown_code"] = $this->data['branch'];
            $where["sap_at"]      = date('Y-m-d');
        }

        $select               = ['sap_at', 'party_code', 'sap_type', 'godown_code', 'sap_type', 'voucher_no', 'paid', 'total_bill'];
        $this->data['result'] = get_result('saprecords', $where, $select);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }

    public function sales_report_item()
    {
        $this->data['subMenu'] = 'data-target="sales_report_item"';

        // get all product
        $this->data['allProduct'] = get_result('products', ['status' => 'available'], ['product_code', 'product_model']);

        // get all category
        $this->data['allCategory'] = get_result('category', '', ['category']);

        // get all sub category
        $this->data['allSubCategory'] = get_result('subcategory', ['trash' => 0], ['subcategory']);

        // get all brand
        $this->data['allBrand'] = get_result('brand', ['trash' => 0], ['brand']);

        // get all product serial
        $this->data['allProductSerial'] = get_result('sapitems', ['quantity >' => 0,'product_serial !=' => ''],'', ['product_serial']);

        // Today's Data
        $where = ['sapitems.status' => 'sale', 'sapitems.trash' => 0];
        $groupBy = "products.product_code,sapitems.product_serial";
        if (isset($_POST['show'])) {

            // godown wise
            if (!empty($_POST['godown_code'])) {
                if ($_POST['godown_code'] != 'all') {
                    $where['sapitems.godown_code'] = $_POST['godown_code'];
                }
            } else {
                $where['sapitems.godown_code'] = $this->data['branch'];
            }

            // product code wise
            if (!empty($_POST['product_code'])) {
                $where["products.product_code"] = $_POST['product_code'];
            }
            
            // category wise
            if (!empty($_POST['product_cat'])) {
                $where["products.product_cat"] = $_POST['product_cat'];
                $groupBy = "products.product_code, products.product_cat,sapitems.product_serial";
            }
            
            // subcategory wise
            if (!empty($_POST['subcategory'])) {
                $where["products.subcategory"] = $_POST['subcategory'];
                $groupBy = "products.product_code, products.subcategory,sapitems.product_serial";
            }
            
            // brand wise
            if (!empty($_POST['brand'])) {
                $where["products.brand"] = $_POST['brand'];
                $groupBy = "products.product_code, products.brand,sapitems.product_serial";
            }


             // serial wise
            if (!empty($_POST['product_serial'])) {
                $where["sapitems.product_serial"] = $_POST['product_serial'];
                $groupBy = "products.product_code, products.brand,sapitems.product_serial";
            }

            // date wise
            foreach ($_POST['date'] as $key => $value) {
                if (!empty($value) && $key == "from") {
                    $where['sapitems.sap_at >='] = $value;
                }
                if (!empty($value) && $key == "to") {
                    $where['sapitems.sap_at <='] = $value;
                }
            }
            
          
        }else{
            $where["sapitems.godown_code"] = $this->data['branch'];
            $where["sapitems.sap_at"]      = date('Y-m-d');
            
        }

        $tableTo              = ['products', 'godowns'];
        $joinCond             = ["sapitems.product_code=products.product_code", "godowns.code=sapitems.godown_code"];
        $items                = ['sapitems.sap_at','voucher_no','SUM(sapitems.quantity) AS quantity', 'AVG(sapitems.sale_price) AS sale_price', 'products.product_code', 'products.product_name', 'products.product_model', 'products.unit', 'godowns.name as godown_name','product_serial'];
        $this->data['results'] = get_join('sapitems', $tableTo, $joinCond, $where, $items, $groupBy);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_report_item', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }

    public function sales_return_report()
    {

        $this->data['subMenu'] = 'data-target="sales_return_report"';


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_return_report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }


}