<?php
class Report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

        $this->data['meta_title'] = 'Report';
        $this->data['active'] = 'data-target="report-menu"';
    }

    public function index() {
        $this->data['subMenu']      = 'data-target="report"';
        $this->data['width']      	= 'full-width';
        $this->data['confirmation'] = $this->data['allInfo'] = null;
        $this->data['employee']     = array();

        $where = $where2 = $where3 = $where4 = $where44 =  $where5 = $where6 = $where7 = $returnWhere = array();
        $where['sap_at'] = $where2['transaction_at'] = $where3['date'] = $where4['salary_records.date'] = $where44['date'] = $where5["partytransaction.transaction_at"] = $where6["date"] = $where7["transaction_date"] = date("Y-m-d");

         //godown balance
        $this->data['pre_cash'] = $this->action->readOrderby("godown_balance","date",array("date <" => date('Y-m-d')),"desc");

        //return physical cost
         $this->data['return_physical_cost'] = $this->action->read("cost",array("type"=>"physical_cost","return_date" => date("Y-m-d"),"status" => "returned"));


        if(isset($_POST["show"])){
            $where = $where2 = $where3 = $where4 = $where44 = $where5 = $where6 = $where7 = array();

            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['sap_at >='] = $val;
                    $where2['transaction_at >='] = $val;
                    $where3['date >='] = $val;
                    $where4['salary_records.date >='] = $val;
                    $where5["partytransaction.transaction_at <="] = $val;
                    $where6["date >="] = $val;
                    $where7["transaction_date >="] = $val;
                    $where44['date >='] = $val;
                    $returnWhere['return_date >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['sap_at <='] = $val;
                    $where2['transaction_at <='] = $val;
                    $where3['date <='] = $val;
                    $where4['salary_records.date <='] = $val;
                    $where5["partytransaction.transaction_at >="] = $val;
                    $where6["date <="] = $val;
                    $where7["transaction_date <="] = $val;
                    $where44['date <='] = $val;
                    $returnWhere['return_date <='] = $val;
                }
            }


             //godown balance
           $this->data['pre_cash'] = $this->action->readOrderby("godown_balance","date",array("date <" => $_POST['date']['from']),"desc");

            $returnWhere["type"] = "physical_cost";
            $returnWhere["status"] = "returned";
            $this->data['return_physical_cost'] = $this->action->read("cost",$returnWhere);
        }

        // sale
        $where["status"] = "sale";
        $this->data["allSale"] = $this->action->read("saprecords", $where);


        //showrom Collection
        $this->data['showroomCollection'] = $this->action->read("showroom_collection",$where3);



        // Cash Received
        $where2["status"] = "receivable";
        $where2["transaction_via"] = "cash";

        $this->data["transactions"] = $this->action->read("partytransaction", $where2);

        // all cost
        $this->data["costType"] = $this->action->readGroupBy("cost", "type", $where3);
        $this->data["allCost"] = $this->action->read("cost", $where3);

        // employee payment
        $empInfo = $this->action->read("employee", array('status' => 'active'));
        if($empInfo != NULL) {
            $cond = array();

            if(isset($_POST['date'])){
                foreach ($_POST['date'] as $key => $value) {
                    if($value != NULL && $key == "from" ){
                        $cond['date >='] = $value;
                    }

                    if($value != NULL && $key == "to" ){
                        $cond['date <='] = $value;
                    }
                }
            }

            foreach ($empInfo as $key => $value) {
                $total = 0.00;
                $cond['eid'] = $value->emp_id;
                $salaryInfo = $this->action->read("salary_records", $cond);

                if($salaryInfo != null) {
                    $this->data['employee'][$key]['employee_id'] = $value->emp_id;
                    $this->data['employee'][$key]['employee_name'] = $this->getEmployee($value->emp_id);
                    $this->data['employee'][$key]['particulars'] = '';
                    $this->data['employee'][$key]['amount'] = 0.00;

                    $insentives = $deduction = 0.00;
                    foreach ($salaryInfo as $recordRow) {
                        if($recordRow->remarks == 'deduction') {
                            $deduction += $recordRow->amounts;
                        } else {
                            $insentives += $recordRow->amounts;
                        }

                        $this->data['employee'][$key]['particulars'] .= $recordRow->fields . ', ';
                    }

                    $this->data['employee'][$key]['amount'] = $insentives - $deduction;
                }
            }
        }

        // company payment
        $where5["parties.type"] = "company";
        $joinCond="partytransaction.party_code=parties.code";
        $this->data['comPayment'] = $this->action->joinAndRead('partytransaction', "parties", $joinCond, $where5);

        // loan
        $this->data["loanInfo"] = $this->action->read("loan", $where6);

        // bank
        $this->data["bankInfo"] = $this->action->read("transaction", $where7);
        $this->data["sallery_info"] = $this->action->readGroupBy("salary_records","eid",$where44);



        //save or update the closing balance start here
        if(isset($_POST['close'])){
           $where = array(
            "date"        => $_POST['date'],
            "showroom_id" => "godown"
           );

           $data = array(
            "date"        	=> $_POST['date'],
            "showroom_id" 	=> "godown",
            "balance"     	=> $_POST['amount'],
            "physical_cost"     => $_POST['physical_cost']
           );

           if($this->action->exists("godown_balance",$where)){
             $this->action->update("godown_balance",$data,$where);
             $title = "update";
             $emit = "Your Closing Balance Successfully Updated!";
           }else{
             $this->action->add("godown_balance",$data);
             $title = "success";
             $emit = "Your Closing Balance Successfully Saved!";
           }
           $msg = array(
             "title" => $title,
             "emit"  => $emit,
             "btn"   => true
           );
           $this->data['confirmation'] = message("success",$msg);
           $this->session->set_flashdata("confirmation",$this->data['confirmation']);
           redirect("report/report","refresh");

            //save or update the closing balance end here
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    private function getEmployee($eid) {
        $where = array('emp_id' => $eid);
        $data = $this->action->read('employee', $where);

        if($data != null) {
            return $data[0]->name;
        }

        return '';
    }

    

    public function Profit_loss_report(){
        $this->data['meta_title'] = 'Profit Report';
        $this->data['active']     = 'data-target="report_menu"';
        $this->data['subMenu']    = 'data-target="product_profit"';
        $this->data['resultInfo'] = null;
        
        $where = ["trash"  => 0,"status" =>"sale"];

        $this->data['allProducts'] = get_result('products',['status' => 'available'], ['product_code', 'product_name']);
        
        $con = ['sap_at' => date("Y-m-d"), 'trash' => 0];

        if(isset($_POST['show'])){

            if(isset($_POST['search'])){
                foreach ($_POST['search'] as $key => $value) {
                    if($value != NULL){
                        $where[$key] = $value;
                    }
                }
            }
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }

            if(isset($_POST['date'])){
                foreach ($_POST['date'] as $key => $value) {
                    if($value != NULL && $key == "from"){
                        $where['sap_at >='] = $value;
                    }

                    if($value != NULL && $key == "to"){
                        $where['sap_at <='] = $value;
                    }
                }
            }

        }else{
            $where["godown_code"]    = $this->data['branch'];
            $where["sap_at"]         = date('Y-m-d');
        }

        $this->data['resultInfo']    = get_result('sapitems',$where, ['product_code', 'voucher_no', 'godown_code', 'purchase_price', 'quantity', 'sale_price']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/profit_nav', $this->data);
        $this->load->view('components/report/lossProfit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
}
