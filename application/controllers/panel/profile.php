<?php

class Profile extends Subscriber_Controller {

    function __construct() {
        parent::__construct();        
       
        $this->data['meta_title'] = 'profile';
    }
    
    public function index() {
        $this->data['active'] = 'data-target="profile"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['width'] = "width";

        $username = $this->data['username'];
        $where=array('type'=>'client', 'username'=>$username);
        $this->data['profile_info'] = $this->retrieve->read('parties',$where);


        $this->load->view('panel/includes/header', $this->data);
        $this->load->view('panel/includes/aside', $this->data);
        $this->load->view('panel/includes/headermenu', $this->data);
        $this->load->view('panel/profile', $this->data);
        $this->load->view('panel/includes/footer', $this->data);
    }   
   
}