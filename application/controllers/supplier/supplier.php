<?php
class Supplier extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index() {
        $this->data['meta_title']   = 'add';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        // get all godowns
        $this->data['allGodowns'] = getAllGodown();

        //Generate Unqiue ID
        $this->data['party_code'] = supplierUniqueId('parties');

        if($this->input->post('add')){
            $data = array(
                'opening'        => date('Y-m-d'),
                'godown_code'    => $this->input->post('godown_code'),
                'code'           => $this->input->post('code'),
                'name'           => $this->input->post('name'),
                'contact_person' => $this->input->post('contact_person'),
                'mobile'         => $this->input->post('mobile'),
                'address'        => $this->input->post('address'),
                'type'           => "supplier",
                //'initial_balance'=> $this->input->post('balance')
                'initial_balance'=> ($_POST['status'] == 'payable') ? (0 - $this->input->post('balance')) : $this->input->post('balance')
            );

            $options = array(
                'title' => 'success',
                'emit'  => 'Supplier Successfully Saved!',
                'btn'   => true
            );

            $this->data['confirmation']= message($this->action->add('parties', $data), $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('supplier/supplier','refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function view_all() {
        $slug = $this->uri->segment(4); 
		if($slug != 'due'){  
    		$this->data['meta_title'] = 'all';
            $this->data['active']     = 'data-target="supplier-menu"';
            $this->data['subMenu']    = 'data-target="all"';
		    
		}else{
		
            $this->data['meta_title'] = 'all';
            $this->data['active']     = 'data-target="due_list_menu"';
            $this->data['subMenu']    = 'data-target="supplier_due"';		
		    
        }
        
        
        // get all godown
        $this->data['allGodowns'] = getAllGodown();

	   // get all vendors
        $this->data['allParty'] = $this->getAllparty();
        
        $where = array("type" => "supplier","trash" =>0);
        
        if(isset($_POST['show'])){
            if(!empty($_POST['code'])){
                $where["code"] = $_POST['code'];
            }

            if(!empty($_POST['godown_code'])){
                $where["godown_code"] = $_POST['godown_code'];
            }
        }
        
        $this->data['results'] = $this->action->read("parties", $where);
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        if($slug != 'due'){ 
            $this->load->view('components/supplier/nav', $this->data);
        }else{
            $this->load->view('components/due_list/nav', $this->data);  
        }
        $this->load->view('components/supplier/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function preview($id=null) {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="supplier-menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $where = array('id' => $id);
        $this->data['partyInfo'] = $this->action->read("parties",$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/preview', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function edit($id=null) {
        $this->data['meta_title']   = 'edit';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array('id' => $id);

        if($this->input->post('update')){
            $data = array(
                'opening'        => date('Y-m-d'),
                'name'           => $this->input->post('name'),
                'contact_person' => $this->input->post('contact_person'),
                'mobile'         => $this->input->post('mobile'),
                'address'        => $this->input->post('address'),
                'status'         => $this->input->post('status'),
                //'initial_balance'=> $this->input->post('initial_balance')
                'initial_balance'=> ($_POST['balance_type'] == 'payable') ? (0 - $this->input->post('initial_balance')) : $this->input->post('initial_balance')
            );
            $options = array(
                "title" => "Success",
                "emit"  => "Supplier Updated Successfully",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->update('parties', $data, $where), $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('supplier/supplier/view_all','refresh');
        }

        $this->data['info'] = $this->action->read('parties',$where);        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }



    /**
     * table: partytransaction,partytransactionmeta,saprecords,sapitems,parties
     * 
     * parties using party-code
     * partyBalance using party-code
     * partymeta using party-code
     * partytransaction using party-code
     * partytransactionmeta using partytransaction:id
     *
     * saprecords using party-code
     * update sapmeta table using saprecords:voucher-number
     * update sapitems table using saprecords:voucher-number
     * 
     */
    public function delete($code) {
        $data  = array("trash" => 1);

        // update party-transaction-meta table using id from party-transaction table
        $where = array("party_code" => $code);
        $transactionRec = $this->action->read('partytransaction', $where);

        if($transactionRec != null) {
            foreach ($transactionRec as $key => $value) {
                $where = array('transaction_id' => $value->id);
                $this->action->update('partytransactionmeta', $data, $where);
            }
        }

        // update party-transaction table using party-code
        $where = array("party_code" => $code);
        $this->action->update('partytransaction', $data, $where);

        // update sapitems and sapmeta table using voucher-number from saprecords
        $sapRec = $this->action->read("saprecords", $where);

        if($sapRec != null) {
            foreach ($sapRec as $key => $row) {
                $where = array("voucher_no" => $row->voucher_no);

                // update sapmeta
                $this->action->update('sapmeta', $data, $where);

                // update sapitems
                $this->action->update('sapitems', $data, $where);
            }
        }

        // update saprecords table using party-code from patries
        $where = array("party_code" => $code);
        $this->action->update('saprecords', $data, $where);

        // update parties table using party-code
        $where = array("code" => $code);
        $status = $this->action->update('parties', $data, $where);

        $msg_array = array(
            "title" =>"delete",
            "emit"  =>"Supplier Successfully Deleted",
            "btn"   => true
        );

        $this->session->set_flashdata("confirmation", message($status, $msg_array));

        redirect('supplier/supplier/view_all', 'refresh');
    }
    
    
    private function getAllparty(){
        $where = array(
            "type"   => "supplier",
            "status" => "active",
            "trash"   => 0
        );
        $party = $this->action->read("parties", $where);
        return $party;
    }
}
