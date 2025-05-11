<?php

class ShowProfile extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }
    
    public function index($emit = NULL) {
        $this->data['meta_title'] = 'profile';
        $this->data['active'] = 'data-target="profile"';
        $this->data['subMenu'] = 'data-target=""';

        $where=array('id'=>$this->input->get('id'));
        $this->data['profile']=$this->action->read("users",$where);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/settings/show-profile', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function deleteProfile() {
        $receive = filter_input(INPUT_POST, 'condition');
        $path = './public/profiles/'.filter_input(INPUT_POST, 'path');
        $condition = json_decode($receive, TRUE); // json object to array
        
        $confirm = $this->profiles_m->deleteData($condition);
        // delete file from dir
        unlink($path);
        // delete_files($path);
        // show confirm message
        echo $this->data[$confirm];
    }

}

