<?php
class Showroom extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->holder();
        $this->load->model('action');
        
        $this->data['meta_title'] = 'Showroom';
        $this->data['active'] = 'data-target="showroom-menu"';
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->data['showroom_id'] = showroomId("showroom");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/showroom/nav', $this->data);
        $this->load->view('components/showroom/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function addShowroom() {
        $this->data['confirmation'] = null;

        foreach ($_POST["type"] as $value) {
            $data=array(
                'name'         => $this->input->post('name'),
                'showroom_id'  => strtolower(str_replace(" ", "-", $this->input->post('showroom_id'))),
                'type'         => $value,
                'supervisor'   => $this->input->post('supervisor'),
                'mobile '      => $this->input->post('contact_number'),
                'address'      => $this->input->post('address'),
                'balance'      => $this->input->post('balance')
            );
            $msg = array(
                'title'=>'success',
                'emit'=>'Showroom Successfully Saved!',
                'btn'=>true
            );
            $w_msg = array(
                'title'=>'warning',
                'emit'=>'<p>This showroom already exists!</p>',
                'btn'=>true
            );

            $where = array(
                'showroom_id'=> $this->input->post('showroom_id'),
                'type'      => $value
            );

            if($this->action->exists('showroom', $where)) {
                $this->data['confirmation'] = message('warning', $w_msg);
            } else {
                $this->data['confirmation'] = message($this->action->add('showroom', $data), $msg);
            }
        }

        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('showroom/showroom','refresh');

    }


    public function view_all() {
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/showroom/nav', $this->data);
        $this->load->view('components/showroom/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    public function edit($s_id = NULL) {
        $this->data['subMenu'] = 'data-target="all"';

        $this->data['s_id'] = $s_id;
        $this->data['info']=$this->action->read("showroom", array('showroom_id'=> $s_id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/showroom/nav', $this->data);
        $this->load->view('components/showroom/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

	public function editShowroom($s_id=NULL) {
        $this->data['confirmation'] = null;

        foreach ($_POST["type"] as $value) {
            $data=array(
                'name'         => $this->input->post('name'),
                'showroom_id'  => strtolower(str_replace(" ", "-", $this->input->post('showroom_id'))),
                'type'         => $value,
                'supervisor'   => $this->input->post('supervisor'),
                'mobile '      => $this->input->post('contact_number'),
                'address'      => $this->input->post('address'),
                'balance'      => $this->input->post('balance')
            );

            $msg_array=array(
                'title'=>'update',
                'emit'=>'Showroom Successfully Updated!',
                'btn'=>true
            );
            $where = array(
                'showroom_id'=> $s_id,
                'type' =>$value
            );
            $this->data['confirmation'] = message($this->action->update('showroom',$data,$where),$msg_array);
        }
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('showroom/showroom/view_all','refresh');
    }


    public function deleteShowroom($s_id=NULL) {
      $this->data['confirmation'] = null;

       $msg_array=array(
            'title'=>'delete',
            'emit'=>'Showroom Successfully Deleted!',
            'btn'=>true
         );

        $this->data['confirmation']=message($this->action->deleteData('showroom',array('showroom_id'=> $s_id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('showroom/showroom/view_all','refresh');

    }
    
    public function headoffice_balance(){
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;
        
        if(isset($_POST['save'])){
           $data = array(
		"date" 	        => date("Y-m-d"),
		"showroom_id"   => "godown",
		"balance"      => $_POST['balance']
           );
           
           $where = array(
               "date" 	     => date("Y-m-d"),
               "showroom_id" => "godown"
            );
           
           if($this->action->exists("godown_balance",$where)){
              $options = array(
               "title" => "update",
               "emit"   => "Balance Successfully Updated",
               "btn"    => true
              );
            
            $this->data['confirmation'] = message($this->action->update("godown_balance",$data,$where),$options);
           }else{
           $options = array(
               "ttitle" => "success",
               "emit"   => "Balance Successfully Saved",
               "btn"    => true
              );
            
            $this->data['confirmation'] = message($this->action->add("godown_balance",$data),$options);
           }
           
           $this->session->set_flashdata("confirmation",$this->data['confirmation']);
           redirect("showroom/showroom/headoffice_balance","refresh");
        }
        
        $balance = $this->action->readOrderby("godown_balance","date",array("date <" => date("Y-m-d")),"desc"); 
        
        
        $this->data['openingBalance'] = ($balance)? $balance[0]->balance : 0.00;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/showroom/nav', $this->data);
        $this->load->view('components/showroom/head-office-balance', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    private function holder(){
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
