<?php

class Purchase_report_item extends Admin_Controller
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
        $this->data['subMenu'] = 'data-target="purchase_report_item"';
        $this->data['results'] = null;

        // get all party
        $this->data['allParty'] = $this->getAllparty();


        // Fetch Purchase Items Info
        $whereProduct             = ['status' => 'available'];
        $this->data['allProduct'] = get_result('products', $whereProduct, ['product_code', 'product_model']);

        // get all category
        $this->data['allCategory'] = get_result('category', '', ['category']);

        // get all sub category
        $this->data['allSubCategory'] = get_result('subcategory', ['trash' => 0], ['subcategory']);

        // get all brand
        $this->data['allBrand'] = get_result('brand', ['trash' => 0], ['brand']);


        // get all product serial
        $this->data['allProductSerial'] = get_result('sapitems', ['quantity >' => 0,'product_serial !=' => ''],'', ['product_serial']);


        // Today's Data dad
        $where = ['sapitems.status' => 'purchase', 'sapitems.trash' => 0];
        $groupBy = "products.product_code,sapitems.product_serial";
        if (isset($_POST['find'])) {

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
            
            
            // product code wise
            if (!empty($_POST['product_serial'])) {
                $where["sapitems.product_serial"] = $_POST['product_serial'];
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

            // date wise
            foreach ($_POST['date'] as $key => $value) {
                if (!empty($value) && $key == "from") {
                    $where['sapitems.sap_at >='] = $value;
                }
                if (!empty($value) && $key == "to") {
                    $where['sapitems.sap_at <='] = $value;
                }
            }
            
        } else {
            
            $where["sapitems.godown_code"] = $this->data['branch'];
            $where["sapitems.sap_at"]      = date('Y-m-d');
        }
        
        
        
        // Data Fetch 
        $tableTo              = ['products', 'godowns'];
        $joinCond             = ["sapitems.product_code=products.product_code", "godowns.code=sapitems.godown_code"];
        $items                = ['sapitems.sap_at', 'sapitems.voucher_no','SUM(sapitems.quantity) AS quantity', 'AVG(sapitems.purchase_price) AS purchase_price', 'products.product_code', 'products.product_name', 'products.product_model', 'products.unit', 'godowns.name as godown_name','product_serial'];
        $this->data['result'] = get_join('sapitems', $tableTo, $joinCond, $where, $items, $groupBy);

        


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/purchase_nav', $this->data);
        $this->load->view('components/report/purchase_report_item', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }


    private function getAllparty(){
        $where = array(
            "type"   => "supplier",
            "status" => "active",
            "trash"   => 0
        );
        $party = $this->action->read("parties", $where);
        return $party;
    }



}