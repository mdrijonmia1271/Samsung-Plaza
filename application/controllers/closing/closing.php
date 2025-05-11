<?php
class Closing extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->holder();

        $this->load->model('action');
        $this->data["opening"] = count($this->action->read("closing"));
    }

    public function index() {
        $this->data['meta_title']   = 'Category';
        $this->data['active']       = 'data-target="closing-menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] =  null;

        //Saving Data Start here----------------------------------------------------------------
        if ($this->input->post("submit")) {
            $data = array(
                "date"          =>  $this->input->post("date"),
                "opening"       =>  $this->input->post("opening"),
                "income"        =>  $this->input->post("income"),
                "cost"          =>  $this->input->post('cost'),
                "bank_withdraw" =>  $this->input->post('bank_withdraw'),
                "bank_diposit"  =>  $this->input->post('bank_diposit'),
                "hand_cash"     =>  $this->input->post('hand_cash'),
                //"showroom"  =>  $this->data['branch']
            );
            $where = array(
                "date"          =>$_POST['date'],
                "opening_type"  => "auto"
                );

            if ($this->action->exists("closing",$where)) {
                $msg_array=array(
                    'title'=>'update',
                    'emit'=>'Closing Successfully Updated!',
                    'btn'=>true
                 );
                $this->data['confirmation']=message($this->action->update("closing",$data,$where),$msg_array);
            }else{
                $msg_array=array(
                    'title'=>'Saved',
                    'emit'=>'Closing Successfully Saved!',
                    'btn'=>true
                 );
                $this->data['confirmation']=message($this->action->add("closing",$data),$msg_array);
            }
        }
        //Saving Data End here----------------------------------------------------------------

        $today = date("Y-m-d");
        //Set custome date
        if($this->input->post("find")){
            $today = $this->input->post("date");
        }

        //All Income Start here-------------------------------------------------------------------------------------------------
        //Income By Due Collection And Sale 
        $where = array(
            "transaction_at" => $today,
            "status"         => "receivable"
        );
        $sale = $this->action->read_sum("partytransaction","paid",$where);

        //Income By Bank Withdraw
        $where = array(
            "transaction_date" => $today,
            "transaction_type" => "Debit"
        );
        $bank_withdraw = $this->action->read_sum("transaction","amount",$where);

        //Income By Previous Hand cash
        $prev_handCash = 0;
        $last_closing = $this->action->readOrderby("closing","date",array("date < "=>$today,"opening_type" => "auto"),"desc");
        if (count($last_closing)>0) {
            $prev_handCash = $last_closing[0]->hand_cash;
        }else{
            $closing_menual = $this->action->read("closing",array("opening_type" => "menual"));
            if(count($closing_menual)>0){
                $prev_handCash = $closing_menual[0]->hand_cash;
            }
        }

        //All Income End here-------------------------------------------------------------------------------------------------
        
        //All cost Start here-------------------------------------------------------------------------------------------------
        
        //Cost By Due Collection And Purchase 
        $where = array(
            "transaction_at" => $today,
            "status"         => "payable"
        );
        $purchase = $this->action->read_sum("partytransaction","paid",$where);

        //Cost By Bank Diposit
        $where = array(
            "transaction_date" => $today,
            "transaction_type" => "Credit"
        );
        $bank_diposit = $this->action->read_sum("transaction","amount",$where);

        //General cost
        $where = array(
            "date" => $today
        );
        $general_cost = $this->action->read_sum("cost","amount",$where);

        //All cost End here-------------------------------------------------------------------------------------------------
        
        //Sending all Income Start
        $this->data["party_income"] = $sale[0]->paid+0;
        $this->data["bank_withdraw"] = $bank_withdraw[0]->amount+0;
        $this->data["prev_handCash"] = $prev_handCash;
        $this->data["all_income"] = $sale[0]->paid + $bank_withdraw[0]->amount + $prev_handCash;
        //Sending all Income End
        
        //Sending all Income Start
        $this->data["party_cost"] = $purchase[0]->paid+0;
        $this->data["bank_diposit"] = $bank_diposit[0]->amount+0;
        $this->data["general_cost"] = $general_cost[0]->amount+0;
        $this->data["all_cost"] = $purchase[0]->paid + $bank_diposit[0]->amount + $general_cost[0]->amount;
        //Sending all Income End

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/closing/nav', $this->data);
        $this->load->view('components/closing/daily', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function report() {
        $this->data['meta_title'] = 'Category';
        $this->data['active'] = 'data-target="closing-menu"';
        $this->data['subMenu'] = 'data-target="report"';
        $this->data['resultset'] = null;

        // search
        if(isset($_POST['search'])){
            $where = array(
                "date"          => $this->input->post('date'),
                "opening_type"  => "auto"
            );

            if($this->data['privilege'] == "user"){
             $where['showroom'] = $this->data['branch'];
            }else{
              $where['showroom'] = $this->input->post('showroom');
            }

            $this->data['resultset'] = $this->action->read("closing", $where);
        }

        $this->data['showroom'] = $this->action->read("showroom");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/closing/nav', $this->data);
        $this->load->view('components/closing/report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function opening() {
        $this->data['meta_title'] = 'Category';
        $this->data['active'] = 'data-target="closing-menu"';
        $this->data['subMenu'] = 'data-target="opening"';
        $this->data['confirmation'] = null;

        $where=array(
            "opening_type"=>"menual",
             "showroom" => $this->data['branch']
        );

        //Save start
        if ($this->input->post("submit")) {
            $data=array(
                "date"          => date("Y-m-d"),
                "hand_cash"     => $this->input->post("opening_amount"),
                "opening_type"  => "menual"
                //"showroom" => $this->data['branch']
            );

            $msg_array=array(
                'title'=>'update',
                'emit'=>'Data Successfully Saved!',
                'btn'=>true
             );
            $this->data['confirmation']=message($this->action->add("closing",$data),$msg_array);
        }
        //Save end
        //Update Start
        if ($this->input->post("update")) {
            $data=array(
                "hand_cash" => $this->input->post("opening_amount")
            );

            $msg_array=array(
                'title'=>'update',
                'emit'=>'Data Successfully Updated!',
                'btn'=>true
             );
            $this->data['confirmation']=message($this->action->update("closing",$data,$where),$msg_array);
        }
        //Update End

        $this->data["opening_val"] = $this->action->read("closing",$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/closing/nav', $this->data);
        $this->load->view('components/closing/opening', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }


  private function holder(){
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
