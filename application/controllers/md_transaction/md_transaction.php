<?php
class Md_transaction extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->holder();
        
        
        $this->data['allGodown'] = getAllGodown();
    }

    public function index() {
        $this->data['meta_title']   = 'Md_transaction';
        $this->data['active']       = 'data-target="md_transaction_menu"';
        $this->data['subMenu']      = 'data-target="new"';
        $this->data['confirmation'] = null;
        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/md_transaction/nav', $this->data);
        $this->load->view('components/md_transaction/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function addMd_transaction(){
        $this->data['confirmation'] = null;
        $data = array(
            'date'          => $this->input->post('date'),
            'type'          => $this->input->post('type'),
            'name'          => $this->input->post('name'),
            'godown_code'   => $this->input->post('godown_code'),
            'amount'        => $this->input->post('amount'),
            'particulars'   => trim($this->input->post('particulars'))
        );
        $options = array(
            'title' => 'success',
            'emit'  => 'Md Transaction Successfully Saved!',
            'btn'   => true
        );
        
        //chack md_transaction table
        $this->data['confirmation'] = message($this->action->add('md_transactions', $data), $options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('md_transaction/md_transaction','refresh');
    }



    public function allMd_transaction(){
        $this->data['meta_title']   = 'Md_transaction';
        $this->data['active']       = 'data-target="md_transaction_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        $where = array('trash' => 0);
        
        if($this->input->post('show')) {
            if($this->input->post('type'))      $where['type']      = $this->input->post('type');
            if($this->input->post('name'))      $where['name']      = $this->input->post('name');
            if($this->input->post('dateFrom'))  $where['date >=']   = $this->input->post('dateFrom');
            if($this->input->post('dateTo'))    $where['date <=']   = $this->input->post('dateTo');
        }
        
        if(!empty($_POST['godown_code'])){
            if($_POST['godown_code'] != 'all'){
                $where['godown_code'] = $_POST['godown_code'];
            }
        }else{
            $where['godown_code'] = $this->data['branch'];
        }
        
        $this->data['result']   = $this->action->readOrderBy("md_transactions", 'date', $where, 'desc');


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/md_transaction/nav', $this->data);
        $this->load->view('components/md_transaction/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    
    
    public function balance_report(){
        $this->data['meta_title']   = 'Md_transaction';
        $this->data['active']       = 'data-target="md_transaction_menu"';
        $this->data['subMenu']      = 'data-target="balance"';
        $this->data['confirmation'] = null;
        
        $where = array('trash' => 0);
        
        if($this->input->post('show')) {
            if($this->input->post('type'))      $where['type']      = $this->input->post('type');
            if($this->input->post('name'))      $where['name']      = $this->input->post('name');
            if($this->input->post('dateFrom'))  $where['date >=']   = $this->input->post('dateFrom');
            if($this->input->post('dateTo'))    $where['date <=']   = $this->input->post('dateTo');
        }
        
        if(!empty($_POST['godown_code'])){
            if($_POST['godown_code'] != 'all'){
                $where['godown_code'] = $_POST['godown_code'];
                $where_godown['godown_code'] = $_POST['godown_code'];
            }
        }else{
            $where['godown_code'] = $this->data['branch'];
            $where_godown['godown_code'] = $this->data['branch'];
        }
        if(!empty($where_godown)){
            $total_investment = $this->action->read('md_transactions',$where_godown);
        }
        $total_balance = $total_rcv =$total_paid = 0;
        if(!empty($where_godown)){
            foreach($total_investment as $val){
                if($val->type=='Received'){
                    $total_rcv += $val->amount;
                }else{
                    $total_paid += $val->amount;
                }
            }
        }    
        
        $total_balance = $total_rcv - $total_paid;
        $this->data['balance_amount']   = $total_balance;
        
        $this->data['result']   = $this->action->readOrderBy("md_transactions", 'date', $where, 'desc');


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/md_transaction/nav', $this->data);
        $this->load->view('components/md_transaction/balance_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function edit($id){
        $this->data['active']       = 'data-target="md_transaction_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['md_transaction'] = null;
        $this->data['confirmation'] = null;
        
        $where = array('trash' => 0, 'id' => $id);
        
        if($this->input->post('submit')) {
            
            $data = array(
                'date'          => $this->input->post('date'),
                'type'          => $this->input->post('type'),
                'name'          => $this->input->post('name'),
                'amount'        => $this->input->post('amount'),
                'godown_code'   => $this->input->post('godown_code'),
                'particulars'   => trim($this->input->post('particulars'))
            );
            
            $options = array(
                'title' => 'success',
                'emit'  => 'Md Transaction Successfully Updated!',
                'btn'   => true
            );
            
            //chack md_transaction table
            $this->data['confirmation'] = message($this->action->update('md_transactions', $data, $where), $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('md_transaction/md_transaction/allMd_transaction','refresh');
        }
        
        
        $this->data['result']   = $this->action->read("md_transactions", $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/md_transaction/nav', $this->data);
        $this->load->view('components/md_transaction/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    


    public function delete($id=NULL) {
        $this->data['confirmation'] = null;     

        $data  = array('trash' => 1);
        $where = array('id'=>$id);

        $msg_array = array(
            'title' => 'delete',
            'emit'  => 'Md Transaction Successfully Deleted!',
            'btn'   => true
        );
        $this->data['confirmation'] = message($this->action->update('md_transactions', $data, $where), $msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('md_transaction/md_transaction/allMd_transaction','refresh');
    }

    private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
}
