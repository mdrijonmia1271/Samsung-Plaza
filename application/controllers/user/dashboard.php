<?php
class Dashboard extends Admin_controller{

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action'); 
    }

    public function index() {
        $this->data['meta_title'] = 'dashboard';
        $this->data['active']     = 'data-target="dashboard"';
        $this->data['subMenu']    = 'data-target=""';

        // initial date and godown code
        $today = date("Y-m-d");
        $godown_code = $this->data['branch']; 
        
        // Today's purchase
        $where = array(
            "godown_code" => $godown_code,
            "sap_at" => $today,
            "status" => "purchase",
            'trash'  => 0
        );
        $this->data['todays_purchase'] = get_sum("saprecords", "total_bill", $where);
        
        // Today's sale
        $where["status"] = "sale";
        $this->data['todays_sale'] = get_sum("saprecords", "total_bill", $where);
        
        // Today's paid 
        $this->data["totals_paid"] = get_sum("saprecords", "paid", $where); 
        
        // Today's due
        $this->data['todays_due'] = $this->data['todays_sale'] - $this->data["totals_paid"];
        
       
        // Sale Return
        $today_sale_return = $this->action->readGroupBy("sale_return", "return_amount",array('trash'=>0));
        $this->data['totalSaleReturn'] = 0.00;
        foreach ($today_sale_return as $key => $value) {
            $this->data['totalSaleReturn'] += $value->return_amount;
        }
        

        //Bank Diposit
        $where = [];
        $where = array(
            "transaction_date" => $today,
            "transaction_type" => "Credit"
        );
        $this->data['bank_diposit'] = get_sum('transaction',"amount", $where);

        //Bank Withdraw
        $where ["transaction_type"] = "Debit";
        $this->data['bank_withdraw'] = get_sum('transaction', 'amount',  $where);
        
        //Bank To Cash
        $where ["transaction_type"] = "BTC";
        $this->data['bank_to_cash'] = get_sum('transaction','amount',$where);
        
        //Cash To Bank
        $where ["transaction_type"] = "CTB";
        $this->data['cash_to_bank'] = get_sum('transaction','amount',$where);
        
        //Bank To TT
        $where ["transaction_type"] = "bank_to_TT";
        $this->data['bankToTT'] = get_sum('transaction','amount',$where);
        
        //Cash To TT
        $where = [];
        $where = array('trash'=> 0, "transaction_at" => $today);
        $where ["transaction_via"] = "cash_to_tt";
        $this->data['cashToTT'] = get_sum('partytransaction', 'debit', $where);
        

        //Total Cost $ Income
        $where = [];
        $where = array(
            "date" => $today,
            "godown_code" => $godown_code,
            "trash" => 0
        );
        $this->data['total_cost'] = get_sum('cost','amount', $where);
        $this->data['total_income'] = get_sum('income','amount', $where);
        $this->data['total_rent'] = get_sum('rent','amount', $where);
         
        
        // Client Collection
        $where = [];
        $where = ['transaction_at' => $today, 'trash' => 0, 'transaction_by' => 'client', 'godown_code' => $godown_code];
        $todaClientTran = get_sum('partytransaction', 'credit', $where);
        $todaDueCollection = get_sum('due_collect', 'paid', ['date'=> $today, 'godown_code' => $godown_code]);
        $this->data['client_collection'] = (!empty($todaClientTran) ? $todaClientTran : 0) +  (!empty($todaDueCollection) ? $todaDueCollection : 0);

        
        
        // Supplier paid
        $where = [];
        $where = array('transaction_at' => $today, 'trash' => 0, 'transaction_by' => 'supplier', 'godown_code' => $godown_code);
        $this->data['supplier_paid'] = get_sum('partytransaction','debit', $where);
        
        
        // Todays installment
        $where = [];
        $where = array(
            'saprecords.godown_code' => $godown_code,
            'saprecords.installment_date' => $today,
            'saprecords.trash' => 0
        );
        $joincond = "parties.code=saprecords.party_code";
        $select = ['saprecords.installment_amount', 'saprecords.party_code', 'parties.name', 'parties.mobile', 'parties.address'];
        $this->data['todaysInstallment'] =get_join('saprecords', 'parties', $joincond, $where);


        // Today commission
        $where = [];
        $where = ['commitments.date' => $today, 'commitments.godown_code' => $godown_code];
        $select = ['commitments.*', 'parties.name', 'parties.mobile', 'parties.address', 'parties.initial_balance'];
        $this->data["todaysCommitment"] = get_join('commitments', 'parties', 'parties.code=commitments.party_code', $where, $select);
        
        //Entire Details Start here-----------------------------------------------
        
        
        /* 
        //Purchase
        $where = array(
            "status" => "purchase"
        );
        $this->data['entire_purchase'] = $this->action->read_sum("saprecords", "total_bill", $where);

        //Sale
        $where["status"] = "sale";
        $this->data['entire_sale'] = $this->action->read_sum("saprecords", "total_bill", $where); 

        //Total Cost
        $where = array("trash" => 0);
        $this->data['entire_cost'] = $this->action->read_sum('cost','amount',$where);

        //Parties
        $where = array("trash" => 0);
        $party = $this->action->read('parties',$where);

        $client = 0;
        $supplier = 0;
        foreach ($party as $key => $value) {
            if($value->type=="client"){
                $client += 1;
            }else{
                $supplier += 1;
            }
        }

        $this->data["client"] = $client;
        $this->data["supplier"] = $supplier;

        //Entire Details End here------------------------------------------------


        //customer balance
        $payableBalance = $receivableBalance = 0.00;
        $joincond = "partybalance.code = parties.code";
        $where = array('parties.type' => 'client');
        $balance = $this->action->joinAndRead('partybalance', 'parties', $joincond, $where);
        
        foreach ($balance as $key => $value) {
            if ($value->balance > 0) {
                $payableBalance += $value->balance;
            }else {
                $receivableBalance += abs($value->balance);
            }
        }
   
        //Getting Total Information
        //Stock
        $this->data["stock_raw"] = $this->action->get_stock("raw");
        $this->data["stock_finish"] = $this->action->get_stock("finish_product");
		
		
		$where = array("status" => 'available');
		$this->data["product_quantity"] = $this->getQuantity('products', $where);

        // due calculation  
        $client_due = $supplier_due = array();
        $from = "parties";
        $join = "partybalance";
        $join_cond = "parties.code = partybalance.code";  
                
        $whereC = array(
          "parties.type" => "client",
          "partybalance.balance >"  => 0
        ); 
        
         $whereS = array(
          "parties.type" => "supplier",
          "partybalance.balance <"  => 0
        ); 
        
        $clientDueInfo = $this->action->joinAndRead($from,$join,$join_cond,$whereC);
        $supplierDueInfo = $this->action->joinAndRead($from,$join,$join_cond,$whereS);
        
        foreach($clientDueInfo as $key=>$value){
          $client_due[] = $value->balance;          
        } 
        
       foreach($supplierDueInfo as $key=>$value){
          $supplier_due[] = $value->balance;         
        }      
      
        
        $this->data['clientTotalDue'] = array_sum($client_due);
        $this->data['supplierTotalDue'] = array_sum($supplier_due); */
        
        
        

        $this->load->view('user/includes/header', $this->data);
        $this->load->view('user/includes/aside', $this->data);
        $this->load->view('user/includes/headermenu', $this->data);
        $this->load->view('user/includes/dashboard_nav', $this->data);
        $this->load->view('user/dashboard', $this->data);
        $this->load->view('user/includes/footer');
    }
    
    /* private function getQuantity($table, $where) {
        $data = $this->action->read($table, $where);
        $counter = 0;
        
        foreach ($data as $key => $row) {
            $counter += 1;
        }
        
        return $counter;
    } */

    private function holder(){
        if($this->uri->segment(1) != $this->session->userdata('holder')){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
