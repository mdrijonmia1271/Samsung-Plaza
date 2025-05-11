<?php
class Zone extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title'] = 'Zone';
        $this->data['active'] = 'data-target="zone_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/zone/nav', $this->data);
        $this->load->view('components/zone/add', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

    public function addzone() {  
        $this->data['confirmation'] = null;     

        $data = array(
            'zone'=> str_replace(' ','_', strtolower(trim($_POST['zone'])))
        );

        $msg_array = array(
            'title' => 'success',
            'emit'  => 'zone Successfully Saved!',
            'btn'   => true
        );

        if(!$this->action->exists('zone',array('zone'=>str_replace(' ','_',$this->input->post('zone'))))){
            $this->data['confirmation'] = message($this->action->add('zone',$data),$msg_array);
        } else{
            $this->data['confirmation'] = message('warning',$options);
        }

        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('zone/zone','refresh');

    }


    public function allzone() {
        $this->data['meta_title'] = 'Category';
        $this->data['active'] = 'data-target="zone_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;  
      
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/zone/nav', $this->data);
        $this->load->view('components/zone/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

     public function editzone($id = NULL) {       
        $this->data['active'] = 'data-target="zone_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['category'] = null;

        $this->data['id'] = $id;
        $this->data['category'] = $this->action->read("zone", array('id' => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/zone/nav', $this->data);
        $this->load->view('components/zone/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function edit($id=NULL) {  
        $this->data['confirmation'] = null;

        $data           = ['zone' => str_replace(' ','_', strtolower(trim($_POST['zone'])))];


        //print_r($data_product);
        
        $options = [
            'title' => 'update',
            'emit'  => 'zone Successfully Updated!',
            'btn'   => true
        ]; 


        $status = $this->action->update('zone', $data, array('id' => $id));

        $this->data['confirmation'] = message($status, $options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        
        redirect('zone/zone/allzone','refresh');
    }


   public function deletezone($id=NULL) {  
      $this->data['confirmation'] = null;     

       $msg_array=array(
            'title'=>'delete',
            'emit'=>'zone Successfully Deleted!',
            'btn'=>true
         );

        $this->data['confirmation']=message($this->action->deleteData('zone',array('id'=>$id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('zone/zone/allzone','refresh');

    }
  private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
