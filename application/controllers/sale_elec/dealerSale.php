<?php

/**
* Working with product sale 
* Methods:
*   index: handle action to save record into database.
*   itemWise: fetch product wise sell.
*   getAllProduct: read all products from stock table.
*   getAllClient : read all clients from parties table.
*   getAllGodowns : read all godowns.
*   create: insert record into database.
*   handelStock: manage stock.
*   handelPartyTransaction: insert record into database.
*   sapmeta: insert addiotional info into database.
*
**/
class DealerSale extends Admin_Controller {
 
    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Dealer Sale';
        $this->data['active']       = 'data-target="sale_menu_elec"';
        $this->data['subMenu']      = 'data-target="dealer"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // generate voucher number
        $where = array('status'    => 'sale');
        $this->data['voucher_number'] = generate_voucher('saprecords', $where);
        $this->data['last_voucher'] = $this->action->readSingle('saprecords','voucher_no');

        // get all godowns
        $this->data['allGodowns'] = $this->getAllGodowns();

        if(isset($_POST['save'])) {
        	$this->data['confirmation'] = $this->create();

			// make a product and quantity string
			$productArray = array();
			foreach ($_POST['product'] as $key => $value) {
				$productArray[] = $value . "(" . $_POST['quantity'][$key] ." ". $_POST['quantity'][$key]." )";
			}

			$productStr = implode(', ', $productArray);

            //Sending SMS Start
            if(isset($_POST['send_sms'])){

                $smr = $this->action->read('smr');
                $sign               = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
                $customer_name      = get_row('parties', ['code'=>$this->input->post('code')], ['name']);
                $current_due        = $this->input->post("grand_total") - $this->input->post("paid");
                $smr = $this->action->read('smr');
                $content = "নামঃ ".filter($customer_name->name). ", বিল নংঃ ".$this->data['voucher_no']. ", বিল এমাউন্টঃ " . $this->input->post("grand_total") . " Tk, " . ", জমাঃ ". $this->input->post('paid')." Tk, অবশিষ্ট বাকীঃ ".abs($current_due)." Tk, মোট বাকীঃ " . $this->input->post("current_balance") . " Tk,  তাংঃ ".$this->input->post('date')." ".($smr ? $smr[0]->sms_regards : '');

                $num = $this->input->post("mobile");
                $message = send_sms($num, $content);

                $insert = array(
                    'delivery_date'     => date('Y-m-d'),
                    'delivery_time'     => date('H:i:s'),
                    'mobile'            => $num,
                    'message'           => $content,
                    'godown_code'      => (!empty($_POST['godown_code']) ? $_POST['godown_code'] : $this->data['branch']),
                    'total_characters'  => strlen($content),
                    'total_messages'    => message_length(strlen($content),$message),
                    'delivery_report'   => $message
                );

                if($message){
                    $this->action->add('sms_record', $insert);
                    $this->data['confirmation'] = message('success', array());
                } else {
                    $this->data['confirmation'] = message('warning', array());
                }

            }
            //Sending SMS End
            
        	redirect('sale_elec/viewDealerSale?vno=' . $this->data['voucher_no'], 'refresh');
        }

        $this->data['allProducts'] = $this->getAllProduct();
        $this->data['allClients']  = $this->getAllClient();
        $this->data['allUnit']     = config_item('unit');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/dealer-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function itemWise() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="wise"';
        $this->data['confirmation'] = null;
        $this->data['result'] = null;
        
        //read all products
        $this->data['products'] = $this->action->read('stock');
            
        if(isset($_POST['show'])){ 
            $where = array();
            $where["product_code"] = $_POST['product_code'];
            $where["status"] ="sale";
            $where["trash"] = 0;

            $this->data['result'] = $this->action->read("sapitems", $where);

            $cond = array('product_code' => $_POST['product_code']); 
            $this->data['productInfo'] = $this->action->read('products', $cond);           
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/itemWise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    

    // all available products
    private function getAllProduct(){
        $where = array('quantity >'  => 0 );
        if(!checkAuth('super')) {
            $where['godown_code'] = $this->data['branch'];
        }
        $products = $this->action->read("stock", $where);

        return $products;
    }


    // all active clients
    private function getAllClient() {
        $where = array(
            'type'   => 'client',
            'status' => 'active',
            'customer_type' => 'dealer',
            'trash'  => 0
        );
        
        if(!checkAuth('super')) {
            $where['godown_code'] = $this->data['branch'];
        }
        
        $result = get_result('parties', $where, ['code', 'name', 'mobile']);
        return $result;
    }


    private function getAllGodowns(){
        $godowns = $this->action->read("godowns");
        return $godowns;
    }


    private function create() {
        
        // insert bill record
        if($this->input->post("current_sign") == "Receivable") {
            $balance = 0 + $this->input->post('current_balance');
        } else {
            $balance = 0 - $this->input->post('current_balance');
        }

        $due = $this->input->post('grand_total') - $this->input->post('paid');

        $data = array(
            'sap_at'            => $this->input->post('date'),
            'party_code'        => $this->input->post('code'),
            'total_quantity'    => $this->input->post('totalqty'),
            'total_bill'        => $this->input->post('grand_total'),
            'total_discount'    => $this->input->post('total_commission'),
            'godown_code'       => $this->input->post('godown_code'),
            'party_balance'     => $balance,
            'paid'              => $this->input->post('paid'),
            'due'               => $due,
            'promise_date'      => $this->input->post('promise_date'),
            'method'            => $this->input->post('method'),
            'comment'           => $this->input->post('comment'),
            'status'            => 'sale',
            'sap_type'          => $this->input->post('stype'),
        );

        if($this->input->post('stype') == "cash"){
          $address = json_encode(array("mobile" => $_POST['mobile_number'], "address" => $_POST['details_address']));
          $data['address'] = $address;
          $data['party_code'] = str_replace(" ","_",$_POST['name']);
        }

        $lastId = $this->action->addAndGetId('saprecords', $data);
        $this->data['voucher_no'] = date("y").date("m").date('d').str_pad($lastId,"3",0,STR_PAD_LEFT );
        
        //update saprecords table by created voucher number
        $data = array('voucher_no' => $this->data['voucher_no']);
        $where = array('id' => $lastId);
        $status = $this->action->update('saprecords',$data,$where);
        
        
        //insert sale record to due_collection table for further due management
        if($this->input->post('stype') == "cash"){
            $data = array(
                'date'          => $this->input->post('date'),
                'godown_code'   => $this->input->post('godown_code'),
                'voucher_no'    => $this->data['voucher_no'],
                'party_code'    => str_replace(" ","_",$_POST['name']),
                'total_bill'    => $this->input->post('grand_total')
            );
            
            $this->action->add('due_collect',$data);
        }
        
        
        // insert sale record
        foreach ($_POST['product'] as $key => $value) {
            $data = array(
                'sap_at'             => $this->input->post('date'),
                'voucher_no'         => $this->data['voucher_no'],
                'product_code'       => $_POST['product_code'][$key],
                'product_model'      => $_POST['product_model'][$key],
                'product_serial'     => $_POST['product_serial'][$key],
                'purchase_price'     => $_POST['purchase_price'][$key],
                'sale_price'         => $_POST['sale_price'][$key],
                'quantity'           => $_POST['quantity'][$key],
                'discount'           => $_POST['commission'][$key],
                'discount_percentage'=> $_POST['percentage'][$key],
                'flat_discount'      =>  $_POST['flat_discount'][$key],
                'godown_code'        => $_POST['godown_code'],
                'unit'               => $_POST['unit'][$key],
                'status'             => 'sale',
                'sap_type'           => $this->input->post('stype')
            );

            if($this->action->add('sapitems', $data)){
                $this->handelStock($key);
            }
        }

        $this->handelPartyTransaction();
        $this->sapmeta();
        
        
        $options = array(
            'title' => 'success',
            'emit'  => 'Sale successfully Completed!',
            'btn'   => true
        );

        return message($status, $options);
    }


    private function handelStock($index) {
        $where = array();
        $where['code']   = $_POST['product_code'][$index];
        $where['godown_code']   = $_POST['godown_code'];
        
        // get the product stock
        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = ($record) ? $record[0]->quantity - $_POST['quantity'][$index] : 0;

        $data = array('quantity' => $quantity);
        $this->action->update('stock', $data, $where);
    }


    /**
    * Table : partytransaction
    * Strategy : 
    *    set sale grandtotal amount to debit column.
    *    set paid amount to credit column.
    *    increase transactional record by 1.
    **/
    private function handelPartyTransaction(){
        
        // fetch last insert record and increase by 1.
        $where = array('party_code' => $this->input->post('code'));
        $last_sl = $this->action->read_limit('partytransaction',$where,'desc',1);
        $voucher_sl = ($last_sl)? ($last_sl[0]->serial+1) : 1;
        
        $data = array(
            'transaction_at'    => $this->input->post('date'),
            'party_code'        => $this->input->post('code'),
            'credit'            => $this->input->post('paid'),
            'debit'             => $this->input->post('grand_total'),
            'godown_code'       => $this->input->post('godown_code'),
            'transaction_via'   => $this->input->post('method'),
            'relation'          => 'sales:' . $this->data['voucher_no'],
            'remark'            => 'sale',
            'serial'            => $voucher_sl
        );
        
        $this->action->add('partytransaction', $data);
        return true;
    }

    /**
    * Table : sapmeta
    * Strategy:
    *   insert additional sale voucher info into database by key => value pair technique.
    *
    **/
    private function sapmeta() {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'voucher_no'    => $this->data['voucher_no'],
                    'meta_key'      => $key,
                    'meta_value'    => $value
                );
                 $this->action->add('sapmeta', $data);
            }
        }
        $data['voucher_no'] = $this->data['voucher_no'];
        $data['meta_key']   = 'sale_by';
        $data['meta_value'] = $this->data['name'];
        $this->action->add('sapmeta', $data);
    }
    
    /**
     * Delete Special Sale info.
     * :Description:
     *     Update table: sapitems, saprecords, partytransaction, stock quantity, installment.
     **/
    public function delete(){
        $where = array('voucher_no' => $this->input->get('vno'));
        $data  = array('trash' => 1);
        
        // read all products from sapitems.
        $saleitems = $this->action->read('sapitems', $where);
        
        // update stock quantity..
        if(!empty($saleitems)){
            foreach($saleitems as $value) {
                $stockwhere = array(
                    'code'        => $value->product_code,
                    'godown_code' => $value->godown_code
                );
                $stockInfo = $this->action->read('stock', $stockwhere);
                
                // update quantity
                $updateQty = $stockInfo[0]->quantity + $value->quantity;
                
                $this->action->update('stock', array('quantity' => $updateQty), $stockwhere);
            }
        }
       
        // update sapitems table
        $this->action->update('sapitems', $data, $where);
        
        // update saprecords table
        $this->action->update('saprecords', $data, $where);
        
        // update installment table
        //$this->action->update('installment', $data, $where);
        
        // update partytransaction table
        $transactionWhere = array('relation' => 'sales:'.$this->input->get('vno'));
        $this->action->update('partytransaction', $data, $transactionWhere);
        
        
        // success msg.
        $msg = array(
            'title' => 'Success',
            'emit' => 'Sale Successfully Deleted',
            'btn' => true
        );
        
        $confirm = message('danger', $msg);
        $this->session->set_flashdata('confirmation', $confirm);
        redirect('sale_elec/search_sale', 'refresh');
    }
    
}
