<?php

class Latest_news extends Admin_Controller {

    function __construct() {
        parent::__construct();
        // account holder restriction
        $this->holder();
        // set meta title
        $this->data['meta_title'] = 'components';
        // load model
        $this->load->model('action');
    }
    
    public function index($emit = NULL) {
        $this->data['message'] = $emit;
        // 1 month ago
        $old_date = date('Y-m-d', strtotime('today - 30 days'));
        $cond = array('date >' => $old_date);
        // retrieve data from table
        $this->data['newses'] = $this->action->read('latest_news', $cond);
        
        $this->load->view('super/includes/header', $this->data);
        $this->load->view('super/includes/navigation', $this->data);
        $this->load->view('super/includes/aside', $this->data);
        $this->load->view('components/latest-news/index', $this->data);
        $this->load->view('super/includes/footer');
    }
    
    public function validation() {
        $this->form_validation->set_rules('title', 'Banner title', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('expire', 'Expire date', 'trim|required|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            // call form validation error
            $this->data['warning'] = message('warning', validation_errors('<p>', '</p>'));
            $this->index($this->data['warning']);
        } else {
            $insert = array(
                'date' => date('Y-m-d'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'expire' => $this->input->post('expire'),
            );
            
            $confirm = $this->action->add('latest_news', $insert);
            echo message($confirm);
        }
    }
    
    private function holder() {
        if($this->session->userdata('holder') != 'super'){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}

