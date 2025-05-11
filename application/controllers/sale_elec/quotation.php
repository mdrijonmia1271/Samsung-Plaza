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

class Quotation extends Admin_Controller{
    function __construct()    {
        parent::__construct();
        $this->load->model('action');
    }
    public function index(){
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="quotation"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // get last voucher
        $this->data['last_voucher'] = get_result('saprecords', '', 'voucher_no', '', 'id', 'desc', 1);

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/quotation', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // save data
    public function store(){
        if(isset($_POST['save'])){
            $data = [
                'sap_at'         => $this->input->post('date'),
                'total_quantity' => $this->input->post('totalqty'),
                'total_bill'     => $this->input->post('grand_total'),
                'service_charge' => $this->input->post('service_charge'),
                'total_discount' => $this->input->post('total_discount'),
                'godown_code'         => $_POST['godown_code'],
                'sap_type'       => 'quotation',
                'comment'        => $this->input->post('comment'),
                //'guarantee'      => $this->input->post('guarantee'),
                'status'         => 'quotation',
            ];
            $partyInfo          = json_encode($_POST['partyInfo']);
            $data['address']    = $partyInfo;
            $data['party_code'] = str_replace(" ", "_", $_POST['party_code']);
            // save sap records and return insert id
            $lastId = save_data('saprecords', $data, '', true);
            // generate voucher no
            $this->data['voucher_no'] = get_voucher($lastId, 6);
            // update voucher no
            save_data('saprecords', ['voucher_no' => $this->data['voucher_no']], ['id' => $lastId]);
            // save sap items
            foreach ($_POST['product'] as $key => $value) {
                $data = [
                    'sap_at'              => $this->input->post('date'),
                    'voucher_no'          => $this->data['voucher_no'],
                    'product_code'        => $_POST['product_code'][$key],
                    'product_model'       => $_POST['product_model'][$key],
                    'unit'                => $_POST['unit'][$key],
                    'purchase_price'      => $_POST['purchase_price'][$key],
                    'quantity'            => $_POST['quantity'][$key],
                    'sale_price'          => $_POST['sale_price'][$key],
                    'godown_code'         => $_POST['godown_code'],
                    'sap_type'            => $this->input->post('sap_type'),
                    'status'              => 'quotation',
                ];
                save_data('sapitems', $data);
            
            }
        
              $msg = [
                    'title' => 'success',
                    'emit'  => 'Quotation Save successfully!',
                    'btn'   => true
                ];
                $this->session->set_flashdata('confirmation', message('success', $msg));
              redirect('sale/all_quotation', 'refresh');
        }
       
        
    }


    // show invoice
    public function invoice()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="all_quotation"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;

        if (!empty($_GET['vno'])) {
            $this->data['info'] = get_row('saprecords', ['voucher_no' => $_GET['vno'], 'status' => 'quotation', 'trash' => 0]);
        } else {
            redirect('sale/all_quotation', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/quotation-invoice', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


   
    
    // delete data
    public function delete($vno = null){
       
        if(!empty($vno)){
            // update data
            $where = ['voucher_no' => $vno];
            $data = ["trash" => 1];
            save_data('sapitems', $data, $where);
            save_data('saprecords', $data, $where);
    
            $msg = [
                'title' => 'delete',
                'emit'  => 'Quotation delete successfully!',
                'btn'   => true
            ];
            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }
        redirect('sale/all_quotation', 'refresh');
    }
}