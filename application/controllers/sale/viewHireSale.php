<?php

class ViewHireSale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }
 
    public function index() {
        $this->data['meta_title'] = 'Sale';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="hire-all"';

        $where = array(
            'saprecords.voucher_no'    => $this->input->get('vno'),
            'saprecords.sap_type'      => 'credit',
            'saprecords.status'        => 'sale',
            'saprecords.trash'         => 0
        );

        $this->data['result'] = get_row_join('saprecords', 'parties', 'parties.code=saprecords.party_code', $where, ['saprecords.*', 'parties.*']);
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/viewHiresale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
}


