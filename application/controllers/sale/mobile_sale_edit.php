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

class Mobile_sale_edit extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // brand list
        $this->data['brandList'] = get_result('brand', ['trash' => 0]);
    }

    public function index()
    {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        $this->data['allProducts'] = $this->action->readOrderby('stock', 'name', ['product_serial !=' => ''], 'asc');

        $vno = $this->input->get('vno');

        $this->data['info'] = $info = get_row('saprecords', ['voucher_no' => $vno, 'trash' => 0]);

        if (empty($info)) redirect('sale/search_sale');

        $partyInfo = [
            'code'    => '',
            'name'    => '',
            'mobile'  => '',
            'address' => '',
            'balance' => 0,
            'sign'    => 'Receivable',
        ];

        if ($info->sap_type == 'cash') {

            $cInfo = json_decode($info->address);

            $partyInfo['name']    = $info->party_code;
            $partyInfo['mobile']  = $cInfo->mobile;
            $partyInfo['address'] = $cInfo->address;
        } else {

            $pInfo       = get_row('parties', ['code' => $info->party_code], ['name', 'mobile', 'address']);
            $balanceInfo = (object)get_client_balance($info->party_code, get_name('partytransaction', 'id', ['relation' => 'sales:' . $info->voucher_no]));

            $partyInfo['code']    = $info->party_code;
            $partyInfo['name']    = $pInfo->name;
            $partyInfo['mobile']  = $pInfo->mobile;
            $partyInfo['address'] = $pInfo->address;
            $partyInfo['balance'] = $balanceInfo->balance;
            $partyInfo['sign']    = $balanceInfo->status;
        }

        $this->data['partyInfo'] = (object)$partyInfo;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/mobile_sale_edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // save data
    public function update()
    {
        if (isset($_POST['update'])) {

            $vno = $this->input->post('voucher_no');

            $due = $this->input->post('grand_total') - $this->input->post('paid');

            $data = [
                'sap_at'         => $this->input->post('date'),
                'change_at'      => date('Y-m-d'),
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
            ];

            if ($_POST['sap_type'] == 'cash') {
                $partyInfo          = [
                    'mobile'  => $this->input->post('client_mobile'),
                    'address' => $this->input->post('client_address')
                ];
                $data['address']    = json_encode($partyInfo);
                $data['party_code'] = $this->input->post('client_name');
                $data['due_status'] = ($due > 0 ? 'due' : 'paid');
            }

            // save sap records
            save_data('saprecords', $data, ['voucher_no' => $vno]);


            // save sap items
            foreach ($_POST['product_code'] as $key => $product_code) {

                $where = ['id' => $_POST['item_id'][$key]];

                $data = [
                    'sap_at'              => $this->input->post('date'),
                    'quantity'            => $_POST['quantity'][$key],
                    'purchase_price'      => $_POST['purchase_price'][$key],
                    'sale_price'          => $_POST['sale_price'][$key],
                    'discount_percentage' => $_POST['discount_percentage'][$key],
                    'discount'            => $_POST['discount'][$key],
                ];

                if (empty($_POST['item_id'][$key])) {
                    $where = [];

                    $data['stock_id']       = $_POST['stock_id'][$key];
                    $data['voucher_no']     = $vno;
                    $data['product_code']   = $product_code;
                    $data['product_model']  = $_POST['product_model'][$key];
                    $data['product_serial'] = $_POST['product_serial'][$key];
                    $data['unit']           = $_POST['unit'][$key];
                    $data['color']          = $_POST['color'][$key];
                    $data['godown_code']    = $this->input->post('godown_code');
                    $data['sap_type']       = $this->input->post('sap_type');
                    $data['status']         = 'sale';
                }

                save_data('sapitems', $data, $where);

                // update stock
                $stockWhere = ['id' => $_POST['stock_id'][$key]];
                $stockInfo  = get_row('stock', $stockWhere, 'quantity');
                $quantity   = $stockInfo->quantity - ($_POST['quantity'][$key] - $_POST['old_quantity'][$key]);

                save_data('stock', ['quantity' => $quantity], $stockWhere);
            }

            $this->handelPartyTransaction($vno);
            $this->sapmeta($vno);
            $this->deleteItems();

            // Sending SMS Start
            if (!empty($_POST['send_sms'])) {
                $this->sendSMS();
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Sales update successful.',
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

    // delete voucher item
    private function deleteItems()
    {
        if (!empty($_POST['delete_item_id'])) {
            foreach ($_POST['delete_item_id'] as $key => $id) {

                $stockWhere = ['id' => $_POST['delete_stock_id'][$key]];
                $stockInfo  = get_row('stock', $stockWhere, 'quantity');
                $quantity   = $stockInfo->quantity + $_POST['delete_quantity'][$key];

                save_data('stock', ['quantity' => $quantity], $stockWhere);
                save_data('sapitems', ['trash' => 1], ['id' => $id]);
            }
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
            'change_at'       => date('Y-m-d'),
            'credit'          => $this->input->post('paid'),
            'debit'           => $this->input->post('grand_total'),
            'transaction_via' => $this->input->post('method'),
        ];

        if ($_POST['sap_type'] == 'cash') {
            $data['party_code'] = $this->input->post('client_name');
        }

        save_data('partytransaction', $data, ['relation' => 'sales:' . $vno]);
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
                save_data('sapmeta', $data, ['meta_key' => $key, 'voucher_no' => $vno]);
            }
        }
        $data['voucher_no'] = $vno;
        $data['meta_key']   = 'sale_by';
        $data['meta_value'] = $this->data['name'];
        save_data('sapmeta', $data, ['meta_key' => 'sale_by', 'voucher_no' => $vno]);
    }


    // send message
    private function sendSMS()
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
            $godownName = get_name('godowns', 'name', ['code' => $_POST['godown_code']]);

            $date            = $this->input->post('date');
            $previousSign    = $this->input->post('previous_sign');
            $previousBalance = abs($_POST['previous_balance']);
            $currentSign     = $_POST['current_sign'];
            $currentBalance  = abs($_POST['current_balance']);

            $content = 'Dear, ' . $name . ' your previous ' . $previousSign . ' balance ' . $previousBalance . ' Tk, current ' . $currentSign . ' balance ' . $currentBalance . ' Tk. Date: ' . $date . ' Regards ' . $godownName . '.';

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
