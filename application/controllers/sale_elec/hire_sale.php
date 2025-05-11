<?php

/**
* Working with product sale 
* Methods:
*   index: handle action to save record into database.
*   itemWise: fetch product wise sell.
*   getAllProducts: read all products from stock table.
*   getAllClients : read all clients from parties table.
*   getAllGodowns : read all godowns.
*   create: insert record into database.
*   handelStock: manage stock.
*   handelPartyTransaction: insert record into database.
*   sapmeta: insert addiotional info into database.
*
**/  
class Hire_sale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu_elec"';
        $this->data['subMenu']      = 'data-target="hire"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;
        
         // generate voucher number
        $where = array('status'    => 'sale');
        $this->data['voucher_number'] = generate_voucher('saprecords', $where);
        $this->data['last_voucher'] = $this->action->readSingle('saprecords','voucher_no');

         // get all godowns
        $this->data['allGodowns'] = getAllGodown();
          
        if(isset($_POST['save'])) {
        	$this->data['confirmation'] = $this->create();
        	
        	// send sms
        	$this->sendSMS();

        	redirect('sale_elec/viewHireSale?vno=' . $this->data['voucher_no'], 'refresh');
        }

        $this->data['allUnit']     = config_item('unit');
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/hire-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    // insert data 
    private function create() {
        
        // insert bill record
        if($this->input->post("current_sign") == "Receivable") {
            $balance = 0 + $_POST['grand_total'];
        } else {
            $balance = 0 - $_POST['grand_total'];
        }

        $previous_balance = ($_POST['previous_sign'] == "Payable") ? $_POST['previous_balance'] : 0;

        $due = $_POST['hire_price'] - ($_POST['paid'] + $previous_balance);
        $date = date('Y-m-d', strtotime($_POST['date'] . "+30 days"));

        $data = array(
            'sap_at'               => $this->input->post('date'),
            'party_code'           => $this->input->post('code'),
            'total_quantity'       => $this->input->post('totalqty'),
            'total_bill'           => $this->input->post('hire_price'),
            //'total_discount'       => $this->input->post('total_discount'),
            'commission_percentage'=> $this->input->post('commission_per'),
            'installment_type'     => $this->input->post('installment_type'),
            'installment_no'       => $this->input->post('installment_number'),
            'installment_amount'   => $this->input->post('installment_amount'), 
            'installment_date'     => $date, 
            'godown_code'          => $this->input->post('godown_code'),
            'party_balance'        => $balance,
            'paid'                 => $this->input->post('paid'),
            'due'                  => $due,
            'hire_price'           => $this->input->post('hire_price'),
            'promise_date'         => $this->input->post('promise_date'),
            'method'               => $this->input->post('method'),
            'status'               => 'sale',
            'sap_type'             => $this->input->post('stype')
        );

        /* echo '<pre>';
        print_r($data);
        die(); */
        
        
        $lastId = $this->action->addAndGetId('saprecords', $data);
        $this->data['voucher_no'] = date("y").date("m").date('d').str_pad($lastId,"3",0,STR_PAD_LEFT );
        
        // update saprecords table by created voucher number
        $data   = array('voucher_no' => $this->data['voucher_no']);
        $status = $this->action->update('saprecords', $data, ['id' => $lastId]);
        
        
        // insert sale record
        foreach ($_POST['product'] as $key => $value) {
            $data = array(
                'sap_at'              => $this->input->post('date'),
                'voucher_no'          => $this->data['voucher_no'],
                'product_code'        => $_POST['product_code'][$key],
                'unit'                => $_POST['unit'][$key],
                'product_serial'      => $_POST['product_serial'][$key],
                'product_model'       => $_POST['product_model'][$key],
                'quantity'            => $_POST['quantity'][$key],
                'purchase_price'      => $_POST['purchase_price'][$key],
                'sale_price'          => $_POST['sale_price'][$key],
                'godown_code'         => $_POST['godown_code'],
                'status'              => 'sale',
                'sap_type'            => $this->input->post('stype')
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

    
    // calculate and update stock
    private function handelStock($index) {
        $where = array();
        $where['code']           = $_POST['product_code'][$index];
        $where['godown_code']    = $_POST['godown_code'];
        
        // get the product stock
        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = ($record) ? $record[0]->quantity - $_POST['quantity'][$index] : 0.00;

        $data = array('quantity' => $quantity);
        $this->action->update('stock', $data, $where);
    }


    // calculate and insert party transaction
    private function handelPartyTransaction(){
        
        // fetch last insert record and increase by 1.
        $where = array('party_code' => $this->input->post('code'));
        $last_sl = $this->action->read_limit('partytransaction', $where, 'desc', 1);
        $voucher_sl = ($last_sl)? ($last_sl[0]->serial+1) : 1;
        
        $data = array(
            'transaction_at'    => $this->input->post('date'),
            'party_code'        => $this->input->post('code'),
            'credit'            => $this->input->post('paid'),
            'debit'             => $_POST['total'] + $_POST['added_amount'],
            'transaction_via'   => $this->input->post('method'),
            'godown_code'       => $this->input->post('godown_code'),
            'relation'          => 'sales:' . $this->data['voucher_no'],
            'remark'            => 'sale',
            'serial'            => $voucher_sl
        );
        
        $this->action->add('partytransaction', $data);
        return true;
    }


    // insert sapmeta
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
    
    
    // send client sms
    private function sendSMS(){
        
        if(isset($_POST['send_sms'])){

            $productArray = array();
            foreach ($_POST['product'] as $key => $value) {
                $productArray[] = $value . "(" . $_POST['quantity'][$key] ." ". $_POST['quantity'][$key]." )";
            }

            $productStr = implode(', ', $productArray);

            //Sending SMS Start
            
            $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';

            //$content = "Thanks for purchasing, you have purchase " . $productStr . " and paid " . $this->input->post("paid") . " Tk in " . $this->input->post("method") . " and your current balance is " . $this->input->post("current_balance") . " Tk " . $sign . " Regards, Director RAFIQ ELECTRONICS.";
            $customer_name = get_row('parties', ['code'=>$this->input->post('code')], ['name']);

            $smr = $this->action->read('smr');
            // ($smr ? $smr[0]->sms_regards : '')

            $content = "নামঃ ".filter($customer_name->name). ", বিল নংঃ ".$this->data['voucher_no']. ", বিল এমাউন্টঃ " . $this->input->post("hire_price") . " Tk, " . ", জমাঃ  ". $this->input->post('paid')." Tk, অবশিষ্ট বাকীঃ ".$this->input->post("current_balance")." Tk, মোট বাকীঃ " . $this->input->post("grand_total") . " Tk,  তাংঃ ".$this->input->post('date')." ".($smr ? $smr[0]->sms_regards : '');

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
    }
    
}
