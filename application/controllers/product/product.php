<?php

class Product extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
        $this->load->library('upload');
        $this->load->helper('barcode');
        
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //get all data
        $this->data['allCategory']    = get_result('category');
        $this->data['allSubcategory'] = get_result('subcategory', ['trash' => 0]);
        $this->data['allBrand']       = get_result('brand', ['trash' => 0]);
    }

    public function index()
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store data
    public function store()
    {
        /*$productCode = rand(10000, 99999);
        while (check_exists('products', ['product_code' => $productCode])) {
            $productCode = rand(10000, 99999);
        }*/

        if (isset($_POST['save'])) {

            $data = [
                //'product_name'   => $this->input->post('product_name'),
                'product_name'   => $this->input->post('product_model'),
                'product_model'  => $this->input->post('product_model'),
                'product_code'   => $this->input->post('code'),
                'product_cat'    => $this->input->post('category'),
                'subcategory'    => $this->input->post('sub_category'),
                'brand'          => $this->input->post('brand'),
                'purchase_price' => $this->input->post('purchase_price'),
                'sale_price'     => $this->input->post('sale_price'),
                'unit'           => $this->input->post('unit'),
                'status'         => $this->input->post('status')
            ];

            save_data('products', $data);
            
            $product_code = $this->input->post('code');
            //generate barcode
            Zend_Barcode::setBarcodeFont("private/fonts/Roboto/Roboto-Regular.ttf");
            $barcodeImage = Zend_Barcode::factory('code128', 'image', ['text'=> $product_code, 'barHeight' => 23, 'fontSize' => 12], [])->draw();
            imagepng($barcodeImage, './public/uploaded_barcode/' . $product_code . image_type_to_extension(IMAGETYPE_PNG));
            imagedestroy($barcodeImage);


            $mag = [
                "title" => "success",
                "emit"  => "Product add successful.",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $mag));
        }
            redirect('product/product', 'refresh');
    }

    public function allProduct()
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    public function edit($code = null)
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['info'] = get_row('products', ['product_code' => $code]);
        if (empty($this->data['info'])) redirect('product/product/allProduct');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // update data
    public function update($code = null)
    {
        if (isset($_POST['update']) && !empty($code)) {

            // update product info
            $data = [
                //'product_name'   => $this->input->post('product_name'),
                'product_name'   => $this->input->post('product_model'),
                'product_model'  => $this->input->post('product_model'),
                'product_cat'    => $this->input->post('category'),
                'subcategory'    => $this->input->post('sub_category'),
                'brand'          => $this->input->post('brand'),
                'purchase_price' => $this->input->post('purchase_price'),
                'sale_price'     => $this->input->post('sale_price'),
                'unit'           => $this->input->post('unit'),
                'status'         => $this->input->post('status')
            ];

            save_data('products', $data, ['product_code' => $code]);

            // update stock info
            $stockData = [
                //'name'           => $this->input->post('product_name'),
                'name'           => $this->input->post('product_model'),
                'product_model'  => $this->input->post('product_model'),
                'category'       => $this->input->post('category'),
                'subcategory'    => $this->input->post('sub_category'),
                'brand'          => $this->input->post('brand'),
                'purchase_price' => $this->input->post('purchase_price'),
                'sell_price'     => $this->input->post('sale_price'),
                'unit'           => $this->input->post('unit'),
            ];

            save_data('stock', $stockData, ['code' => $code]);

            $mag = [
                "title" => "success",
                "emit"  => "Product add successful.",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $mag));
        }
        redirect('product/product/allProduct', 'refresh');
    }


    public function delete($id = NULL)
    {
        if (!empty($id)) {

            save_data('products', ['trash' => 1], ['id' => $id]);

            $msg = [
                "title" => "delete",
                "emit"  => "Product Successfully Deleted",
                "btn"   => true
            ];

            $this->data['confirmation'] = message('danger', $msg);
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
        }

        redirect("product/product/allProduct", "refresh");
    }
}
