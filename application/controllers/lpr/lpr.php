<?php
class Lpr extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'LPR';
        $this->data['active'] = 'data-target="lpr_menu"';
        $this->data['subMenu'] = 'data-target="add"';
        
        // get clients whose have hire sale.
        $from = 'saprecords';
        $join = 'parties';
        $joincond = 'saprecords.party_code=parties.code';
        $where = array('sap_type' => 'credit');
        $this->data['allClients'] = $this->action->joinAndReadGroupby($from, $join, $joincond, $where, 'party_code');
        
        
        
        // after submit form
        if(isset($_POST['save'])){
            
            // insert record to `lpr` table
            $data = array(
                'date'             => $this->input->post('date'),
                'lpr_code'         => lprId('lpr'),
                'party_code'       => $this->input->post('party_code'),
                'party_name'       => $this->input->post('party_name'),
                'voucher_no'       => $this->input->post('voucher_no'),
                'down_payment'     => $this->input->post('down_payment'),
                'total_bill'       => $this->input->post('sales_amount'),
                'total_commission' => $this->input->post('commission'),
                'total_paid'       => $this->input->post('paid'),
                'due'              => $this->input->post('due'),
                'payment'          => $this->input->post('payment'),
                'remission'        => $this->input->post('remission'),
                'balance'          => $this->input->post('balance'),
            );
            
            
            $lastId = $this->action->addAndGetId('lpr', $data);
            
            
          /**
           * insert record into `installment` table.
           * Fetch additional info by voucher no from installment table.
           **/
            
            // read additional info from `installment`
            $installmentInfo = $this->action->read_limit('installment', array('voucher_no' => $this->input->post('voucher_no'), 'trash' => 0), $by="desc", $limit=1);
            
            $data = array(
                'date'               => $this->input->post('date'),
                'voucher_no'         => $this->input->post('voucher_no'),
                'voucher_due'        => ($installmentInfo)? $installmentInfo[0]->voucher_due : 0.00,
                'installment_type'   => ($installmentInfo)? $installmentInfo[0]->installment_type : '',
                'installment_no'     => ($installmentInfo)? $installmentInfo[0]->installment_no : 1,
                'installment_amount' => $this->input->post('payment'),
                'total_paid'         => $this->input->post('down_payment'),
                'remission'          => $this->input->post('remission'),
                'client_code'        => $this->input->post('party_code'),
                'installment_given'  => ($installmentInfo)? $installmentInfo[0]->installment_given + 1  : 0,
                //'status'             => ($_POST['balance'] == 0)? 'closed' : 'active',
                'status'             => 'closed',
            );
            
            $status = $this->action->add('installment', $data);
            
            
            /**
             * insert data into `partytransaction` table.
             **/ 
             
            // fetch last insert record and increase by 1.
            $where = array('party_code' => $this->input->post('party_code'));
            $last_sl = $this->action->read_limit('partytransaction',$where,'desc',1);
            $voucher_sl = ($last_sl)? ($last_sl[0]->serial+1) : 1; 
            
            $data = array(
                'transaction_at'   => $this->input->post('date') ,
                'lpr_code'         => lprId('lpr'),
                'party_code'       => $this->input->post('party_code'),
                'credit'           => $this->input->post('payment'),
                'transaction_via'  => 'cash',
                'transaction_by'   => 'client',
                'transaction_type' => 'installment',
                'relation'         => 'transaction',
                'remark'           => 'transaction',
                'serial'           => $voucher_sl,
                'remission'        => $this->input->post('remission'),
                'status'           => 'lpr'
            );
            
            $status = $this->action->add('partytransaction', $data);
            
            $msg_array = array(
                'title' => 'Success',
                'emit' => 'LPR Successfully Completed',
                'btn' => true
            );
            
            $confirm = message($status, $msg_array);
            $this->session->set_flashdata('confirmation', $confirm);
            
            redirect('lpr/lpr/view/'.$lastId, 'refresh');
            
        }
        
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/lpr/nav', $this->data);
        $this->load->view('components/lpr/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function all() {
        $this->data['meta_title'] = 'LPR';
        $this->data['active'] = 'data-target="lpr_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $where = array('trash' => 0);
        if(isset($_POST['search'])){
            if(isset($_POST['party_code'])){
                $where['party_code'] = $_POST['party_code'];
            }
        }
        
        // get all clients
        $this->data['allClients'] = $this->action->read('lpr');
    
        // read all lpr
        $this->data['results'] = $this->action->read('lpr', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/lpr/nav', $this->data);
        $this->load->view('components/lpr/all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }
    
    
    public function edit() {
        $this->data['meta_title'] = 'LPR';
        $this->data['active'] = 'data-target="lpr_menu"';
        $this->data['subMenu'] = 'data-target="all"';

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/lpr/nav', $this->data);
        $this->load->view('components/lpr/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }
    
    
    public function view($id=null) {
        $this->data['meta_title'] = 'LPR';
        $this->data['active'] = 'data-target="lpr_menu"';
        $this->data['subMenu'] = 'data-target="all"';
                
        $where = array('id' => $id);
        $this->data['info'] = $this->action->read('lpr', $where);
        

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/lpr/nav', $this->data);
        $this->load->view('components/lpr/view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer',$this->data);
    }
    
    
    /**
     * Update table: lpr, installment, partytransaction
     * :return: success msg
     **/
    public function delete($id){
        $where = array('id' => $id);
        $data = array('trash' => 1);
        
        // read info from lpr table
        $lprInfo = $this->action->read('lpr', $where);
        
        // update lpr table
        $status = $this->action->update('lpr', $data, $where);
        
        // update partytransaction
        $where = array(
            'party_code' => $lprInfo[0]->party_code,
            'status' => 'lpr'
        );
        $status = $this->action->update('partytransaction', $data, $where);
        
        // update installment table
        $where = array(
            'client_code' => $lprInfo[0]->party_code,
            'status'   => 'closed'
        );
        $status = $this->action->update('installment', $data, $where);
        
        $msg_array = array(
            'title' => 'Delete',
            'emit' => 'LPR Delete Successfully',
            'btn' => true
        );
        
        $confirm = message('danger', $msg_array);
        $this->session->set_flashdata('confirmation', $confirm);
        redirect('lpr/lpr/all', 'refresh');
    }
}
