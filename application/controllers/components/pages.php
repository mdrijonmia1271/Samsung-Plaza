<?php

class Pages extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function index($page) {
        $holders = array('super', 'admin', 'user');
        $this->data['meta_title'] = 'pages';
        $privilege = $this->session->userdata('privilege');
        
        $this->load->view($holders[$privilege].'/includes/header', $this->data);
        $this->load->view($holders[$privilege].'/includes/navigation', $this->data);
        $this->load->view($holders[$privilege].'/includes/aside', $this->data);
        $this->load->view('components/pages/'.$page, $this->data);
        $this->load->view($holders[$privilege].'/includes/footer');
    }

}

