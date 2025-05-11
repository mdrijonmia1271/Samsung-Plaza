<?php
class ClientLedger extends Subscriber_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("action");
    }

    public function index() {
        $this->data['meta_title']   = 'Client Ledger';
        $this->data['active']       = 'data-target="ledger"';
        $this->data['subMenu']      = 'data-target="client-ledger"';
        $this->data['width']      	= 'full-width';

        $this->data['resultset']    = null;
        $this->data['partyCode'] 	= '';
		$this->data['fromDate'] 	= '';
		$this->data['toDate'] 		= '';
		$this->data['partyBalance'] = 0.00;
		$this->data['totalCommissionAmoint'] = 0.00;



        // Get all parties name
        $where = array("type" => "client");
        $this->data['info'] = $this->action->readGroupBy('parties', 'name', $where, 'id', 'asc');

        if(isset($_POST['show'])) {
            $where = array();

            if($this->input->post('search') != NULL) {
                foreach ($this->input->post('search') as $key => $value) {
                    $where[$key] = $value;
                }
            }

            if($this->input->post('date') != NULL) {
                foreach($_POST['date'] as $key => $value) {
                    if($value != NULL) {
                        if($key == "from"){$where["transaction_at >="] = $value;$this->data['fromDate'] = $value;}
                        if($key == "to"){$where["transaction_at <="] = $value;$this->data['toDate'] = $value;}
                    }
                }
            }

            $this->data['resultset'] = $this->action->read('partytransaction', $where);

			if($this->data['resultset'] != null) {
				foreach ($this->data['resultset'] as $key => $row) {
					if($row->remark == 'sale') {
						$relationList = explode(':', $row->relation);
						$where = array('voucher_no' => $relationList[1]);
						$items = $this->action->read('sapitems', $where);

						$amount = metadata('sapmeta', array('voucher_no' => $relationList[1], 'meta_key' => 'commission_amount'));
						$comm = ($amount != null) ? $amount : 0.00;

						foreach ($items as $item) {
							$this->data['totalCommissionAmoint'] += $comm * $item->quantity;
						}
					}
				}
			}

            $where = array('code' => $_POST['search']['party_code']);
			$this->data['partyCode'] = $_POST['search']['party_code'];

            $this->data['partyBalance'] = $this->action->read('partybalance', $where);

			$this->data['partyInfo'] = $this->action->read('parties', $where);
        }

		$this->data['allSubcategories'] = $this->action->read('subcategory');

         $this->load->view('panel/includes/header', $this->data);
         $this->load->view('panel/includes/aside', $this->data);
         $this->load->view('panel/includes/headermenu', $this->data);
         $this->load->view('components/ledger/client-ledger', $this->data);
         $this->load->view('panel/includes/footer', $this->data);


     }


}
