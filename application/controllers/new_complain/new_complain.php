<?php
class New_complain extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->data['meta_title'] = 'Complain';
        $this->data['brand'] = $this->action->readGroupBy('subcategory','category');
        $this->data['product'] = $this->action->read('products');
    }
    public function index() {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="new"';
    

        
        if($this->input->post('save')){
            
                $data=array(
                   "date"           => $this->input->post('date'),
                   "name"           => $this->input->post('name'),
                   "mobile"         => $this->input->post('mobile'),
                   "service_mobile" => $this->input->post('service_mobile'),
                   "address"        => $this->input->post('address'),
                   "brand"          => $this->input->post('brand'),
                   "product"        => $this->input->post('product'),
                   "model"          => $this->input->post('model'),
                   "status"         => $this->input->post('status'),
                   "problem"        => $this->input->post('problem')
                );
            
    
            $options=array(
                'title' => "success",
                'emit'  => "Complain Successfully added!",
                'btn'   => true
            );
            
            $this->data['confirmation'] = message($this->action->add("new_complain",$data),$options);        
    
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("new_complain/new_complain/","refresh"); 
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/new_complain/nav', $this->data);
        $this->load->view('components/new_complain/new_complain', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    
    public function all($id=null) {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $this->data['complainInfo'] = $this->action->read("new_complain");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/new_complain/nav', $this->data);
        $this->load->view('components/new_complain/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function view($id=null) {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $where = array('id' => $id);
        $this->data['complainInfo'] = $this->action->read("new_complain", $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/new_complain/nav', $this->data);
        $this->load->view('components/new_complain/view', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function edit($id=null) {
        $this->data['active']  = 'data-target="complain_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $where = array('id' => $id);
        $this->data['complainInfo'] = $this->action->read("new_complain", $where);
        
        if($this->input->post('update')){
            $data=array(
               "date"           => $this->input->post('date'),
               "name"           => $this->input->post('name'),
               "mobile"         => $this->input->post('mobile'),
               "service_mobile" => $this->input->post('service_mobile'),
               "address"        => $this->input->post('address'),
               "brand"          => $this->input->post('brand'),
               "product"        => $this->input->post('product'),
               "model"          => $this->input->post('model'),
               "status"         => $this->input->post('status'),
               "problem"        => $this->input->post('problem')
            );
    
            $options=array(
                'title' => "success",
                'emit'  => "Complain successfully updated!",
                'btn'   => true
            );
            
            $this->data['confirmation'] = message($this->action->update("new_complain",$data,$where),$options);        
    
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("new_complain/new_complain/all","refresh"); 
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/new_complain/nav', $this->data);
        $this->load->view('components/new_complain/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function delete($id=NULL) {
        $options=array(
            'title' => 'delete',
            'emit'  => 'Complain successfully Deleted!',
            'btn'   => true
        );
        $where=array("id"=>$id);
        $this->data['confirmation']     = message($this->action->deleteData('new_complain',$where),$options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('new_complain/new_complain/all','refresh');
    }
}