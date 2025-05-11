<?php
class Dashboard extends Admin_controller{

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'dashboard';
        $this->data['active'] = 'data-target="dashboard"';
        $this->data['subMenu'] = 'data-target=""';

        $today = date("Y-m-d");

        //Todays Details Start here

        //Purchase
        $where = array(
            "sap_at" => $today,
            "status" => "purchase",
            'trash'  => 0
        );
        $this->data['total_purchase'] = $this->action->read_sum("saprecords", "total_bill", $where);

        //Sale
        $where["status"] = "sale";
        $this->data['total_sale'] = $this->action->read_sum("saprecords", "total_bill", $where);
        
        //Today's Sale Return
        $where["status"] = "sale";
        $this->data['total_sale'] = $this->action->read_sum("saprecords", "total_bill", $where);
        

        $this->data["total_paid"] = $this->action->read_sum("saprecords","paid",$where); 
        
        // Today due calculation
        $allSale = $this->action->read('saprecords',$where);
        $total = 0.00;
        foreach ($allSale as $key => $value) {
            $due = 0.00;
            $due = $value->total_bill - $value->paid;
            if ($due > 0 ) {
               $total += $due;
            }
        }
        $this->data['todays_due'] = $total;
        
        // client collection
        $this->data['todays_due_collection'] = $this->action->read_sum('due_collect','paid',array('date'=> date('Y-m-d')));
        
        // Sale Return
        $today_sale_return = $this->action->readGroupBy("sale_return", "return_amount",array('trash'=>0));
        $this->data['totalSaleReturn'] = 0.00;
        foreach ($today_sale_return as $key => $value) {
            $this->data['totalSaleReturn'] += $value->return_amount;
        }
        

        //Bank Diposit
        $where = array(
            "transaction_date" => $today,
            "transaction_type" => "Credit"
        );
        $this->data['bank_diposit'] = $this->action->read_sum('transaction',"amount",$where);

        //Bank Withdraw
        $where ["transaction_type"] = "Debit";
        $this->data['bank_withdraw'] = $this->action->read_sum('transaction','amount',$where);
        
        //Bank To Cash
        $where ["transaction_type"] = "BTC";
        $this->data['bank_to_cash'] = $this->action->read_sum('transaction','amount',$where);
        
        //Cash To Bank
        $where ["transaction_type"] = "CTB";
        $this->data['cash_to_bank'] = $this->action->read_sum('transaction','amount',$where);
        
        //Bank To TT
        $where ["transaction_type"] = "bank_to_TT";
        $this->data['bankToTT'] = $this->action->read_sum('transaction','amount',$where);
        
        //Cash To TT
        $where = array('trash'=> 0,"transaction_at" => $today);
        $where ["transaction_via"] = "cash_to_tt";
        $this->data['cashToTT'] = $this->action->read_sum('partytransaction','debit',$where);
        

        //Total Cost $ Income
        $where = array(
            "date" => $today,
            "trash" => 0
        );
        $this->data['total_cost'] = $this->action->read_sum('cost','amount', $where);
        $this->data['total_income'] = $this->action->read_sum('income','amount', $where);
        $this->data['total_rent'] = $this->action->read_sum('rent','amount', $where);
        
        
        // Client Collection
        $transactionWhere = array('transaction_at' => $today,'trash' => 0,'transaction_by' => 'client');
        $this->data['client_collection'] = $this->action->read_sum('partytransaction','credit',$transactionWhere);
        
        
        // Supplier paid
        $transactionWhere = array('transaction_at' => $today,'trash' => 0,'transaction_by' => 'supplier');
        $this->data['supplier_paid'] = $this->action->read_sum('partytransaction','debit',$transactionWhere);
        
        
        // Todays installment
        $where = array(
            'installment_date' => date('Y-m-d'),
            'installment.status' => 'active'
        );
        
        $from = 'installment';
        $join = 'parties';
        $joincond = "installment.client_code=parties.code";
        
        $this->data['todaysInstallment'] = $this->action->joinAndRead($from, $join, $joincond, $where);
        
        
        
        //Todays Details End here------------------------------------------------
        
        
        
        
        
        
        
        
        
        
        //Entire Details Start here-----------------------------------------------
        

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
        $this->data['supplierTotalDue'] = array_sum($supplier_due);
        
        $whereCommitment['date'] = date('Y-m-d');
        $this->data['todaysCommitment'] = $this->action->read('commitments', $whereCommitment);

        $this->load->view('super/includes/header', $this->data);
        $this->load->view('super/includes/aside', $this->data);
        $this->load->view('super/includes/headermenu', $this->data);
        $this->load->view('super/includes/dashboard_nav', $this->data);
        $this->load->view('super/dashboard', $this->data);
        $this->load->view('super/includes/footer');
    }
	
	private function getQuantity($table, $where) {
		$data = $this->action->read($table, $where);
		$counter = 0;
		
        foreach ($data as $key => $row) {
            $counter += 1;
        }
		
		return $counter;
	}

    private function holder(){
        if($this->uri->segment(1) != $this->session->userdata('holder')){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
