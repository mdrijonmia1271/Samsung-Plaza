<?php

/**
 * working with product purchase  section.
 * Methods():
 *   index: Handle purchase entry to database.
 *   create: insert record to database.
 *   handelPartyTransaction: insert transactional record.
 *   sapmeta: add additional info to database.
 *   handelStock: update product stock in database table.
 *   getAllparty: fetch all party.
 *   getAllProduct: fetch all products.
 *   getAllGodowns: fetch all Godowns.
 *   show_purchase: fetch all purchase records from database.
 *   view: preview particular purchase record.
 *   delete_purchase: delete particular purchase record.
 *   itemWise: fetch product wise purchase record.
 *
 **/

class PurchaseMobile extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // get data for all function
        $this->data['colorList']   = get_result('colors', ['trash' => 0]);
        $this->data['godownList']  = getAllGodown();
        $this->data['productList'] = get_result("products", ['status' => 'available','product_cat' => 'mobile','trash' => 0], ['product_code', 'product_name', 'product_model']);

        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    public function index()
    {
        
        $this->data['subMenu'] = 'data-target="add-new-mobile"';

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/add_mobile', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store()
    {
        if (isset($_POST['save'])) {

            // $due = $this->input->post('grand_total') - $this->input->post('paid');
            $grand_total = (float) $this->input->post('grand_total');
            $paid = (float) $this->input->post('paid');
            
            $due = $grand_total - $paid;


            $data = [
                'sap_at'         => $this->input->post('date'),
                'party_code'     => $this->input->post('party_code'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_discount' => $this->input->post('total_discount'),
                'transport_cost' => $this->input->post('transport_cost'),
                'party_balance'  => $this->input->post('previous_balance'),
                'paid'           => $this->input->post('paid'),
                'due'            => ($due > 0 ? $due : 0),
                'method'         => $this->input->post('method'),
                'godown_code'    => $this->input->post('godown_code'),
                'comment'        => $this->input->post('comment'),
                'voucher_type'   => 'mobile',
                'status'         => 'purchase',
            ];
            
            // dd($_POST['color']);
           
            $id  = save_data('saprecords', $data, '', true);
            $vno = get_voucher($id, 6);

            save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);

           
            // insert purchase record
            foreach ($_POST['product'] as $key => $value) {

                $data                       = [];
                $data['sap_at']             = $this->input->post('date');
                $data['voucher_no']         = $vno;
                $data['product_code']       = $_POST['product_code'][$key];
                $data['product_model']      = $_POST['product_model'][$key];
                $data['color']              = $_POST['color'][$key];
                $data['product_serial']     = $_POST['product_serial'][$key];
                $data['quantity']           = $_POST['quantity'][$key];
                $data['unit']               = $_POST['unit'][$key];
                $data['purchase_commission'] = $_POST['commission'][$key];
                $data['purchase_price']     = $_POST['purchase_price'][$key];
                $data['sale_price']         = $_POST['sale_price'][$key];
                $data['godown_code']        = $_POST['godown_code'];
                $data['status']             = 'purchase';
    
                
                $id = save_data('sapitems', $data, '', true);

                // store data
                $imeiList = [];
                $imeiList = explode(',', $_POST['product_serial'][$key]);
                $imeiList = array_filter($imeiList);
                if (!empty($imeiList)) {
                    foreach ($imeiList as $value) {

                        $stockData                   = [];
                        $stockData['item_id']        = $id;
                        $stockData['code']           = $_POST['product_code'][$key];
                        $stockData['name']           = $_POST['product_model'][$key];
                        $stockData['product_model']  = $_POST['product_model'][$key];
                        $stockData['category']       = $_POST['product_cat'][$key];
                        $stockData['subcategory']    = $_POST['product_subcat'][$key];
                        $stockData['brand']          = $_POST['brand'][$key];
                        $stockData['color']          = $_POST['color'][$key];
                        $stockData['product_serial'] = $value;
                        $stockData['quantity']       = 1;
                        $stockData['unit']           = $_POST['unit'][$key];
                        $stockData['purchase_price'] = $_POST['purchase_price'][$key];
                        $stockData['sell_price']     = $_POST['sale_price'][$key];
                        $stockData['godown_code']    = $_POST['godown_code'];
                        
                        save_data('stock', $stockData);
                    }
                }
            }

            $this->handelPartyTransaction($vno);
            $this->sapmeta($vno);

            $msg = [
                'title' => 'success',
                'emit'  => 'Purchase add successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('purchase/purchaseMobile', 'refresh');
    }


    /**
     * store party transaction data
     */
    private function handelPartyTransaction($vno)
    {
        // fetch last insert record and increase by 1.
        $partyCode = $this->input->post('party_code');
        $serialNo  = custom_query("SELECT IFNULL(COUNT(*), 0) AS serial FROM partytransaction WHERE party_code='$partyCode' AND trash=0", true)->serial;
        $serialNo  = (!empty($serialNo)) ? ($serialNo + 1) : 1;

        $data = [
            'transaction_at'   => $this->input->post('date'),
            'party_code'       => $partyCode,
            'credit'           => $this->input->post('grand_total'),
            'debit'            => $this->input->post('paid'),
            'previous_balance' => $this->input->post('previous_balance'),
            'current_balance'  => $this->input->post('current_balance'),
            'transaction_via'  => $this->input->post('method'),
            'relation'         => 'purchase:' . $vno,
            'remark'           => 'purchase',
            'godown_code'      => $this->input->post('godown_code'),
            'serial'           => $serialNo
        ];

        save_data('partytransaction', $data);
    }

    /**
     * store sap meta info
     */
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
        $data['meta_key']   = 'purchase_by';
        $data['meta_value'] = $this->data['name'];
        save_data('sapmeta', $data);
    }

    /**
     * Delete purchase data
     */
    public function delete()
    {
        $vno = $this->input->get('vno');
        if (!empty($vno)) {

            // delete stock data;
            custom_query("DELETE FROM stock WHERE item_id IN(SELECT id FROM sapitems WHERE voucher_no='$vno' AND trash=0)", '', false);

            $data  = ['trash' => 1];
            $where = ['voucher_no' => $vno, 'trash' => 0];

            save_data('sapitems', $data, $where);
            save_data('sapmeta', $data, $where);
            save_data('saprecords', $data, $where);
            save_data('partytransaction', $data, ['relation' => 'purchase:' . $vno]);

            $msg = [
                'title' => 'delete',
                'emit'  => 'Purchase delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }
        redirect('purchase/purchase/show_Purchase', 'refresh');
    }
}
