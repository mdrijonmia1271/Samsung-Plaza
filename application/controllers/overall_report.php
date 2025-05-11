<?php

class Overall_report extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('action');
        $this->data['allGodown'] = $this->action->read('godowns');
    }

    public function index()
    {
        $this->data['meta_title'] = 'Overall Report';
        $this->data['active']     = 'data-target=""';
        
        $whereSale                  = array();
        $wherePurchase              =array();
        $wherePurchaseReturn        =array();
        $whereSale                  = array();
        $whereSaleReturn            =array();
        $whereVoucherCollection     = array();
        $whereRetailCollection      =array();
        $whereInstallmentCollection = array();
        $whereTransactionCollection = array();
        $whereSupplierPayment       = array();
        $whereRemark                = array();
        $whereStock                 = array();
        $whereBank                  = array();
        $whereCashInHand            = array();   
        
        
        if(isset($_POST['show'])){
        
            if((!empty($_POST['date_from'])) && (!empty($_POST['date_to']))){
                
                $dataFrom = $_POST['date_from'];
                $dataTo = $_POST['date_to'];
                
                $whereSale['sap_at >='] = $dataFrom;
                $whereSale['sap_at <='] = $dataTo;
                
                $wherePurchase['sap_at >='] = $dataFrom;
                $wherePurchase['sap_at <='] = $dataTo;
                
                $wherePurchaseReturn['transaction_at >= '] = $dataFrom;
                $wherePurchaseReturn['transaction_at <=  '] = $dataTo;
                
                $whereSaleReturn['transaction_at >='] = $dataFrom;
                $whereSaleReturn['transaction_at <='] = $dataTo;
                
                $whereVoucherCollection['sap_at >='] = $dataFrom;
                $whereVoucherCollection['sap_at <='] = $dataTo;
                
                $whereRetailCollection['date >='] = $dataFrom;
                $whereRetailCollection['date <='] = $dataTo;
                
                $whereInstallmentCollection['partytransaction.transaction_at >='] = $dataFrom;
                $whereInstallmentCollection['partytransaction.transaction_at <='] = $dataTo;
                
                $whereTransactionCollection['partytransaction.transaction_at >='] = $dataFrom;
                $whereTransactionCollection['partytransaction.transaction_at <='] = $dataTo;
                
                
                $whereSupplierPayment['transaction_at >='] = $dataFrom;
                $whereSupplierPayment['transaction_at <='] = $dataTo;
                
                $whereRemark['transaction_at >='] = $dataFrom;
                $whereRemark['transaction_at <='] = $dataTo;
                
                $whereIncome['date >='] = $dataFrom;
                $whereIncome['date <='] = $dataTo;
                
                $whereCost['date >='] = $dataFrom;
                $whereCost['date <='] = $dataTo;
                
                $whereComission['sap_at >='] = $dataFrom;
                $whereComission['sap_at <='] = $dataTo;
                
                $whereCashInHand['date >='] = $dataFrom;
                $whereCashInHand['date <='] = $dataTo;
                
                $whereFixedAssate['date >='] = $dataFrom;
                $whereFixedAssate['date <='] = $dataTo;
                
            }
            
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $whereSale['godown_code']                  = $_POST['godown_code'];
                    $whereSale['godown_code !=']           = '';
            
                    
                    $wherePurchase['godown_code']              = $_POST['godown_code'];
                    $wherePurchase['godown_code !=']           = '';
                  
                    
                    $wherePurchaseReturn['godown_code']        = $_POST['godown_code'];
                    $wherePurchaseReturn['godown_code !=']           = '';
                    
                    
                    $whereSaleReturn['godown_code']            = $_POST['godown_code'];
                    $whereSaleReturn['godown_code !=']           = '';
                   
                    
                    $whereVoucherCollection['godown_code']     = $_POST['godown_code'];
                    $whereVoucherCollection['godown_code !=']           = '';
                    
                    
                    $whereRetailCollection['godown_code']      = $_POST['godown_code'];
                    $whereRetailCollection['godown_code !=']           = '';
                    
                    
                    $whereInstallmentCollection['partytransaction.godown_code'] = $_POST['godown_code'];
                    $whereInstallmentCollection['partytransaction.godown_code !=']           = '';
                    
                    
                    $whereTransactionCollection['partytransaction.godown_code'] = $_POST['godown_code'];
                    $whereTransactionCollection['partytransaction.godown_code !=']           = '';
                   
                    
                    $whereSupplierPayment['godown_code'] = $_POST['godown_code'];
                    $whereSupplierPayment['godown_code !=']           = '';
                    
                    
                    
                    $whereRemark['godown_code'] = $_POST['godown_code'];
                    $whereRemark['godown_code !=']           = '';
                    
                    
                    $whereCost['godown_code'] = $_POST['godown_code'];
                    $whereCost['godown_code !=']           = '';
                    
                    $whereIncome['godown_code'] = $_POST['godown_code'];
                    $whereIncome['godown_code !=']           = '';
                    
                    $whereComission['godown_code'] = $_POST['godown_code'];
                    $whereComission['godown_code !=']           = '';
                    
                    $whereStock['godown_code'] = $_POST['godown_code'];
                    $whereStock['godown_code !=']           = '';
                    
                    
                    $whereBank['godown_code'] = $_POST['godown_code'];
                    $whereBank['godown_code !=']           = '';
                    
                    
                    $whereCashInHand['godown_code'] = $_POST['godown_code'];
                    $whereCashInHand['godown_code !=']           = '';
                    
                    $where_client['godown_code'] = $_POST['godown_code'];
                    $where_client['godown_code !=']           = '';
                    
                    
                    
                    $where_purchase_invoice['godown_code'] = $_POST['godown_code'];
                    $where_purchase_invoice['godown_code !=']    = '';
                    
                    $where_sale_invoice['godown_code'] = $_POST['godown_code'];
                    $where_sale_invoice['godown_code !=']    = '';
                    
                    $whereFixedAssate['godown_code'] = $_POST['godown_code'];
                    $whereFixedAssate['godown_code !=']    = '';
                    
                    
                }
            }
           
        }else{
            
                 $whereSale['godown_code']              = $this->data['branch'];
                 $whereSale['godown_code !=']           = '';
                 
                 
                 $wherePurchase['godown_code']          = $this->data['branch'];
                 $wherePurchase['godown_code !=']           = '';
                 
                 
                 $wherePurchaseReturn['godown_code']    = $this->data['branch'];
                 $wherePurchaseReturn['godown_code !=']           = '';
                 
                  
                 $whereSaleReturn['godown_code']        = $this->data['branch'];
                 $whereSaleReturn['godown_code !=']           = '';
                
                  
                 $whereVoucherCollection['godown_code'] = $this->data['branch'];
                 $whereVoucherCollection['godown_code !=']           = '';
                 
                  
                 $whereRetailCollection['godown_code']  = $this->data['branch'];
                 $whereRetailCollection['godown_code !=']           = '';
                 
                 $whereInstallmentCollection['partytransaction.godown_code']  = $this->data['branch'];
                 $whereInstallmentCollection['partytransaction.godown_code !=']           = '';
                 
                 
                 $whereTransactionCollection['partytransaction.godown_code']  = $this->data['branch'];
                 $whereTransactionCollection['partytransaction.godown_code !=']           = '';
                 
                 
                 $whereSupplierPayment['godown_code']  = $this->data['branch'];
                 $whereSupplierPayment['godown_code !=']           = '';
                
                 
                 
                 $whereRemark['godown_code']  = $this->data['branch'];
                 $whereRemark['godown_code !=']           = '';
                 
                 
                 $whereCost['godown_code']  = $this->data['branch'];
                 $whereCost['godown_code !=']           = '';
                 
                 $whereIncome['godown_code']  = $this->data['branch'];
                 $whereIncome['godown_code !=']           = '';
                 
                 $whereComission['godown_code']  = $this->data['branch'];
                 $whereComission['godown_code !=']           = '';
                 
                 $whereStock['godown_code']  = $this->data['branch'];
                 $whereStock['godown_code !=']           = '';
                 
                 $whereBank['godown_code']  = $this->data['branch'];
                 $whereBank['godown_code !=']           = '';
                 
                 $whereCashInHand['godown_code']  = $this->data['branch'];
                 $whereCashInHand['godown_code !=']           = '';
                 
                 
                 $where_client['godown_code']  = $this->data['branch'];
                 $where_client['godown_code !=']           = '';
                 
                 $where_purchase_invoice['godown_code']  = $this->data['branch'];
                 $where_purchase_invoice['godown_code !=']           = '';
                 
                 $where_sale_invoice['godown_code']  = $this->data['branch'];
                 $where_sale_invoice['godown_code !=']           = '';
                 
                 $whereFixedAssate['godown_code']  = $this->data['branch'];
                 $whereFixedAssate['godown_code !=']           = '';
                 
                 
                  
        }
        
        
       // Total Sale 
        $whereSale['status']                          = 'sale';
        $whereSale['trash']                           = 0;
        $this->data['total_sale']                     = get_sum('saprecords','total_bill',$whereSale);
       
       
        // Total Purchase 
        $wherePurchase['status']                      = 'purchase';
        $wherePurchase['trash']                       = 0;
        $this->data['total_purchase']                 = get_sum('saprecords','total_bill',$wherePurchase);
        
        
        // Total Sale  Return
        $whereSaleReturn['remark']                    = 'saleReturn';
        $whereSaleReturn['trash']                     = 0;
        $this->data['total_sale_return']              = get_sum('partytransaction','credit',$whereSaleReturn);
        
        
        // Total Purchase Return
        $wherePurchaseReturn['remark']                = 'purchase return';
        $wherePurchaseReturn['trash']                 = 0;
        $this->data['total_purchase_return']          = get_sum('partytransaction','debit',$wherePurchaseReturn);
       
       
       
       // Total Sale Collection
        $whereVoucherCollection['status']             = 'sale';
        $whereVoucherCollection['trash']              = 0;
        $this->data['total_voucher_collection']       = get_sum('saprecords','paid',$whereVoucherCollection);
       
       
       // Total Retail Collection
        $this->data['total_retail_collection']        = $this->action->read_sum('due_collect','paid',$whereRetailCollection);
        
       
       // Total Installment Collection
        $whereInstallmentCollection['partytransaction.remark']         = 'installment';
        $whereInstallmentCollection['partytransaction.transaction_by'] = 'client';
        $whereInstallmentCollection['partytransaction.trash']          = 0;
        //$this->data['total_installment_collection']   = get_sum('partytransaction','credit',$whereInstallmentCollection);
       
       
        $select= ['sum(credit) as total_installment'];
        $this->data['total_installment_collection'] = get_join('partytransaction', 'parties', 'parties.code=partytransaction.party_code',  $whereInstallmentCollection, $select, 'partytransaction.trash', 'partytransaction.id', 'desc');
       
       
       
        
        // Total Transaction Collection
        //$whereTransactionCollection['partytransaction.remark']         = 'transaction';
        $whereTransactionCollection['partytransaction.transaction_by'] = 'client';
        $whereTransactionCollection['partytransaction.trash']          = 0;
        //$this->data['total_transaction_collection']   = get_sum('partytransaction','credit',$whereTransactionCollection);
        $select= ['sum(credit) as total_transaction'];
        $this->data['total_transaction_collection'] = get_join('partytransaction', 'parties', 'parties.code=partytransaction.party_code',  $whereTransactionCollection, $select, 'partytransaction.trash', 'partytransaction.id', 'desc');
        
        
        
        // Total supplier Payment
        $whereSupplierPayment['remark']         = 'transaction';
        $whereSupplierPayment['transaction_by'] = 'supplier';
        $whereSupplierPayment['trash']          = 0;
        $this->data['total_supplier_payment']   = get_sum('partytransaction','debit',$whereSupplierPayment);
        
        
        // Total supplier Payment
        $whereRemark['remark']         = 'transaction';
        $whereRemark['transaction_by'] = 'client';
        $whereRemark['trash']          = 0;
        $this->data['total_remission']   = get_sum('partytransaction','remission',$whereRemark);
        
        
        // Total General Income
        $whereIncome['trash']          = 0;
        $this->data['total_income']   = get_sum('income','amount',$whereIncome);
        
       
         // Total General Cost
        $whereCost['trash']          = 0;
        $this->data['total_cost']   = get_sum('cost','amount',$whereCost);
        
        
        // Total Comission 
        $whereComission['status']                          = 'sale';
        $whereComission['trash']                           = 0;
        $this->data['total_comission']                     = get_sum('sapitems','discount',$whereComission);
        
        
        // Total Comission 
        $whereComission['status']                          = 'sale';
        $whereComission['trash']                           = 0;
        $this->data['total_comission']                     = get_sum('sapitems','discount',$whereComission);
        
        
        
        //Stock Value
        $stock_value   =    $this->action->read('stock',$whereStock);
        $total_stock_value = 0;
        if(!empty($stock_value)){
            foreach($stock_value as $val){
                 $total_stock_value += $val->purchase_price*$val->quantity;
            }
        }
        $this->data['total_stock_value'] = $total_stock_value;
        
        
        
        //total bank balance
    
            $totalBalance = 0.00;
            $all_account = $this->action->read('bank_account');
            foreach($all_account as $key=>$account){
    
                $where = array(
                "bank"              =>  $account->bank_name,
                "account_number"    =>  $account->account_number
                );
    
                $transaction = $this->retrieve->read("transaction",$where);
    
                $credits = $debits = $balance = 0;
    
                foreach ($transaction as $val) {
                if ($val->transaction_type=="Credit") {
                    $credits += $val->amount;
                }else{
                    $debits += $val->amount;
                }
                $balance = $credits - $debits;
            }
           
            $totalBalance += ($account->pre_balance + $balance); 
        }
                   
        $this->data['total_bank_balance'] = $totalBalance;
        
        
        
        //cash  in hand
        if(!empty($_POST['godown_code']) && ($_POST['godown_code'] == 'all')){
            $total_cash_in_hand = 0;
            $all_godown = $this->action->read('godowns',array('trash' => 0));
            if(!empty($all_godown)){
                foreach($all_godown as $val){
                    $godown_code = $val->code;
                    $cash_in_hand = $this->action->readOrderBy('opening_balance','date',array('godown_code' => $godown_code),'desc');
                    if(!empty($cash_in_hand)){
                        $total_cash_in_hand += $cash_in_hand[0]->closing_balance;
                    }
                }
            }
            $this->data['total_cash_in_hand'] = $total_cash_in_hand;
        }else{
            $cash_in_hand = $this->action->readOrderBy('opening_balance','date',$whereCashInHand,'desc');
            if(!empty($cash_in_hand)){
                 $this->data['total_cash_in_hand'] = $cash_in_hand[0]->closing_balance;
            }else{
                 $this->data['total_cash_in_hand'] = 0;
            }
           
        }    


        //calculate sales profit
        
        $calculate_profit_loss = 0;
        $where = ['status' => 'sale', 'trash' => 0];
        if (isset($_POST['show'])) {


            if (!empty($_POST['godown_code'])) {
                if ($_POST['godown_code'] != 'all') {
                    $where['godown_code'] = $_POST['godown_code'];
                }
            } else {
                $where['godown_code'] = $this->data['branch'];
            }
            
            if(!empty($dataFrom) && !empty($dataTo)){
                $where['sap_at >='] =$dataFrom;
                $where['sap_at <='] =$dataTo;
            }
            
          
        } else {
            $where["godown_code"] = $this->data['branch'];
        }

        $result = get_result('saprecords', $where, ['sap_at', 'voucher_no', 'party_code', 'address', 'total_quantity', 'total_bill', 'hire_price', 'total_discount', 'sap_type']);
        $data   = [];
        if (!empty($result)) {
            foreach ($result as $_key => $item) {


                $purchase_price       = custom_query("SELECT SUM(purchase_price * quantity) AS total_purchase_price FROM sapitems WHERE voucher_no='$item->voucher_no' AND status='sale' AND trash=0 GROUP BY voucher_no");
                $total_purchase_price = (!empty($purchase_price) ? $purchase_price[0]->total_purchase_price : 0);

                $data[$_key]['sap_at']     = $item->sap_at;
                $data[$_key]['voucher_no'] = $item->voucher_no;
                $data[$_key]['party_code'] = $item->party_code;

                if ($item->sap_type == 'credit' || $item->sap_type == 'dealer') {
                    $partyInfo              = get_row('parties', ['code' => $item->party_code, 'trash' => 0], ['name', 'address']);
                    $data[$_key]['name']    = (!empty($partyInfo) ? check_null($partyInfo->name) : 'N/A');
                    $data[$_key]['address'] = (!empty($partyInfo) ? check_null($partyInfo->address) : 'N/A');
                } else {
                    $partyInfo              = json_decode($item->address, true);
                    $data[$_key]['name']    = check_null($item->party_code);
                    $data[$_key]['address'] = (!empty($partyInfo) ? check_null($partyInfo['address']) : 'N/A');
                }

                $data[$_key]['total_quantity']       = $item->total_quantity;
                $data[$_key]['total_purchase_price'] = $total_purchase_price;

                if ($item->sap_type == 'credit') {
                    $data[$_key]['total_sale_price'] = $item->hire_price;
                } elseif ($item->sap_type == 'dealer') {
                    $data[$_key]['total_sale_price'] = $item->total_bill;
                } else {
                    $data[$_key]['total_sale_price'] = $item->total_bill;
                }

                $data[$_key]['total_discount'] = $item->total_discount;

                $calculate_profit_loss += $data[$_key]['total_sale_price'] - $data[$_key]['total_purchase_price'];

               
            }
        }

       
        $this->data['calculate_profit_loss'] = $calculate_profit_loss;


        //total client
        $where_client['trash'] = 0;
        $where_client['type'] = 'client';
        $all_client = $this->action->read('parties',$where_client);
        $this->data['total_client'] = count($all_client);
        
        
        //total product
        $where_product['status'] = 'available';
        $all_product = $this->action->read('products',$where_product);
        $this->data['total_product'] = count($all_product);        
        
         //total purchase invoice
        $where_purchase_invoice['status'] = 'purchase';
        $where_purchase_invoice['trash'] = 0;
        $all_purchase_invoice = $this->action->read('saprecords',$where_purchase_invoice);
        $this->data['total_purchase_invoice'] = count($all_purchase_invoice);        
        
        
         //total sales invoice
        $where_sale_invoice['status'] = 'sale';
        $where_sale_invoice['trash'] = 0;
        $all_sale_invoice = $this->action->read('saprecords',$where_sale_invoice);
        $this->data['total_sale_invoice'] = count($all_sale_invoice);   
        
        
        
        // Total Fixed Asset 
        $whereFixedAssate['trash']          = 0;
        $this->data['total_fixed_asset_val']   = $this->action->read('fixed_assate',$whereFixedAssate);
        
        
        
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/overall_report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

}
