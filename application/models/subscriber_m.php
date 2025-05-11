<?php

class Subscriber_m extends Lab_Model {
    
    protected $_table_name = 'parties';
    protected $_limit = '1';
            
    function __construct() {
        parent::__construct();
    }
    
    public function login() {
        $user = $this->retrieve_by(array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'type'     => 'client',
            'status'   => 'active'
        ));       
       
        
        if(count($user)) {
            // log in user
            $data = array(
                'opening'        => $user[0]->opening,
                'code'           => $user[0]->code,
                'name'           => $user[0]->name,
                'contact'        => $user[0]->contact,
                'address'        => $user[0]->address,
                'email'          => $user[0]->email,
                'username'       => $user[0]->username,
                'photo'          => $user[0]->photo,
                'type'           => $user[0]->type,
                'status'         => $user[0]->status,
                'showroom'       => $user[0]->showroom_id,
                'privilege'      => 'client',                
                'holder'         => 'client',
                'loggedin'       => TRUE
            );
            
            $this->session->set_userdata($data);            
        }
    }
    
    public function logout() {
        $this->session->sess_destroy();
    }
    
    public function loggedin() {
        return (bool) $this->session->userdata('loggedin');
    }
    
    public function hash($string) {
        return base64_encode($string);
    }
}

