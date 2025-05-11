<?php
class Dashboard extends Subscriber_controller{

    function __construct() {
        parent::__construct();
        $this->holder();                
    }
    
    public function index() {
        $this->data['meta_title'] = 'dashboard';
        $this->data['active'] = 'data-target="dashboard"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['width']  = "width";

        $this->load->view('panel/includes/header', $this->data);
        $this->load->view('panel/includes/aside', $this->data);
        $this->load->view('panel/includes/headermenu', $this->data);
        $this->load->view('panel/dashboard', $this->data);
        $this->load->view('panel/includes/footer', $this->data);
    }

    private function holder(){
        if($this->session->userdata('holder') != "client"){
            $this->subscriber_m->logout();
            redirect('access/subscriber/login','refresh');
        }
    }

}
