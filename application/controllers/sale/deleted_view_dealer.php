<?php

class Deleted_view_dealer extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title'] = 'Dealer Sale';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="all_deleted"';

        $where = array(
            'voucher_no'    => $this->input->get('vno'),
            'status'        => 'sale',
            'trash'         => 1
        );

        $this->data['result'] = $this->action->read('saprecords', $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/view-dealer-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
}
