<?php
class Sheet extends Admin_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
        $this->data['showrooms'] = $this->action->read("showroom");
    }

    public function index() {
        $this->data['meta_title'] = 'add';
        $this->data['active'] = 'data-target="sheet-menu"';
        $this->data['subMenu'] = 'data-target="add"';
        $this->data['confirmation'] = $this->data["results"] = null;

        $this->data['zilla'] = $this->action->readGroupBy('parties', 'zone');
        $this->data['brands'] = $this->action->readGroupBy('partybalance', 'brand');

        $where = array(
            "type" => "client",
        );
        $this->data['client_name'] = $this->action->read("parties",$where);

        if ($this->input->post("show")) {
            $where = array(
                "parties.type"   => "client",
                "parties.status" => "active"
            );
            $where2 = array();

            if ($this->input->post('search')) {
              foreach ($this->input->post('search') as $key => $value) {
                  if($value != NULL){
                      $where["parties.".$key] = $value;
                  }
              }
            }

            $conditions = array();
            //Condition for Multibrand
            if ($this->input->post('brands')) {
              foreach ($this->input->post('brands') as $key => $value) {
                  if($value != NULL){
                    $conditions[] = "partybalance.brand = '".$value."'";
                  }
              }
            }
            
            // Condition for multi areas
            
            if ($this->input->post('areas')) {
              foreach ($this->input->post('areas') as $key => $value) {
                  if($value != NULL){
                    $conditions[] = "parties.area = '".$value."'";
                  }
              }
            }
            
            if (count($conditions)>0) {
                $where2 = implode(" OR ", $conditions);
            }
            $joinCond = "partybalance.code = parties.code";
            $this->data["results"] = $this->action->joinAndReadGroupby("parties", "partybalance", $joinCond, $where,"partybalance.code",$where2);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
       // $this->load->view('components/sheet/nav', $this->data);
        $this->load->view('components/sheet/collection_sheet', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function return_upazila(){

     $content = file_get_contents("php://input");
     $receive = json_decode($content, true);

     $condition = array();
     $condition = $receive['key'];


     $zone = config_item("dist_upozila");
     $upazilla = array();

     foreach ($zone as $key => $value) {
      if($key == $condition){
       $upazilla = $value;
      }
     }

     echo json_encode($upazilla);
    }

}
