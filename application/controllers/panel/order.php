<?php
class Order extends Subscriber_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->data['width']        = '';
    }

    public function index() {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="order-menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->data['fo'] = $this->action->read("users",array("privilege" => "field_officer"));

        //print_r($this->data);
        //echo $this->data["showroom"];

        if ($this->input->post("save")) {
            $data = array(
                "name"          => $this->input->post("name"),
                "company"       => $this->input->post("company"),
                "products"      => $this->input->post("products"),
                "price"         => $this->input->post("price"),
                "amount"        => $this->input->post("amount"),
                "mobile_number" => $this->input->post("mobile_number"),
                "district"      => $this->input->post("district"),
                "upazila"       => $this->input->post("upazila"),
                "delivary_date" => $this->input->post("delivary_date"),
                "order_by"      => $this->data["code"],//$this->input->post("order_by"),
                "address"       => $this->input->post("address"),
                "remark"        => $this->input->post("remark"),
                "status"        => "pending",
                "showroom_id"   => $this->data["showroom"]
            );


            $msg_array=array(
                "title"=>"Success",
                "emit"=>"New Order Successfully Saved",
                "btn"=>true
            );

            $this->data['confirmation']=message($this->action->add("order",$data), $msg_array);
        }

        $this->load->view('panel/includes/header', $this->data);
        $this->load->view('panel/includes/aside', $this->data);
        $this->load->view('panel/includes/headermenu', $this->data); 
        $this->load->view('panel/order/nav', $this->data);
        $this->load->view('panel/order/order', $this->data);
        $this->load->view('panel/includes/footer', $this->data);
    }

    public function all() {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="order-menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array("order_by" => $this->data["code"]);

        $this->data["orders"] = $this->action->read("order",$where);

        $this->load->view('panel/includes/header', $this->data);
        $this->load->view('panel/includes/aside', $this->data);
        $this->load->view('panel/includes/headermenu', $this->data); 
        $this->load->view('panel/order/nav', $this->data);
        $this->load->view('panel/order/all', $this->data);
        $this->load->view('panel/includes/footer', $this->data);
    }

    public function edit($id) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="order-menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array("id" => $id);
        $this->data['fo'] = $this->action->read("users",array("privilege" => "field_officer"));

        if ($this->input->post("update")) {
            $data = array(
                "name"          => $this->input->post("name"),
                "company"       => $this->input->post("company"),
                "products"      => $this->input->post("products"),
                "price"         => $this->input->post("price"),
                "amount"        => $this->input->post("amount"),
                "mobile_number" => $this->input->post("mobile_number"),
                "district"      => $this->input->post("district"),
                "upazila"       => $this->input->post("upazila"),
                "delivary_date" => $this->input->post("delivary_date"),
                "order_by"      => $this->data["code"],
                "address"       => $this->input->post("address"),
                "remark"        => $this->input->post("remark"),
                "status"        => $this->input->post("status"),
                "showroom_id"   => $this->data["showroom"]
            );

            $msg_array=array(
                "title"=>"Success",
                "emit"=>"New Order Successfully Update",
                "btn"=>true
            );

            $this->data['confirmation']=message($this->action->update("order",$data,$where), $msg_array);
        }

        $this->data["orders"] = $this->action->read("order",$where);

        $this->load->view('panel/includes/header', $this->data);
        $this->load->view('panel/includes/aside', $this->data);
        $this->load->view('panel/includes/headermenu', $this->data); 
        $this->load->view('panel/order/nav', $this->data);
        $this->load->view('panel/order/edit', $this->data);
        $this->load->view('panel/includes/footer', $this->data);
    }

    public function view($id) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="order-menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array("id" => $id);
        $this->data["order"] = $this->action->read("order",$where);

        $this->load->view('panel/includes/header', $this->data);
        $this->load->view('panel/includes/aside', $this->data);
        $this->load->view('panel/includes/headermenu', $this->data); 
        $this->load->view('panel/order/nav', $this->data);
        $this->load->view('panel/order/view', $this->data);
        $this->load->view('panel/includes/footer', $this->data);
    }

    public function delete($id){
        $where = array("id" => $id);

        $msg_array=array(
            "title"=>"Deleted",
            "emit"=>"Order Successfully Deleted",
            "btn"=>true
        );

        $confirmation = message($this->action->deleteData("order", $where), $msg_array);
        $this->session->set_flashdata('confirmation', $confirmation);
        redirect('panel/order/all','refresh');
    }

    public function ajax_dis_upazilla(){
        $dis = $this->input->post("dis");

        $dis_upazilla = config_item("dist_upozila");

        foreach ($dis_upazilla[$dis] as $value) {
            echo '<option value="'.$value.'">'.$value.'</option>';
        }

    }

    public function ajax_change_status(){
        $id = $this->input->post("id");
        $status = $this->input->post("status");

        $where = array("id" => $id);
        $data = array("status" => $status);

        if($this->action->update("order",$data,$where)){
            echo "success";
        }
    }
}
