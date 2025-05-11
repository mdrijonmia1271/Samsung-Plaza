<?php
class Sale_commission extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->data['meta_title'] = 'Sale Commission';
        $this->data['active'] = 'data-target="commission-menu"';
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="sale"';
        $this->data['confirmation'] = $this->data['result'] = null;
        $this->data['rate'] = 0.00;

        $this->data['company'] = $this->action->read("subcategory");
        $this->data['result'] = $this->action->read("sapitems",array(),"desc");

        if(isset($_POST['show'])){
            $commissionCond = array();
            $where = array();

            foreach ($_POST['search'] as $key => $value) {
               if($value != NULL){
                  $where[$key] = $value;
               }
            }

           foreach ($_POST['date'] as $key => $value) {
                if($value != NULL && $key == "from"){
                    $where['sap_at >='] = $value;

                    $commissionCond['fromMonth']    = date("m", strtotime($value));
                    $commissionCond['fromYear']     = date("Y", strtotime($value));
                }

                if($value != NULL && $key == "to"){
                    $where['sap_at <='] = $value;

                    $commissionCond['toMonth']    = date("m", strtotime($value));
                    $commissionCond['toYear']     = date("Y", strtotime($value));
                }
            }

            $this->data['result'] = $this->action->read("sapitems", $where, "desc");

            if(count($commissionCond) > 0) {
                if($commissionCond['fromYear'] == $commissionCond['toYear']){
                    if($commissionCond['fromMonth'] == $commissionCond['toMonth']){

                        $where = array(
                            "year" => $commissionCond['fromYear'],
                            "month" => $commissionCond['fromMonth']
                        );

                        $rateInfo = $this->action->read('commissions', $where);
                        if($rateInfo != null) {
                            $this->data['rate'] = $rateInfo[0]->amount;
                        }
                    }
                }
            }
        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/commission/nav', $this->data);
        $this->load->view('components/commission/sale-commission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }



}
