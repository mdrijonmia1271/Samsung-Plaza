<?php

/**
 * Working with product sale
 * Methods:
 *   index: handle action to save record into database.
 *   itemWise: fetch product wise sell.
 *   getAllProducts: read all products from stock table.
 *   getAllClients : read all clients from parties table.
 *   getAllGodown : read all godowns.
 *   create: insert record into database.
 *   handelStock: manage stock.
 *   handelPartyTransaction: insert record into database.
 *   sapmeta: insert addiotional info into database.
 *
 **/

class Mobile_sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // brand list
        $this->data['brandList'] = get_result('brand', ['trash' => 0]);
    }

    public function index()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="mobile_sale"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        $this->data['allProducts'] = $this->action->readOrderby('stock', 'name', ['product_serial !=' => ''], 'asc');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/mobile_sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // save data
    public function store()
    {
        if (isset($_POST['save'])) {

            $due = $this->input->post('grand_total') - $this->input->post('paid');

            $data = [
                'sap_at'         => $this->input->post('date'),
                'brand'          => $this->input->post('brand'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_discount' => $this->input->post('total_discount'),
                'party_balance'  => $this->input->post('previous_balance'),
                'paid'           => $this->input->post('paid'),
                'due'            => ($due > 0 ? $due : 0),
                'promise_date'   => $this->input->post('promise_date'),
                'method'         => $this->input->post('method'),
                'godown_code'    => $this->input->post('godown_code'),
                'sap_type'       => $this->input->post('sap_type'),
                'comment'        => $this->input->post('comment'),
                'voucher_type'   => 'mobile',
                'status'         => 'sale',
            ];

            if ($_POST['sap_type'] == 'cash') {
                $partyInfo          = [
                    'mobile'  => $this->input->post('client_mobile'),
                    'address' => $this->input->post('client_address')
                ];
                $data['address']    = json_encode($partyInfo);
                $data['party_code'] = $this->input->post('client_name');
                $data['due_status'] = ($due > 0 ? 'due' : 'paid');
            } else {
                $data['party_code'] = $this->input->post('party_code');
            }

            // save sap records and return insert id
            $id = save_data('saprecords', $data, '', true);

            // generate voucher no
            $vno = get_voucher($id, 6);

            // update voucher no
            save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);

            // save sap items
            foreach ($_POST['product_code'] as $key => $value) {

                $data = [
                    'stock_id'            => $_POST['stock_id'][$key],
                    'sap_at'              => $this->input->post('date'),
                    'voucher_no'          => $vno,
                    'product_code'        => $_POST['product_code'][$key],
                    'product_model'       => $_POST['product_model'][$key],
                    'color'               => $_POST['color'][$key],
                    'product_serial'      => $_POST['product_serial'][$key],
                    'unit'                => $_POST['unit'][$key],
                    'quantity'            => $_POST['quantity'][$key],
                    'purchase_price'      => $_POST['purchase_price'][$key],
                    'sale_price'          => $_POST['sale_price'][$key],
                    'godown_code'         => $_POST['godown_code'],
                    'discount_percentage' => $_POST['discount_percentage'][$key],
                    'discount'            => $_POST['discount'][$key],
                    'sap_type'            => $this->input->post('sap_type'),
                    'status'              => 'sale',
                ];

                save_data('sapitems', $data);

                // update stock
                //echo 'stock_id='.$_POST['stock_id'][$key];
                
                if($_POST['stock_id'][$key] == 'na'){
                    $stockWhere = ['code' => $_POST['product_code'][$key]];
                }else{
                    $stockWhere = ['id' => $_POST['stock_id'][$key]];
                }
              
                
                
                $stockInfo  = get_row('stock', $stockWhere, 'quantity');
                $quantity   = $stockInfo->quantity - $_POST['quantity'][$key];

                save_data('stock', ['quantity' => $quantity], $stockWhere);
            }

            $this->handelPartyTransaction($vno);
            $this->sapmeta($vno);

            // Sending SMS Start
            if (!empty($_POST['send_sms'])) {
                $this->sendSMS($vno);
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Sale successfully Completed.',
                'btn'   => true
            ];

            if ($_POST['sap_type'] == 'cash') {
                $redirect = 'sale/retail_sale/invoice?vno=' . $vno;
            } else {
                $redirect = 'sale/viewDealerSale?vno=' . $vno;
            }

            $this->session->set_flashdata('confirmation', message('success', $msg));
            redirect($redirect, 'refresh');
        } else {
            redirect('sale/retail_sale', 'refresh');
        }
    }

    // show invoice
    public function invoice()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;

        if (!empty($_GET['vno'])) {
            $this->data['info'] = get_row('saprecords', ['voucher_no' => $_GET['vno'], 'status' => 'sale', 'trash' => 0]);
        } else {
            redirect('sale/search_sale', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/retail-invoice', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // save party transaction
    private function handelPartyTransaction($vno)
    {
        $data = [
            'transaction_at'  => $this->input->post('date'),
            'credit'          => $this->input->post('paid'),
            'debit'           => $this->input->post('grand_total'),
            'transaction_via' => $this->input->post('method'),
            'brand'           => $this->input->post('brand'),
            'godown_code'     => $this->input->post('godown_code'),
            'relation'        => 'sales:' . $vno,
            'remark'          => 'sale',
            'status'          => 'sale',
            'serial'          => 1
        ];

        if ($_POST['sap_type'] == 'cash') {
            $data['party_code'] = $this->input->post('client_name');
        } else {
            $data['party_code'] = $this->input->post('party_code');
        }

        save_data('partytransaction', $data);
    }

    // save sap meta info
    private function sapmeta($vno)
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'voucher_no' => $vno,
                    'meta_key'   => $key,
                    'meta_value' => $value
                );
                save_data('sapmeta', $data);
            }
        }
        $data['voucher_no'] = $vno;
        $data['meta_key']   = 'sale_by';
        $data['meta_value'] = $this->data['name'];
        save_data('sapmeta', $data);
    }


    // send message
    private function sendSMS($vno)
    {
        if (isset($_POST['send_sms'])) {

            $name = $mobile = '';
            if ($_POST['sap_type'] == 'cash') {
                $mobile = $this->input->post('client_mobile');
                $name   = $this->input->post('client_name');
            } else {
                $mobile = $this->input->post('party_mobile');
                $name   = $this->input->post('party_name');
            }
            $godownName = 'শুভেচ্ছা :  '. get_name('godowns', 'name', ['code' => $_POST['godown_code']]);

            $date            = $this->input->post('date');
            $previousSign    = $this->input->post('previous_sign');
            $previousBalance = abs($_POST['previous_balance']);
            $currentSign     = $_POST['current_sign'];
            $currentBalance  = abs($_POST['current_balance']);
            
            //$content = 'Dear, ' . $name . ' your previous ' . $previousSign . ' balance ' . $previousBalance . ' Tk, current ' . $currentSign . ' balance ' . $currentBalance . ' Tk. Date: ' . $date . ' Regards ' . $godownName . '.';
            $content = 'নামঃ  ' . $name .", বিল নংঃ ".$vno.', '.$_POST['brand'].',  বিল এমাউন্টঃ ' . $this->input->post('grand_total') .' টাকা,  জমাঃ '
            . $this->input->post('paid') . ' টাকা,  মোট বাকীঃ '. $this->input->post('current_balance') .
            ' টাকা,  তাংঃ ' . $date ." ". $godownName . '।';
            
            $num     = $mobile;
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'    => date('Y-m-d'),
                'delivery_time'    => date('H:i:s'),
                'mobile'           => $num,
                'message'          => $content,
                'total_characters' => strlen($content),
                'total_messages'   => message_length(strlen($content), $message),
                'delivery_report'  => $message
            );

            if ($message) {
                  
                save_data('sms_record', $insert);
                  
                // $another_number = "01303270422";  
                // $message_another = send_sms($another_number, $content);
                
                // if($message_another){      
                       
                //     $insert = array(
                //         'delivery_date'    => date('Y-m-d'),
                //         'delivery_time'    => date('H:i:s'),
                //         'mobile'           => $another_number,  
                //         'message'          => $content,
                //         'total_characters' => strlen($content),
                //         'total_messages'   => message_length(strlen($content), $message_another),
                //         'delivery_report'  => $message_another
                //     );
                    
                //     save_data('sms_record', $insert);
                // }
            }
        }
    }

  
    // delete data
    public function delete($vno = null)
    {
        $vno = $this->input->get('vno');

        $saleInfo = get_result('sapitems', ['voucher_no' => $vno, 'trash' => 0], ['stock_id', 'quantity']);

        if (!empty($saleInfo)) {

            foreach ($saleInfo as $row) {

                // update stock
                $stockWhere = ['id' => $row->stock_id];
                $stockInfo  = get_row('stock', $stockWhere, 'quantity');
                $quantity   = $stockInfo->quantity + $row->quantity;

                save_data('stock', ['quantity' => $quantity], $stockWhere);
            }

            // update data
            $where = ['voucher_no' => $vno];
            $data  = ["trash" => 1];

            save_data('sapitems', $data, $where);
            save_data('saprecords', $data, $where);
            save_data('sapmeta', $data, $where);
            save_data('partytransaction', $data, ["relation" => "sales:" . $vno]);

            $msg = [
                'title' => 'delete',
                'emit'  => 'Sale delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('sale/search_sale', 'refresh');
    }
}
