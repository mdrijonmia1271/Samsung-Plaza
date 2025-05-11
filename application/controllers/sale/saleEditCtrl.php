<?php

class SaleEditCtrl extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        if(isset($_POST['change'])) {
            $this->session->set_flashdata('confirmation', $this->change());

            // Sending SMS Start
           /* $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
            $content = "Your balance has been updated, your current balance is ".$this->input->post("current_balance")."Tk ".$sign;
            $num = $this->input->post("party_mobile");
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'     => date('Y-m-d'),
                'delivery_time'     => date('H:i:s'),
                'mobile'            => $num,
                'message'           => $content,
                'total_characters'  => strlen($content),
                'total_messages'    => message_length(strlen($content)),
                'delivery_report'   => $message
            );

            if($message){
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }*/
            // Sending SMS End

            redirect("sale/saleEditCtrl?vno=". $_POST['voucher_no'], 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/edit-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function change(){
        // update sale record
        foreach ($_POST['id'] as $key => $value) {
            $where = array('id' => $_POST['id'][$key]);

            $data = array('sap_at' => $this->input->post('date')); // update date
            $data['sale_price'] = $_POST['new_sale_price'][$key];
            $data['quantity']   = $_POST['new_quantity'][$key];

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

        $due = $this->input->post('new_grand_total') - $this->input->post('total_paid');

        $data = array(
            'sap_at'            => $this->input->post('date'),
            'change_at'         => date('Y-m-d'),
            'total_quantity'    => $this->input->post('totalqty'),
            'total_bill'        => $this->input->post('new_grand_total'),
            'total_discount'    => $this->input->post('new_total_discount'),
            'party_balance'     => $balance,
            'paid'              => $this->input->post('total_paid'),
            'due'               => $due
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
        $where['code']  = $_POST['product_code'][$index];
       
        $record = $this->action->read('stock', $where);

        // set the quantity
        $newQuantity = $_POST['new_quantity'][$index] - $_POST['old_quantity'][$index];
        $quantity = $record[0]->quantity - $newQuantity;

        // update the stock
        $data = array();
        $data = array('quantity' => $quantity);

        $this->action->update('stock', $data, $where);
    }

    private function handelPartyTransaction() {
        
        $data = array(
            'change_at' => $this->input->post('date'),
            'credit'    => $this->input->post('total_paid'),
            'debit'     => $this->input->post('new_grand_total'),
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
