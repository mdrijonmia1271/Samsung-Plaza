<?php

class PaymentHistory extends Admin_Controller {

  function __construct() {
        parent::__construct();

        $this->load->model('action');
    }
    
    public function index($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="payment_menu"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;

        if($this->input->get('delete') == 1){
            $this->data['confirmation'] = message($this->deleteProfile());
        }

        $this->data['profiles']=$this->action->read("users");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/student_payment/payment_history', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    } 

    public function monthly_payment_history($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="payment_menu"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;

        if($this->input->get('delete') == 1){
            $this->data['confirmation'] = message($this->deleteProfile());
        }

        $this->data['profiles']=$this->action->read("users");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/student_payment/monthly_payment_history', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function deleteProfile() {
        $confirm = $this->action->deleteData('users', array('id' => $this->input->get('id')));

        return $confirm;
    }

}