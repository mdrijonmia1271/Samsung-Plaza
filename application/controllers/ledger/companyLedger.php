<?php
class CompanyLedger extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']               = 'Company Ledger';
        $this->data['active']                   = 'data-target="ledger"';
        $this->data['subMenu']                  = 'data-target="company-ledger"';
		$this->data['width']      	            = 'width';
		$this->data['resultset']                = null;
        $this->data['partyCode'] 	            = '';
		$this->data['fromDate'] 	            = '';
		$this->data['toDate'] 		            = '';
		$this->data['partyBalance']             = 0.00;
		$this->data['totalCommissionAmoint']    = 0.00;

        $this->data['allGodown']                = getAllGodown();
        // Get all parties name
        $this->data['info'] = $this->getAllSupplier();

        $this->data['defaultData'] = $this->getDefaultData();
        
        // Get data after submit query Start here
        if(isset($_POST['show'])) {
            $where = ["trash" => 0];

            if(!empty($this->input->post('search'))){
                foreach ($this->input->post('search') as $key => $value) {
                    $where[$key] = $value;
                }
            }

            if(isset($_POST['show'])) {

                if(!empty($_POST['godown_code'])){
                    if($_POST['godown_code'] != 'all'){
                        $where['godown_code'] = $_POST['godown_code'];
                    }
                }else{
                    $where['godown_code'] = $this->data['branch'];
                }

            }else{
                $where["godown_code"] = $this->data['branch'];
            }

            if($this->input->post('date') != NULL){
                foreach($_POST['date'] as $key => $value) {
                    if($value != NULL){
                        if($key == "from"){$where["transaction_at >="] = $value;$this->data['fromDate'] = $value;}
                        if($key == "to"){$where["transaction_at <="] = $value;$this->data['toDate'] = $value;}
                    }
                }
            }

            $this->data['resultset'] = get_result('partytransaction', $where, ['transaction_at','godown_code', 'previous_balance', 'inc_code', 'remark', 'relation', 'credit', 'debit', 'comment']);

            if(!empty($_POST['search']['party_code'])){
                $where_parties['code']   = $_POST['search']['party_code'];  
            }else{
                $where_parties = [];
            }
    	                    
    	    $this->data['partyInfo'] = get_row('parties', $where_parties, ['code', 'godown_code', 'name', 'address', 'mobile', 'initial_balance', '', ]);
        }
        // Get data after submit query End here

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/company-ledger', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    // Get the default data
    public function getDefaultData() {
        $data = array();
        $allCompany = $this->getAllSupplier();

        // get company transaction
        if(!empty($allCompany)){
            foreach ($allCompany as $key => $value) {
            
                // set the company information
                $data[$key]['code']             = $value->code;
                $data[$key]['name']             = $value->name;
                $data[$key]['init']             = $value->initial_balance;
                $data[$key]['init_status']      = ($value->initial_balance >= 0 )? "Receivable":"Payable";
                $data[$key]['debit']            = 0.00;
                $data[$key]['credit']           = 0.00;

                $data[$key]['opening_balance']  = $value->initial_balance;

                $where =[ "party_code" => $value->code, "trash" => 0];

                if(isset($_POST['show'])) {

                    if(!empty($_POST['godown_code'])){
                        if($_POST['godown_code'] != 'all'){
                            $where['godown_code'] = $_POST['godown_code'];
                        }
                    }else{
                        $where['godown_code'] = $this->data['branch'];
                    }

                }else{
                    $where["godown_code"] = $this->data['branch'];
                }

                
                $allTransaction = $this->action->read('partytransaction', $where);


                if($allTransaction != null) {
                    foreach ($allTransaction as $records) {
                        $data[$key]['debit']                += $records->debit;
                        $data[$key]['credit']               += $records->credit;
                        $data[$key]['comment']               = $records->comment;
                    }
                }
            }
        }

        return $data;
    }

    // get all supplier
    private function getAllSupplier(){

        $where  =["type" => "supplier", "trash" => 0];

        /*if(isset($_POST['show'])) {

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }

        }else{
            $where["godown_code"] = $this->data['branch'];
        }*/

        $result = get_result('parties', $where, ['code','godown_code', 'name', 'address', 'initial_balance']);
        return $result;
    }


}