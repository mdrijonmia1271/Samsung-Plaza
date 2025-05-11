<?php

class ReturnPurchase extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }
    public function index() {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active'] = 'data-target="purchase_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        

        if(isset($_POST['change'])){
            $this->session->set_flashdata('confirmation', $this->change());
            redirect("purchase/returnPurchase?vno=" . $this->input->get('vno'), "refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/return', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    private function change(){
        // update purchase record
        $total_quantity = 0;
        foreach ($_POST['id'] as $key => $value) {
            $newQuantity = 0;
            $newQuantity = ($_POST['old_quantity'][$key] - $_POST['return_quanity'][$key]);
            $total_quantity += $newQuantity;
            $data = array();
            $where = array('id' => $_POST['id'][$key]);

            $data['sap_at']         = $this->input->post('date');
            $data['purchase_price'] = $_POST['purchase_price'][$key];
            $data['quantity']       = $newQuantity;
            
            if($this->action->update('sapitems', $data, $where)){
                $this->handelStock($key);
            }
        }

        // update bill record
        if($this->input->post("previous_sign") == "Receivable"){
            $balance = 0 + $this->input->post('previous_balance');
        } else {
            $balance = 0 - $this->input->post('previous_balance');
        }

        $data = array(
            'total_quantity'    => $total_quantity,
            'total_bill'        => $this->input->post('new_grand_total'),
        );
        
        $where = array('voucher_no' => $this->input->get('vno'));
        $status = $this->action->update('saprecords', $data, $where);

        $this->handelPartyTransaction();

        $options = array(
            'title' => 'Updated',
            'emit'  => 'Purchase successfully changed!',
            'btn'   => true
        );

        return message($status, $options);
    }

    private function handelStock($index) {
        // get stock info
        $where                = array();
        $where['code']        = $_POST['product_code'][$index];
        $where['godown_code'] = $_POST['godown_code'][$index];
        $record = $this->action->read('stock', $where);
        
        
        if(!empty($record)){
            // set the quantity
            $quantity = $record[0]->quantity - $_POST['return_quanity'][$index];
    
            // update the stock
            $data = array('quantity' => $quantity);
            
            $this->action->update('stock', $data, $where);
        }

    }

    private function handelPartyTransaction(){
        $data = array(
            'change_at' => $this->input->post('date'),
            'credit'    => $this->input->post('new_grand_total')
        );
        $where = array('relation' => 'purchase:' . $this->input->get('vno'));
        $this->action->update('partytransaction', $data, $where);
        return true;
    }
}
