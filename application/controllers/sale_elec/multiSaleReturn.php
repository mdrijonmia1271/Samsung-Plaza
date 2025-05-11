<?php

class MultiSaleReturn extends Admin_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('action');
    }
    /**
       * Return Multiple Product at one time.
       * Table: Stock
       * Strategy:
       *     Update quantity or Insert row.
       * Update:
       *     Update quantity by product_code godownwise.
       * Insert:
       *     Insert new row godownwise.
       **/
    public function index(){
        $this->data['meta_title']   = 'Sale Retun';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="return"';
        $this->data['confirmation'] = null;
        
        $this->data['allClients']   = $this->getAllClient();
        
        $this->data['allproducts']  = $this->action->read('products', array());
        
        $this->data['invoice']      = generate_voucher('sale_return');
        
        // get all godowns
        $this->data['allGodowns']   = getAllGodown();
        
        
        if(isset($_POST['return'])){
            
            foreach ($_POST['product_code'] as $key => $value) {

                $data = array(
                    'product_code'          => $value,
                    'date'                  => $this->input->post('date'),
                    'voucher_no'            => $this->data['invoice'],
                    'client_code'           => $this->input->post('code'),
                    'previous_balance'      => $this->input->post('previous_balance'),
                    'current_balance'       => $this->input->post('current_balance'),
                    'product_model'         => $_POST['product_model'][$key],
                    'quantity'              => $_POST['quantity'][$key],
                    'product_price'         => $_POST['return_price'][$key],
                    'return_price'          => $_POST['product_total'][$key],
                    'totalQty'              => $this->input->post('totalQty'),
                    'total_return'          => $this->input->post('total'),
                    'return_amount'         => $this->input->post('paid'),
                    'godown_code'           => $_POST['godown'],
                    'return_type'           => 'product_wise',
                    'comment'               => $_POST['comment'],
                    'balance_type'          => $this->input->post('current_sign')
                );
                
                $this->action->add('sale_return', $data);
                
                // send data for handling stock
                $product_code = $_POST['product_code'][$key];
                $quantity     = $_POST['quantity'][$key];
                $godown_code  = $_POST['godown'];
                $this->handleStock($product_code, $quantity, $godown_code);
            }
            
            
            // Handling Party Transaction Start ------------------------------->
            // fetch last insert record and increase by 1.
            $where = array('party_code' => $this->input->post('code'));
            $last_sl = $this->action->read_limit('partytransaction', $where, 'desc', 1);
            $voucher_sl = ($last_sl)? ($last_sl[0]->serial+1) : 1;
            
            $data = array(
                'transaction_at'    => $this->input->post('date'),
                'party_code'        => $this->input->post('code'),
                'godown_code'       => $_POST['godown'],
                'credit'            => $this->input->post('total'),
                'debit'             => $this->input->post('paid'),
                'relation'          => 'salesReturn:'.$this->data['invoice'],
                'remark'            => 'saleReturn',
                'serial'            => $voucher_sl
            );
            $this->action->add('partytransaction', $data);
            // Handling Party Transaction Start ------------------------------->
            
            
            
            //Sending SMS Start
            
           // $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';

            //$content = "Thanks for purchasing, you have purchase " . $productStr . " and paid " . $this->input->post("paid") . " Tk in " . $this->input->post("method") . " and your current balance is " . $this->input->post("current_balance") . " Tk " . $sign . " Regards, Director RAFIQ ELECTRONICS.";
            $customer_name = get_row('parties', ['code'=>$this->input->post('code')], ['name']);

            $smr = $this->action->read('smr');
            // ($smr ? $smr[0]->sms_regards : '')

            $content = "নামঃ ".filter($customer_name->name). ", বিল নংঃ ".$this->data['invoice']. ", ফেরত বিল এমাউন্ট " . $this->input->post("total") . " Tk, " . ", গ্রহণ : ". $this->input->post('paid')." Tk, পূর্বের ব্যালেন্স : ".$this->input->post("previous_balance")." Tk, বর্তমান ব্যালেন্স : " . $this->input->post("current_balance") . " Tk,  তাংঃ ".$this->input->post('date').($smr ? $smr[0]->sms_regards : '');

            $num = $this->input->post("mobile");
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'     => date('Y-m-d'),
                'delivery_time'     => date('H:i:s'),
                'mobile'            => $num,
                'message'           => $content,
                'total_characters'  => strlen($content),
                'total_messages'    => message_length(strlen($content),$message),
                'delivery_report'   => $message
            );

           
           $this->action->add('sms_record', $insert);
          //Sending SMS End
            
            
            $options = array(
                'title' => 'success',
                'emit'  => 'Product successfully Return!',
                'btn'   => true
            );
            
            $this->session->set_flashdata('confirmation', message('success', $options));
            redirect('sale/multiSaleReturn/all', 'refresh');
        }
        
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/multi-sale-return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
        
    }
    
 
    // all available products
    private function getAllProduct(){
        
        if(!checkAuth('super')){
            $productWhere['godown_code'] = $this->data['branch'];
        }else{
            $productWhere = [];
        }
        
        $products = $this->action->read("stock", $productWhere);

        return $products;
    }
    
    
    // all clients
    private function getAllClient() {
        $where = array(
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        );
        
        if(!checkAuth('super')){
            $where['godown_code'] = $this->data['branch'];
        }

        $result = $this->action->read('parties', $where);

        return $result;
    }
    
    
    private function handleStock($product_code, $quantity, $godown_code) {
        $where = array();
        $where['code']          = $product_code;
        $where['godown_code']   = $godown_code;
        
        // get the product stock
        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = $record[0]->quantity + $quantity;

        $data = array('quantity' => $quantity);
        $this->action->update('stock', $data, $where);
        
        return true;
    }
    
    
    public function all(){
      	$this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="return-all"';
        $this->data['confirmation'] = null;
        
        // get all godowns
        $this->data['allGodowns'] = getAllGodown();
        
        $this->data['allClients'] = $this->getAllClient();
        // get all product model 
        $this->data['product_model'] = get_result('stock', [], ['product_model'], 'product_model'); 
        
        $where['sale_return.trash']         = 0;
        $where['sale_return.return_type']   = 'product_wise';

        if(isset($_POST['show'])) {

	        if(isset($_POST['search'])){
	            foreach($_POST['search'] as $key => $value){
	                if($value != null){
	                    $where[$key] = $value;
	                }
	            }
            }
            if(!empty($_POST['product_model'])){
                $where['product_model'] = $_POST['product_model'];
            }
	        
	        if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }

            if($this->input->post('date') != NULL){
                foreach($_POST['date'] as $key => $value) {
                    if($value != NULL){
                        if($key == "from"){$where["sale_return.date >="] = $value;}
                        if($key == "to"){$where["sale_return.date <="] = $value;}
                    }
                }
            }
        }else{
            $where = array('godown_code'=>$this->data['branch']);
            $where['sale_return.trash']         = 0;
            $where['sale_return.return_type']   = 'product_wise';
        }
        
        
      	$this->data['SaleReturnInfo'] = get_join('sale_return', 'godowns', 'godowns.code=sale_return.godown_code', $where, ['sale_return.*', 'godowns.name as godown_name'], 'voucher_no', 'sale_return.date', 'DESC');
      
     	$this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/all-sale-return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
      
    }
    
    public function view(){
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="multi-return-all"';
        $this->data['confirmation'] = null;
        
        $where = array('voucher_no' => $this->input->get('vno'), 'trash' => 0);
        $this->data['result'] = $this->action->read('sale_return', $where);
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/view-return-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    /**
     * update stock quantity.
     * udpate sale_return table voucher.
     * update partytransaction table.
     * :return : success msg.
     **/
    public function delete(){
        $where = array('voucher_no' => $this->input->get('vno'));
        $data = array('trash' => 1);
        
        // update stock quantity
        $returnInfo = $this->action->read('sale_return', $where);
        foreach($returnInfo as $key => $value){
            
            // read current quantity form stock
            $stockWhere = array('code' => $value->product_code, 'godown_code' => $value->godown_code);
            $stockInfo = $this->action->read('stock', $stockWhere);
            $updateQty = $stockInfo[0]->quantity - $value->quantity;
            
            $this->action->update('stock', array('quantity' => $updateQty) , $stockWhere);
        }
        
        // update sale_return table.
        $this->action->update('sale_return', $data, $where);
        
        // update partytransaction table
        $where = array('relation' => 'salesReturn:'.$this->input->get('vno'));
        $this->action->update('partytransaction', $data, $where);
        
        
        $msg = array(
            'title' => 'Success',
            'emit' => 'Sale Return Successfully Deleted',
            'btn' => true
        );
        
        $confirm = message('danger', $msg);
        $this->session->set_flashdata('confirmation', $confirm);
        redirect('sale/multiSaleReturn/all', 'refresh');
    }
}