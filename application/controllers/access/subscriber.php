<?php

class Subscriber extends Subscriber_Controller {

    function __construct() {
        parent::__construct();        
        $this->data['meta_title'] = 'user login';        
        $this->load->library('user_agent');
        $this->load->model('action');
    }

    
public function login() {  
    if($this->subscriber_m->loggedin() == TRUE){
            redirect('panel/dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|xss_clean');

        if($this->form_validation->run() == TRUE) {
            if($this->subscriber_m->login() == TRUE) {
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
                $this->action->update('access_infos',$data_arr,array('login_period' => $log_preiod));                   
                
                redirect('panel/dashboard');
            } else {
                $messArr = array(
                    "title" => "login warning",
                    "icon" => "home",
                    "emit" => "Wrong Username or Password!",
                    "btn" => false
                );
                $this->session->set_flashdata('error', message('warning-login', $messArr));

                redirect('access/subscriber/login', 'refresh');
            }
        }

      $this->load->view('access/user-login', $this->data);
    } 

public function logout(){
        $this->subscriber_m->logout();
        redirect('access/subscriber/login',"refresh");
    }

    
   
}

