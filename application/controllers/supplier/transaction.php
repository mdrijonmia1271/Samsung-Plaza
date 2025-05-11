<?php
/**
* Working with Supplier transaction
* Methods():
*   index: Add transactional record
*   edit_transaction: Edit transactional record
*   partyTransactionMeta : Add addtional record
*
**/
class Transaction extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="transaction"';
        $this->data['confirmation'] = null;
        
        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        if(isset($_POST['save'])) {
            // fetch last insert record and increase by 1.
            $where = array('party_code' => $this->input->post('code'));
            $last_sl = $this->action->read_limit('partytransaction',$where,'desc',1);
            $voucher_sl = ($last_sl)? ($last_sl[0]->serial+1) : 1;
            
            $data = array(
                'transaction_at'     => $this->input->post('created_at'),
                'inc_code'           => transactionCollectionId('partytransaction'),
                'godown_code'        => !empty($_POST['godown_code']) ? $_POST['godown_code'] : $this->data['branch'],
                'party_code'         => $this->input->post('code'),
                'debit'              => $this->input->post('payment'),
                'transaction_via'    => $this->input->post('payment_type'),
                'transaction_by'     => 'supplier',
                'serial'             => $voucher_sl,
                'relation'           => 'transaction',
                'remark'             => 'transaction',
                'comment'            => $this->input->post('comment'),
            );
            
            /*echo '<pre>';
            print_r($data);
            die();*/

            $options = array(
                'title' => 'success',
                'emit'  => 'Supplier Transaction Successfully Saved!',
                'btn'   => true
            );

            $tid = $this->action->addAndGetId('partytransaction', $data);
            // save additional transaction info
            if ($this->input->post('payment_type') == 'cheque') {
                $this->partyTransactionMeta($tid);
            }
            $this->session->set_flashdata('confirmation', message("success", $options));
            $lastId = $this->action->read('partytransaction',array(),'DESC');
            
            redirect('supplier/all_transaction/view/' . $lastId[0]->id, 'refresh');
        }

        // Get all Supplier parties name
        $where = array(
            "type"   => "supplier", 
            "status" => "active", 
            "trash"  => 0
        );

        $this->data['info'] = $this->action->readGroupBy('parties', 'name', $where, "id", "asc");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/transaction', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    /**
     * Edit transaction
     * table : partytransaction
     * Strategy : Update column debit using table id
     *
     */
    public function edit_transaction($id = null) {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = null;

        // Get transaction Info
        $where = array("id" => $id);
        $this->data['records'] = $this->action->read('partytransaction', $where);

        // get party info 
        $where = array('code' => $this->data['records'][0]->party_code);
        $this->data['partyinfo'] = $this->action->read("parties",$where);

        // Calculate Balance from partytrasaction table.
        // Final balance = total_debit - total_credit + initial_balance.
        // Final Balance (+ve) = Receivable and (-ve) = Payable
        $where = array(
            'party_code' => $this->data['records'][0]->party_code,
            'trash' => 0
        );
        $transactionRec = $this->retrieve->read('partytransaction',$where);
        $total_credit = $total_debit = 0.0;
        if ($transactionRec != null) {
            foreach ($transactionRec as $key => $row) {
                $total_credit += $row->credit;
                $total_debit += $row->debit;
            }
            $balance = $total_debit -  $total_credit + $this->data['partyinfo'][0]->initial_balance;
        }else{
            $balance = $this->data['partyinfo'][0]->initial_balance;
        }
        $balance_status = ($balance >= 0) ?  "Receivable" : "Payable";

        $this->data['current_balance'] = $balance;
        $this->data['current_sign'] = $balance_status;


        //Update start from here
        if(isset($_POST['update'])) {
            $where = array("id" => $id);
            $data = array(
                "transaction_at"  => $this->input->post("date"),
                "change_at"       => date('Y-m-d'),
                "debit"           => $this->input->post("payment"),
                "transaction_via" => $this->input->post("payment_type"),
                "remark"          => $this->input->post("remark")
            );

            // Save additional transactional info
            if ($this->input->post('payment_type') == 'cheque') {
                $this->partyTransactionMeta($id);
            }

            $msg_array = array(
              "title" => "Success",
              "emit"  => "Transaction Successfully Updated",
              "btn"   => true
            );

            $this->data["confirmation"] = message($this->action->update("partytransaction",$data,$where),$msg_array);
            
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);

            redirect('supplier/transaction/edit_transaction/' . $id, 'refresh');
        }
        // Update end here

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/edit_transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * Save cheque info
     * Table: partytransactionmeta
     * Strategy: partytransaction's table auto increament id
     *  save into transaction_id column and other info as meta_key and meta_value
     */
    private function partyTransactionMeta($id) {
        if(isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'transaction_id' => $id,
                    'meta_key'       => $key,
                    'meta_value'     => $value
                );
                $this->action->add('partytransactionmeta', $data);
            }
        }
        return true;
    }
}
