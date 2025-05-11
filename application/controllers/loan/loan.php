<?php
class Loan extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->data['meta_title'] = 'Bank';
        $this->data['active'] = 'data-target="loan-menu"';
    }
    

    public function index() {
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan/nav', $this->data);
        $this->load->view('components/loan/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    // view all data
    public function view_all() {
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array();
        if ($this->input->post("show")) {
            $where = array();
            foreach ($_POST["search"] as $key => $value) {
                if ($value != null) {
                    $where[$key] = $value;
                }
            }

            foreach ($_POST["date"] as $key => $value) {
                if ($value != null && $key == "from") {
                    $where["date >="] = $value;
                }
                if ($value != null && $key == "to") {
                    $where["date <="] = $value;
                }
            }
        }

        $this->data["allInfo"] = $this->action->read("loan", $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan/nav', $this->data);
        $this->load->view('components/loan/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    // edit data
    public function edit($id = null){
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data["info"] = $this->action->read("loan", array("id" => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan/nav', $this->data);
        $this->load->view('components/loan/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    // preview data
    public function preview($id = null){
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data["allInfo"] = $this->action->read("loan", array("id" => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan/nav', $this->data);
        $this->load->view('components/loan/preview', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    // add data
    public function add(){

        if ($this->input->post("type") == "Bank") {
            $this->form_validation->set_rules("account_no", "Account Number", "trim|required|xss_clean");
        }else {
            $this->form_validation->set_rules("person_name", "Person Name", "trim|required|xss_clean");
        }

        if ($this->form_validation->run() == FALSE) {

            $w_msg = array(
                "title" => "warning",
                "emit"  => validation_errors('<p>', '</p>'),
                "btn"   => true
            );

            $this->data['confirmation'] = message('warning', $w_msg);
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("loan/loan", "refresh");
        }else {
            $data = array(
                "date"          => $this->input->post("date"),
                "type"          => $this->input->post("type"),
                "contact_info"  => $this->input->post("contact_info"),
                "address"       => $this->input->post("address"),
                "loan_type"     => $this->input->post("loan_type"),
                "loan_by"       => $this->input->post("loan_by"),
                "remarks"       => $this->input->post("remarks"),
                "amount"        => $this->input->post("amount")
            );

            if ($this->input->post("type") == "Bank") {
                $data["name"]        = $this->input->post("bank_name");
                $data["branch"]      = $this->input->post("branch");
                $data["account_no"]  = $this->input->post("account_no");
            }else{
                $data["name"]        = $this->input->post("person_name");
            }

            $msg = array(
                "title" => "success",
                "emit"  => "Loan Successfully " . $this->input->post("loan_type"),
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->add("loan", $data), $msg);
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("loan/loan", "refresh");
        }
    }
    

    // edit data
    public function loan_edit($id = null){

        $where = array("id" => $id);

        $data = array(
            "date"          => $this->input->post("date"),
            "type"          => $this->input->post("type"),
            "contact_info"  => $this->input->post("contact_info"),
            "address"       => $this->input->post("address"),
            "loan_type"     => $this->input->post("loan_type"),
            "loan_by"       => $this->input->post("loan_by"),
            "remarks"       => $this->input->post("remarks"),
            "amount"        => $this->input->post("amount")
        );

        if ($this->input->post("type") == "Bank") {
            $data["name"]        = $this->input->post("bank_name");
            $data["branch"]      = $this->input->post("branch");
            $data["account_no"]  = $this->input->post("account_no");
        }else{
            $data["name"]        = $this->input->post("person_name");
        }

        $msg = array(
            "title" => "update",
            "emit"  => "This data successfully updated!",
            "btn"   => true
        );

        $this->data['confirmation'] = message($this->action->update("loan", $data, $where), $msg);
        $this->session->set_flashdata("confirmation", $this->data['confirmation']);
        redirect("loan/loan/view_all", "refresh");
    }
    

    // change status
    public function status($id = null){
        $this->data["confirmation"] = null;

        $where = array("id" => $id);
        $info = $this->action->read("loan", $where);

        if ($info[0]->status == "Open") {
            $data["status"] = "Closed";
            $text = "Closed";
        }else {
            $data["status"] = "Open";
            $text = "Open";
        }

        $msg = array(
            "title" => "success",
            "emit"  => "Loan Successfully " . $text,
            "btn"   => true
        );

        $ths->data["confirmation"] = message($this->action->update("loan", $data, $where), $msg);
        $this->session->set_flashdata("confirmation", $ths->data["confirmation"]);
        redirect("loan/loan/view_all", "refresh");
    }


    // delete data
    public function delete($id = null){
        $where = array("id" => $id);

        $msg = array(
            "title" => "delete",
            "emit"  => "Data Successfully Deleted!",
            "btn"   => true
        );

        $this->data["confirmation"] = message($this->action->deleteData("loan", $where), $msg);
        $this->session->set_flashdata("confirmation", $this->data['confirmation']);
        redirect("loan/loan/view_all", "refresh");
    }


    public function transaction() {
        $this->data['subMenu'] = 'data-target="trans"';
        $this->data['confirmation'] = null;
        $where = array(
            "type" => "Bank",
            "status" => "Open"
        );
        $this->data['banks'] = $this->action->read("loan",$where);

        $where = array(
            "type" => "Person",
            "status" => "Open"
        );
        $this->data['persons'] = $this->action->read("loan",$where);

        if($this->input->post("save")){
            $data = array(
                "date"           => $this->input->post("date"),
                "loan_id"        => $this->input->post("loan_id"),
                "transaction_by" => $this->input->post("transaction_by"),
                "amount"         => $this->input->post("amount")
            );

            if($this->input->post("due")<=0){
                $this->updateStatus();
            }

            $msg = array(
                "title" => "success",
                "emit"  => "Transaction Successfully Saved",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->add("loan_transaction", $data), $msg);
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("loan/loan/transaction", "refresh");
        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan/nav', $this->data);
        $this->load->view('components/loan/transaction', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    

    private function updateStatus(){
        $where = array(
            "id"  => $this->input->post("loan_id")
        );

        $data = array(
            "status" => "Closed"
        );

        $this->action->update("loan", $data,$where);
    }
    

    public function alltransaction() {
        $this->data['subMenu'] = 'data-target="alltrans"';
        $this->data['confirmation'] = $this->data['transaction'] = null;

        $where = array(
            "type" => "Bank",
        );
        $this->data['banks'] = $this->action->read("loan",$where);

        $where = array(
            "type" => "Person",
        );
        $this->data['persons'] = $this->action->read("loan",$where);

        if($this->input->post("show")){
            //Search query start here-----------------------------
            $where = $where_info = array();
            if ($this->input->post('search')) {
              foreach ($this->input->post('search') as $key => $value) {
                  if($value != NULL){
                        $where[$key] = $value;
                        if($key=="loan_id"){
                            $where_info["id"] = $value;
                        }
                  }
              }
            }

            foreach ($this->input->post('date') as $key => $value) {
                if($value != NULL){
                    if($key=="from"){
                      $where["date >="] = $value;
                    }
                    if($key=="to"){
                      $where["date <="] = $value;
                    }
                }
            }
            $this->data['transaction']=$this->action->read('loan_transaction', $where);
            $this->data['info']=$this->action->read('loan', $where_info);
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan/nav', $this->data);
        $this->load->view('components/loan/alltransaction', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

}
