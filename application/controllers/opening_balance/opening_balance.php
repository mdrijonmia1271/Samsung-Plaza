<?php

class Opening_balance extends Admin_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title'] = 'Opening Balance';
        $this->data['active'] = 'data-target="opening_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        // read opeinginfo
        $where = array();
        $this->data['openingInfo'] = $this->action->read('opening_balance', $where);
        
        // save record to database
        if(isset($_POST['submit'])){
            $data = array(
                'date' => date('Y-m-d', strtotime("-1 day")),
                'opening_balance' => $this->input->post('opening_amount'),
                'closing_balance' => $this->input->post('opening_amount'),
            );
            
            $status = $this->action->add('opening_balance', $data);
            
            $msg = array(
                'title' => 'Success',
                'emit' => 'Opening Balance Set Successfully',
                'btn' => true
            );
            
            $confirm = message($status, $msg);
            $this->session->set_flashdata('confirmation', $confirm);
            
            redirect('opening_balance/opening_balance', 'refresh');
        }

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        //$this->load->view('components/opening_balance/nav', $this->data);
        $this->load->view('components/opening_balance/add', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }
}
