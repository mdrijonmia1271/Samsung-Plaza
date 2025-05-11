<?php
class Brand extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
      
    
    public function index() {
        $this->data['meta_title']   = 'Brand';
        $this->data['active']       = 'data-target="brand_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/brand/nav', $this->data);
        $this->load->view('components/brand/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function add_brand() {  
        $this->data['confirmation'] = null;   

        $data = array(
            'date'    => date('Y-m-d'),
            'brand'   => str_replace(' ',"_", trim($this->input->post('brand')))
        );

        $options = array(
            'title' => 'success',
            'emit'  => 'Brand Successfully Saved!',
            'btn'   => true
        );

        $where = array(
            'brand' => str_replace(' ',"_", $this->input->post('brand'))
        );

        //chack sub category table
        if(!$this->action->exists('brand', $where)){
            $this->data['confirmation'] = message($this->action->add('brand', $data), $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        }else{
            $this->data['confirmation'] = message('warning',$option);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        }

        redirect('brand/brand','refresh');
    }



    public function all_brand() {
        $this->data['meta_title']   = 'Brand';
        $this->data['active']       = 'data-target="brand_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/brand/nav', $this->data);
        $this->load->view('components/brand/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function edit($id) {       
        $this->data['active']       = 'data-target="brand_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['brand']        = null;
        $this->data['confirmation'] = null;   

        $this->data['brand']  = get_row('brand', ['id' => $id]); 

        if(isset($_POST['update'])){
            
            $data           = ['date'    => date('Y-m-d'), 'brand'   => str_replace(' ',"_", trim($this->input->post('brand')))];
            $data_product   = ['brand'   => str_replace(' ',"_", trim($this->input->post('brand')))];

            $msg_array = [
                'title' => 'update',
                'emit'  => 'Brand Successfully Updated!',
                'btn'   => true
            ];

            $this->action->update('products', $data_product, ['brand' => $this->input->post('old_brand')]);

            $this->data['confirmation'] = message($this->action->update('brand', $data, ['id' => $id]), $msg_array);

            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('brand/brand/all_brand', 'refresh');

        }

        

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/brand/nav', $this->data);
        $this->load->view('components/brand/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    


    public function delete_brand($id=NULL) {
        $this->data['confirmation'] = null;     
        
        $data  = array('trash' => 1);
        $where = array('id'=>$id);
        
        $msg_array = array(
            'title' => 'delete',
            'emit'  => 'Brand Successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation'] = message($this->action->update('brand', $data, $where), $msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('brand/brand/all_brand','refresh');
    }
    

    private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
