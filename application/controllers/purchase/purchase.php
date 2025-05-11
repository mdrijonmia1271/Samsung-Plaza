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

class Purchase extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();
    }

    public function index()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';

        if (!empty($_GET['type']) && ($_GET['type'] == 'mobile')) {
            $this->data['subMenu'] = 'data-target="add-new-mobile"';
        } else {
            $this->data['subMenu'] = 'data-target="add-new"';
        }

        $this->data['confirmation'] = null;


        // get color list
        $this->data['colorList'] = get_result('colors', ['trash' => 0]);

        // get all vendors
        $this->data['allParty'] = $this->getAllparty();

        // get all products
        $this->data['allProducts'] = $this->getAllProduct();


        $this->data['invoice'] = generate_invoice("saprecords", array("status" => "purchase"));

        // save purchase data
        if (isset($_POST['save'])) {
            $this->data['confirmation'] = $this->create();
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("purchase/purchase", "refresh");
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        if (!empty($_GET['type']) && ($_GET['type'] == 'mobile')) {
            $this->load->view('components/purchase/add_mobile', $this->data);
        } else {
            $this->load->view('components/purchase/add', $this->data);
        }

        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function create()
    {
        // insert purchase record
        $total_quantity = 0;
        foreach ($_POST['product'] as $key => $value) {

            $total_quantity += $_POST['quantity'][$key];

            $data                        = [];
            $data['sap_at']              = $this->input->post('date');
            $data['voucher_no']          = $this->input->post('voucher_no');
            $data['product_code']        = $_POST['product_code'][$key];
            $data['product_model']       = $_POST['product_model'][$key];
            $data['purchase_commission'] = $_POST['commission'][$key];
            $data['sale_price']          = $_POST['sale_price'][$key];
            $data['purchase_price']      = $_POST['imei_no'][$key];
            $data['product_serial']      = $_POST['quantity'][$key];
            $data['quantity']            = $_POST['quantity'][$key];
            $data['unit']                = $_POST['unit'][$key];
            $data['godown_code']         = $_POST['godown_code'];
            $data['status']              = 'purchase';

            if ($this->action->add('sapitems', $data)) {
                $this->handelStock($key);
            }
        }

        // insert bill record
        $previous_balance = ($_POST['previous_sign'] == 'Receivable' ? +$_POST['previous_balance'] : -$_POST['previous_balance']);

        $data = array(
            'sap_at'         => $this->input->post('date'),
            'voucher_no'     => $this->input->post('voucher_no'),
            'party_code'     => $this->input->post('party_code'),
            'total_bill'     => $this->input->post('grand_total'),
            'total_quantity' => $total_quantity,
            'total_discount' => $this->input->post('total_discount'),
            'transport_cost' => $this->input->post('transport_cost'),
            'party_balance'  => $previous_balance,
            'paid'           => $this->input->post('paid'),
            'method'         => $this->input->post('method'),
            'godown_code'    => $this->input->post('godown_code'),
            'status'         => 'purchase',
        );

        if (!empty($_POST['voucher_type']) && ($_POST['voucher_type'] == 'mobile')) {
            $data['voucher_type'] = 'mobile';
        } else {
            $data['voucher_type'] = 'electronics';
        }
        /* echo '<pre>';
         print_r($data);
         die();*/
        $status = $this->action->add('saprecords', $data);
        $this->handelPartyTransaction();
        $this->sapmeta();

        $options = array(
            'title' => 'success',
            'emit'  => 'Purchase successfully Completed!',
            'btn'   => true
        );

        return message($status, $options);
    }


    /**
     * Table : partytransaction
     * Strategy :
     *    set purchase grandtotal amount to credit column
     *    set paid amount to debit column
     *
     **/
    private function handelPartyTransaction()
    {

        // fetch last insert record and increase by 1.
        $where      = array('party_code' => $this->input->post('party_code'));
        $last_sl    = $this->action->read_limit('partytransaction', $where, 'desc', 1);
        $voucher_sl = ($last_sl) ? ($last_sl[0]->serial + 1) : 1;

        $previous_balance = ($_POST['previous_sign'] == 'Receivable' ? +$_POST['previous_balance'] : -$_POST['previous_balance']);
        $current_balance  = ($_POST['current_sign'] == 'Receivable' ? +$_POST['current_balance'] : -$_POST['current_balance']);

        $data = array(
            'transaction_at'   => $this->input->post('date'),
            'party_code'       => $this->input->post('party_code'),
            'credit'           => $this->input->post('grand_total'),
            'debit'            => $this->input->post('paid'),
            'previous_balance' => $previous_balance,
            'current_balance'  => $current_balance,
            'transaction_via'  => $this->input->post('method'),
            'relation'         => 'purchase:' . $this->input->post('voucher_no'),
            'remark'           => 'purchase',
            'godown_code'      => $this->input->post('godown_code'),
            'serial'           => $voucher_sl
        );

        $this->action->add('partytransaction', $data);

        return true;
    }


    private function sapmeta()
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'voucher_no' => $this->input->post('voucher_no'),
                    'meta_key'   => $key,
                    'meta_value' => $value
                );
                $this->action->add('sapmeta', $data);
            }
        }

        $data['voucher_no'] = $this->input->post('voucher_no');
        $data['meta_key']   = 'purchase_by';
        $data['meta_value'] = $this->data['name'];
        $this->action->add('sapmeta', $data);
    }


    private function handelStock($index)
    {

        // get stock info
        $where         = array();
        $where['code'] = $_POST['product_code'][$index];
        if (!empty($_POST['imei_no'][$index])) {
            $where['product_serial'] = $_POST['imei_no'][$index];
        }
        $where['godown_code'] = $this->input->post('godown_code');

        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = ($record != null) ? ($record[0]->quantity + $_POST['quantity'][$index]) : $_POST['quantity'][$index];

        // check the product update or insert
        // set product an averge purchase price if the product have already purchased before.

        if ($record != null) {
            $data = array('quantity' => $quantity);

            //read from `sapitems` table for previous purchase price 
            $cond            = array(
                'product_code' => $_POST['product_code'][$index],
                'trash'        => 0
            );
            $purchaseRecords = $this->action->read('sapitems', $cond);

            $count              = 0.00;
            $totalPurchasePrice = 0.00;
            if ($purchaseRecords != null) {
                foreach ($purchaseRecords as $key => $value) {
                    $totalPurchasePrice += ($value->purchase_price * $value->quantity);
                    $count              += $value->quantity;
                }
            } else {
                $count = 1; // for escaping ZeroDivisonError
            }

            $average_price = ($totalPurchasePrice) / $count;


            if ($_POST['purchase_price'][$index] > 0) {
                $data['purchase_price'] = $average_price;
            }

            if (!empty($_POST['imei_no'][$index])) {
                $data['product_serial'] = $_POST['imei_no'][$index];
            }

            $this->action->update('stock', $data, $where);

        } else {

            $data = array(
                'code'           => $_POST['product_code'][$index],
                'product_model'  => $_POST['product_model'][$index],
                'name'           => $_POST['product'][$index],
                'category'       => $_POST['product_cat'][$index],
                'subcategory'    => $_POST['product_subcat'][$index],
                'quantity'       => $quantity,
                'purchase_price' => $_POST['purchase_price'][$index],
                'sell_price'     => $_POST['sale_price'][$index],
                'godown_code'    => $_POST['godown_code'],
                'unit'           => $_POST['unit'][$index],
            );

            if (!empty($_POST['imei_no'][$index])) {
                $data['product_serial'] = $_POST['imei_no'][$index];
            }

            $this->action->add('stock', $data);
        }
    }


    private function getAllparty()
    {
        $where = array(
            "type"   => "supplier",
            "status" => "active",
            "trash"  => 0
        );
        $party = $this->action->read("parties", $where);
        return $party;
    }


    private function getAllProduct()
    {
        if (!empty($_GET['type']) && ($_GET['type'] == 'mobile')) {
            $result = get_result("products", ["status" => "available", "trash" => 0], ['product_code', 'product_name', 'product_model']);
        } else {
            $result = get_result("products", ["status" => "available", "trash" => 0], ['product_code', 'product_name', 'product_model']);
        }

        return $result;
    }


    public function show_purchase()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;


        // get all godowns
        $this->data['godownList'] = getAllGodown();

        // get all product model
        $this->data['productList'] = get_result('products', ['status' => 'available', 'trash' => 0], ['product_code', 'product_name', 'product_model']);

        $this->data['colorList'] = get_result('colors', ['trash' => 0]);

        // get all saprecords width filter
        $where = [
            "saprecords.status" => 'purchase',
            "saprecords.voucher_type" => 'mobile',
            "saprecords.trash"  => 0,
        ];

        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if ($val != null) {
                    $where["saprecords.$key"] = $val;
                }
            }

            if (!empty($_POST['product_code'])) {
                $where['sapitems.product_code'] = $_POST['product_code'];
            }

            if (!empty($_POST['color'])) {
                $where['sapitems.color'] = $_POST['color'];
            }


            foreach ($_POST['date'] as $key => $val) {
                if ($val != null && $key == 'from') {
                    $where['saprecords.sap_at >='] = $val;
                }

                if ($val != null && $key == 'to') {
                    $where['saprecords.sap_at <='] = $val;
                }
            }

        } else {
            $where['saprecords.sap_at'] = date("Y-m-d");
        }

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['saprecords.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['saprecords.godown_code'] = $this->data['branch'];
        }
        
        $like = [];
        if(!empty($_POST['product_serial'])){
            $like['sapitems.product_serial'] = $_POST['product_serial']; 
        }

        $tableTo              = ['parties', 'godowns', 'sapitems'];
        $joinCond             = ['parties.code=saprecords.party_code', 'godowns.code=saprecords.godown_code', 'sapitems.voucher_no=saprecords.voucher_no'];
        $select               = ['saprecords.sap_at', 'saprecords.voucher_type', 'saprecords.voucher_no', 'saprecords.total_bill', 'saprecords.paid', 'saprecords.due', 'parties.name', 'parties.mobile', 'godowns.name as godown_name', 'sapitems.product_model'];
        $this->data['result'] = get_join("saprecords", $tableTo, $joinCond, $where, $select, "voucher_no", "saprecords.id", "desc", "", "", "", $like);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function view()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'saprecords.voucher_no' => $vno,
            'saprecords.status'     => 'purchase',
            'saprecords.trash'      => 0,
        ];

        $joinCond                  = "saprecords.party_code = parties.code";
        $select                    = ['saprecords.*', 'parties.name', 'parties.address', 'parties.mobile'];
        $this->data['voucherInfo'] = get_row_join("saprecords", "parties", $joinCond, $where, $select);

        $sapitemsWhere = [
            'sapitems.voucher_no' => $vno,
            'sapitems.status'     => 'purchase',
            'sapitems.trash'      => 0,
        ];

        $joinCond                   = 'sapitems.product_code=products.product_code';
        $select                     = ['sapitems.*', 'products.product_cat', 'products.product_model'];
        $this->data['voucherItems'] = get_left_join('sapitems', "products", $joinCond, $sapitemsWhere, $select);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * Delete purchase and update stock
     * table : saprecords,sapitems,stock,partytransaction
     *
     **/
    public function delete()
    {

        $where        = array('voucher_no' => $this->input->get('vno'));
        $purchaseInfo = $this->action->read('sapitems', $where);

        foreach ($purchaseInfo as $key => $value) {
            // set condition for every item
            $stockWhere = [
                "code"        => $value->product_code,
                "godown_code" => $purchaseInfo[0]->godown_code
            ];

            // get stock information
            $stockInfo = get_row('stock', $stockWhere, ['quantity']);


            // caltulate new quantity
            if (!empty($stockInfo)) {
                $quantity = $stockInfo->quantity - $purchaseInfo[$key]->quantity;
                $data     = array('quantity' => $quantity);
                // update the stock
                $this->action->update('stock', $data, $stockWhere);
            }
        }

        // Update row
        $data     = array("trash" => 1);
        $response = $this->action->update('sapitems', $data, $where);
        $response = $this->action->update('saprecords', $data, $where);
        $response = $this->action->update('sapmeta', $data, $where);
        $this->action->update('partytransaction', $data, array("relation" => "purchase:" . $this->input->get('vno')));

        $options = array(
            'title' => 'delete',
            'emit'  => 'Purchase  delete successfully!',
            'btn'   => true
        );

        $this->session->set_flashdata('deleted', message($response, $options));
        redirect('purchase/purchase/show_purchase', 'refresh');
    }


    public function delete_purchase_mobile()
    {

        $where        = array('voucher_no' => $this->input->get('vno'));
        $purchaseInfo = $this->action->read('sapitems', $where);

        foreach ($purchaseInfo as $key => $value) {
            // set condition for every item
            $stockWhere = [
                "product_serial" => $value->product_serial,
                "godown_code"    => $purchaseInfo[0]->godown_code
            ];

            // get stock information
            $stockInfo = get_row('stock', $stockWhere, ['quantity']);


            // caltulate new quantity
            if (!empty($stockInfo)) {
                $quantity = $stockInfo->quantity - $purchaseInfo[$key]->quantity;
                $data     = array('quantity' => $quantity);
                // update the stock
                $this->action->update('stock', $data, $stockWhere);
            }
        }

        // Update row
        $data     = array("trash" => 1);
        $response = $this->action->update('sapitems', $data, $where);
        $response = $this->action->update('saprecords', $data, $where);
        $response = $this->action->update('sapmeta', $data, $where);
        $this->action->update('partytransaction', $data, array("relation" => "purchase:" . $this->input->get('vno')));

        $options = array(
            'title' => 'delete',
            'emit'  => 'Purchase  delete successfully!',
            'btn'   => true
        );

        $this->session->set_flashdata('deleted', message($response, $options));
        redirect('purchase/purchase/show_purchase', 'refresh');
    }


    public function itemWise()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="wise"';
        $this->data['result']     = null;

        // get all godowns
        $this->data['godownList'] = getAllGodown();

        // get all products
        $this->data['productList'] = get_result('products', ['trash' => 0], ['product_code', 'product_name', 'product_model']);


        // search product
        $where = [
            'sapitems.status' => 'purchase',
            'sapitems.trash'  => 0,
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['product_code'])) {
                $where['sapitems.product_code'] = $_POST['product_code'];
            }

            if (!empty($_POST['dateFrom'])) {
                $where['sapitems.sap_at >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['sapitems.sap_at <='] = $_POST['dateTo'];
            }
        } else {
            $where['sapitems.sap_at'] = date('Y-m-d');
        }

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['sapitems.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['sapitems.godown_code'] = $this->data['branch'];
        }

        $tableTo  = ['godowns'];
        $joinCond = ['sapitems.godown_code=godowns.code'];
        $select   = ['sapitems.sap_at', 'sapitems.voucher_no', 'sapitems.product_serial', 'sapitems.product_model', 'sapitems.quantity', 'sapitems.unit', 'godowns.name as godown_name'];

        $this->data['results'] = get_left_join('sapitems', $tableTo, $joinCond, $where, $select);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/itemWise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
}
