<?php

class Chaque extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'Chaque';
        $this->data['active'] = 'data-target="cheque_menu"';
        $this->data['subMenu'] = 'data-target="all"';
		$this->data['resultset'] = null;

        // set default date
        $date = new DateTime("+3days");
        $from = date('Y-m-d');
        $to = $date->format("Y-m-d");

        // override the date
		if(isset($_POST['show'])) {
			foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from') {
                    $from = $val;
                }

                if($val != null && $key == 'to'){
                    $to = $val;
                }
            }
		}

        $this->data['resultset'] = $this->getRequiredCheque($from, $to);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        //$this->load->view('components/chaque/nav', $this->data);
        $this->load->view('components/chaque/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function getRequiredCheque($from, $to) {
        $data = array();
        $recored = array();
        $transaction_id = array();

        $metadata = $this->action->read("partytransactionmeta");
        foreach ($metadata as $key => $value) {
            if(in_array($value->transaction_id, $transaction_id)) {
                $recored[$value->transaction_id][$value->meta_key] = $value->meta_value;
            } else {
                $transaction_id[] = $value->transaction_id;

                $recored[$value->transaction_id]['transaction_id'] = $value->transaction_id;
                $recored[$value->transaction_id][$value->meta_key] = $value->meta_value;
            }
        }

        foreach ($recored as $key => $value) {
            if(array_key_exists('status', $value)) {
                if($value['status'] == "pending") {
                    if(array_key_exists('passdate', $value)) {
                        $passdateDateTime = new DateTime($value['passdate']);

                        $fromDateTime = new DateTime($from);
                        $toDateTime = new DateTime($to);

                        if($passdateDateTime >= $fromDateTime && $passdateDateTime <= $toDateTime) {
                            $data[] = $value;
                        }
                    }
                }
            }
        }

        return $data;
    }

	public function changeStatus() {
        $this->data["confirmation"] = null;
        $data = null;
        $where = array();
        $metadata = $this->action->read("partytransactionmeta", array("transaction_id" => $this->input->get('id')));
        foreach ($metadata as $key => $value) {
            if ($value->transaction_id == $this->input->get('id') && $value->meta_key == "status") {
                $where = array("id" => $value->id);
                $data = array("meta_value" => "withdraw");
            }
        }

        $msg = array(
            "title" => "success",
            "emit"  => "Check Payment Successfull",
            "btn"   => true
        );

        $this->data["confirmation"] = message($this->action->update("partytransactionmeta", $data, $where), $msg);
        $this->session->set_flashdata("confirmation", $this->data["confirmation"]);
		redirect('chaque/chaque', 'refresh');
	}

}
