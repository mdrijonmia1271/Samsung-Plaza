<?php

class Teacher_membership_m extends Lab_Model {
    
    protected $_table_name = 'employee';
    protected $_order_by = 'name';
    protected $_limit = '1';
    
    function __construct() {
        parent::__construct();
    }
    
    public function login() {
        $user = $this->retrieve_by(array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password')
        ));
        
        $holder = array('super', 'admin', 'user');
        
        if(count($user)) {
            // log in user
            $data = array(
                'name' => $user[0]->name,
                'username' => $user[0]->username,
                'mobile' => $user[0]->mobile,
                'type' => $user[0]->type,
                'designation' => $user[0]->designation,
                'photo' => $user[0]->photo,
                'subject' => $user[0]->subject,
                'loggedin' => TRUE
            );
            
            $this->session->set_userdata($data);
            // var_dump($user);
        }
    }
    
    public function logout() {
        $this->session->sess_destroy();
    }
    
    public function loggedin() {
        return (bool) $this->session->userdata('loggedin');
    }    
  
}

