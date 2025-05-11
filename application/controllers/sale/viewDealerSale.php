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
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        
        $vno = $this->input->get('vno');

        $where = [
            'voucher_no' => $vno,
            'status'     => 'sale',
            'trash'      => 0
        ];

        $voucherInfo = $this->data['voucherInfo'] = get_row('saprecords', $where);
        
        if(empty($voucherInfo)){
            redirect('sale/search_sale', 'refresh');
        }
        
        $this->data['voucherItems'] = get_result('sapitems', $where);
        
        $partyInfo = [
            'code'             => '',
            'name'             => '',
            'mobile'           => '',
            'address'          => '',
            'previous_balance' => 0,
            'previous_sign'    => 'Receivable',
            'current_balance'  => 0,
            'current_sign'     => 'Receivable',
        ];
        
        if($voucherInfo->sap_type == 'cash'){
            
            $cInfo = json_decode($voucherInfo->address);
            
            $balance = $voucherInfo->total_bill - $voucherInfo->paid;
            
            $partyInfo['name']            = filter($voucherInfo->party_code);
            $partyInfo['mobile']          = $cInfo->mobile;
            $partyInfo['address']         = $cInfo->address;
            $partyInfo['grand_total']     = $voucherInfo->total_bill;
            $partyInfo['current_balance'] = $balance;
            $partyInfo['current_sign']    = ($balance > 0 ? 'Receivable' : 'Payable');
        }else{
            
            $pInfo = get_row('parties', ['code' => $voucherInfo->party_code], ['name', 'mobile', 'address']);
            
            $previousBalanceInfo = (object)get_client_balance($voucherInfo->party_code, get_name('partytransaction', 'id', ['relation' => 'sales:'. $voucherInfo->voucher_no]));
            
            $balance = $previousBalanceInfo->balance + $voucherInfo->total_bill - $voucherInfo->paid;
            
            $partyInfo['code']             = $voucherInfo->party_code;
            $partyInfo['name']             = $pInfo->name;
            $partyInfo['mobile']           = $pInfo->mobile;
            $partyInfo['address']          = $pInfo->address;
            $partyInfo['previous_balance'] = $previousBalanceInfo->balance;
            $partyInfo['previous_sign']    = $previousBalanceInfo->status;
            $partyInfo['grand_total']      = $previousBalanceInfo->balance + $voucherInfo->total_bill;
            $partyInfo['current_balance']  = $balance;
            $partyInfo['current_sign']     = ($balance > 0 ? 'Receivable' : 'Payable');
        }
        
        $this->data['partyInfo'] = (object)$partyInfo;
        

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/view-dealer-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
}
