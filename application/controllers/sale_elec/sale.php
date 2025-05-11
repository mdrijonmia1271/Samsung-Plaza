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
class Sale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu_elec"';
        $this->data['subMenu']      = 'data-target="add-new"';
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
            /*
            $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
            $content = "Thanks for purchasing, you have purchase " . $productStr . " and paid " . $this->input->post("paid") . " Tk in " . $this->input->post("method") . " and your current balance is " . $this->input->post("current_balance") . " Tk " . $sign . "Regards, Director Shirin Enterprise.";

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

            if($message){
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }
            */
            //Sending SMS End
            
        	redirect('sale/viewSale?vno=' . $this->data['voucher_no'], 'refresh');
        }

        $this->data['allProducts'] = $this->getAllProduct();
        $this->data['allClients']  = $this->getAllClient();
        $this->data['allUnit']     = config_item('unit');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/add-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function itemWise(){
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu_elec"';
        $this->data['subMenu']      = 'data-target="wise"';
        $this->data['confirmation'] = null;
        $this->data['result'] = null;
        
        
        // get all godowns
        $this->data['allGodowns'] = getAllGodown();
        
        //read all products
         if(!checkAuth('super')) {
            $stockWhere['godown_code'] = $this->data['branch'];
        }else{
            $stockWhere = [];
        }
        $this->data['products'] = get_result('stock', $stockWhere, ['code', 'name','product_model']);
        
        
        // show all data in product wise
        if(isset($_POST['show'])){ 
            $where["sapitems.product_code"] = $_POST['product_code'];
            $where["sapitems.status"] ="sale";
            $where["sapitems.trash"] = 0;
            
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['sapitems.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['sapitems.godown_code'] = $this->data['branch'];
            }
            
            if(!empty($_POST['sale_type'])){
                    $where['sapitems.sap_type'] = $_POST['sale_type'];
            }
            

            $this->data['result'] = get_join("sapitems", 'godowns', 'godowns.code=sapitems.godown_code', $where, ['sapitems.*', 'godowns.name as godown_name']);

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
        if(!checkAuth('super')){
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
            'trash'  => 0
        );
        
        if(!checkAuth('super')){
            $where['godown_code'] = $this->data['branch'];
        }
        
        $result = $this->action->read('parties', $where);
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
            //'voucher_no'        => $this->input->post('voucher_number'),
            'party_code'        => $this->input->post('code'),
            'total_quantity'    => $this->input->post('totalqty'),
            'total_bill'        => $this->input->post('grand_total'),
            'total_discount'    => $this->input->post('total_discount'),
            'party_balance'     => $balance,
            'paid'              => $this->input->post('paid'),
            'due'               => $due,
            'promise_date'      => $this->input->post('promise_date'),
            'method'            => $this->input->post('method'),
            'status'            => 'sale',
            'sap_type'          => $this->input->post('stype')
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
                'voucher_no'    => $this->data['voucher_no'],
                'party_code'    => str_replace(" ","_",$_POST['name']),
                'total_bill'    => $this->input->post('grand_total'),
                //'previous_paid' => $this->input->post('previous_paid'),
                //'paid'          => $this->input->post('paid'),
                //'due'           => $this->input->post('due'),
               // 'remission'     => $this->input->post('remission')
            );
            
            $this->action->add('due_collect',$data);
        }
        
        
        // insert sale record
        foreach ($_POST['product'] as $key => $value) {
            $data = array(
                'sap_at'            => $this->input->post('date'),
                'voucher_no'        => $this->data['voucher_no'],
                'product_code'      => $_POST['product_code'][$key],
                'product_serial'    => $_POST['product_serial'][$key],
                'purchase_price'    => $_POST['purchase_price'][$key],
                'sale_price'        => $_POST['sale_price'][$key],
                'quantity'          => $_POST['quantity'][$key],
		        'unit'      	    => $_POST['unit'][$key],
                'status'            => 'sale',
                'sap_type'          => $this->input->post('stype')
            );

            if($this->action->add('sapitems', $data)){
                $this->handelStock($key);
            }
        }

        $this->handelPartyTransaction();
        $this->sapmeta();
        
        
        
        if(isset($_POST['installment_type'])){
            $this->handleInstallment();   
        }
        
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
        //$where['unit']   = $_POST['unit'][$index];
        $where['product_serial']   = $_POST['product_serial'][$index];
        
        // get the product stock
        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = ($record) ? $record[0]->quantity - $_POST['quantity'][$index] : 0.00;

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
    
    
    
    private function handleInstallment(){
        
        //$due = $this->input->post('grand_total') - $this->input->post('paid');
        
        $data = array(
            'date'               => date('Y-m-d'),
            'voucher_no'         => $this->data['voucher_no'],
            //'voucher_due'        => $due,
            'voucher_due'        => $this->input->post('current_balance'),      // voucher due = client full due balance..
            'installment_type'   => $this->input->post('installment_type'),
            'installment_no'     => $this->input->post('installment_number'),
            'installment_amount' => $this->input->post('installment_amount'), 
            'client_code'        => $this->input->post('code'),
            'installment_date'   => $this->input->post('installment_date'),
        );
        
        $this->action->add('installment', $data);
        
        return true;
        
    }
}
