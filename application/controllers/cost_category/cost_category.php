<?php
class Cost_category extends Admin_Controller {
     function __construct() 
         {
            parent::__construct();
            $this->holder();
            $this->load->model('action');
            $this->load->helper('custom_helper');
            $this->load->helper('url');
         }

        public function index() {
        $this->data['meta_title'] = 'cost category';
        $this->data['active'] = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="all_cost_category"';
        $this->data['confirmation'] = null;
        
        $where = array();
        $this->data['resultset'] = $this->action->read('cost_category',$where);
        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/all_cost_category', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

    public function add() {  
        $this->data['confirmation'] = null;     
        $data = array(
            'cost_category' => trim($this->input->post('cost_category')),
        );

        $msg_array = array(
            'title' => 'success',
            'emit'  => 'Cost Category Data Successfully Saved!',
            'btn'   => true
         );
        $this->data['confirmation'] = message($this->action->add('cost_category',$data),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('cost_category/cost_category','refresh');

    }



     public function edit_cost_category($id = NULL) {       
        $this->data['meta_title'] = 'Edit';
        $this->data['active'] = 'data-target="cost"';
        $this->data['subMenu'] = 'data-target="all_cost_category"';
        $this->data['category'] = null;

        
        $this->data['listing'] = $this->action->read('cost_category',array());
        $id = $this->uri->segment(4);
        $this->data['row'] = $this->action->read("cost_category", array('id' => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/edit_cost_category', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function edit($id=NULL) {  

        $this->data['confirmation'] = null;

        if(isset($_POST['update'])){

            $id = trim($this->input->post('id'));
            
                $data = array(
                    'cost_category' => trim($this->input->post('cost_category')),
                );
                $options = array(
                'title' => 'update',
                'emit'  => 'Cost Category Data Successfully Updated!',
                'btn'   => true
                );

                $status = $this->action->update('cost_category', $data, array('id' => $id));
                $this->data['confirmation'] = message($status, $options);
                
          }
           
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('cost_category/cost_category','refresh');

    }


   public function delete($id=NULL) {  
      $this->data['confirmation'] = null;     
       
       $id = $this->uri->segment(4);
       $msg_array=array(
            'title'=>'delete',
            'emit'=>'Cost Category Data Successfully Deleted!',
            'btn'=>true
         );

        
        if($id){
             $this->data['confirmation']=message($this->action->deleteData('cost_category',array('id'=> $id)),$msg_array);  
        }
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('cost_category/cost_category','refresh');

    }


  private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
 

}

?>