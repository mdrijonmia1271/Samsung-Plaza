<?php
class Cost extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('action');
        $this->data['meta_title'] = 'Cost';
        $this->data['allGodown']  = getAllGodown();
    }
    
    public function index() {
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="field"';  
        
        $this->data['cost_categories'] = $this->action->read('cost_category');
        
        // Update field name
        if($this->input->post('update')){
            
            $data       = [
                "cost_field"    => str_replace(" ", "_", $this->input->post('cost_field')),
                "cost_category" => $this->input->post('cost_category')
            ];
            $where      = ['id' => $this->input->post('id')];
            
            $this->action->update('cost_field', $data, $where);
            
            $msg = array(
                'title' => "success",
                'emit'  => "Field of Cost successfully Update!",
                'btn'   => true
            );
            
            $this->data['confirmation'] = message('success', $msg);
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("cost/cost", "refresh");
        }
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/fieldcost', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function add(){
        $data = [
            "cost_field"    => str_replace(" ", "_", $this->input->post('field_cost')),
            "cost_category" => $this->input->post('cost_category')
        ];

        $options1=array(
            'title' => "update",
            'emit'  => "Field of Cost successfully update!",
            'btn'   => true
        );

        $options2=array(
            'title' => "success",
            'emit'  => "Field of Cost successfully saved!",
            'btn'   => true
        );

        if($this->action->exists('cost_field', $data)){
            $this->data['confirmation'] = message($this->action->update("cost_field", $data, $data),$options1);
        }else{
            $this->data['confirmation'] = message($this->action->add("cost_field", $data), $options2);
        }

        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("cost/cost","refresh");
    }
    

    public function newcost() {
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="new"';
        
        $this->data['cost_fields']=$this->action->readDistinct('cost_field',"cost_field");
        $this->data['godowns']=$this->action->read('godowns',array('trash' => 0));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/new', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }


    public function add_new_cost(){
        
        $data=array(
            "date"            =>$this->input->post('date'),
            "godown_code"     =>$this->input->post('godown_code'),
            "cost_field"      => str_replace(" ","_",$this->input->post('cost_field')),
            "cost_category"   => $this->input->post('cost_category'),
            "description"     =>$this->input->post('description'),
            "amount"          =>$this->input->post('amount'),
            "spend_by"        =>$this->input->post('spend_by')
        );      

        $options=array(
            'title' => "success",
            'emit'  => "Cost successfully saved!",
            'btn'   => true
        );
        
        $this->data['confirmation']=message($this->action->add("cost",$data),$options);        
        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("cost/cost/newcost","refresh");
    }


    public function allcost() {
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="all"';

        $this->data['cost_fields'] = $this->action->readDistinct('cost_field', "cost_field");
        $this->data['cost_categories'] = $this->action->readDistinct('cost_category', "cost_category");

        $where = ['cost.trash' => 0];
        
        if(isset($_POST['show'])){

            foreach ($_POST['search'] as $key => $value) {
                if(!empty($value)){
                    $where["cost.$key"]    = $value;
                }
            }

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['cost.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['cost.godown_code'] = $this->data['branch'];
            }

            foreach ($_POST['date'] as $key => $value) {
                if(!empty($value) && $key == "from"){
                    $where['cost.date >='] = $value;
                }
                if(!empty($value) && $key == "to"){
                    $where['cost.date <='] = $value;
                }
            }
            
        } else {
            $where["cost.godown_code"] = $this->data['branch'];
            $where["cost.date"]        = date('Y-m-d');
        }
        
        // Join `godowns` && `cost` get all_data(`Khairul Islam Tonmoy`) 
        $joinCond = 'cost.godown_code=godowns.code';
        $select = ['cost.id', 'cost.date', 'cost.cost_field', 'cost.cost_category', 'cost.description', 'cost.spend_by', 'cost.amount', 'godowns.name'];
        $this->data['costs'] = get_join('cost', 'godowns', $joinCond, $where, $select, '', 'cost.id', 'desc');
    
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function edit($id=NULL) {
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        
        $this->data['godowns']     = $this->action->read('godowns',array('trash' => 0));
        $this->data['cost']        = $this->action->read('cost',array('id'=>$id));
        $this->data['cost_fields'] = $this->action->readDistinct('cost_field',"cost_field");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function update_cost($id=NULL){
        $data=array(
            "date"             =>$this->input->post('date'),
            "godown_code"      =>$this->input->post('godown_code'),
            "cost_field"       =>str_replace(" ", "_", $this->input->post('cost_field')),
            "cost_category"    => $this->input->post('cost_category'),
            "description"      =>$this->input->post('description'),
            "amount"           =>$this->input->post('amount'),
            "spend_by"         =>$this->input->post('spend_by')
        );      

        $options=array(
            'title' => "update",
            'emit'  => "Cost successfully updated!",
            'btn'   => true
        );
        
        $this->data['confirmation']=message($this->action->update("cost", $data, array('id'=>$id)), $options);        
        $this->session->set_flashdata("confirmation", $this->data['confirmation']);
        redirect("cost/cost/allcost", "refresh");
    }


    public function delete_field($id=NULL){
        $options=array(
            'title' => 'delete',
            'emit'  => 'This field of cost successfully Deleted!',
            'btn'   => true
        );
        $where=array("id" => $id);
        $this->data['confirmation']=message($this->action->deleteData('cost_field', $where), $options);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('cost/cost', 'refresh');
    }
    

    public function delete_cost($id=NULL){
        
        $where = array("id" => $id);
        $data  = array('trash' => 1);
        
        $options=array(
            'title' => 'delete',
            'emit'  => 'Cost successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation'] = message($this->action->update('cost',$data,$where),$options);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('cost/cost/allcost', 'refresh');
    }
}