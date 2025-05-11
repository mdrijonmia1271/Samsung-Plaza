<?php
class Showroom_collection extends Admin_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->data['showrooms'] = $this->action->readGroupBy("showroom","name",array(),"id","asc");
    }

    public function index() {
        $this->data['meta_title'] = 'add';
        $this->data['active'] = 'data-target="collection"';
        $this->data['subMenu'] = 'data-target="add"';
        $this->data['confirmation'] =  null;

        if(isset($_POST['collect'])){
          $msg = $this->collectAmount();
          $this->session->set_flashdata("confirmation",$msg);
          redirect("sheet/showroom_collection","refresh");
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sheet/nav', $this->data);
        $this->load->view('components/sheet/showroom_collection', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    private function collectAmount(){
       $data = array(
         "date"         => $this->input->post('date'),
         "showroom_id"  => $this->input->post('showroom'),
         "amount"       => $this->input->post('amount'),
         "collected_by" => $this->input->post("collected_by"),
         "remarks"       => $this->input->post("remark")
       );

      $options = array(
        'title' => "success",
        'emit'  => "Collection from Showroom Successfully Completed!",
        'btn'   => true
      );
       return message($this->action->add("showroom_collection",$data),$options);
    }

    public function all(){
      $this->data['meta_title'] = 'view all';
      $this->data['active'] = 'data-target="collection"';
      $this->data['subMenu'] = 'data-target="all"';
      $this->data["results"] = null;

      $this->data["results"] = $this->action->read("showroom_collection");

      if(isset($_POST['show'])){
        $where =  array();
        if(isset($_POST['search'])){
          foreach ($_POST['search'] as $key => $value) {
            if($value != NULL){
              $where[$key] = $value;
            }
          }
        }

        if(isset($_POST['date'])){
          foreach ($_POST['date'] as $key => $value) {
            if($value != NULL && $key == "from"){
              $where['date >='] = $value;
            }
            if($value != NULL && $key == "to"){
              $where['date <='] = $value;
            }
          }
        }

        $this->data["results"] = $this->action->read("showroom_collection",$where);
      }

      $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
      $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
      $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
      $this->load->view('components/sheet/nav', $this->data);
      $this->load->view('components/sheet/show_collection', $this->data);
      $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }


    public function delete($id=NULL){
      $option = array(
        'title' => "delete",
        'emit'  => "Successfully Deleted!",
        'btn'   => true
      );

      $msg = message($this->action->deletedata("showroom_collection",array("id" => $id)),$option);
      $this->session->set_flashdata("confirmation",$msg);
      redirect("sheet/showroom_collection/all","refresh");
    }

}
