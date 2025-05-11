<?php
class Loan_new extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->data['meta_title'] = 'Loan';
        $this->data['active']     = 'data-target="loan-menu"';
        
        $this->data['allGodowns'] = getAllGodown();
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        $this->data['personId']   = generateUniqueId('loan_new', 6);
        
        if($this->input->post('save')) {
            $data = array (
                'date'          => $this->input->post('date'),
                'godown_code'   => $this->input->post('godown_code'),
                'name'          => $this->input->post('person_name'),
                'person_code'   => $this->input->post('person_code'),
                'mobile'        => $this->input->post('mobile'),
                'address'       => $this->input->post('address'),
                'balance'       => $this->input->post('balance'),
                'type'          => $this->input->post('type')
            );
                
            $options = array(
                'title' => 'success',
                'emit'  => 'Details Successfully Saved!',
                'btn'   => true
            );

            // insert data into parties table
            $this->data['confirmation'] = message($this->action->add('loan_new', $data), $options);
            $this->session->set_flashdata("confirmation", $this->data["confirmation"]);
            redirect("loan_new/loan_new", "refresh");
        }
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan_new/nav', $this->data);
        $this->load->view('components/loan_new/add_new', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function all() {
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $joinCond = 'loan_new.godown_code=godowns.code';
        $select = ['loan_new.*', 'godowns.name as godown_name'];
        $this->data['all'] = get_join('loan_new', 'godowns', $joinCond, [], $select);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan_new/nav', $this->data);
        $this->load->view('components/loan_new/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function delete($id=null) {
        $where = array( 'id'    => $id );
        
        $msg= array(
            'title' => 'delete',
            'emit'  => 'Loan Successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation']=message($this->action->deletedata('loan_new', $where), $msg);
        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("loan_new/loan_new/all","refresh");
    }
    
    
    public function edit($id = null) {
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        $where = array( 'id' => $id );
        $this->data['edit'] = $this->action->read('loan_new', $where);
        
        if($this->input->post('save')) {
            $data = array (
                'date'          => $this->input->post('date'),
                'godown_code'   => $this->input->post('godown_code'),
                'name'          => $this->input->post('person_name'),
                'mobile'        => $this->input->post('mobile'),
                'address'       => $this->input->post('address'),
                'balance'       => $this->input->post('balance'),
                'type'          => $this->input->post('type')
            );
                
            $options = array(
                'title' => 'success',
                'emit'  => 'Details Successfully Updated!',
                'btn'   => true
            );

            // insert data into parties table
            $this->data['confirmation'] = message($this->action->update('loan_new', $data, $where), $options);
            $this->session->set_flashdata("confirmation",$this->data["confirmation"]);
            redirect("loan_new/loan_new/all","refresh");
        }
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan_new/nav', $this->data);
        $this->load->view('components/loan_new/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function add_trx() {
        $this->data['subMenu'] = 'data-target="trans"';
        $this->data['confirmation'] = null;
        
        $this->data['person'] = $this->action->read('loan_new');
        
        if($this->input->post('submit')){
            $data = array (
                'date'          => date('Y-m-d'),
                'godown_code'   => $this->input->post('godown_code'),
                'person_code'   => $this->input->post('person_code'),
                'mobile'        => $this->input->post('mobile'),
                'address'       => $this->input->post('address'),
                'type'          => $this->input->post('type'),
                'amount'        => $this->input->post('amount'),
                'remark'        => $this->input->post('remark')
            );
            
            $options = array(
                'title' => 'success',
                'emit'  => 'Transaction Successfully Add!',
                'btn'   => true
            );
            
            // insert data into parties table
            $this->data['confirmation'] = message($this->action->add('add_trx', $data), $options);
            $this->session->set_flashdata("confirmation", $this->data["confirmation"]);
            redirect("loan_new/loan_new/add_trx", "refresh");
        }
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan_new/nav', $this->data);
        $this->load->view('components/loan_new/add_trx', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    

    public function edit_trx($id = null) {
        $this->data['subMenu'] = 'data-target="trans"';
        $this->data['confirmation'] = null;

        $this->data['person'] = $this->action->read('loan_new');
        $this->data['loanInfo'] = get_row('add_trx', array('id' => $id));

        if($this->input->post('submit')){
            $data = array (
                'date'          => date('Y-m-d'),
                'godown_code'   => $this->input->post('godown_code'),
                'type'          => $this->input->post('type'),
                'amount'        => $this->input->post('amount'),
                'remark'        => $this->input->post('remark')
            );

            $options = array(
                'title' => 'success',
                'emit'  => 'Transaction Successfully Update!',
                'btn'   => true
            );

            // insert data into parties table
            $this->data['confirmation'] = message($this->action->update('add_trx', $data, array('id' => $id)), $options);
            $this->session->set_flashdata("confirmation", $this->data["confirmation"]);
            redirect("loan_new/loan_new/add_trx", "refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan_new/nav', $this->data);
        $this->load->view('components/loan_new/edit_trx', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    
    public function all_trx() {
        $this->data['subMenu'] = 'data-target="all_trx"';
        $this->data['confirmation'] = null;

        $where = array();
        
        // read client Name
        $this->data['allClients'] = get_result('loan_new');
        
        if(isset($_POST['show'])){
            $where = array();
            if(isset($_POST['search'])){
                
                foreach($_POST['search'] as $key => $value){
                    if($key == 'person_code' && $value != null){
                        $where['add_trx.person_code'] = $value;
                    }
                    if($key == 'type' && $value != null){
                        $where['add_trx.type'] = $value;     
                    }
                    
                }
            }

            if(isset($_POST['date'])){
                foreach($_POST['date'] as $key => $value){
                    if($key == 'from' && $value != null) {
                        $where['add_trx.date >='] = $value;
                    }
                    if($key == 'to' && $value != null){
                        $where['add_trx.date <= '] = $value;
                    }
                }
            }
        }
        
        $joinCond = 'add_trx.godown_code=godowns.code';
        $select = ['add_trx.*', 'godowns.name as godown_name'];
        $this->data['allInfo'] = get_join('add_trx', 'godowns', $joinCond, $where, $select);
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan_new/nav', $this->data);
        $this->load->view('components/loan_new/all_trx', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function delete_trx ($id=null) {
        $where = array(
            'id'    => $id
        );
            
        $msg= array(
            'title' => 'delete',
            'emit'  => 'Transaction Successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation']=message($this->action->deletedata('add_trx', $where), $msg);
        $this->session->set_flashdata("confirmation", $this->data['confirmation']);
        redirect("loan_new/loan_new/all_trx", "refresh");
    }
    
    
    public function ledger() {
        $this->data['subMenu'] = 'data-target="ledger"';
        $this->data['confirmation'] = null;
        $this->data['all'] = $this->action->read('loan_new');
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan_new/nav', $this->data);
        $this->load->view('components/loan_new/ledger', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
}
