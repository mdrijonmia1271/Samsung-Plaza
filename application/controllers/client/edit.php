<?php
class Edit extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index($id) {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="none"';

        // Get transactionj Info
        $where = array("id" => $id);
        $this->data['transactionRec'] = $this->action->read('partytransaction', $where);

        // get party info 
        $joincond = "parties.code = partybalance.code";
        $where = array('parties.code' => $this->data['transactionRec'][0]->party_code);

        $this->data['partyinfo'] = $this->action->joinAndRead("parties", "partybalance", $joincond, $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/edit-transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * update table
     * 
     * update partybalance table using code from partytransaction:party_code
     * 
     * update partytransactionmeta table using transaction_id from partytransaction:id
     * update partytransaction table using id
     *
     */
    public function change($id = null){
        // update partybalance table using code from partytransaction:party_code
        $where = array('id' => $this->uri->segment(4));
        $partytransactionRec = $this->action->read('partytransaction', $where);

        if($this->input->post('csign') == 'Receivable') {
            $balance = 0 + $this->input->post('totalBalance');
        } else {
            $balance = 0 - $this->input->post('totalBalance');
        }

        $where = array('code' => $partytransactionRec[0]->party_code);
        $data = array('balance' => $balance);

        $this->action->update('partybalance', $data, $where);

        // update partytransactionmeta table using transaction_id from partytransaction:id
        if($this->input->post('payment_type') == 'cheque') {
            foreach ($_POST['meta'] as $key => $value) {
                $where = array(
                    'transaction_id' => $id,
                    'meta_key' => $key
                );

                $data = array('meta_value' => $value);

                $this->action->update('partytransactionmeta', $data, $where);
            }
        }

        // update partytransaction table using id
        $where = array('id' => $id);

        $data = array(
            'previous_balance'   => $this->input->post('balance'),
            'paid'               => $this->input->post('payment'),
            'current_balance'    => $this->input->post('totalBalance'),
            'transaction_via'    => $this->input->post('payment_type'),
            'remark'             => $this->input->post('remark'),
            'status'             => $this->input->post('csign')
        );

        $msg = $this->action->update('partytransaction', $data, $where);

        $options = array(
            'title' => 'success',
            'emit'  => 'Supplier Transaction Successfully Saved!',
            'btn'   => true
        );

        $this->session->set_flashdata('confirmation', message($msg, $options));

        redirect('client/edit/index/' . $id, 'refresh');
    }



}
