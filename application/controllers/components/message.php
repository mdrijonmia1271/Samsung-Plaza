<?php

class Message extends Admin_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $holders = array('super', 'admin', 'user');
        $this->data['meta_title'] = 'components';
        $privilege = $this->session->userdata('privilege');
        
        $this->load->view($holders[$privilege].'/includes/header', $this->data);
        $this->load->view($holders[$privilege].'/includes/navigation', $this->data);
        $this->load->view($holders[$privilege].'/includes/aside', $this->data);
        $this->load->view('components/messages/index', $this->data);
        $this->load->view($holders[$privilege].'/includes/footer');
    }
}

