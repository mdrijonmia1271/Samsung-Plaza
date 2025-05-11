<?php

class BarcodeGenerate extends Admin_controller {

    function __construct() {
        parent::__construct();

        $this->holder();
        $this->load->model('action');

        $this->data['meta_title'] = 'Barcode';
        $this->data['active'] = 'data-target="barcode_menu"';
    }

    public function index() {
         $this->data['subMenu'] = 'data-target="barcodegen"';
         $this->data['row'] = $this->data['column'] = $this->data['allProducts'] = null;
         $this->data['products'] = array();

        // after form submit
        if(isset($_POST['generateForm'])){
        	$column = 7;

        	foreach($_POST['code'] as $key => $value){
        	    
        		$where = array("product_code" => $value);
            	$info = $this->action->read('products', $where);
            	//print_r($info);

        		if($info){
	        		$product = array(
                        'quantity'    => $_POST['quantity'][$key],
                        'sale_price'  => $_POST['sale_price'][$key],
                        'column'      => $column,
                        'row'         => ceil($_POST['quantity'][$key] / $column),
                        'code'        => $value,
                        'img'         => base_url('public/uploaded_barcode') . '/' . $value . ".png",
                        'productInfo' => (array)$info[0]
	        		);

	        		//print_r($product);
	        		$this->data['products'][] = $product;
        		}
        	}
        }
        
        
        $this->data['allProducts'] = $this->action->read("products",array("status" => 'available'));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/barcode/menu', $this->data);
        $this->load->view('components/barcode/barcodeGenerate', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }


    /**
     *  description:
     *     fetch purchase record from database
     */
    public function show_purchase(){

        $this->data['subMenu'] = 'data-target="purchase_barcode_upload"';
        $this->data['result'] = null;

        if(isset($_POST['show'])){
            $where = array();
            foreach($_POST['search'] as $key => $val){
                if($val != ''){
                    if($key == 'voucher_no'){
                        $where['saprecords.'.$key] = $val;
                    }else{
                        $where[$key] = $val;
                    }
                }    
            }

            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['saprecords.sap_at >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['saprecords.sap_at <='] = $val;
                }
            }
            
           $joinCond = 'saprecords.voucher_no=sapitems.voucher_no';
           $where['total_quantity > '] = 0;
           $where['saprecords.'.'trash'] = 0;
           $where['saprecords.'.'status'] = 'purchase';
           $this->data['result'] = $this->action->joinAndReadGroupby('saprecords', 'sapitems', $joinCond, $where, 'saprecords.voucher_no');
           
           //print_r($where);
           //print_r($this->data['result']);
        }

        // get all vendors
        $this->data['allVendors'] = $this->getAllVendors();
        
        // get all product
        $this->data['allProduct'] = $this->getAllProduct();
        
        
        // get all category
        $this->data['allCategory'] = $this->getAllCategory();
        
        // get all subcategory
        $this->data['allSubCategory'] = $this->getAllSubCategory();

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/barcode/menu', $this->data);
        $this->load->view('components/barcode/show_purchase', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);   
    }

    /**
     *  description: 
     *      Read all products from database table voucher wise.
     *      Generate barcode and upload to directory.
     *      Show success message.
     */
    public function barcode_generate(){
        $this->data['subMenu'] = 'data-target="purchase_barcode_upload"';
        $this->data['row'] = $this->data['column'] = $this->data['results'] = null;
        $this->data['products'] = array();

        $where = array("voucher_no" => $_GET['vno']);
        $this->data['results'] = $this->action->read("sapitems", $where);
        //print_r($where);
        //print_r($this->data['results']);

        //Generate All Barcode data
        $codes = array();
        foreach($this->action->read_col("sapitems", "product_code", array("voucher_no" => $_GET['vno'])) as $key => $val){
            $codes[] = $val->product_code;
        }
        $this->data['codes'] = json_encode($codes);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/barcode/menu', $this->data);
        $this->load->view('components/barcode/purchase_barcode_upload', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    
    public function purchase_wise() {
        $this->data['subMenu'] = 'data-target="purchase_barcode"';
        $this->data['result'] = null;

        if(isset($_POST['show'])){
            
            $where = array();
            foreach($_POST['search'] as $key => $val){
                if($val != ''){
                    if($key == 'voucher_no'){
                        $where['saprecords.'.$key] = $val;
                    }else{
                        $where[$key] = $val;
                    }
                }
            }

            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['saprecords.sap_at >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['saprecords.sap_at <='] = $val;
                }
            }
            
           $joinCond = 'saprecords.voucher_no=sapitems.voucher_no';
           $where['total_quantity > '] = 0;
           $where['saprecords.'.'trash'] = 0;
           $where['saprecords.'.'status'] = 'purchase';
           $this->data['result'] = $this->action->joinAndReadGroupby('saprecords', 'sapitems', $joinCond, $where, 'saprecords.voucher_no');
        }

        // get all vendors
        $this->data['allVendors'] = $this->getAllVendors();
        
        // get all product
        $this->data['allProduct'] = $this->getAllProduct();
        
        
        // get all category
        $this->data['allCategory'] = $this->getAllCategory();
        
        // get all subcategory
        $this->data['allSubCategory'] = $this->getAllSubCategory();

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/barcode/menu', $this->data);
        $this->load->view('components/barcode/purchase_wise', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    
    
    private function getAllVendors(){
        $vendors = $this->action->read('parties', array('type'=>'supplier', "trash" => "0"));
        return $vendors;
    }
    
    
     private function getAllProduct(){
        $product = $this->action->readGroupBy('products', "product_name", array("status" => 'available'), "product_name", "asc");
        return $product;
    }
    

    private function getAllCategory(){
        $category = $this->action->read('category');
        return $category;
    }
    
      private function getAllSubCategory(){
        $subcategory = $this->action->read('subcategory');
        return $subcategory;
    }
    
    


    public function purchase_barocde() {
         $this->data['subMenu'] = 'data-target="purchase_barcode"';
         $this->data['row'] = $this->data['column'] = $this->data['results'] = null;
         $this->data['products'] = array();

        // after form submit
        if(isset($_POST['generateForm'])){
        	$column = 7;

        	foreach($_POST['code'] as $key => $value){
        		$where = array("product_code" => $value);
            		$info = $this->action->read('products', $where);

        		if($info){
	        		$product = array(
	        			'quantity' 	=> $_POST['quantity'][$key],
	        			'column' 	=> $column,
	        			'row'		=> ceil($_POST['quantity'][$key] / $column),
	        			'code' 		=> $value,
	        			'img' 		=> base_url('public/uploaded_barcode') . '/' . $value . ".png",
	        			'productInfo'	=> (array)$info[0]
	        		);

	        		$this->data['products'][] = $product;
        		}
        	}
        }

        $this->data['results'] = $this->action->read("sapitems", array("voucher_no" => $_GET['vno']));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/barcode/menu', $this->data);
        $this->load->view('components/barcode/purchase_barocde', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }



    public function rangeBarcode() {
         $this->data['subMenu'] = 'data-target="range"';
         $this->data['row'] = $this->data['column'] = null;

        // after form submit
        if(isset($_POST['generateForm'])){
            $this->data['from'] = $this->input->post('from');
            $this->data['to'] = $this->input->post('to');
            $this->data['quantity'] = ($this->data['to'] - $this->data['from']) + 1;
            $this->data['column'] = 4;
            $this->data['row'] = ceil($this->data['quantity'] / $this->data['column']);

            $forF = $this->input->post('from');
            $forT = $this->input->post('to');

            $this->data["proInfo"] = $this->action->readProductRange('products', 'bar_code', $forF, $forT);
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/barcode/menu', $this->data);
        $this->load->view('components/barcode/rangebarcodeGenerate', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    private function holder(){
       if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}



