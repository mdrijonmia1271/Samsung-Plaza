<?php

class Cheque extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'add';
        $this->data['active'] = 'data-target="cheque-menu"';
        $this->data['subMenu'] = 'data-target=" "';
        $this->data['resultset'] = array();

        $where = array("transaction_via" => "cheque");
        $chequeInfo = $this->action->read('partytransaction', $where);

        if($chequeInfo != null) {
            foreach ($chequeInfo as $key => $row) {
                $where = array('transaction_id' => $row->id);
                $metaInfo = $this->action->read('partytransactionmeta', $where);

                if($metaInfo != null) {
                    $where = array('code' => $row->party_code);
                    $customerInfo = $this->action->read('parties', $where);

                    $this->data['resultset'][$key]['customer_name'] = $customerInfo[0]->name;
                    $this->data['resultset'][$key]['customer_code'] = $customerInfo[0]->code;
                    $this->data['resultset'][$key]['customer_mobile'] = $customerInfo[0]->contact;
                    $this->data['resultset'][$key]['amount'] = $row->paid;
                    $this->data['resultset'][$key]['id'] = $row->id;

                    foreach ($metaInfo as $meta) {
                        $this->data['resultset'][$key][$meta->meta_key] = $meta->meta_value;
                    }
                }
            }
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/cheque', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function payment() {
        $where = array(
            'transaction_id' => $this->input->get('id'),
            'meta_key' => 'status'
        );

        $data = array('meta_value' => 'complete');
        $status = $this->action->update('partytransactionmeta', $data, $where);

        $msg = array(
            "title" => "success",
            "emit"  => "Payment complete!",
            "btn"   => false
        );

        $this->session->set_flashdata('confirmation', message($status, $msg));
        redirect('cheque', 'refresh');
    }
 

}
