<?php
class Product extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->library('upload');
        $this->holder();
    }
    
    public function index() {
        $this->data['meta_title'] = 'Product';
        $this->data['active'] = 'data-target="f_product_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        if ($this->input->post("save")) {
            $data=array(
                "date"   => date("Y-m-d"),
                "category" => $this->input->post("category"),
            );

          //Uploading Students Photo
            if ($_FILES["image"]["name"]!=null && $_FILES["image"]["name"]!="" ) {

                $config['upload_path'] = './public/upload/product';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] =str_shuffle("Product".rand(100000,999999)); 
                $config['overwrite']=true;   

                $this->upload->initialize($config);
                if ($this->upload->do_upload("image")){
                    $upload_data = $this->upload->data();
                    $data["image"]="public/upload/product/".$upload_data['file_name'];
                }
            }

            $msg_array=array(
                "title"=>"Success", 
                "emit"=> "Product Successfully Saved",
                "btn"=>false
            );
            $this->data['confirmation'] = message($this->action->add("front_product",$data), $msg_array);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/frontproduct/nav', $this->data);
        $this->load->view('components/frontproduct/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function allProduct() {
        $this->data['meta_title'] = 'Product';
        $this->data['active'] = 'data-target="f_product_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data["products"] = $this->action->read("front_product");

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/frontproduct/nav', $this->data);
        $this->load->view('components/frontproduct/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }

    public function editProduct($id=null) {
        $this->data['meta_title'] = 'Product';
        $this->data['active'] = 'data-target="f_product_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/frontproduct/nav', $this->data);
        $this->load->view('components/frontproduct/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function delete($id=null){
        $where = array("id" => $id);
        $info = $this->action->read("front_product",$where);
        if(is_file("./".$info[0]->image)){
            unlink("./".$info[0]->image);
        }
        $this->action->deleteData("front_product", $where);

        $msg_array=array(
            "title"=>"Deleted",
            "emit"=>"Product Successfully Deleted",
            "btn"=>true
        );
        $this->session->set_flashdata('confirmation', message("danger",$msg_array));
        redirect('frontproduct/product/allProduct','refresh');
    }


    private function holder(){
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

    
}
