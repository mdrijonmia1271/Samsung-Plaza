<?php
class Godown extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title'] = 'Godown';
        $this->data['active'] = 'data-target="godown_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';

        $this->data['godown'] = $this->action->read("godowns");

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/godown/nav', $this->data);
        $this->load->view('components/godown/add', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

    public function add() {
        
        $this->data['confirmation'] = null;
        $data = array(
            'date'      => date('Y-m-d'),
            'name'      => trim($this->input->post('name')),
            'code'      => $this->input->post('code'),
            'manager'   => trim($this->input->post('manager')),
            'mobile'    => $this->input->post('mobile'),
            'address'   => trim($this->input->post('address')),
            'prefix'   => trim($this->input->post('prefix')),
        );
        
        $msg_array = array(
            'title' => 'success',
            'emit'  => 'Godown Successfully Saved!',
            'btn'   => true
        );
        
        if(!$this->action->exists('godowns',array('prefix'=>$this->input->post('prefix')))){
            $this->data['confirmation'] = message($this->action->add('godowns',$data),$msg_array);
        } else{
            $this->data['confirmation'] = message('warning',$options);
        }
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('godown/godown','refresh');

    }


    public function all() {
        $this->data['meta_title'] = 'Godown';
        $this->data['active'] = 'data-target="godown_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['godown'] = $this->action->read("godowns");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/godown/nav', $this->data);
        $this->load->view('components/godown/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

     public function edit($id = NULL) {       
        $this->data['active'] = 'data-target="godown_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['godown'] = null;

        $this->data['id'] = $id;
        $this->data['godown'] = $this->action->read("godowns", array('id' => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/godown/nav', $this->data);
        $this->load->view('components/godown/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function editData($id=NULL) {
        $this->data['confirmation'] = null;

        $data=array(
            'name'      => trim($this->input->post('name')),
            'manager'   => trim($this->input->post('manager')),
            'mobile'    => $this->input->post('mobile'),
            'address'   => trim($this->input->post('address'))
        );

        $options = array(
            'title' => 'update',
            'emit'  => 'Godown Successfully Updated!',
            'btn'   => true
        );
        if($status = $this->action->update('godowns', $data, array('id' => $id))){
            $this->data['confirmation'] = message($status, $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        }else{
            $options = array(
                'title' => 'warning',
                'emit'  => 'Godown Not Updated!',
                'btn'   => true
            );
            $this->data['confirmation'] = message("warning", $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        }
        redirect('godown/godown/all','refresh');
    }


   public function delete($id=NULL) {  
      $this->data['confirmation'] = null;     

       $msg_array=array(
            'title'=>'delete',
            'emit'=>'Godown Successfully Deleted!',
            'btn'=>true
         );

        $this->data['confirmation']=message($this->action->deleteData('godowns',array('id'=>$id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('godown/godown/all','refresh');

    }
  private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
