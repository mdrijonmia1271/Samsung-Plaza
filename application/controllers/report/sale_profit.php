<?php

class Sale_profit extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['meta_title'] = 'Report';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index()
    {

        $this->data['subMenu'] = 'data-target="sale-profit"';
        $this->data['results']  = null;

        
        // search all data
        $this->data['results'] = $this->search();
        
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        //$this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sale-profit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }
    
    
    private function search(){
        
        $where = ['saprecords.status' => 'sale', 'saprecords.trash' => 0];

        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if (!empty($val)) {
                    $where[$key] = $val;
                }
            }

            if (!empty($_POST['godown_code'])) {
                if ($_POST['godown_code'] != 'all') {
                    $where['saprecords.godown_code'] = $_POST['godown_code'];
                }
            } elseif(!empty($this->data['branch'])) {
                $where['saprecords.godown_code'] = $this->data['branch'];
            }

            foreach ($_POST['date'] as $key => $value) {
                if (!empty($value)) {
                    if($key == "from"){
                        $where['saprecords.sap_at >='] = $value;
                    }
                    
                    if($key == "to"){
                        $where['saprecords.sap_at <='] = $value;
                    }
                }
            }
            

        } else {
            if(!empty($this->data['branch'])){
                $where["saprecords.godown_code"] = $this->data['branch'];
            }
            //$where["saprecords.sap_at"]      = date('Y-m-d');
            
            $where["saprecords.sap_at >="]      = date('Y-m-1');
            $where["saprecords.sap_at <="]      = date('Y-m-t');
        }

        $select = ['saprecords.sap_at', 'saprecords.party_code', 'saprecords.sap_type', 'saprecords.address', 'godowns.name AS godown_name', 'saprecords.voucher_no', 'saprecords.paid'];
        $allSale = get_join('saprecords', 'godowns', 'saprecords.godown_code=godowns.code', $where, $select, '', 'saprecords.id', 'desc', '', '', [['saprecords.sap_type', ['cash', 'credit']]]);
        
        $result = [];
        if(!empty($allSale)){
            
            foreach($allSale as $_key => $item){
                
                if($item->sap_type == 'credit'){
                    
                    // get party info
                    $partyInfo  = get_row('parties', ['code' => $item->party_code], ['name', 'address']);
                    
                    $name = filter($partyInfo->name);
                    $address = filter($partyInfo->address);
                    
                    // get transaction info 
                    $tranInfo = custom_query("SELECT total_bill, total_paid, total_purchase FROM( SELECT voucher_no, party_code, total_bill FROM saprecords WHERE voucher_no='$item->voucher_no' AND trash=0)saprecords LEFT JOIN ( SELECT party_code, SUM(credit) AS total_paid FROM partytransaction WHERE relation IN ('sales:$item->voucher_no', '$item->voucher_no') AND trash=0)partytransaction ON saprecords.party_code=partytransaction.party_code LEFT JOIN ( SELECT voucher_no, SUM(purchase_price * quantity) AS total_purchase FROM sapitems WHERE voucher_no='$item->voucher_no' AND trash=0 )sapitems ON saprecords.voucher_no=sapitems.voucher_no");
                    
                    $total_bill     = (!empty($tranInfo[0]->total_bill) ? $tranInfo[0]->total_bill : 0);
                    $total_paid     = (!empty($tranInfo[0]->total_paid) ? $tranInfo[0]->total_paid : 0);
                    $total_purchase = (!empty($tranInfo[0]->total_purchase) ? $tranInfo[0]->total_purchase : 0);
                    
                    // get total profit
                    $total_profit = $total_bill - $total_purchase;
                    
                    // get total due
                    $total_due = $total_bill - $total_paid;
                    
                    // get profit
                    $profit = ($total_paid > 0 ? ($total_profit * $total_paid / $total_bill) : 0);
                    
                } else {
                    
                    // get party info
                    $partyInfo = json_decode($item->address);
                    
                    $name = filter($item->party_code);
                    $address = filter($partyInfo->address);
                    
                    // get transaction info 
                    $tranInfo = custom_query("SELECT total_bill, total_paid, total_purchase FROM ( SELECT voucher_no, party_code, total_bill FROM saprecords WHERE voucher_no='$item->voucher_no' AND trash=0 )saprecords LEFT JOIN ( SELECT voucher_no, SUM(paid) AS total_paid FROM due_collect WHERE voucher_no='$item->voucher_no' )due_collect ON saprecords.voucher_no=due_collect.voucher_no LEFT JOIN ( SELECT voucher_no, SUM(purchase_price * quantity) AS total_purchase FROM sapitems WHERE voucher_no='$item->voucher_no' AND trash=0 )sapitems ON saprecords.voucher_no=sapitems.voucher_no");
                    
                    $total_bill     = (!empty($tranInfo[0]->total_bill) ? $tranInfo[0]->total_bill : 0);
                    $total_paid     = (!empty($tranInfo[0]->total_paid) ? ($item->paid + $tranInfo[0]->total_paid) : $item->paid);
                    $total_purchase = (!empty($tranInfo[0]->total_purchase) ? $tranInfo[0]->total_purchase : 0);
                    
                    // get total profit
                    $total_profit = $total_bill - $total_purchase;
                    
                    // get total due
                    $total_due = $total_bill - $total_paid;
                    
                    // get profit
                    $profit = ($total_paid > 0 ? ($total_profit * $total_paid / $total_bill) : 0);
                }
                
                $result[$_key]['date']       = $item->sap_at;
                $result[$_key]['voucher_no'] = $item->voucher_no;
                $result[$_key]['name']       = $name;
                $result[$_key]['address']    = $address;
                $result[$_key]['total_bill'] = $total_bill;
                $result[$_key]['paid']       = $total_paid;
                $result[$_key]['profit']     = $profit;
                $result[$_key]['godown']     = $item->godown_name;
                
            }
        }
        
        return $result;
    }

}