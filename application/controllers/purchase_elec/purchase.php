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

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu_elec"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        // get all vendors
        $this->data['allParty'] = $this->getAllparty();

        // get all products
        $this->data['allProducts'] = $this->getAllProduct();

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        $this->data['invoice'] = generate_invoice("saprecords", array("status" => "purchase"));

        // save purchase data
        if (isset($_POST['save'])) {
            $this->data['confirmation'] = $this->create();
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("purchase_elec/purchase", "refresh");
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase_elec/nav', $this->data);
        $this->load->view('components/purchase_elec/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function create()
    {
        if (isset($_POST['save'])) {

            // $due = $this->input->post('grand_total') - $this->input->post('paid');
            $grand_total = (float) $this->input->post('grand_total');
            $paid = (float) $this->input->post('paid');
            
            $due = $grand_total - $paid;


            $data = [
                'sap_at'         => $this->input->post('date'),
                'voucher_no'     => $this->input->post('voucher_no'),
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
                'voucher_type'   => 'electronics',
                'status'         => 'purchase',
            ];
           
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
                $data['purchase_commission'] = $_POST['purchase_commission'][$key];
                $data['flat_discount']       = $_POST['flat_discount'][$key];
                $data['color']              = $_POST['color'][$key];
                // $data['product_serial']     = $_POST['product_serial'][$key];
                $data['quantity']           = $_POST['quantity'][$key];
                $data['unit']               = $_POST['unit'][$key];
                $data['purchase_price']     = $_POST['purchase_price'][$key];
                $data['sale_price']         = $_POST['sale_price'][$key];
                $data['godown_code']        = $_POST['godown_code'];
                $data['status']             = 'purchase';
    
                
                $id = save_data('sapitems', $data, '', true);
                
                //get stock info
                $where         = array();
                $where['code'] = $_POST['product_code'][$key];
                $where['godown_code'] = $this->input->post('godown_code');
                
                // Read current stock record
                $record = $this->action->read('stock', $where);
                
                // Determine quantity for stock update or insertion
                $quantity = ($record != null) ? ($record[0]->quantity + (float)$_POST['quantity'][$key]) : (float)$_POST['quantity'][$key];
            
                
                if (!empty($record)) {
                    // Update stock if product already exists
                    $totalAmount = ($record[0]->purchase_price * $record[0]->quantity) + (float)$_POST['subtotal'][$key];
                    $quantity    = $record[0]->quantity + (float)$_POST['quantity'][$key];
                    $avg_price   = $totalAmount / $quantity;
            
                    $data = array(
                        'quantity'       => $quantity,
                        'purchase_price' => $avg_price,
                        'dealer_sale_price' => $_POST['dealer_sale_price'][$key] ?? 0,  // Add a fallback if dealer_sale_price is not set
                        'brand'             => $_POST['brand'][$key],
                    );
            
                    // Update stock table
                    $this->action->update('stock', $data, $where);
                } else {
                    // Insert new stock record if product is not already in stock
                    $data = array(
                        'code'              => $_POST['product_code'][$key],
                        'product_model'     => $_POST['product_model'][$key],
                        'name'              => $_POST['product'][$key],
                        'category'          => $_POST['product_cat'][$key],
                        'subcategory'       => $_POST['product_subcat'][$key],
                        'brand'             => $_POST['brand'][$key],
                        'quantity'          => (float)$_POST['quantity'][$key],
                        'purchase_price'    => (float)$_POST['purchase_price'][$key],
                        'dealer_sale_price' => $_POST['dealer_sale_price'][$key] ?? 0,
                        'sell_price'        => (float)$_POST['sale_price'][$key],
                        'godown_code'       => $_POST['godown_code'],
                        'unit'              => $_POST['unit'][$key]
                    );
            
                    // Insert new stock record
                    $this->action->add('stock', $data);
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
            // return message($status, $options);
        }
        redirect('purchase_elec/purchase', 'refresh');
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
        // Get stock info
        $where = array(
            'code'        => $_POST['product_code'][$index],
            'godown_code' => $this->input->post('godown_code')
        );
    
        // Read current stock record
        $record = $this->action->read('stock', $where);
    
        // Determine quantity for stock update or insertion
        $quantity = ($record != null) ? ($record[0]->quantity + (float)$_POST['quantity'][$index]) : (float)$_POST['quantity'][$index];
    
        if (!empty($record)) {
            // Update stock if product already exists
            $totalAmount = ($record[0]->purchase_price * $record[0]->quantity) + (float)$_POST['subtotal'][$index];
            $quantity    = $record[0]->quantity + (float)$_POST['quantity'][$index];
            $avg_price   = $totalAmount / $quantity;
    
            $data = array(
                'quantity'       => $quantity,
                'purchase_price' => $avg_price,
                'dealer_sale_price' => $_POST['dealer_sale_price'][$index] ?? 0  // Add a fallback if dealer_sale_price is not set
            );
    
            // Update stock table
            $this->action->update('stock', $data, $where);
        } else {
            // Insert new stock record if product is not already in stock
            $data = array(
                'code'              => $_POST['product_code'][$index],
                'product_model'     => $_POST['product_model'][$index],
                'name'              => $_POST['product'][$index],
                'category'          => $_POST['product_cat'][$index],
                'subcategory'       => $_POST['product_subcat'][$index],
                'brand'             => $_POST['brand'][$index],
                'quantity'          => (float)$_POST['quantity'][$index],
                'purchase_price'    => (float)$_POST['purchase_price'][$index],
                'dealer_sale_price' => $_POST['dealer_sale_price'][$index] ?? 0,
                'sell_price'        => (float)$_POST['sale_price'][$index],
                'godown_code'       => $_POST['godown_code'],
                'unit'              => $_POST['unit'][$index]
            );
    
            // Insert new stock record
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
        $result = get_result("products", ["product_cat" => 'electronics',"status" => "available"], ['product_code', 'product_name', 'product_model']);
        return $result;
    }


    public function show_purchase()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu_elec"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;


        // get all party
        $this->data['allParty'] = $this->getAllparty();

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        // get all product model
        $this->data['allModel'] = get_result('products', ['status' => 'available'], 'product_model');


        // get all saprecords width filter
        $where = [
            "saprecords.status" => 'purchase',
            "saprecords.voucher_type" => 'electronics',
            "saprecords.trash"  => 0,
        ];

        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if ($val != null) {
                    $where["saprecords.$key"] = $val;
                }
            }

            if (!empty($_POST['product_model'])) {
                $where['sapitems.product_model'] = $_POST['product_model'];
            }


            if (!empty($_POST['godown_code'])) {
                if ($_POST['godown_code'] != 'all') {
                    $where['saprecords.godown_code'] = $_POST['godown_code'];
                }
            } else {
                $where['saprecords.godown_code'] = $this->data['branch'];
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
            $where["saprecords.godown_code"] = $this->data['branch'];
            $where['saprecords.sap_at']      = date("Y-m-d");
        }

        $tableTo              = ['parties', 'godowns', 'sapitems'];
        $joinCond             = ['parties.code=saprecords.party_code', 'godowns.code=saprecords.godown_code', 'sapitems.voucher_no=saprecords.voucher_no'];
        $select               = ['saprecords.sap_at', 'saprecords.voucher_no', 'saprecords.total_bill', 'saprecords.paid', 'parties.name', 'parties.mobile', 'godowns.name as godown_name', 'sapitems.product_model'];
        $this->data['result'] = get_join("saprecords", $tableTo, $joinCond, $where, $select, "voucher_no", "saprecords.id", "desc");

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase_elec/nav', $this->data);
        $this->load->view('components/purchase_elec/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function view()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where                         = [
            'saprecords.voucher_no' => $this->input->get('vno'),
            'saprecords.status'     => 'purchase',
            'saprecords.trash'      => 0,
        ];
        $joinCond                      = "saprecords.party_code = parties.code";
        $select                        = ['saprecords.*', 'parties.name', 'parties.address', 'parties.mobile'];
        $this->data['purchase_record'] = get_join("saprecords", "parties", $joinCond, $where, $select);

        $sapitemsWhere = array(
            "sapitems.voucher_no" => $this->input->get('vno'),
            'sapitems.status'     => 'purchase',
            'sapitems.trash'      => 0,
        );

        $joinCond                    = "sapitems.product_code=products.product_code";
        $select                      = ['sapitems.*', 'products.product_cat', 'products.product_model'];
        $this->data['purchase_info'] = get_join("products", "sapitems", $joinCond, $sapitemsWhere);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase_elec/nav', $this->data);
        $this->load->view('components/purchase_elec/view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * Delete purchase and update stock
     * table : saprecords,sapitems,stock,partytransaction
     * Strategy:
     *   Update column trash 0 to 1
     *   Update Stock quantity by code,category,subcategory,godown
     *
     **/
    public function delete_purchase()
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
        redirect('purchase_elec/purchase/show_purchase', 'refresh');
    }

    public function itemWise()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="wise"';
        $this->data['result']     = null;

        // get all product
        if (!checkAuth('super')) {
            $stockWhere['godown_code'] = $this->data['branch'];
        } else {
            $stockWhere = [];
        }
        $this->data['allProducts'] = get_result('stock', $stockWhere, ['code', 'name', 'product_model']);

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();


        // search product
        if (isset($_POST['show'])) {

            $where["sapitems.product_code"] = $_POST['product_code'];
            $where["sapitems.status"]       = "purchase";
            $where["sapitems.trash"]        = 0;

            if (!empty($_POST['godown_code'])) {
                if ($_POST['godown_code'] != 'all') {
                    $where['sapitems.godown_code'] = $_POST['godown_code'];
                }
            } else {
                $where['sapitems.godown_code'] = $this->data['branch'];
            }

            $select               = ['sapitems.sap_at', 'sapitems.voucher_no', 'sapitems.quantity', 'sapitems.unit', 'godowns.name as godown_name'];
            $this->data['result'] = get_join('sapitems', 'godowns', 'godowns.code=sapitems.godown_code', $where, $select);

            $cond                  = array('product_code' => $_POST['product_code']);
            $this->data['rawname'] = $this->action->read('products', $cond);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase_elec/nav', $this->data);
        $this->load->view('components/purchase_elec/itemWise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
}
