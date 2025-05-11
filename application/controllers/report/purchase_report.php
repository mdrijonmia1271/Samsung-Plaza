<?php
class Purchase_report extends Admin_Controller {
    
    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){

		$this->data['subMenu']      = 'data-target="purchase_report"';
        $this->data['allGodown']    = getAllGodown();
        
        //Today's Data
        
        $where = ['saprecords.status' => 'purchase', 'saprecords.trash' =>0];

         if (isset($_POST['show'])) {

            foreach($_POST['search'] as $key => $val){
                if($val != null){
                    $where["saprecords.".$key] = $val;
                }
            }

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['saprecords.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['saprecords.godown_code'] = $this->data['branch'];
            }

            foreach ($_POST['date'] as $key => $value) {
                if($value != NULL && $key == "from"){
                    $where['saprecords.sap_at >='] = $value;
                }
                if($value != NULL && $key == "to"){
                    $where['saprecords.sap_at <='] = $value;
                }
            }
            
         }else{
            $where["saprecords.godown_code"]    = $this->data['branch'];
            $where["saprecords.sap_at"]         = date('Y-m-d');
         }

        $tableTo                = ['parties', 'godowns'];
        $joinCond               = ["saprecords.party_code=parties.code", "godowns.code=saprecords.godown_code"];
        $items                  = ['saprecords.sap_at', 'saprecords.voucher_no', 'parties.name', 'parties.mobile', 'saprecords.total_bill', 'saprecords.paid', 'saprecords.total_quantity', 'godowns.name as godwon_name'];
        $this->data['result']   = get_join('saprecords', $tableTo, $joinCond, $where, $items);
    
    
        // get all Supplier
        $this->data['allParty'] = $this->getAllparty();

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/purchase_nav', $this->data);
        $this->load->view('components/report/purchase_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }


    private function getAllparty(){
        $where = ["type"   => "supplier", "status" => "active", "trash"   => 0];
        $party = get_result("parties", $where, ['code', 'name', 'address']);
        return $party;
    }
 }