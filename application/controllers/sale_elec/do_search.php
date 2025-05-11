<?php

class Do_search extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Search';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="do-search"';
        $this->data['result']       = null;

        $this->data['result'] = $this->doSearch();
        if(isset($_POST['show'])) {
            $this->data['result'] = $this->doSearch();
        }

        // get all DO numbers
        $this->data['allDONumbers'] = $this->getAllDO();

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/do-search', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function doSearch(){
        $where = array();
	    $records = array();
	
        if (isset($_POST['search'])) {
            foreach($_POST['search'] as $key => $val) {
                if($val != null){
                    $where[$key] = $val;
                }
            }
        }

        $where['sap_type'] = 'do';

        $dataset = $this->action->read('sapitems', $where);
        foreach ($dataset as $key => $row) {
            $records[$key]['sl'] = $key + 1;
            $records[$key]['date'] = $row->sap_at;
            $records[$key]['voucherNo'] = $row->voucher_no;
            $records[$key]['doNo'] = $row->do_no;
            $records[$key]['productCode'] = $row->product_code;
            $records[$key]['company'] = $row->brand;
            $records[$key]['salePrice'] = $row->sale_price;
            $records[$key]['quantity'] = $row->quantity;
            $records[$key]['unit'] = $row->unit;

            $where = array("voucher_no" => $row->voucher_no);
            $data = $this->action->read("saprecords", $where);

            $records[$key]['partyCode'] = $data[0]->party_code;

            $where = array("code" => $data[0]->party_code);
            $data = $this->action->read("parties", $where);

            $records[$key]['partyName'] = $data[0]->name;
            $records[$key]['partyMobile'] = $data[0]->contact;
        }

        return $records;
    }

    private function getAllDO() {
        $resultset = array();

        $where = array(
            'status'    => 'sale',
            'sap_type'  => 'do'
        );

        $records = $this->action->readGroupBy('sapitems', 'do_no',$where,'id','asc');

        if($records != null) {
            foreach ($records as $key => $row) {
                if($row->do_no != "") {
                    $resultset[] = $row->do_no;
                }
            }
        }
        
        return $resultset;
    }

}
