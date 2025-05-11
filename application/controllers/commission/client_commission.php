<?php
class Client_commission extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

        $this->data['meta_title'] = 'Client Commission';
        $this->data['active'] = 'data-target="commission-menu"';
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="client"';
        $this->data['confirmation'] = $this->data['result'] = null;

        $this->data['allBrand'] = $this->action->read("subcategory");
        $this->data['zilla'] = $this->action->readGroupBy('parties', 'zone', array());
        $this->data['allClient'] = $this->action->readGroupBy("parties", "code", array("type" => "client"));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/commission/nav', $this->data);
        $this->load->view('components/commission/client-commission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

	// all new functions
    public function search() {
		$condition = array();
		$resultset = array();

        $content = file_get_contents("php://input");
        $receive = json_decode($content, true);

        // set conditions
		foreach ($receive as $key => $value) {
			$condition[$key] = $value;
		}

		$condition["remark"] = "sale";
		$condition["comission"] = "due";

		$result = $this->action->read("partytransaction", $condition);

		if($result != null){
			foreach ($result as $key => $row) {
				$name = $this->action->read("parties", array("code" => $row->party_code));

				$vno = explode(":", $row->relation);

				$quantity = metadata("sapmeta", array("voucher_no" => $vno[1], "meta_key" => "commission_quantity"));
				$amount = metadata("sapmeta", array("voucher_no" => $vno[1], "meta_key" => "commission_amount"));
				$total = metadata("sapmeta", array("voucher_no" => $vno[1], "meta_key" => "commission_total"));

				$resultset[] = array(
					"id" => $row->id,
					"sl" => ($key + 1),
					"date" => $row->transaction_at,
					"code" => $row->party_code,
					"name" => $name[0]->name,
					"brand" => $row->party_brand,
					"quantity" => $quantity,
					"amount" => $amount,
					"total" => $total,
					"action" => false
				);
			}
		}

        // convart the information array to JSON string
        echo json_encode($resultset);
    }

	public function payment() {
		foreach ($_POST['action'] as $key => $value) {
			$where = array("id" => $value);
			$data = array("comission" => "paid");

			$this->action->update("partytransaction", $data, $where);
		}

		$attribute = array(
			"title" => "Success",
			"emit" 	=> "Payment completed!",
			"btn" 	=> true
		);

		$this->session->set_flashdata('confirmation', message('success', $attribute));
		redirect('commission/client_commission', 'refresh');
	}

}
