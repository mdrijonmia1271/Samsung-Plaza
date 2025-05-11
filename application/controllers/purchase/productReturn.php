<?php

class ProductReturn extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // get all godowns
        $this->data['godownList']  = getAllGodown();
        $this->data['productList'] = get_result('products', ['trash' => 0], ['product_code', 'product_name', 'product_model']);

        $this->data['meta_title'] = 'Purchase Return';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    /**
     * show all return data
     */
    public function index()
    {
        $this->data['subMenu']      = 'data-target="allReturn"';
        $this->data['confirmation'] = null;


        // get voucher info
        $where = [
            'saprecords.status' => 'purchase_return',
            'saprecords.trash'  => 0
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['saprecords.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['dateFrom'])) {
                $where['saprecords.sap_at >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['saprecords.sap_at <='] = $_POST['dateTo'];
            }
        }else{
            $where['saprecords.sap_at'] = date('Y-m-d');
        }

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['saprecords.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['saprecords.godown_code'] = $this->data['branch'];
        }

        $tableTo  = ['parties', 'godowns'];
        $joinCond = ['saprecords.party_code=parties.code', 'saprecords.godown_code=godowns.code'];
        $select   = ['saprecords.*', 'parties.name', 'parties.mobile', 'parties.address', 'godowns.name AS godown_name'];

        $this->data['results'] = get_left_join('saprecords', $tableTo, $joinCond, $where, $select);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/return-list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * show return form
     */
    public function create()
    {
        $this->data['subMenu']      = 'data-target="createReturn"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/return-create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store()
    {
        if (isset($_POST['update'])) {

            $data = [
                'sap_at'         => $this->input->post('date'),
                'party_code'     => $this->input->post('party_code'),
                'total_bill'     => $this->input->post('total_amount'),
                'total_quantity' => $this->input->post('total_quantity'),
                'party_balance'  => $this->input->post('previous_balance'),
                'paid'           => $this->input->post('paid'),
                'method'         => $this->input->post('method'),
                'godown_code'    => $this->input->post('godown_code'),
                'status'         => 'purchase_return',
            ];

            $id  = save_data('saprecords', $data, '', true);
            $vno = get_voucher($id);

            save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);

            foreach ($_POST['product'] as $key => $value) {

                $data                   = [];
                $data['sap_at']         = $this->input->post('date');
                $data['voucher_no']     = $vno;
                $data['stock_id']       = $_POST['stock_id'][$key];
                $data['product_code']   = $_POST['product_code'][$key];
                $data['product_model']  = $_POST['product_model'][$key];
                $data['color'] = $_POST['color'][$key];
                $data['product_serial'] = $_POST['product_serial'][$key];
                $data['unit']           = $_POST['unit'][$key];
                $data['purchase_price'] = $_POST['purchase_price'][$key];
                $data['sale_price']     = $_POST['sale_price'][$key];
                $data['quantity']       = $_POST['quantity'][$key];
                $data['godown_code']    = $_POST['godown_code'];
                $data['status']         = 'purchase_return';

                if ($this->action->add('sapitems', $data)) {
                    $this->handelStock($key);
                }
            }

            $this->handelPartyTransaction($vno);
            $this->sapmeta($vno);

            $msg = [
                'title' => 'success',
                'emit'  => 'Purchase Return successfully Completed!',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }

        redirect("purchase/productReturn/create", "refresh");
    }


    /**
     * Store party transaction data
     **/
    private function handelPartyTransaction($vno)
    {
        $data = [
            'transaction_at'   => $this->input->post('date'),
            'party_code'       => $this->input->post('party_code'),
            'debit'            => $this->input->post('total_amount'),
            'credit'           => $this->input->post('paid'),
            'previous_balance' => $this->input->post('previous_balance'),
            'current_balance'  => $this->input->post('current_balance'),
            'godown_code'      => $this->input->post('godown_code'),
            'relation'         => 'purchase_return:' . $vno,
            'remark'           => 'purchase_return',
        ];

        save_data('partytransaction', $data);
    }

    /**
     * store sapmeta info
     */
    private function sapmeta($vno)
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = [
                    'voucher_no' => $vno,
                    'meta_key'   => $key,
                    'meta_value' => $value
                ];
                save_data('sapmeta', $data);
            }
        }

        $data['voucher_no'] = $vno;
        $data['meta_key']   = 'purchase_return_by';
        $data['meta_value'] = $this->data['name'];
        save_data('sapmeta', $data);
    }

    /**
     * update stock
     */
    private function handelStock($index)
    {
        $stockWhere = [
            'id'             => $_POST['stock_id'][$index],
            'product_serial' => $_POST['product_serial'][$index],
        ];

        $stockInfo = get_row('stock', $stockWhere, 'quantity');
        $quantity  = $stockInfo->quantity - $_POST['quantity'][$index];
        save_data('stock', ['quantity' => $quantity], $stockWhere);
    }

    /**
     * show return invoice
     */
    public function show()
    {
        $this->data['subMenu']      = 'data-target="allReturn"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        // get voucher info
        $where  = [
            'saprecords.voucher_no' => $vno,
            'saprecords.trash'      => 0
        ];
        $select = ['saprecords.*', 'parties.name', 'parties.mobile', 'parties.address'];

        $this->data['voucherInfo'] = $info = get_row_join('saprecords', 'parties', 'saprecords.party_code=parties.code', $where, $select);

        // get voucher item info
        $where  = [
            'sapitems.voucher_no' => $vno,
            'sapitems.trash'      => 0
        ];
        $select = ['sapitems.*', 'products.product_name', 'products.product_model', 'products.brand'];

        $this->data['voucherItems'] = get_left_join('sapitems', 'products', 'sapitems.product_code=products.product_code', $where, $select);

        // get previous balance
         $previousBalance = (object)get_supplier_balance($info->party_code, get_name('partytransaction', 'id', ['relation' => 'purchase_return:' . $vno]));

        $this->data['previousBalance'] = $previousBalance->balance;

        // calculate current balance
        $this->data['currentBalance'] = $previousBalance->balance + ($info->total_bill + $info->paid);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/return-invoice', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    /**
     * Delete return data
     **/
    public function delete()
    {
        $vno = $this->input->get('vno');

        if (!empty($vno)) {

            $where       = ['voucher_no' => $vno, 'trash' => 0];
            $productList = get_result('sapitems', $where);

            if (!empty($productList)) {
                foreach ($productList as $item) {

                    $stockWhere = [
                        'id'             => $item->stock_id,
                        'product_serial' => $item->product_serial
                    ];

                    $stockInfo = get_row('stock', $stockWhere, 'quantity');
                    $quantity  = $stockInfo->quantity + $item->quantity;
                    save_data('stock', ['quantity' => $quantity], $stockWhere);
                }
            }

            $data = ['trash' => 1];
            save_data('sapitems', $data, $where);
            save_data('saprecords', $data, $where);
            save_data('sapmeta', $data, $where);
            save_data('partytransaction', $data, ['relation' => 'purchase_return:' . $vno]);

            $msg = [
                'title' => 'delete',
                'emit'  => 'Purchase return  delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('purchase/productReturn', 'refresh');
    }
}
