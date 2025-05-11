<?php

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('admin');
        $this->load->library('session');

        $this->data['meta_title'] = 'Client Panel';

        $this->checkLogin();
    }

    public function index()
    {
        $partyCode = $this->session->userdata('party_code');

        $this->data['partyInfo']   = get_row('parties', ['code' => $partyCode], ['opening', 'code', 'godown_code', 'name', 'address', 'mobile', 'initial_balance']);
        $this->data['balanceInfo'] = get_client_balance($partyCode);
        $this->data['results']     = $this->clientLedger();

        $this->data['content'] = $this->load->view('client/dashboard', $this->data, true);
        $this->load->view('client/app-layout', $this->data);
    }

    public function clientLedger()
    {
        $partyCode  = $this->session->userdata('party_code');
        $godownCode = $this->session->userdata('godown_code');

        $where = ['party_code' => $partyCode, 'trash' => 0];

        $dateFrom = $dateTo = '';

        if (!empty($_POST['dateFrom'])) {
            $where['transaction_at >='] = $dateFrom = $_POST['dateFrom'];
        }

        if (!empty($_POST['dateTo'])) {
            $where['transaction_at <='] = $dateTo = $_POST['dateTo'];
        }

        $this->data['dateFrom'] = $dateFrom;
        $this->data['dateTo']   = $dateTo;


        if (!empty($_POST['godown_code'])) {
            $where['godown_code'] = $_POST['godown_code'];
        }

        return get_result('partytransaction', $where, ['transaction_at', 'remark', 'comment', 'relation', 'previous_balance', 'inc_code', 'debit', 'comission', 'credit', 'remission']);
    }


    public function checkLogin()
    {
        $privilege   = $this->session->userdata('privilege');
        $loginStatus = $this->session->userdata('login_status');

        if ($privilege == 'client' && $loginStatus == true) {
            return true;
        } else {
            $this->session->sess_destroy();
            $this->session->set_flashdata('success', 'Logout successful.');
            redirect('client/login', 'refresh');
        }
    }
}
