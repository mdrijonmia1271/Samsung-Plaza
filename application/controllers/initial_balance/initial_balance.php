<?php
class Initial_balance extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }

    public function index() {
        $this->data['meta_title'] = 'Initial Balance';
        $this->data['active'] = 'data-target="initial_balance_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $where = array(
            "meta_key" => $this->data["branch"],
            "meta_type" => "initial_balance"
        );
        
        if ($this->input->post("save")) {
            $data = array(
                "meta_key" => $this->data["branch"],
                "meta_type" => "initial_balance",
                "meta_value" => $this->input->post("initial_balance")
            );

            $msg_array=array(
                "title"=>"Success",
                "emit"=>"Initial Balance Save",
                "btn"=>true
            );

            $this->data['confirmation']=message($this->action->add("sitemeta",$data), $msg_array);
        }

        if ($this->input->post("update")) {
            $data = array(
                "meta_value" => $this->input->post("initial_balance")
            );

            $msg_array=array(
                "title"=>"Success",
                "emit"=>"Initial Balance Update",
                "btn"=>true
            );

            $this->data['confirmation']=message($this->action->update("sitemeta",$data,$where), $msg_array);
        }

        $this->data["balance"] = $this->action->read("sitemeta",$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        //$this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/initial_balance/initial_balance', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }


}