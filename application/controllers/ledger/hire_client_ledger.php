<?php
class Hire_client_ledger extends Admin_Controller {

    function __construct() {
        parent::__construct();

         $this->load->model('action');
         $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title']   = 'Client Ledger';
        $this->data['active']       = 'data-target="ledger"';
        $this->data['subMenu']      = 'data-target="hire_client_ledger"';

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/hire_client_ledger', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

}
