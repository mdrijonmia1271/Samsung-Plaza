<?php

class Users extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->model('action');
        $this->data['meta_title'] = 'Login';
        $this->data['title'] = config_item('heading');

    }

    public function login() {

        if($this->membership_m->loggedin() == TRUE){
            //code for access browse and os

            $login_preiod = $this->session->userdata('login_period');   
            $login_time = explode('pm',$login_preiod);
            $log_preiod = trim($login_time[0]);
            

            $browser = $this->agent->browser();
            $operating_system = $this->agent->platform();
            
            $data_arr = array(
                               'os'  => $operating_system,
                               'browser' => $browser
                            );
            $this->action->update('access_info',$data_arr,array('login_period' => $log_preiod)); 
            redirect($this->session->userdata('privilege') . '/dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|xss_clean');

        if($this->form_validation->run() == TRUE) {
            if($this->membership_m->login() == TRUE) {
                redirect($this->session->userdata('privilege') . '/dashboard');
            } else {
                $messArr = array(
                    "title" => "login warning",
                    "icon" => "home",
                    "emit" => "Wrong Username or Password!",
                    "btn" => false
                );
                $this->session->set_flashdata('error', message('warning-login', $messArr));

                redirect('access/users/login', 'refresh');
            }
        }

        $this->load->view('access/login', $this->data);
    }

    public function directAccess($id) {
    	if($this->membership_m->directLogin($id) == TRUE) {
            redirect($this->session->userdata('privilege') . '/dashboard');
        }
    }

    public function logout(){
        $this->membership_m->logout();
        redirect('access/users/login');
    }


}
