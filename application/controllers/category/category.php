<?php
class Category extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title'] = 'Category';
        $this->data['active'] = 'data-target="category_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/category/nav', $this->data);
        $this->load->view('components/category/add', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

    public function addCategory() {  
        $this->data['confirmation'] = null;     

        $data = array(
            'date'    => date('Y-m-d'),
            'category'=> str_replace(' ','_', strtolower(trim($_POST['category'])))
        );

        $msg_array = array(
            'title' => 'success',
            'emit'  => 'Category Successfully Saved!',
            'btn'   => true
        );

        if(!$this->action->exists('category',array('category'=>str_replace(' ','_',$this->input->post('category'))))){
            $this->data['confirmation'] = message($this->action->add('category',$data),$msg_array);
        } else{
            $this->data['confirmation'] = message('warning',$options);
        }

        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('category/category','refresh');

    }


    public function allCategory() {
        $this->data['meta_title'] = 'Category';
        $this->data['active'] = 'data-target="category_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;  
      
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/category/nav', $this->data);
        $this->load->view('components/category/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

     public function editCategory($id = NULL) {       
        $this->data['active'] = 'data-target="category_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['category'] = null;

        $this->data['id'] = $id;
        $this->data['category'] = $this->action->read("category", array('id' => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/category/nav', $this->data);
        $this->load->view('components/category/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function edit($id=NULL) {  
        $this->data['confirmation'] = null;

        $data           = ['category' => str_replace(' ','_', strtolower(trim($_POST['category'])))];
        $data_product   = ['product_cat' => str_replace(' ','_', strtolower(trim($_POST['old_category'])))];


        //print_r($data_product);
        
        $options = [
            'title' => 'update',
            'emit'  => 'Category Successfully Updated!',
            'btn'   => true
        ]; 


        $this->action->update('products', ['product_cat' => str_replace(' ','_', strtolower(trim($_POST['category'])))], ['product_cat' => str_replace(' ','_', strtolower(trim($_POST['old_category'])))]);
        $this->action->update('stock', ['category' => str_replace(' ','_', strtolower(trim($_POST['category'])))], ['category' => str_replace(' ','_', strtolower(trim($_POST['old_category'])))]);

        $this->action->update('subcategory', $data, ['category' => str_replace(' ','_', strtolower(trim($_POST['old_category'])))]);

        $status = $this->action->update('category', $data, array('id' => $id));

        $this->data['confirmation'] = message($status, $options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        
        redirect('category/category/allCategory','refresh');
    }


   public function deleteCategory($id=NULL) {  
      $this->data['confirmation'] = null;     

       $msg_array=array(
            'title'=>'delete',
            'emit'=>'Category Successfully Deleted!',
            'btn'=>true
         );

        $this->data['confirmation']=message($this->action->deleteData('category',array('id'=>$id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('category/category/allCategory','refresh');

    }
  private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
