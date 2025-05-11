<?php
class Privilege extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'Privilege';
        $this->data['active'] = 'data-target="privilege-menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $where = array("privilege !=" => "super");
        $this->data['privileges'] = $this->action->read_distinct("users", $where, "privilege");

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/privilege/set-privilege', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }
    
    
    public function set_privilege_ajax(){
        $privilege_name = $this->input->post("privilege_name");
        $user_id        = $this->input->post("user_id");
        $access         = $this->input->post("access");

        $data = array(
            "date"           => date("Y-m-d"),
            "privilege_name" => $privilege_name,
            "user_id"        => $user_id,
            "access"         => $access
        );
        $where = array(
            "privilege_name" => $privilege_name,
            "user_id"        => $user_id,
        );

        if($this->action->exists("privileges", $where)){
            if($this->action->update("privileges",$data,$where)){
                echo "success";
            }else{
                echo "error";
            }
        }else{
            if($this->action->add("privileges",$data)){

                echo "success";
            }else{
                echo "error";
            }
        }
    }
    

    public function get_privilege_ajax(){
        $where = array(
            "privilege_name" => $this->input->post("privilege_name"),
            "user_id"        => $this->input->post("user_id")
        );

        $data = $this->action->read("privileges",$where);
        if($data!=null){
            echo json_encode($data[0]);
        }else{
            echo "error";
        }
    }
    

    private function holder(){
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
}