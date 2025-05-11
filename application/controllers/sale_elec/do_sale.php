<?php

class Do_sale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title'] = 'DO Sale';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="do"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // generate voucher number
        $where = array('status'    => 'sale','sap_type' => 'do');
       // $this->data['voucher_number'] = $this->memo_no('saprecords', $where,"PCPL-");

        if(isset($_POST['save'])) {
        	$this->data['confirmation'] = $this->create();

            //Sending SMS Start
            $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
            $content = "Thanks for purchasing, your have paid ".$this->input->post("paid")."Tk in ".$this->input->post("method")." and your current balance is ".$this->input->post("current_balance")."Tk " . $sign;
            $num = $this->input->post("mobile");
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'     => date('Y-m-d'),
                'delivery_time'     => date('H:i:s'),
                'mobile'            => $num,
                'message'           => $content,
                'total_characters'  => strlen($content),
                'total_messages'    => message_length(strlen($content)),
                'delivery_report'   => $message
            );

            if($message){
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }
            //Sending SMS End

        	redirect('sale/viewSale?vno=' . $this->input->post('voucher_number'), 'refresh');
        }

        // get all category and clients
        $this->data['allCategory'] = $this->getAllCategory();
        $this->data['allClients'] = $this->getAllClients();
        $this->data['allCompany'] = $this->getAllCompany();

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/do-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    // all clients
    private function getAllClients() {
        $where = array(
            'type'   => 'client',
            'ctype'  => 'do',
            'status' => 'active'
        );

        $result = $this->action->read('parties', $where);

        return $result;
    }

    // all company
    private function getAllCompany(){
        $where = array(
            'type'   => 'company',
            'status' => 'active'
        );

        $company = $this->action->read("parties", $where, "code");

        return $company;
    }




    // all category
    private function getAllCategory(){
        $where = array('showroom_id' => $this->data['branch']);
        $category = $this->action->read_distinct('stock', $where, 'category');

        return $category;
    }



    private function create(){
        // insert sale record
        foreach ($_POST['product'] as $key => $value) {
            $data = array(
                'sap_at'            => $this->input->post('date'),
                'voucher_no'        => $this->input->post('voucher_number'),
                'do_no'             => $_POST['do_no'][$key],
                'product_code'      => $_POST['product_code'][$key],
                'brand'             => $_POST['brand'][$key],
                'purchase_price'    => $_POST['purchase_price'][$key],
                'sale_price'        => $_POST['sale_price'][$key],
                'quantity'          => $_POST['quantity'][$key],
				'unit'      		=> $_POST['unit'][$key],
                'godown_code'       => $this->data['branch'],
                'showroom_id'       => $this->data['branch'],
                'status'            => 'sale',
                'sap_type'          => 'do'
            );

            // check the product free or not
            if($_POST['sale_price'][$key] <= 0) {
                $data['remark'] = 'free';
            }

            if($this->action->add('sapitems', $data)){
                $this->handelStock($key);
            }
        }

        // insert bill record
        if($this->input->post("previous_sign") == "Receivable") {
            $balance = 0 - $this->input->post('previous_balance');
        } else {
            $balance = 0 + $this->input->post('previous_balance');
        }

        $data = array(
            'sap_at'            => $this->input->post('date'),
            'voucher_no'        => $this->input->post('voucher_number'),
            'party_code'        => $this->input->post('code'),
            'showroom_code'     => $this->data['branch'],
            'total_bill'        => $this->input->post('grand_total'),
            'total_discount'    => $this->input->post('discount'),
            'party_balance'     => $balance,
            'paid'              => $this->input->post('paid'),
            'method'            => $this->input->post('method'),
            'showroom_id'       => $this->data['branch'],
            'status'            => 'sale',
            'sap_type'          => 'do'
        );

        $status = $this->action->add('saprecords', $data);
        $this->handelPartyBalance($_POST['brand'][0]);
        $this->handelPartyTransaction();
        $this->sapmeta();

        $options = array(
            'title' => 'success',
            'emit'  => 'Product Sale successfully Completed!',
            'btn'   => true
        );

        return message($status, $options);
    }

    private function handelStock($index) {
        $where = array();

        $where['product_code']  = $_POST['product_code'][$index];
        $where['unit']  	= $_POST['unit'][$index];
        $where['godown']        = $this->data['branch'];
        $where['showroom_id']   = $this->data['branch'];
        $where['type']          = 'do';
        $where['do_no']         = $_POST['do_no'][$index];

        // get the product stock
        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = $record[0]->do_out + $_POST['quantity'][$index];
        $data = array("do_out" => $quantity);
        $this->action->update('stock', $data, $where);

    }

    private function handelPartyTransaction() {
        if($this->input->post('previous_sign') == 'Receivable') {
            $previous_balance = 0 - $this->input->post('previous_balance');
        } else {
            $previous_balance = 0 + $this->input->post('previous_balance');
        }

        if($this->input->post('current_sign') == 'Receivable') {
            $current_balance = 0 - $this->input->post('current_balance');
        } else {
            $current_balance = 0 + $this->input->post('current_balance');
        }

        $data = array(
            'transaction_at'    => $this->input->post('date'),
            'party_code'        => $this->input->post('code'),
            'party_brand'        => strtolower(str_replace(" ","-",$_POST['brand'][0])),
            'previous_balance'  => $previous_balance,
            'paid'              => $this->input->post('paid'),
            'current_balance'   => $current_balance,
            'transaction_via'   => $this->input->post('method'),
            'relation'          => 'sales:' . $this->input->post('voucher_number'),
            'remark'            => 'sale',
            'status'             => "receivable"
        );

       $lastInsertedId = $this->action->addAndGetId('partytransaction', $data);
       $this->partyTransactionMeta($lastInsertedId);

        return true;
    }
    
    private function partyTransactionMeta($id) {
        if(isset($_POST['do_meta'])){
            foreach ($_POST['do_meta'] as $key => $value) {
                $data = array(
                    'transaction_id'    => $id,
                    'meta_key'          => $key,
                    'meta_value'        => $value
                );

                $this->action->add('partytransactionmeta', $data);
            }
      }
    }

    private function handelPartyBalance($brand = NULL) {
        $where = array(
		  'code' => $this->input->post('code'),
		  'brand' => strtolower(str_replace(" ","-",$brand))
		);

        if($this->input->post('current_sign') == 'Receivable') {
            $balance = 0 - $this->input->post('current_balance');
        } else {
            $balance = 0 + $this->input->post('current_balance');
        }

        $data = array('balance' => $balance);
        $this->action->update('partybalance', $data, $where);

        return true;
    }

    private function sapmeta() {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'voucher_no'    => $this->input->post('voucher_number'),
                    'meta_key'      => $key,
                    'meta_value'    => $value
                );

                $this->action->add('sapmeta', $data);
            }
        }
    }
    
    
    
    
 // genetate memo no
 private function memo_no($table, $where=array(), $prefix = '') {
    $code = '';
    $counter = 1;
       
    $val = $this->retrieve->readOrderby($table, "id", $where, 'desc');   


    if($val != null){
        $counter = intval($val[0]->id) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='00000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='0000' . $counter;
    }elseif(strlen($counter) == 3) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 4) {
        $counter ='00' . $counter;
    }elseif(strlen($counter) == 5) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = $prefix . date('Y') ."/" .$counter; 
    return $code;
}



}
