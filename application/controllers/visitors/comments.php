<?php

class Comments extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }
    
    public function index($emit = NULL) {
        $this->data['meta_title'] = 'Visitors';
        $this->data['active'] = 'data-target="visitor"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;
        
        $this->data['messages']=$this->action->read('visitor_comments',array(),'desc');

        if ($this->input->post('view_query')) {
            $where=array('messages_date'=>$this->input->post('date'));
            $this->data['messages']=$this->action->read('messages',$where,'desc');
        }

        //---------------------Delete Data Start------------------------------
        if($this->input->get("id")){//Deleting Message
            $this->action->deletedata('visitor_comments',array('id'=>$this->input->get("id")));
            redirect('visitors/comments?d_success=1','refresh');
        }

        if ($this->input->get("d_success")==1){
            $msg_array=array(
                "title"=>"Deleted",
                "emit"=>"Message Successfully Deleted",
                "btn"=>true
            );
            $this->data['confirmation']=message("danger",$msg_array);
        }
        //---------------------Delete Data End--------------------------------

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/visitor_comments/index', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function view_comments($emit = NULL) {
        $this->data['meta_title'] = 'Visitors';
        $this->data['active'] = 'data-target="visitor"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;

        $where=array('id'=>$this->input->get('id'));
        
        $this->data['messages']=$this->action->read('visitor_comments',$where);

        $data=array("status"=>"read");
        $this->action->update('visitor_comments',$data,$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/visitor_comments/view_comments', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    } 



   private function holder() {
        $holder = config_item("privilege");
        if(!(in_array($this->session->userdata('holder'), $holder)))
        {
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}