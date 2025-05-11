<?php

class Production extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }

  public function index() {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="production_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $where = array(
            'type'   => 'finish_product',
            'status' => 'available',
            'trash'  => 0
         );

        $whereR = array(
            'quantity > '   => 0,
            'unit'          => 'Kg',
            'godown'        => 1,
            'type'          => 'raw'
        );

        $this->data['result'] = $this->action->read('materials',$where);
        $this->data['raws'] = $this->action->readGroupBy('stock','code',$whereR);

        if(isset($_POST['save'])){
            $mesg = $this->saveData();
            $this->session->set_flashdata("confirmation", $mesg);

            redirect("production/production","refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/production/nav', $this->data);
        $this->load->view('components/production/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function saveData(){
        foreach ($_POST['raw_code'] as $key => $value) {
            $data = array(
                "date"               => date("Y-m-d"),
                "batch_no"           => $this->input->post("batch_no"),
                "raw_material"       => $value,
                "raw_unit"           => "Kg",
                "raw_quantity"       => $_POST['raw_quantity'][$key],
                "finish_product"     => $this->input->post('finish_product_code'),
                "quantity"           =>  $this->input->post('finish_quantity'),
                "finish_unit"        => "Kg"
            );
          $this->action->add("production",$data);
        }

        $msg = array(
            "title"  => "success",
            "emit"   => "Production Successfully Completed!",
            "btn"    => true
        );

       $message = message("success",$msg);
       $this->handleStock();
       $this->handleRawStock();
      return $message;
    }

    private function handleStock(){
        $code = $this->input->post("finish_product_code");
        $where = array(
            "code"       => $code,
            "unit"       => "Kg",
            "godown"     => 1,
            "type"       => "finish_product"
        );

        $stockInfo = $this->action->read("stock",$where);
        if($stockInfo != NULL){
            $quantity = $stockInfo[0]->quantity + $this->input->post("finish_quantity");

            $data = array("quantity"  => $quantity);
            $this->action->update("stock",$data,$where);
        }else{
            $data = array(
                "code"       => $code,
                "name"       => $this->input->post("finish_product"),
                "quantity"   => $this->input->post("finish_quantity"),
                "unit"       => "Kg",
                "godown"     => 1,
                "type"       => "finish_product"
            );
          $this->action->add("stock",$data);
        }

        return true;
    }

    private function handleRawStock(){
        foreach ($_POST['raw_code'] as $key => $value) {
            $where = array(
                "code"       => $value,
                "unit"       => "Kg",
                "godown"     => 1,
                "type"       => "raw"
            );

            $stockInfo = $this->action->read("stock",$where);

            if($stockInfo != NULL){
                $quantity = $stockInfo[0]->quantity -  $_POST['raw_quantity'][$key];

                $data = array("quantity"  => $quantity);
                $this->action->update("stock",$data,$where);
            }
        }
      return true;
    }

      public function view_all() {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="production_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        
        
        // Finish Product
        $whereF = array(
            'type'   => 'finish_product',
            'status' => 'available',
            'trash'  => 0
         );
        $this->data['finish_product'] = $this->action->read('materials',$whereF);
        
        
         if(isset($_POST['show'])){
             
            $where = array();
            
            if($this->input->post('search') != null) {

                foreach($_POST['search'] as $key => $val) {
                    if($val != null){
                        $where[$key] = $val;
                    }
                }
            
            }

            foreach($_POST['date'] as $key => $val) {
                if($val != null && $key == 'from') {
                    $where['date >='] = $val;
                }

                if($val != null && $key == 'to') {
                    $where['date <='] = $val;
                }
            }
        }
        
        $where['status'] = 'available';
        $where['trash'] = 0;
        
        $this->data['result'] = $this->action->readGroupBy('production',"batch_no", $where,"id","asc");
        
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/production/nav', $this->data);
        $this->load->view('components/production/view_all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

     public function view($code=null) {
        $this->data['active']       = 'data-target="production_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array('batch_no'   => $code);
        $this->data['record'] = $this->action->read('production',$where);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/production/nav', $this->data);
        $this->load->view('components/production/view', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

     public function edit($code=null) {
        $this->data['active']       = 'data-target="production_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        if(isset($_POST['edit'])){
            foreach ($_POST['raw_code'] as $key => $value) {
                $dataP = array(
                    "finish_product" =>  $this->input->post("finish_product_code"),
                    "quantity"       =>  $this->input->post("finish_quantity")
                );

                $this->action->update("production",$dataP,array("batch_no"  => $code));
            }

            $condition = array(
                "code"    =>  $this->input->post("finish_product_code"),
                "godown"  => 1,
                "type"    => "finish_product"
            );

            $stockInfo  = $this->action->read("stock",$condition);
            $quantity  = 0;
            if($stockInfo != NULL){
                if($this->input->post("old_finish_quantity") > $this->input->post("finish_quantity")){
                    $quantity = $stockInfo[0]->quantity - ($this->input->post("old_finish_quantity") - $this->input->post("finish_quantity"));
                }else{
                    $quantity = $stockInfo[0]->quantity + ($this->input->post("finish_quantity") - $this->input->post("old_finish_quantity"));
                }
            }

            $dataS = array(
                "name"           =>  $this->input->post("finish_product"),
                "quantity"       =>  $quantity
            );
            $options = array(
                "title"   => "update",
                "emit"    => "Production has been successfully Updated!",
                "btn"     => true
            );

            $msg = message($this->action->update("stock",$dataS,$condition),$options);

            $this->session->set_flashdata("confirmation",$msg);
            redirect("production/production/view_all","refresh");
        }



        $cond = array('type' => 'finish_product', 'status' =>'available','trash' =>0);
        $this->data['result'] = $this->action->read('materials',$cond);

        $from = "stock";
        $join = "production";
        $join_cond = "production.finish_product = stock.code";
        $where = array('batch_no' => $code,"trash" => 0);
        $this->data['production'] = $this->action->joinAndRead($from,$join,$join_cond,$where);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/production/nav', $this->data);
        $this->load->view('components/production/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function delete($code = NULL){

        $where = array("batch_no" => $code);
        $data  = array("trash" =>1 );


        $msg_array=array(
            "title" =>"delete",
            "emit"  =>"Production Successfully Deleted",
            "btn"   =>true
        );

        $quantity = 0;
        $productInfo = $this->action->read("production",$where);

        if($productInfo != NULL){
            $cond = array("code" => $productInfo[0]->finish_product);
            $stockInfo = $this->action->read("stock",$cond);
            $quantity = ($stockInfo) ? $stockInfo[0]->quantity - $productInfo[0]->quantity : 0;
            $this->action->update("stock",array('quantity' => $quantity),$cond);

            $this->deleteRawStock($code);
        }

        $this->data['confirmation']=message($this->action->update('production',$data,$where),$msg_array);

        $this->session->set_flashdata("confirmation",$this->data['confirmation']);

        redirect("production/production/view_all","refresh");
    }

    private function deleteRawStock($code = NULL){
        $where = array("batch_no" => $code);

        $productInfo = $this->action->read("production",$where);

        if($productInfo != NULL){
            foreach ($productInfo as $key => $value) {
                $cond = array("code" => $value->raw_material);
                $stockInfo = $this->action->read("stock",$cond);

                $quantity = ($stockInfo) ? $stockInfo[0]->quantity + $value->raw_quantity : 0;
                $this->action->update("stock",array('quantity' => $quantity),$cond);
            }
        }
        return true;
    }

}
