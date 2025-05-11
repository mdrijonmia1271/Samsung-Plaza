<?php

class Due extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'Sell';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="due"';
        $this->data['confirmation'] = null;


        //$this->data['zilla'] = $this->action->readGroupBy('parties', 'zone', array());
        $this->data['zilla'] = config_item("dist_upozila");
        $this->data['allBrand'] = $this->action->readGroupBy('partybalance', 'brand', array());
        
        // get the due record
        $where = array('type'  => 'client', 'balance <' => 0);

        if ($this->input->post('search')) {
            foreach ($this->input->post('search') as $key => $value) {
                if($value != NULL){ $where[$key] = $value; }
            }

            // print_r($where);
        }

        $joinCond = "parties.code = partybalance.code";
        $this->data['allDue'] = $this->action->joinAndRead('parties', 'partybalance', $joinCond, $where);

        if ($this->input->post("send")) {
            //Sending SMS Start
            $content = $this->input->post("message");
            foreach ($this->input->post("mobiles") as $num) {
                $message = send_sms($num, $content);
                    $insert = array(
                        'delivery_date'     => date('Y-m-d'),
                        'delivery_time'     => date('H:i:s'),
                        'mobile'            => $num,
                        'message'           => $content,
                        'total_characters'  => strlen($content),
                        'total_messages'    => message_length(strlen($content)),
                        'delivery_report'   => $message
                    );

                if($message){
                    $this->action->add('sms_record', $insert);
                }
            }

            if($message){
                $msg_array = array(
                    'title' => 'Warning',
                    'emit'  => 'SMS Successfully Sent',
                    'btn'   => true
                );
                $this->data['confirmation'] = message('success', $msg_array);
            } else {
                $msg_array = array(
                    'title' => 'Warning',
                    'emit'  => 'Could not send this SMS',
                    'btn'   => true
                );
                $this->data['confirmation'] = message('warning', $msg_array);
            }
        //Sending SMS End
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/due', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function due_payment(){
        $this->data['meta_title'] = 'Sale';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="due"';
        $this->data['confirmation'] = null;

        if(isset($_POST['save'])){
            $this->data['confirmation'] = $this->change();
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect("sale/due", 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/due-payment', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function change(){
        foreach ($_POST['id'] as $key => $value) {
            $where = array('id' => $value);

            $info = $this->action->read("sale",$where);
            $paid = $remission = 0.00;
            if($info!=NULL){
                $paid = $info[0]->paid + $this->input->post('deposit');
                $remission = $info[0]->remission + $this->input->post('remission');
            }

            $data = array(
                'paid' => $paid,
                'remission' => $remission,
                'due' => $this->input->post('due')
            );

         $this->action->update('sale', $data, $where);
        }

        $options = array(
            'title' => 'success',
            'emit'  => 'Sale change successfully completed!',
            'btn'   => true
        );

        return message('success', $options);
    }

    public function return_upazila(){

   $content = file_get_contents("php://input");
   $receive = json_decode($content, true);

   $condition = array();
   $condition = $receive['key'];


   $zone = config_item("dist_upozila");
   $upazilla = array();

   foreach ($zone as $key => $value) {
    if($key == $condition){
     $upazilla = $value;
    }
   }

   echo json_encode($upazilla);
}

}
