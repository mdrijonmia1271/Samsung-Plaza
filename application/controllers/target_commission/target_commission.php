<?php
class Target_commission extends Admin_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'add';
        $this->data['active'] = 'data-target="target-menu"';
        $this->data['subMenu'] = 'data-target="add"';
        $this->data['confirmation'] = null;

        $this->data['months'] = config_item('months');
        $this->data['brands'] = $this->action->read('subcategory');

        if (isset($_POST['save'])) {
            $data = array(
                "year"    => $this->input->post('year'), 
                "month"   => $this->input->post('month'), 
                "amount"  => $this->input->post('commission'),
                "brand"   => $this->input->post('brand')
            );

            $status = $this->action->add('commissions', $data);

            $options = array(
                'title' => 'success',
                'emit'  => 'Commissions successfully saved!',
                'btn'   => true
            );

            $this->data['confirmation'] = message($status, $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);

            redirect('target_commission/target_commission', 'refresh');
        }
    
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/target_commission/nav', $this->data);
        $this->load->view('components/target_commission/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

     public function all() {
        $this->data['meta_title'] = 'all';
        $this->data['active'] = 'data-target="target-menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        $this->data['allInfo'] = null;



      //  $this->data['allcommissions'] = $this->action->read('commissions');

        if($this->input->get("id")){
            $options = array(
                'title' => 'delete',
                'emit'  => 'successfully Deleted!',
                'btn'   => true
            );

            $this->data['confirmation'] = message($this->action->deletedata('commissions', array('id' => $this->input->get("id"))), $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);

            redirect('target_commission/target_commission/all', 'refresh');
        }
        
    
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/target_commission/nav', $this->data);
        $this->load->view('components/target_commission/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function update($id) {
        $this->data['meta_title'] = 'all';
        $this->data['active'] = 'data-target="target-menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        $this->data['allCommissions'] = null;

        $this->data['months'] = config_item('months');
        $this->data['brands'] = $this->action->read('subcategory');


        $where = array('id' => $id);

        if($this->input->post('update')){

            $data = array(
                "year"    => $this->input->post('year'), 
                "month"   => $this->input->post('month'), 
                "amount"  => $this->input->post('commission'),
                "brand"   => $this->input->post('brand')
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "successfully Updated!",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->update("commissions", $data, $where), $msg_array);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);

            redirect("target_commission/target_commission/all", "refresh");
        }

        $this->data['allCommissions'] = $this->action->read('commissions',$where);
    
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/target_commission/nav', $this->data);
        $this->load->view('components/target_commission/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


}
