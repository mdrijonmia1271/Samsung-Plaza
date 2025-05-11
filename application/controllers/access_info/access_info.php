<?php
class Access_Info extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title'] = 'access info';
        $this->data['active'] = 'data-target="access_info"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;
        if(isset($_POST['show'])){
            $date = trim($this->input->post('from'));
        }else{
            $date = date('Y-m-d');
        }
        
        $this->data['resultset'] = $this->action->readLikeAfter('access_info','login_period',$date);   
        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/access_info/access_info', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

 
  private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
