<?php

class Banner extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }
    
    public function index($emit = NULL) {
        $this->data['meta_title'] = 'banner';
        $this->data['active'] = 'data-target="header_menu"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;
        
        
        $this->data['banner_info'] = get_result("banner", '', '', '', 'id', 'desc');
        
     
        if ($this->input->post("banner_save")) {
            
            $file_path = file_upload('banner_image', 'banner', '', $_POST['godown_code']);
            
            // data insert showroom wise
            if($this->input->post('godown_code')){
                $data_showroom_wise = array(
                    'godown_code' => $_POST['godown_code'],
                    'path'=> $file_path,
                    'date' => date('Y-m-d')
                );
                $this->action->deleteData('banner',array('godown_code' => $_POST['godown_code']));
                $this->action->add('banner',$data_showroom_wise);
            }



            $msg_array=array(
                "title"=>"success",
                "emit"=>"Banner successfully uploaded",
                "btn"=>true
            );
           
            $this->data['confirmation']=message("success",$msg_array);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
 
            //redirect('banner/banner','refresh');
            //redirect('theme/themeSetting/','refresh');
        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/banner/banner', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

}
