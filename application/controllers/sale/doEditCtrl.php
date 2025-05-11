<?php

class doEditCtrl extends Admin_Controller {

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
            $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
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

            if($message) {
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }
            // Sending SMS End

            redirect("sale/doEditCtrl?vno=". $_POST['voucher_no'], 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/do-edit-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function change() {
        // update sale record
        foreach ($_POST['id'] as $key => $value) {
            $data = array();
            $where = array('id' => $_POST['id'][$key]);

            $data['sale_price'] = $_POST['new_sale_price'][$key];
            $data['quantity']   = $_POST['new_quantity'][$key];

            // check the product free or not
            if($_POST['new_sale_price'][$key] <= 0) {
                $data['remark'] = 'free';
            }

            if($this->action->update('sapitems', $data, $where)) {
                $this->handelStock($key);
            }
        }

        // update bill record
        if($this->input->post("previous_sign") == "Receivable"){
            $balance = 0 - $this->input->post('previous_balance');
        } else {
            $balance = 0 + $this->input->post('previous_balance');
        }

        $data = array(
            'change_at'         => date('Y-m-d'),
            'total_bill'        => $this->input->post('new_total'),
            'total_discount'    => $this->input->post('new_total_discount'),
            'party_balance'     => $balance,
            'paid'              => $this->input->post('paid')
        );

        $where = array('voucher_no' => $this->input->post('voucher_no'));
        $status = $this->action->update('saprecords', $data, $where);

        $this->handelPartyBalance();
        $this->handelPartyTransaction();
        $this->sapmeta();

        $options = array(
            'title' => 'Updated',
            'emit'  => 'Product purchase successfully changed!',
            'btn'   => true
        );

        return message($status, $options);
    }

    private function handelStock($index) {
        // get stock info
        $where = array();

        $where['product_code']  = $_POST['product_code'][$index];
        $where['godown']        = $_POST['godown'];
        $where['showroom_id']   = $_POST['showroom_id'];
        $where['type']          = $_POST['sap_type'];

        $record = $this->action->read('stock', $where);

        // set the quantity
        $newQuantity = $_POST['new_quantity'][$index] - $_POST['old_quantity'][$index];
        $quantity = $record[0]->quantity - $newQuantity;

        // update the stock
        $data = array();
        $data = array('do_out' => $quantity);

        $this->action->update('stock', $data, $where);
    }

    private function handelPartyBalance() {
        $where = array('code' => $this->input->post('party_code'));

        if($this->input->post('current_sign') == 'Receivable'){
            $balance = 0 - $this->input->post('current_balance');
        } else {
            $balance = 0 + $this->input->post('current_balance');
        }

        $data = array('balance' => $balance);
        $this->action->update('partybalance', $data, $where);

        return true;
    }

    private function handelPartyTransaction() {
        if($this->input->post('previous_sign') == 'Receivable') {
            $previous_balance = 0 - $this->input->post('previous_balance');
        } else {
            $previous_balance = 0 + $this->input->post('previous_balance');
        }

        if($this->input->post('current_sign') == 'Receivable') {
            $current_balance = 0 - $this->input->post('current_balance');
        } else {
            $current_balance = 0 + $this->input->post('current_balance');
        }

        $data = array(
            'previous_balance'  => $previous_balance,
            'paid'              => $this->input->post('paid'),
            'current_balance'   => $current_balance,
            'transaction_via'   => $this->input->post('method')
        );

        $where = array('relation' => 'sales:' . $this->input->post('voucher_no'));
        $this->action->update('partytransaction', $data, $where);

        return true;
    }

    private function sapmeta() {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $where = array(
                    "voucher_no"    => $this->input->post('voucher_no'),
                    "meta_key"      => $key
                );

                $data = array('meta_value' => $value);

                $this->action->update('sapmeta', $data, $where);
            }
        }
    }

}
