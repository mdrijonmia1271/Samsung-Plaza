<?php

class Fixed_assate extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('action');
        $this->data['meta_title'] = 'Fixed assate';
    }
    
    public function index() {
        $this->data['active']  = 'data-target="fixed_assate_menu"';
        $this->data['subMenu'] = 'data-target="field"';        
        
        // Update field name
        if($this->input->post('update')){
            $data = array("field_fixed_assate"=> str_replace(" ","_",$this->input->post('new_name')));
            $where = array('id' => $this->input->post('id'));
            
            // update fixed_assate_field in fixed_assate table
            $this->action->update('fixed_assate_field',$data,$where);
            
            $msg = array(
                'title' =>"success",
                'emit'  =>"Field of Fixed assate successfully Update!",
                'btn'   =>true
            );
            
            $this->data['confirmation'] = message('success',$msg);
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("fixed_assate/fixed_assate","refresh");
        }
        
        $this->data['fixed_asset_filed'] = $this->action->read('fixed_assate_field');
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/fixed_assate/nav', $this->data);
        $this->load->view('components/fixed_assate/fieldfixed_assate', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function add(){
        $data = array("field_fixed_assate"=> str_replace(" ","_",$this->input->post('field_fixed_assate')));

        $options1=array(
            'title' =>"update",
            'emit'  =>"Field of Fixed assate successfully update!",
            'btn'   =>true
        );

        $options2=array(
            'title' =>"success",
            'emit'  =>"Field of Fixed assate successfully saved!",
            'btn'   =>true
        );

        if($this->action->exists('fixed_assate_field',$data)){
            $this->data['confirmation']=message($this->action->update("fixed_assate_field",$data,$data),$options1);
        }else{
            $this->data['confirmation']=message($this->action->add("fixed_assate_field",$data),$options2);
        }

        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("fixed_assate/fixed_assate","refresh");
    }

    public function newfixed_assate() {
        $this->data['active']  = 'data-target="fixed_assate_menu"';
        $this->data['subMenu'] = 'data-target="new"';
        
        $this->data['fixed_assate_fields']=$this->action->readDistinct('fixed_assate_field',"field_fixed_assate");

        // print_r($this->data['fixed_assate_fields']);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/fixed_assate/nav', $this->data);
        $this->load->view('components/fixed_assate/new', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }


    public function add_new_fixed_assate(){
        $data=array(
         "date"        => $this->input->post('date'),
         "godown_code" => $this->input->post('godown_code'),
         "field_fixed_assate"  => str_replace(" ","_",$this->input->post('field_fixed_assate')),
         "description" =>$this->input->post('description'),
         "quantity"    =>$this->input->post('quantity'),
         "amount"      =>$this->input->post('amount'),
         "spend_by"    =>$this->input->post('spend_by')
        );      

        $options=array(
            'title' =>"success",
            'emit'  =>"Fixed assate successfully saved!",
            'btn'   =>true
        );
        
        $this->data['confirmation']=message($this->action->add("fixed_assate",$data),$options);        

        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("fixed_assate/fixed_assate/newfixed_assate","refresh");
    }

    public function allfixed_assate() {
        $this->data['active']  = 'data-target="fixed_assate_menu"';
        $this->data['subMenu'] = 'data-target="all"';

        $this->data['fixed_assate_fields'] =$this->action->readDistinct('fixed_assate_field',"field_fixed_assate");

        $where = ['trash' => 0];

        if(isset($_POST['show'])){
            $where = array('trash'=> 0);
            foreach ($_POST['search'] as $key => $value) {
                if(!empty($value)){
                    $where[$key] = $value;
                }
            }
            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['godown_code'] = $this->data['branch'];
            }
           /* foreach ($_POST['date'] as $key => $value) {
                if(!empty($value) && $key == "from"){
                    $where['date >='] = $value;
                }
				
                if(!empty($value) && $key == "to"){
                    $where['date <='] = $value;
                }
            }*/
        }else{
             $where['godown_code'] = $this->data['branch'];
        }

        $this->data['fixed_assates'] = get_result('fixed_assate', $where, '', '', 'id', 'desc');

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/fixed_assate/nav', $this->data);
        $this->load->view('components/fixed_assate/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function edit($id=NULL) {
        $this->data['active']  = 'data-target="fixed_assate_menu"';
        $this->data['subMenu'] = 'data-target="all"';

        $this->data['fixed_assate']=$this->action->read('fixed_assate',array('id'=>$id));
        $this->data['fixed_assate_fields']=$this->action->readDistinct('fixed_assate_field',"field_fixed_assate");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/fixed_assate/nav', $this->data);
        $this->load->view('components/fixed_assate/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function update_fixed_assate($id=NULL){
         $data=array(
             "date"        =>$this->input->post('date'),
             "godown_code" => $this->input->post('godown_code'),
             "field_fixed_assate"  =>str_replace(" ","_",$this->input->post('field_fixed_assate')),
             "description" =>$this->input->post('description'),
             "quantity"    =>$this->input->post('quantity'),
             "amount"      =>$this->input->post('amount'),
             "spend_by"    =>$this->input->post('spend_by')
        );      

        $options=array(
            'title' =>"update",
            'emit'  =>"Fixed assate successfully updated!",
            'btn'   =>true
        );
        
        $this->data['confirmation']=message($this->action->update("fixed_assate",$data,array('id'=>$id)),$options);        

        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("fixed_assate/fixed_assate/allfixed_assate","refresh");

    }

    public function delete_field($id=NULL){
        $options=array(
            'title' =>'delete',
            'emit'  =>'This field of Fixed assate successfully Deleted!',
            'btn'   =>true
        );
        $where=array("id"=>$id);
        $this->data['confirmation']=message($this->action->deleteData('fixed_assate_field',$where),$options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('fixed_assate/fixed_assate','refresh');
    }

     public function delete_fixed_assate($id=NULL){
        $where = array("id"=>$id);
        $data =  array('trash'=>1);
        $options=array(
            'title' =>'delete',
            'emit'  =>'Fixed assate successfully Deleted!',
            'btn'   =>true
        );

        $this->data['confirmation']=message($this->action->update('fixed_assate',$data,$where),$options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('fixed_assate/fixed_assate/allfixed_assate','refresh');
    }



}