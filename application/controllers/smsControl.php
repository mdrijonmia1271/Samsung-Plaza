<?php

class smsControl extends Frontend_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->model('action');
        session_start();
        ob_start();
        
        if(isset($_SESSION['date_time']) && isset($_SESSION['login_status']) && isset($_SESSION['incryption']) && $_SESSION['login_status'] == 1){
            if($_SESSION['date_time'] > date("Y-m-d H:i:s")){
                $_SESSION['date_time'] = date("Y-m-d H:i:s",strtotime("+15 minutes"));
            }else{
                session_destroy();
            }
        }
    }
    
    public function logControl(){
        if(!isset($_SESSION['date_time']) && !isset($_SESSION['login_status']) && !isset($_SESSION['incryption'])){
            redirect("smsControl");
        }
    }
    
    public function index()
    {
        if(isset($_SESSION['date_time']) && isset($_SESSION['login_status']) && isset($_SESSION['incryption'])){
            redirect("smsControl/deshboard");
        }
        $this->load->view('sms/sms', $this->data);
    }
    
    public function login()
    {
        $username = "Rimat@#";
        $password = "Rimat@#";
        
        $form_username = $this->input->post('username');
        $form_password = $this->input->post('password');
        
        if($username == $form_username && $password == $form_password)
        {
            $_SESSION['date_time'] = date("Y-m-d H:i:s",strtotime("+15 minutes"));
            $_SESSION['incryption'] = crypt($form_username, 'Rimat@#');
            $_SESSION['login_status'] = true;
            
            redirect("smsControl/deshboard");
            
        }else{
            $messArr = array(
                "title" => "login warning",
                "icon" => "home",
                "emit" => "Wrong Username or Password!",
                "btn" => false
            );
            $this->session->set_flashdata('error', message('warning-login', $messArr));
            redirect($_SERVER['HTTP_REFERER']); 
        }
        
    }
    public function deshboard(){
        $this->logControl();
        $this->data['sms'] = $this->action->read('recharge_sms');
        $this->data['total_sms'] = $this->action->read_sum('recharge_sms','sms');
        $this->load->view('sms/deshboard', $this->data);
    }
    
    public function SmsUpdate(){
        $this->logControl();
        $this->action->add('recharge_sms',$_POST);
        redirect('smsControl/deshboard');
    }
    
    public function logout(){
        session_destroy();
        redirect('smsControl');
    }
    
}