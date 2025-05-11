<?php
class ClientLedger extends Admin_Controller {

    function __construct() {
        parent::__construct();

         $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Client Ledger';
        $this->data['active']       = 'data-target="ledger"';
        $subMenu                    = !empty($_GET['type']) ? $_GET['type'] : 'client' ;
        $this->data['subMenu']      = 'data-target="'.$subMenu.'-ledger"';
        $this->data['width']        = 'width';
        
        if(!empty($_GET['type'])){
            $this->data['c_type'] = $_GET['type'];
        }else{
            $this->data['c_type'] = '';
        }
        
        $this->data['resultset']                = null;
        $this->data['partyCode'] 	            = '';
    	$this->data['fromDate'] 	            = '';
    	$this->data['toDate'] 		            = '';
    	$this->data['partyBalance']             = 0.00;
    	$this->data['totalCommissionAmoint']    = 0.00;

        // Get all parties name
        $this->data['info']                     = $this->getAllClient($this->data['c_type']);
        $this->data['defaultData']              = $this->getDefaultData($this->data['c_type']);

        //Get Data After Submit Query Start here
        $where = ["trash"   =>0];
        $where_sapitems     = ["trash" =>0];
        $where_parties      = ["trash" =>0];
        if(isset($_POST['show'])) {

            if($this->input->post('search') != NULL) {
                foreach ($this->input->post('search') as $key => $value) {
                    $where[$key] = $value;
                }
            }
            
            if($this->input->post('date') != NULL) {
                foreach($_POST['date'] as $key => $value) {
                    if($value != NULL) {
                        if($key == "from"){
                            $where["transaction_at >="]             = $value; $this->data['fromDate'] = $value;
                            $where_sapitems["transaction_at >="]    = $value; $this->data['fromDate'] = $value;
                            //$where_parties["opening >="]            = $value; $this->data['fromDate'] = $value;
                        }
                        if($key == "to"){
                            $where["transaction_at <="]             = $value; $this->data['toDate'] = $value;
                            $where_sapitems["transaction_at <="]    = $value; $this->data['toDate'] = $value;
                            //$where_parties["opening <="]            = $value; $this->data['toDate'] = $value;
                        }
                    }
                }
            }

            if (!empty($_POST['godown_code'])){
                $where['godown_code'] = $_POST['godown_code'];
            }

            $this->data['resultset'] = get_result('partytransaction', $where, ['transaction_at', 'remark', 'comment', 'relation', 'previous_balance', 'inc_code', 'debit', 'adjustment', 'comission', 'credit', 'remission']);
            if(!empty($this->data['resultset'])) {
                foreach ($this->data['resultset'] as $key => $row) {
                    if($row->remark == 'sale') {
                        $relationList = explode(':', $row->relation);
                        if(!empty($_POST['search'])){
                            $where_sapitems = array('voucher_no' => $relationList[1]);
                        }

                        $items = $this->action->read('sapitems', $where_sapitems);

                        $amount = metadata('sapmeta', array('voucher_no' => $relationList[1], 'meta_key' => 'commission_amount'));
                        $comm = ($amount != null) ? $amount : 0.00;

                        foreach ($items as $item) {
                            $this->data['totalCommissionAmoint'] += $comm * $item->quantity;
                        }
                    }
                }
            }

            if(!empty($_POST['search']['party_code'])){
                $this->data['partyCode']        = $_POST['search']['party_code'];
                $where_parties['code'] = $_POST['search']['party_code'];

                if (!empty($_POST['godown_code'])){
                    $where_parties['godown_code'] = $_POST['godown_code'];
                }
            }

            $this->data['partyInfo']    = get_row('parties', $where_parties, ['opening', 'code', 'godown_code', 'name', 'address', 'mobile', 'initial_balance']);

        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/client-ledger', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    
    // Get the default data
    public function getDefaultData($c_type) {

        $clientList = $this->getAllClient($c_type);
            
        $results = [];

        // get Client transaction
        if(!(empty($clientList))){
            foreach ($clientList as $row) {
                
                $item = [];
                
                $balanceInfo = (object)get_client_balance($row->code);
                
                // set the client information
                $item['code']              = $row->code;
                $item['godown_name']       = $row->godown_name;
                $item['name']              = $row->name;
                $item['address']           = $row->address;
                $item['credit_limit']      = $row->credit_limit;
                $item['initial_balance']   = $row->initial_balance;
                $item['init_status']       = ($row->initial_balance < 0 ? "Payable" : "Receivable");
                $item['debit']             = $balanceInfo->debit;
                $item['credit']            = $balanceInfo->credit;
                $item['remission']         = $balanceInfo->remission;
                $item['adjustment']        = $balanceInfo->adjustment;
                $item['balance']           = $balanceInfo->balance;
                
                array_push($results, (object)$item);
            }
        }
        
        return $results;
    }

    // get all client
    private function getAllClient($c_type){
        
        $where = [
            'parties.type' => 'client',
            'parties.customer_type' => 'dealer',
            'parties.trash' => 0
        ];
        
        if(!empty($c_type)){
            $where['parties.customer_type'] = $c_type;
        }

        if(!empty($_POST['godown_code'])){
            if($_POST['godown_code'] != 'all'){
                $where['parties.godown_code'] = $_POST['godown_code'];
            }
        }else{
            $where['parties.godown_code'] = $this->data['branch'];
        }

        $select = ['parties.code', 'parties.name', 'parties.address', 'parties.mobile', 'parties.credit_limit', 'parties.initial_balance', 'godowns.name as godown_name'];
        $result = get_left_join('parties', 'godowns', 'parties.godown_code=godowns.code', $where, $select);
        return $result;
    }

    // Get the default data
    public function getClientData($where) {
        $data = array();
        $allClient = $this->action->read('parties', $where);

        // get Client transaction
        foreach ($allClient as $key => $value) {
         
            // set the client information
            $data[$key]['code']        = $value->code;
            $data[$key]['name']        = $value->name;
            $data[$key]['address']     = $value->address;
            $data[$key]['credit_limit']= $value->credit_limit;
            $data[$key]['init']        = $value->initial_balance;
            $data[$key]['init_status'] = ($value->initial_balance >= 0 )? "Receivable":"Payable";
            $data[$key]['quantity']    = 0.00;
            $data[$key]['debit']       = 0.00;
            $data[$key]['credit']      = 0.00;

            $data[$key]['opening_balance'] = $value->initial_balance;

            $where = array(
                "party_code" => $value->code,
                "trash" => 0
            );
            $allTransaction = $this->action->read('partytransaction', $where);

            if($allTransaction != null) {
                foreach ($allTransaction as $records) {
                    $data[$key]['debit']        += $records->debit + $records->comission;
                    $data[$key]['credit']       += $records->credit + $records->remission;
                    $data[$key]['comment']       = $records->comment;
                }
            }
        }

        return $data;
    }
    
    
    
    public function customer($party_code) {
        $this->data['meta_title']   = 'Client Ledger';
        $this->data['active']       = 'data-target="ledger"';
        $this->data['subMenu']      = 'data-target="client-ledger"';
        $this->data['width']        = 'width';
        
        $this->data['c_type'] = 'client';
        
        $data = array();
        $clientWhere = array('code' => $party_code, 'type' => 'client', 'trash' => 0);
        $allClient = get_result('parties', $clientWhere, ['code', 'godown_code', 'godown_code as showroom', 'name', 'address', 'mobile', 'credit_limit', 'initial_balance']);

        // get Client transaction
        if(!(empty($allClient))){

            foreach ($allClient as $key => $value) {
            
                // set the client information
                $data[$key]['code']             = $value->code;
                $data[$key]['showroom']         = $value->showroom;
                $data[$key]['name']             = $value->name;
                $data[$key]['address']          = $value->address;
                $data[$key]['credit_limit']     = $value->credit_limit;
                $data[$key]['init']             = $value->initial_balance;
                $data[$key]['init_status']      = ($value->initial_balance >= 0) ? "Receivable" : "Payable";
                $data[$key]['quantity']         = 0.00;
                $data[$key]['debit']            = 0.00;
                $data[$key]['credit']           = 0.00;
                $data[$key]['toal_remission']   = 0.00;

                $data[$key]['opening_balance'] = $value->initial_balance;

                // Showroom Wise Check 

                $trxWhere = ["party_code" => $value->code, "trash" => 0];
                $allTransaction = get_result('partytransaction', $trxWhere, ['godown_code', 'debit', 'comission', 'credit', 'remission', 'comment']);
                //print_r($allTransaction);
                
                if($allTransaction != null) {
                    foreach ($allTransaction as $records) {
                        $data[$key]['debit']                += $records->debit + $records->comission;
                        $data[$key]['credit']               += $records->credit + $records->remission;
                        $data[$key]['toal_remission']       += $records->remission;
                        $data[$key]['comment']              = $records->comment;
                        $data[$key]['godown_code']          = $records->godown_code;
                    }
                }
            }
        }
        
        $this->data['defaultData']  = $data;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/client-ledger', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
}