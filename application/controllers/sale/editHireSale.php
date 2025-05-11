<?php

class EditHireSale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }
 
    public function index() {
        $this->data['meta_title']   = 'Edit Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="hire-all"';
        $this->data['confirmation'] = null;

        if(isset($_POST['change'])) {
            $this->session->set_flashdata('confirmation', $this->change());

            redirect("sale/editHireSale?vno=". $_POST['voucher_no'], 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/edit-hire-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    private function change(){
        // update sale record
       foreach ($_POST['id'] as $key => $value) {
            $where = array('id' => $_POST['id'][$key]);

            $data = array('sap_at' => $this->input->post('date'));
            $data['sale_price'] = $_POST['sale_price'][$key];
            $data['quantity']   = $_POST['new_quantity'][$key];

            if($this->action->update('sapitems', $data, $where)){
                $this->handelStock($key);
            }
        } 

        // update bill record
        if($this->input->post("current_sign") == "Receivable"){
            $balance = 0 + $this->input->post('grand_total');
        } else {
            $balance = 0 - $this->input->post('grand_total');
        }

        $previous_balance = ($_POST['previous_sign'] !== 'Receivable') ? $_POST['previous_balance'] : 0;
        $due = $_POST['hire_price'] - ($_POST['paid'] + $previous_balance);

         $data = array(
            'sap_at'            => $this->input->post('date'),
            'change_at'         => date('Y-m-d'),
            'total_quantity'    => $this->input->post('totalqty'),
            'total_bill'        => $this->input->post('hire_price'),
            'commission_percentage'=> $this->input->post('commission_per'),
            'installment_date'   => $this->input->post('installment_date'),
            'installment_no'     => $this->input->post('installment_number'),
            'installment_amount' => $this->input->post('installment_amount'),
            //'total_discount'    => $this->input->post('total_discount'),
            'party_balance'     => $balance,
            'paid'              => $this->input->post('paid'),
            'due'               => $due,
            'hire_price'        => $this->input->post('hire_price'),
        );

        $where = array('voucher_no' => $this->input->post('voucher_no'));
        $status = $this->action->update('saprecords', $data, $where);

        $this->handelPartyTransaction();
        $this->sapmeta();
        
        $options = array(
            'title' => 'Updated',
            'emit'  => 'Sale successfully changed!',
            'btn'   => true
        );

        return message($status, $options);
    }

    private function handelStock($index) {
        // get stock info
        $where = array();
        $where['code']           = $_POST['product_code'][$index];
        $where['product_serial'] = $_POST['product_serial'][$index];
        $where['godown_code']    = $_POST['godown_code'];
       
        $record = $this->action->read('stock', $where);

        // set the quantity
        $newQuantity = $_POST['new_quantity'][$index] - $_POST['quantity'][$index];
        $quantity = $record[0]->quantity - $newQuantity;

        // update the stock
        $data = array();
        $data = array('quantity' => $quantity);

        $this->action->update('stock', $data, $where);
    }

    private function handelPartyTransaction() {
        
        $data = array(
            'change_at' => $this->input->post('date'),
            'credit'    => $this->input->post('paid'),
            'debit'     => $_POST['total'] + $_POST['added_amount'],
        );

        $where = array('relation' => 'sales:' . $this->input->post('voucher_no'));
        $this->action->update('partytransaction', $data, $where);

        return true;
    }

    private function sapmeta() {
        if (isset($_POST['meta'])) {
            $where = array();

            foreach ($_POST['meta'] as $key => $value) {
                $data = array('meta_value' => $value);

                $where['voucher_no'] = $this->input->post('voucher_no');
                $where['meta_key'] = $key;

                $this->action->update('sapmeta', $data, $where);
            }
        }
    }
    
}
