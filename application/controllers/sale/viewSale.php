<?php

class ViewSale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title'] = 'Sale';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="all"';

        $where = array(
            'voucher_no'    => $this->input->get('vno'),
            'status'        => 'sale',
            'trash'         => 0
        );

        $this->data['result'] = $this->action->read('saprecords', $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/view_sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
}
