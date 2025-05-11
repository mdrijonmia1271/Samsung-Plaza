<?php

class SendSms extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
        $this->data['total_sms'] = config_item('total_sms');
        $sent_sms_data = $this->action->read("sms_record", array("delivery_report" => "1"));
        $total_sent_sms = 0;
        $this->data['godowns']=$this->action->read('godowns',array('trash' => 0));
        
        foreach($sent_sms_data as $total_sent_sms_data){
            $total_sent_sms = $total_sent_sms +$total_sent_sms_data->total_messages; 
        }
        $this->data['sent_sms'] = $total_sent_sms;
        
    }

    public function index()
    {
        $this->data['meta_title']   = 'Mobile SMS';
        $this->data['active']       = 'data-target="sms_menu"';
        $this->data['subMenu']      = 'data-target="send-sms"';
        $this->data['confirmation'] = $this->data["receivers"] = null;
        $this->data['godown_code']  = $this->data["godown_code"] =null;

        if ($this->input->post("show")) {

            if($this->input->post("type") != 'supplier'){
                $where = array(
                    "godown_code" => $this->input->post("godown_code"),
                    "type" => 'client',
                    "customer_type" => $this->input->post('type'),
                    "status" => "active",
                    "trash" => 0
                );
            }else{
                $where = array(
                    "godown_code" => $this->input->post("godown_code"),
                    "type" => $this->input->post("type"),
                    "status" => "active",
                    "trash" => 0
                );
            }
            $this->data['godown_code'] = $this->input->post("godown_code");
            $this->data["receivers"] = get_result("parties", $where);
        }

        // send data
        if (isset($_POST['sendSms'])) {
            $content = $this->input->post('message');

            foreach ($_POST['mobile'] as $key => $num) {
                $message = send_sms($num, $content);
                $insert = array(
                    'delivery_date'    => date('Y-m-d'),
                    'delivery_time'    => date('H:i:s'),
                    'godown_code'      => $this->input->post('godown_code'),
                    'mobile'           => $num,
                    'message'          => $this->input->post('message'),
                    'total_characters' => $this->input->post('total_characters'),
                    'total_messages'   => $this->input->post('total_messages'),
                    'delivery_report'  => $message
                );
                $this->action->add('sms_record', $insert);
            }

            if ($message) {
                $options = array(
                    "title" => "success",
                    "emit"  => "Your Message has been Successfully Sent!",
                    "btn"   => true
                );
                $this->data['confirmation'] = message('success', $options);
            } else {
                $options = array(
                    "title" => "warning",
                    "emit"  => "Oops! Something went Wrong!Try again Please.",
                    "btn"   => true
                );
                $this->data['confirmation'] = message('warning', $options);
            }
        }


        $this->data["receiversInfo"] = $this->action->readGroupBy("parties", 'type');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sms/sms-nev', $this->data);
        $this->load->view('components/sms/send-sms', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function send_custom_sms()
    {
        $this->data['meta_title']   = 'Mobile SMS';
        $this->data['active']       = 'data-target="sms_menu"';
        $this->data['subMenu']      = 'data-target="custom-sms"';
        $this->data['confirmation'] = null;


        if (isset($_POST['sendSms'])) {
            $mobile_no = explode(",", $this->input->post('mobiles'));
            $content = $this->input->post('message');
            $godown_code = $this->input->post('godown_code');
            
            foreach ($mobile_no as $key => $num) {
                $message = send_sms($num, $content);
                $insert = array(
                    'delivery_date'    => date('Y-m-d'),
                    'delivery_time'    => date('H:i:s'),
                    'mobile'           => $num,
                    'message'          => $this->input->post('message'),
                    'total_characters' => $this->input->post('total_characters'),
                    'total_messages'   => $this->input->post('total_messages'),
                    'godown_code'      => $this->input->post('godown_code'),
                    'delivery_report'  => $message
                );
                $this->action->add('sms_record', $insert);
            }

            if ($message) {
                $msg_array = array(
                    "title" => "Success",
                    "emit"  => "SMS Sent Successfully",
                    "btn"   => true
                );
                $this->data['confirmation'] = message('success', $msg_array);
            } else {
                $msg_array = array(
                    "title" => "Success",
                    "emit"  => "Could not send this SMS!",
                    "btn"   => true
                );
                $this->data['confirmation'] = message('warning', $msg_array);
            }

            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("sms/sendSms/send_custom_sms", "refresh");
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sms/sms-nev', $this->data);
        $this->load->view('components/sms/send-custom-sms', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function sms_report()
    {
        $this->data['meta_title']   = 'Mobile SMS';
        $this->data['active']       = 'data-target="sms_menu"';
        $this->data['subMenu']      = 'data-target="sms-report"';
        $this->data['confirmation'] = $this->data['sms_record'] = null;


        if ($this->input->post('show_between')) {

            $where = array();
            $godown_code = $this->input->post('godown_code');
            if($godown_code){
                $where['godown_code'] = $godown_code;
            }
            foreach ($_POST['date'] as $key => $val) {
                if ($val != null && $key == 'from') {
                    $where['delivery_date >='] = $val;
                }

                if ($val != null && $key == 'to') {
                    $where['delivery_date <='] = $val;
                }
            }
            $where['delivery_report'] = 1;
            $this->data['sms_record'] = $this->action->read('sms_record', $where, "desc");
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sms/sms-nev', $this->data);
        $this->load->view('components/sms/sms-report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


}
