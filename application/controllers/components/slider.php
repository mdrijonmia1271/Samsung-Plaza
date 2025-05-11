<?php

class Slider extends Admin_Controller {

    function __construct() {
        parent::__construct();
        // account holder restriction
        $this->holder();
        // set meta title
        $this->data['meta_title'] = 'components';
        // load library
        $this->load->library('upload');
        // load model
        $this->load->model('action');
    }
    
    public function index($emit = NULL) {
        $this->data['message'] = $emit;
        
        // retrieve from database
        $this->data['slieds'] = $this->action->read('slider');
        
        $this->load->view('super/includes/header', $this->data);
        $this->load->view('super/includes/navigation', $this->data);
        $this->load->view('super/includes/aside', $this->data);
        $this->load->view('components/slider/index', $this->data);
        $this->load->view('super/includes/footer');
    }
    
    public function validation() {
        $this->form_validation->set_rules('title', 'Banner title', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('link', 'Any link', 'trim|max_length[255]|xss_clean');
        
        if($this->form_validation->run() == FALSE) {
            // call form validation error
            $this->data['warning'] = message('warning', validation_errors('<p>', '</p>'));
            $this->index($this->data['warning']);
        } else {
            // set img upload condition
            $config['upload_path']      = './public/slider/';
            $config['allowed_types']    = 'jpeg|jpg|png';
            $config['max_size']         = '1024';
            $config['file_name']        = 'slider-' . strtotime(date('Y-m-d H:i:s'));
            $config['overwrite']        = true;
            
            $this->upload->initialize($config);
            $this->form_validation->set_rules('image', 'Photo', 'callback_handle_upload');
            
            if ($this->form_validation->run() == FALSE){
                // call form validation error
                $this->data['warning'] = message('warning', validation_errors('<p>', '</p>'));
                $this->index($this->data['warning']);
            } else {
                $upload_data = $this->upload->data();
                $file = $upload_data['file_name'];
                
                $insert = array(
                    'date' => date('Y-m-d'),
                    'title' => $this->input->post('title'),
                    'path' => $file,
                    'url' => $this->input->post('link')
                );
                
                // print_r($insert);
                $confirm = $this->action->add('slider', $insert);
                $this->index(message($confirm));
            }
        }
    }
    
    function handle_upload() {
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                $this->upload->data();
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_upload', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('handle_upload', "You must upload an valid image!");
            return false;
        }
    }
    
    private function holder() {
        if($this->session->userdata('holder') != 'super'){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
    
}

