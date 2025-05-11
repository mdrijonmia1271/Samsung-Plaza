<?php
class Complain extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->data['meta_title'] = 'Complain';
    }
    public function index() {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="new"';
        
        $this->data['allClients']  = $this->getAllClients();
        
        if($this->input->post('save')){
            
            if($this->input->post('sale_type') == 'cash'){
                $data=array(
                   "date"          => date('Y-m-d'),
                   "name"          => $this->input->post('name'),
                   "mobile"        => $this->input->post('mobile'),
                   "address"       => $this->input->post('address'),
                   "product_name"  => $this->input->post('product_name'),
                   "sale_type"     => $this->input->post('sale_type'),
                   "status"        => 'New Complain',
                   "complain"      => $this->input->post('complain')
                );
            }else{
                $data=array(
                   "date"          => date('Y-m-d'),
                   "name"          => $this->input->post('cre_name'),
                   "mobile"        => $this->input->post('cre_mobile'),
                   "address"       => $this->input->post('cre_address'),
                   "product_name"  => $this->input->post('product_name'),
                   "sale_type"     => $this->input->post('sale_type'),
                   "status"        => 'New Complain',
                   "complain"      => $this->input->post('complain')
                );
            }
    
            $options=array(
                'title' => "success",
                'emit'  => "Complain successfully added!",
                'btn'   => true
            );
            
            $this->data['confirmation'] = message($this->action->add("complain",$data),$options);        
    
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("complain/complain/","refresh"); 
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/complain/nav', $this->data);
        $this->load->view('components/complain/complain', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    // all active clients
    private function getAllClients() {
        $where = array(
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        );
        $result = $this->action->read('parties', $where);
        return $result;
    }
    
    public function all($id=null) {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $this->data['complainInfo'] = $this->action->read("complain");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/complain/nav', $this->data);
        $this->load->view('components/complain/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function view($id=null) {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $where = array('id' => $id);
        $this->data['complainInfo'] = $this->action->read("complain", $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/complain/nav', $this->data);
        $this->load->view('components/complain/view', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function edit($id=null) {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $where = array('id' => $id);
        $this->data['complainInfo'] = $this->action->read("complain", $where);
        
        if($this->input->post('update')){
            $data=array(
               "date"          => date('Y-m-d'),
               "name"          => $this->input->post('name'),
               "mobile"        => $this->input->post('mobile'),
               "address"       => $this->input->post('address'),
               "product_name"  => $this->input->post('product_name'),
               "sale_type"     => $this->input->post('sale_type'),
               "status"        => $this->input->post('status'),
               "complain"      => $this->input->post('complain')
            );      
    
            $options=array(
                'title' => "success",
                'emit'  => "Complain successfully updated!",
                'btn'   => true
            );
            
            $this->data['confirmation'] = message($this->action->add("complain",$data),$options);        
    
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("complain/complain/all","refresh"); 
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/complain/nav', $this->data);
        $this->load->view('components/complain/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function delete($id=NULL) {
        $options=array(
            'title' => 'delete',
            'emit'  => 'Complain successfully Deleted!',
            'btn'   => true
        );
        $where=array("id"=>$id);
        $this->data['confirmation']     = message($this->action->deleteData('complain',$where),$options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('complain/complain/all','refresh');
    }
}