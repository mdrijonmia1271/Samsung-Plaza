<?php

class BankInfo extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->data['allBank'] = $this->action->read('bank');
        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|is_unique[bank_account.account_number]');

        if ($this->input->post('add_account')) {
            if ($this->form_validation->run() == false) {
                $msg_array                  = array(
                    "title" => "Error",
                    "emit"  => validation_errors(),
                    "btn"   => true
                );
                $this->data['confirmation'] = message("warning", $msg_array);
            } else {
                $data = array(
                    "datetime"       => $this->input->post('date'),
                    "bank_name"      => $this->input->post('bank_name'),
                    "branch_name"    => $this->input->post('branch_name'),
                    "holder_name"    => $this->input->post('account_holder_name'),
                    "account_number" => $this->input->post('account_number'),
                    "init_balance"   => $this->input->post('previous_balance'),
                    "pre_balance"    => $this->input->post('previous_balance'),
                    "godown_code"    => $this->input->post('godown_code'),
                );

                $msg_array = array(
                    "title" => "Success",
                    "emit"  => "New Account Added Successfully",
                    "btn"   => true
                );

                $this->data['confirmation'] = message($this->action->add('bank_account', $data), $msg_array);
            }
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/add_account', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function add_bank()
    {

        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add-bank"';
        $this->data['confirmation'] = null;

        if (isset($_POST['add_bank'])) {

            $data = [
                'date'      => date('Y-m-d'),
                'bank_name' => $this->input->post('bank_name')
            ];

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Bank Added Successfully",
                "btn"   => true
            );

            save_data('bank', $data);

            $this->data['confirmation'] = message('success', $msg_array);
        }

        $this->data['allBank'] = get_result('bank');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/add_bank', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function all_account()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="all-acc"';
        $this->data['confirmation'] = null;

        //---------------------Delete Data Start------------------------------
        if ($this->input->get("id")) {//Deleting Message
            $this->action->deletedata('bank_account', array('id' => $this->input->get("id")));
            redirect('bank/bankInfo/all_account?d_success=1', 'refresh');
        }

        if ($this->input->get("d_success") == 1) {
            $msg_array                  = array(
                "title" => "Deleted",
                "emit"  => "Account Successfully Deleted",
                "btn"   => true
            );
            $this->data['confirmation'] = message("danger", $msg_array);
        }
        //---------------------Delete Data End--------------------------------
        /*$this->data['showrooms'] = $this->action->readGroupBy("showroom","showroom_id",array(),"id","asc");
        $where = array('showroom_id' => $this->data['branch']);
        if ($this->input->post('showroom')) {
            $where['showroom_id'] = $this->input->post('showroom');
        }*/
        $this->data['all_account'] = $this->action->read('bank_account');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/all_account', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function editAccount()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="all-acc"';
        $this->data['confirmation'] = null;

        $where = array('id' => $this->input->get('id'));

        if ($this->input->post('edit_account')) {

            $data = array(
                "datetime"       => $this->input->post('date'),
                "bank_name"      => $this->input->post('bank_name'),
                "holder_name"    => $this->input->post('account_holder_name'),
                "account_number" => $this->input->post('account_number'),
                "pre_balance"    => $this->input->post('previous_balance')
                //"showroom_id" =>$this->data['branch']
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Account Updated Successfully",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->update('bank_account', $data, $where), $msg_array);
        }

        $this->data['all_account'] = $this->action->read('bank_account', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/editAccount', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function transaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        $this->data['allGodowns'] = getAllGodown();

        $this->data["bank_list"] = $this->action->read_distinct("bank_account", array(), "bank_name");

        if ($this->input->post('add_transaction')) {

            $data = array(
                'transaction_date' => $this->input->post('date'),
                'bank'             => $this->input->post('bank_name'),
                'account_number'   => $this->input->post('account_number'),
                'transaction_type' => $this->input->post('transaction_type'),
                'amount'           => $this->input->post('amount'),
                'transaction_by'   => $this->input->post('transaction_by'),
                'remarks'          => $this->input->post('remarks'),
                'godown_code'      => $this->input->post('godown_code'),
            );

            $msg_array                  = array(
                "title" => "Success",
                "emit"  => "Transaction Added Successfully",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add("transaction", $data), $msg_array);

            // change the current balance
            // $where = array(
            //     'bank_name' => $this->input->post('bank_name'),
            //     'account_number' => $this->input->post('account_number')
            // );
            //
            // $bank_info = $this->action->read('bank_account', $where);
            //
            // if($this->input->post('transaction_type') == 'Debit'){
            //     $balance = $bank_info[0]->pre_balance - $this->input->post('amount');
            // } else {
            //     $balance = $bank_info[0]->pre_balance + $this->input->post('amount');
            // }

            // $data = array('pre_balance' => $balance);
            // $this->action->update('bank_account', $data, $where);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/add_transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function delete_tran($id = null)
    {

        if (!empty($id)) {

            // delete data
            delete_data('transaction', ['id' => $id]);

            $msg_array = [
                "title" => "Delete",
                "emit"  => "Transaction Added Successfully",
                "btn"   => true
            ];

            $this->data['confirmation'] = message('danger', $msg_array);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('bank/bankInfo/all_transaction', 'refresh');

        } else {
            redirect('bank/bankInfo/all_transaction', 'refresh');
        }
    }


    public function searchViewTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="search"';
        $this->data['confirmation'] = $this->data['bank_record'] = null;

        if (isset($_POST['custom_show'])) {
            $where = array();
            foreach ($_POST['search'] as $key => $val) {
                if ($val != null) {
                    $where[$key] = $val;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if ($val != null && $key == 'from') {
                    $where['transaction_date >'] = $val;
                }

                if ($val != null && $key == 'to') {
                    $where['transaction_date <'] = $val;
                }
            }

            // $this->data['bank_record'] = $this->action->searchTransaction('transaction');
            $this->data['bank_record'] = $this->action->read('transaction', $where);
        }

        $where                   = array();
        $this->data["bank_list"] = $this->action->read_distinct("bank_account", $where, "bank_name");

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/searchViewTransaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function allTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get all bank
        $this->data['allBank'] = $this->action->read_distinct("bank_account", array(), 'bank_name');

        // before submit
        $this->data['resultset'] = $this->getRecord();

        // after submit
        if (isset($_POST["show"])) {
            // get from db
            $this->data["resultset"] = $this->getAllTransaction();
        }

        // Delete Data Start
        if ($this->input->get("id")) {    // Deleting Message
            $this->action->deletedata('transaction', array('id' => $this->input->get("id")));
            redirect('bank/bankInfo/allTransaction?d_success=1', 'refresh');
        }

        if ($this->input->get("d_success") == 1) {
            $msg_array                  = array(
                "title" => "Deleted",
                "emit"  => "Transaction Successfully Deleted",
                "btn"   => true
            );
            $this->data['confirmation'] = message("danger", $msg_array);
        }
        //---------------------Delete Data End--------------------------------

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/allTransaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function ledger()
    {
        $this->data['meta_title']   = 'Bank Ledger';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="ledger"';
        $this->data['confirmation'] = $this->data['from_date'] = null;

        $this->data['allGodowns'] = getAllGodown();

        // get all bank
        $this->data['allBank'] = $this->action->read_distinct("bank_account", array(), 'bank_name');

        // before submit
        $this->data['resultset'] = $this->getRecord();

        // after submit
        if (isset($_POST["show"])) {
            // get from db
            $this->data["resultset"] = $this->getAllTransaction();

            // Previous Balance
            $this->data['previous_transaction'] = $this->getAllRecords();

            if ($this->input->post("search") != null) {
                foreach ($this->input->post("search") as $key => $value) {
                    if ($value != null) {
                        $where[$key] = $value;
                    }
                }

                foreach ($_POST['date'] as $key => $val) {
                    if ($val != null && $key == 'from') {
                        $where['transaction_date >='] = $val;
                        $this->data['from_date']      = $val;
                    }
                }
            }
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/ledger', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    private function getRecord()
    {
        $data = array();

        $allAccount = $this->action->read("bank_account");
        if ($allAccount != null) {
            foreach ($allAccount as $key => $row) {
                $data[$key]["bank"]    = str_replace("_", " ", $row->bank_name);
                $data[$key]["holder"]  = $row->holder_name;
                $data[$key]["account"] = $row->account_number;
                $data[$key]["initial"] = $row->init_balance;
                $data[$key]["debit"]   = 0.00;
                $data[$key]["credit"]  = 0.00;

                $where        = array("account_number" => $row->account_number);
                $transactions = $this->action->read("transaction", $where);

                if ($transactions != null) {
                    foreach ($transactions as $transaction) {
                        if ($transaction->transaction_type == "Debit") {
                            $data[$key]["debit"] += $transaction->amount;
                        }

                        if ($transaction->transaction_type == "bank_to_TT") {
                            $data[$key]["debit"] += $transaction->amount;
                        }

                        if ($transaction->transaction_type == "Credit") {
                            $data[$key]["credit"] += $transaction->amount;
                        }
                    }
                }
            }
        }

        return $data;
    }


    private function getAllTransaction()
    {
        $where = array();

        if ($this->input->post("search") != null) {
            foreach ($this->input->post("search") as $key => $value) {
                if ($value != null) {
                    $where[$key] = $value;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if ($val != null && $key == 'from') {
                    $where['transaction_date >='] = $val;
                }

                if ($val != null && $key == 'to') {
                    $where['transaction_date <='] = $val;
                }
            }
        }
        return get_result("transaction", $where);
    }


    private function getAllRecords()
    {
        $where = array();

        if ($this->input->post("search") != null) {
            foreach ($this->input->post("search") as $key => $value) {
                if ($value != null) {
                    $where[$key] = $value;
                }
            }

            /*foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['transaction_date >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['transaction_date <='] = $val;
                }
            }*/
        }
        return $this->action->read("transaction", $where);
    }


    public function changeTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        $where                   = array("id" => $this->input->get('id'));
        $this->data["records"]   = $this->action->read("transaction", $where);
        $this->data["bank_list"] = $this->action->read_distinct("bank_account", array(), "bank_name");

        if (isset($_POST['edit'])) {
            $data = array(
                'transaction_date' => $this->input->post('date'),
                'bank'             => $this->input->post('bank_name'),
                'account_number'   => $this->input->post('account_number'),
                'transaction_type' => $this->input->post('transaction_type'),
                'amount'           => $this->input->post('amount'),
                'transaction_by'   => $this->input->post('transaction_by'),
                'remarks'          => $this->input->post('remarks')
                //'showroom_id'        => $this->data['branch']
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Transaction Added Successfully",
                "btn"   => true
            );

            $this->session->set_flashdata('confirmation', message($this->action->update("transaction", $data, $where), $msg_array));
            redirect('bank/bankInfo/changeTransaction?id=' . $this->input->get('id'), 'refresh');

            // change the current balance
            // $where = array(
            //     'bank_name' => $this->input->post('bank_name'),
            //     'account_number' => $this->input->post('account_number')
            // );
            //
            // $bank_info = $this->action->read('bank_account', $where);
            //
            // if($this->input->post('transaction_type') == 'Debit'){
            //     $balance = $bank_info[0]->pre_balance - $this->input->post('amount');
            // } else {
            //     $balance = $bank_info[0]->pre_balance + $this->input->post('amount');
            // }

            // $data = array('pre_balance' => $balance);
            // $this->action->update('bank_account', $data, $where);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/change-transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function editTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target=""';
        $this->data['confirmation'] = null;

        $this->data["bank_list"] = $this->action->read_distinct("bank_account", array(), "bank_name");

        $where = array("id" => $this->input->get("id"));

        if ($this->input->post('add_transaction')) {
            $data = array(
                'transaction_date' => $this->input->post('date'),
                'bank'             => $this->input->post('bank_name'),
                'account_number'   => $this->input->post('account_number'),
                'transaction_type' => $this->input->post('transaction_type'),
                'amount'           => $this->input->post('amount'),
                'transaction_by'   => $this->input->post('transaction_by')
                //'showroom_id'    => $this->data['branch']
            );

            $msg_array                  = array(
                "title" => "Success",
                "emit"  => "Transaction Added Successfully",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update("transaction", $data, $where), $msg_array);
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/edit-transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function ajax_account_list()
    {
        $where    = array("bank_name" => $this->input->post('bankName'), "godown_code" => $this->input->post('godown_code'));
        $alldata  = $this->action->read('bank_account', $where);
        $alldatas = json_encode($alldata);
        echo $alldatas;
    }


    public function ajax_bank_list()
    {
        $where       = array("godown_code" => $this->input->post('godown_code'));
        $alldataBank = $this->action->readGroupBy('bank_account', 'bank_name', $where);
        echo '<option value="">-- Select Bank --</option>';
        if (!empty($alldataBank)) {
            foreach ($alldataBank as $bank) {
                echo '<option value="' . $bank->bank_name . '">' . $bank->bank_name . '</option>';
            }
        }
    }


    public function ajax_account_number()
    {
        $where    = array("account_number" => $this->input->post('account_number'));
        $alldata  = $this->action->read('bank_account', $where);
        $alldatas = json_encode($alldata);
        echo $alldatas;
    }

    public function all_transaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="all_transaction"';
        $this->data['confirmation'] = null;

        $this->data['transactions'] = get_result('transaction', '', '', '', 'id', 'desc');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/all-transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

}
