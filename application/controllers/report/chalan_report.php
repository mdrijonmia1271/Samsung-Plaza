<?php
class Chalan_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){
        $this->data['subMenu'] = 'data-target="sales_report"';

        $where = array(
            "type"   => "client",
            "trash"  =>0,
            "status" =>"active"
        );

        $this->data['allClients'] = $this->action->read('parties',$where);


        $where = array();
        if(isset($_POST['show'])){

            foreach ($_POST['search'] as $key => $value) {
                if($value != NULL){
                    $where[$key] = $value;
                }
            }

            foreach ($_POST['date'] as $key => $value) {
                if($value != NULL && $key == "from"){
                    $where['date >='] = $value;
                }

                if($value != NULL && $key == "to"){
                    $where['date <='] = $value;
                }
            }
            //print_r($where);
        }


        $this->data['result']=$this->action->read('chalan', $where);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        // $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/chalan_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }

 } 