<?php
class Damages extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->library('upload');
    }

    public function index() {
        $this->data['meta_title'] = 'Damages';
        $this->data['active'] = 'data-target="damages_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->data['product'] = $this->action->read('stock');

        if ($this->input->post("product_add")) {

            $data = array(
                "date"         => date('Y-m-d'),
                "product_code" => $this->input->post('product_code'),
                "quantity"     => $this->input->post('quantity'),
                "unit"         => $this->input->post('unit'),
                "remark"       => $this->input->post('remark')
                );
            // Add damage product to damage_product table
            $this->action->add('damage_product',$data);


            // Update stock table start here
            $damageWhere   = array("code" => $this->input->post('product_code'));
            $stockInfo     = $this->action->read("stock",$damageWhere);
            $NewQuanity    = $this->input->post('quantity');
            $OldQuantity   = $stockInfo[0]->quantity;
            $updateQuanity = $OldQuantity - $NewQuanity;
           
            $update_data = array("quantity"=> $updateQuanity,"type"=> 'damage');

            $this->action->update('stock',$update_data,$damageWhere);

            // Update stock table end here


            $options = array(
                'title' =>"success",
                'emit'  =>"Damage Product successfully Move!",
                'btn'   => true
            );
            
            $msg = message('success', $options);
            $this->session->set_flashdata("confirmation", $msg);
            redirect("damages/damages","refresh");

        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/damages/nav', $this->data);
        $this->load->view('components/damages/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function view_all() {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="damages_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['results'] = $this->action->read('damage_product');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/damages/nav', $this->data);
        $this->load->view('components/damages/all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }

    public function edit($id=null) {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="damages_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array('trash' =>0);
        $this->data['product'] = $this->action->read('materials',$where);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/damages/nav', $this->data);
        $this->load->view('components/damages/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function editDamages($id=null){

        $where  = array('id' =>$id);


        $data=array(
            'name'      =>  $this->input->post('product_name'),
            'price'     =>  $this->input->post('sale_price'),
            'status'    =>  $this->input->post('status')
          );
        $msg_array=array(
            'title' =>'update',
            'emit'  =>'Damages Products Successfully Updated!',
            'btn'   =>true
         );

        $this->data['confirmation']=message($this->action->update('materials',$data,$where),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('damages/damages/view_all','refresh');
    }

    public function delete($id = NULL){

        $where = array("id" =>$id);

        $data = array("trash" =>1 );

        $msg_array=array(
            "title" =>"delete",
            "emit"  =>"Damages Products Successfully Deleted",
            "btn"   =>true
        );
        $this->data['confirmation']=message($this->action->update('materials',$data,$where),$msg_array);
        $this->session->set_flashdata("confirmation",$this->data['confirmation']);

        redirect('damages/damages/view_all','refresh');
    }   
}
