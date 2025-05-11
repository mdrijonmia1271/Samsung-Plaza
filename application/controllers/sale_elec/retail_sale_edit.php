<?php

class Retail_sale_edit extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        
        // brand list
        $this->data['brandList'] = get_result('brand', ['trash' => 0]);
        $this->load->model('action');
    }


    public function index()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu_elec"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;
        $this->data['info']         = null;

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        if (!empty($_GET['vno'])) {
            $this->data['info'] = get_row('saprecords', ['voucher_no' => $_GET['vno']]);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/retail-sale-edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // save data
    public function update()
    {
        if (isset($_POST['update'])) {

            $data = [
                'sap_at'         => $this->input->post('date'),
                'brand'          => $this->input->post('brand'),
                'total_quantity' => $this->input->post('totalqty'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_discount' => $this->input->post('total_discount'),
                'party_balance'  => 0,
                'paid'           => $this->input->post('paid'),
                'due'            => ($_POST['current_sign'] == 'Due' ? $_POST['current_balance'] : 0),
                'promise_date'   => $this->input->post('promise_date'),
                'method'         => $this->input->post('method'),
                'godown_code'    => $this->input->post('godown_code'),
                'comment'        => $this->input->post('comment'),
            ];

            $partyInfo          = json_encode($_POST['partyInfo']);
            $data['address']    = $partyInfo;
            $data['party_code'] = str_replace(" ", "_", $_POST['party_code']);
            $data['due_status'] = ($_POST['current_sign'] == 'Due' ? 'due' : 'paid');

            // save sap records
            save_data('saprecords', $data, ['voucher_no' => $_POST['voucher_no']]);

            // save sap items
            foreach ($_POST['product'] as $key => $value) {

                $itemWhere = $data = [];

                if (empty($_POST['id'][$key])) {

                    $data = [
                        'sap_at'              => $this->input->post('date'),
                        'voucher_no'          => $_POST['voucher_no'],
                        'product_code'        => $_POST['product_code'][$key],
                        'product_model'       => $_POST['product_model'][$key],
                        'product_serial'      => $_POST['product_serial'][$key],
                        'unit'                => $_POST['unit'][$key],
                        'purchase_price'      => $_POST['purchase_price'][$key],
                        'quantity'            => $_POST['quantity'][$key],
                        'sale_price'          => $_POST['sale_price'][$key],
                        'godown_code'         => $_POST['godown_code'],
                        'discount'            => $_POST['discount'][$key],
                        'discount_percentage' => $_POST['discount_percentage'][$key],
                        'sap_type'            => $this->input->post('sap_type'),
                        'status'              => 'sale',
                    ];

                } else {

                    $data = [
                        'sap_at'              => $this->input->post('date'),
                        'product_serial'      => $_POST['product_serial'][$key],
                        'purchase_price'      => $_POST['purchase_price'][$key],
                        'quantity'            => $_POST['quantity'][$key],
                        'sale_price'          => $_POST['sale_price'][$key],
                        'discount'            => $_POST['discount'][$key],
                        'discount_percentage' => $_POST['discount_percentage'][$key],
                    ];

                    $itemWhere['id'] = $_POST['id'][$key];
                }

                if (save_data('sapitems', $data, $itemWhere)) {
                    $this->handelStock($key);
                }
            }

            $this->handelPartyTransaction();
            $this->sapmeta();


            // Sending SMS Start
            if (!empty($_POST['send_sms'])) {
                $this->sendSMS();
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Sale successfully Completed!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
            redirect('sale_elec/retail_sale/invoice?vno=' .$_POST['voucher_no'], 'refresh');

        } else {

            redirect('sale_elec/retail_sale', 'refresh');
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
            redirect('sale_elec/search_sale', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/retail-invoice', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // handel stock
    private function handelStock($index)
    {
        $where                = [];
        $where['code']        = $_POST['product_code'][$index];
        $where['godown_code'] = $_POST['godown_code'];

        // get stock quantity
        $record = get_row('stock', $where, 'quantity');

        if (!empty($record)) {

            // calculate quantity
            $newQuantity = $_POST['quantity'][$index] - $_POST['old_quantity'][$index];

            $quantity    = $record->quantity - $newQuantity;

            // save data
            save_data('stock', ['quantity' => $quantity], $where);
        }
    }


    // save party transaction
    private function handelPartyTransaction()
    {
        $data = [
            'transaction_at'  => $this->input->post('date'),
            'credit'          => $this->input->post('paid'),
            'debit'           => $this->input->post('grand_total'),
            'transaction_via' => $this->input->post('method'),
            'godown_code'     => $this->input->post('godown_code'),
        ];

        $tranWhere = [
            'relation' => 'sales:' . $_POST['voucher_no'],
            'trash'    => 0
        ];

        save_data('partytransaction', $data, $tranWhere);
    }


    // save sap meta info
    private function sapmeta()
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {

                $tranMetaWhere = [
                    'voucher_no' => $_POST['voucher_no'],
                    'meta_key'   => $key,
                ];

                // check exists
                if (check_exists('sapmeta', $tranMetaWhere)) {

                    $data = ['meta_value' => $value];

                } else {

                    $tranMetaWhere = [];

                    $data = [
                        'voucher_no' =>$_POST['voucher_no'],
                        'meta_key'   => $key,
                        'meta_value' => $value
                    ];
                }

                save_data('sapmeta', $data, $tranMetaWhere);

            }
        }

        $metaWhere = [
            'voucher_no' => $_POST['voucher_no'],
            'meta_key'   => 'sale_by',
        ];

        $data = ['meta_value' => $this->data['name']];
        save_data('sapmeta', $data, $metaWhere);
    }


    // send message
    private function sendSMS()
    {
        // make a product and quantity string
        $productArray = array();
        foreach ($_POST['product'] as $key => $value) {
            $productArray[] = $value . "(" . $_POST['quantity'][$key] . " " . $_POST['quantity'][$key] . " )";
        }

        $productStr = implode(', ', $productArray);

        if ($_POST['current_balance'] == 'Due') {
            $content = "নামঃ " . filter($this->input->post('party_code')) . ", বিল নংঃ " .$_POST['voucher_no'] . ", বিল এমাউন্টঃ " . $this->input->post("grand_total") . " Tk, " . ", জমাঃ " . $this->input->post('paid') . " Tk, মোট বাকীঃ " . $this->input->post("current_balance") . " Tk,  তাংঃ " . $this->input->post('date') . " রফিক ইলেকট্রনিক্স.";
        } else {
            $content = "নামঃ " . filter($this->input->post('party_code')) . ", বিল নংঃ " .$_POST['voucher_no'] . ", বিল এমাউন্টঃ " . $this->input->post("grand_total") . " Tk, " . ", জমাঃ " . $this->input->post('paid') . " Tk, মোট বাকীঃ 0 Tk,  তাংঃ " . $this->input->post('date') . " রফিক ইলেকট্রনিক্স.";
        }

        $num = $this->input->post("mobile");
        //$num = '01937476716';
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


    // delete data
    public function delete($vno = null)
    {

        $saleInfo = get_result('sapitems', ['voucher_no' => $vno, 'trash' => 0], ['product_code', 'quantity', 'godown_code']);

        if (!empty($vno)) {

            foreach ($saleInfo as $value) {

                // get stock quantity
                $stockWhere = [
                    "code"        => $value->product_code,
                    "godown_code" => $value->godown_code
                ];

                $stockInfo = get_row('stock', $stockWhere, 'quantity');

                // calculate new quantity
                $quantity = 0;
                if (!empty($stockInfo)) {

                    $quantity = $stockInfo->quantity + $value->quantity;

                    // update the stock
                    save_data('stock', ['quantity' => $quantity], $stockWhere);
                }
            }

            // update data
            $where = ['voucher_no' => $vno];
            $data  = ["trash" => 1];

            save_data('sapitems', $data, $where);
            save_data('saprecords', $data, $where);
            save_data('sapmeta', $data, $where);
            save_data('partytransaction', $data, array("relation" => "sales:" . $vno));

            $msg = [
                'title' => 'delete',
                'emit'  => 'Sale delete successfully!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('sale_elec/search_sale', 'refresh');

    }
}
