<?php
class Sister_concern extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->library('upload');
        $this->holder();
    }
    
    public function index() {
        $this->data['meta_title'] = 'sister_concern';
        $this->data['active'] = 'data-target="sister_concern_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        if ($this->input->post("save")) {
            $data=array(
                "date"   => date("Y-m-d")
            );

          //Uploading Students Photo
            if ($_FILES["image"]["name"]!=null && $_FILES["image"]["name"]!="" ) {

                $config['upload_path'] = './public/upload/sister_concern';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] =str_shuffle("Sister_Concern".rand(100000,999999)); 
                $config['overwrite']=true;   

                $this->upload->initialize($config);
                if ($this->upload->do_upload("image")){
                    $upload_data = $this->upload->data();
                    $data["image"]="public/upload/sister_concern/".$upload_data['file_name'];
                }
            }

            $msg_array=array(
                "title"=>"Success", 
                "emit"=> "Data Successfully Saved",
                "btn"=>false
            );
            $this->data['confirmation'] = message($this->action->add("sister_concern",$data), $msg_array);
        }
      
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sister_concern/nav', $this->data);
        $this->load->view('components/sister_concern/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function all() {
        $this->data['meta_title'] = 'sister concern';
        $this->data['active'] = 'data-target="sister_concern_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        /* delete sister concern */
        $where = array("id" => $this->input->get("id"));
        if ($this->input->get("id") != null) {
            $infoDelete = $this->action->read("sister_concern", $where);
            unlink('./'. $infoDelete[0]->image);

            $msg = array(
                "title"=>"warning", 
                "emit"=> "Data successfully deleted",
                "btn"=> true
            );

            $this->data["confirmation"] = message($this->action->deleteData("sister_concern", $where), $msg);
            $this->session->set_flashdata("confirmation", $this->data["confirmation"]);
            redirect("sister_concern/sister_concern/all", "refresh");
        }  
             
        /* view all sister concern */
        $this->data["info"] = $this->action->read("sister_concern"); 

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sister_concern/nav', $this->data);
        $this->load->view('components/sister_concern/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }

    public function edit($id=null) {
        $this->data['meta_title'] = 'Product';
        $this->data['active'] = 'data-target="sister_concern_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sister_concern/nav', $this->data);
        $this->load->view('components/sister_concern/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function holder(){
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

    
}
