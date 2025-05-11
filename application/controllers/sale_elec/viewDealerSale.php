<?php

class ViewDealerSale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index()
    {
        $this->data['meta_title'] = 'Dealer Sale';
        $this->data['active']     = 'data-target="sale_menu_elec"';
        $this->data['subMenu']    = 'data-target="dealer"';

        $where = array(
            'saprecords.voucher_no' => $this->input->get('vno'),
            'saprecords.status'     => 'sale',
            'saprecords.trash'      => 0
        );

        $joinCond             = 'parties.code=saprecords.party_code AND parties.godown_code=saprecords.godown_code';
        $select               = ['saprecords.*', 'parties.name', 'parties.initial_balance'];
        $this->data['result'] = $result = get_join('saprecords', 'parties', $joinCond, $where, $select);

        $voucher_no       = "sales:" . $result[0]->voucher_no;
        $party_code       = $result[0]->party_code;
        $tranInfo         = custom_query("SELECT SUM(credit) AS credit, SUM(debit) AS debit, SUM(adjustment) AS adjustment FROM partytransaction WHERE id < (SELECT id FROM partytransaction WHERE relation='$voucher_no') AND party_code='$party_code' AND trash=0", true);
        $credit           = (!empty($tranInfo->credit) ? $tranInfo->credit : 0);
        $debit            = (!empty($tranInfo->debit) ? $tranInfo->debit : 0);
        $adjustment       = (!empty($tranInfo->adjustment) ? $tranInfo->adjustment : 0);
        $previous_balance = $result[0]->initial_balance + $debit - ($credit + $adjustment);

        $this->data['previous_balance'] = $previous_balance;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/view-dealer-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
}
