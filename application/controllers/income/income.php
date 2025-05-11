<?php
class Income extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('action');
        $this->data['meta_title']       = 'Income';
        $this->data['allGodown']        = getAllGodown();
    }
    public function index() {
        $this->data['active']  = 'data-target="income_menu"';
        $this->data['subMenu'] = 'data-target="field"';        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/field', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function add() {
        
        $data=array("field" => str_replace(" ","_",$this->input->post('income')));      
        $options1=array(
            'title' => "warning",
            'emit'  => "Field of Income Allready Exists!",
            'btn'   => true
        );
        $options2=array(
            'title' => "success",
            'emit'  => "Field of Income successfully saved.",
            'btn'   => true
        );
        if($this->action->exists('income_field',$data)){
            $this->data['confirmation']     = message("warning",$options1);
        }else{
            $this->data['confirmation']     = message($this->action->add('income_field',$data),$options2);
        }
        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("income/income","refresh");
        
    }

    public function newIncome() {
        $this->data['active']   = 'data-target="income_menu"';
        $this->data['subMenu']  = 'data-target="new"';
        $this->data['allGodowns'] = [];
        $this->data['fields']   = $this->action->readDistinct('income_field',"field");
        


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/new', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function addIncome() {
        $data=array(
         "date"         => $this->input->post('date'),
         "field"        => $this->input->post('field'),
         "godown_code"  => $this->input->post('godown_code'),
         "description"  => $this->input->post('description'),
         "amount"       => $this->input->post('amount'),
         "income_by"     => $this->input->post('income_by')
        );      

        $options=array(
            'title' => "success",
            'emit'  => "Income successfully saved!",
            'btn'   => true
        );
        
        $this->data['confirmation'] = message($this->action->add("income",$data),$options);        

        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("income/income/newIncome","refresh");
    }

    public function all() {
        $this->data['active']       = 'data-target="income_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        
        $this->data['fields']       = $this->action->readDistinct('income_field',"field");
        
        $where= ['income.trash'=>0];

        if(isset($_POST['show'])){
            
            foreach ($_POST['search'] as $key => $value) {
                if($value != NULL){
                    $where[$key]    = $value;
                }
            }

            if(!empty($_POST['godown_code'])){
                if($_POST['godown_code'] != 'all'){
                    $where['income.godown_code'] = $_POST['godown_code'];
                }
            }else{
                $where['income.godown_code'] = $this->data['branch'];
            }
            
            foreach ($_POST['date'] as $key => $value) {
                if($value != NULL && $key == "from"){
                    $where['income.date >='] = $value;
                }
                if($value != NULL && $key == "to"){
                    $where['income.date <='] = $value;
                }
            }
        }
        else{
            $where["income.godown_code"]    = $this->data['branch'];
            $where["income.date"]           = date('Y-m-d');
        }
        
        // Join `godowns` && `income` get all_data(`Khairul Islam Tonmoy`) 
        
        $joinCond = 'income.godown_code=godowns.code';
        $select = ['income.id', 'income.date', 'income.field', 'income.description', 'income.income_by', 'income.amount', 'godowns.name'];
        $this->data['income']   = get_join('income', 'godowns', $joinCond, $where, $select);
        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function edit($id=NULL) {
        $this->data['active']   = 'data-target="income_menu"';
        $this->data['subMenu']  = 'data-target="all"';

        $this->data['income']   = $this->action->read('income',array('id'=>$id));
        $this->data['fields']   = $this->action->readDistinct('income_field',"field");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function update($id=NULL) {
         $data=array(
             "date"        => $this->input->post('date'),
             "field"       => $this->input->post('field'),
             "godown_code" => $this->input->post('godown_code'),
             "description" => $this->input->post('description'),
             "amount"      => $this->input->post('amount'),
             "income_by"   => $this->input->post('income_by')
        );      
        $options=array(
            'title' => "update",
            'emit'  => "Income successfully updated!",
            'btn'   => true
        );
        $this->data['confirmation']     = message($this->action->update("income",$data,array('id'=>$id)),$options);
        $this->session->set_flashdata("confirmation",$this->data['confirmation']);
        redirect("income/income/all","refresh");
    }
    
    public function edit_field($id=NULL) {
        $this->data['active']   = 'data-target="income_menu"';
        $this->data['subMenu']  = 'data-target="all"';

        $this->data['fields']   = $this->action->read('income_field',array('id' => $id));
        
        if($this->input->post('update')){
        
            $data=array(
                "field"       => $this->input->post('field')
            );      
            $options=array(
                'title' => "update",
                'emit'  => "Income field successfully updated!",
                'btn'   => true
            );
            $this->data['confirmation']     = message($this->action->update("income_field",$data,array('id'=>$id)),$options);
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("income/income/","refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/edit_field', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function delete_field($id=NULL) {
        $options=array(
            'title' => 'delete',
            'emit'  => 'This field of Income successfully Deleted!',
            'btn'   => true
        );
        $where=array("id"=>$id);
        $this->data['confirmation']     = message($this->action->deleteData('income_field',$where),$options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('income/income','refresh');
    }

     public function delete_income($id=NULL) {
        $where = array("id"     => $id);
        $data =  array('trash'  => 1);
        $options=array(
            'title' => 'delete',
            'emit'  => 'Income successfully Deleted!',
            'btn'   => true
        );
        $this->data['confirmation']     = message($this->action->update('income',$data,$where),$options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('income/income/all','refresh');
    }
    
    public function rent() {
        $this->data['active']  = 'data-target="income_menu"';
        $this->data['subMenu'] = 'data-target="rent"'; 
        
        $this->data['fields']   = $this->action->readDistinct('income_field',"field");
        
        if($this->input->post('save')){
            $data=array(
                "date"         => $this->input->post('date'),
                "field"        => $this->input->post('field'),
                "year"         => $this->input->post('year'),
                "month"        => $this->input->post('month'),
                "amount"       => $this->input->post('amount'),
                "received_by"  => $this->input->post('received_by'),
                "remark"       => $this->input->post('remark')
            );      
    
            $options=array(
                'title' => "success",
                'emit'  => "Rent successfully saved!",
                'btn'   => true
            );
            
            $this->data['confirmation'] = message($this->action->add("rent",$data),$options);
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("income/income/rent","refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/rent', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function allRent() {
        $this->data['active']       = 'data-target="income_menu"';
        $this->data['subMenu']      = 'data-target="all_rent"';
        
        $this->data['fields']       = $this->action->readDistinct('income_field',"field");
    
        $where=array('date' => date('Y-m-d'));
        if(isset($_POST['show'])){
            $where = array('trash'=> 0);
            foreach ($_POST['search'] as $key => $value) {
                if($value != NULL){
                    $where[$key]    = $value;
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
        }
        $this->data['rentInfo']   = $this->action->read('rent', $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/all_rent', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function rentRecipt($id=NULL) {
        $this->data['active']   = 'data-target="income_menu"';
        $this->data['subMenu']  = 'data-target="all_rent"';

        $this->data['rentInfo'] = $this->action->read('rent',array('id'=>$id));
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/rent_recipt', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function editRent($id=NULL) {
        $this->data['active']   = 'data-target="income_menu"';
        $this->data['subMenu']  = 'data-target="all_rent"';

        $this->data['rent']   = $this->action->read('rent',array('id'=>$id));
        $this->data['fields']   = $this->action->readDistinct('income_field',"field");
        
        if($this->input->post('update')){
            $data=array(
                "date"         => $this->input->post('date'),
                "field"        => $this->input->post('field'),
                "year"         => $this->input->post('year'),
                "month"        => $this->input->post('month'),
                "amount"       => $this->input->post('amount'),
                "received_by"  => $this->input->post('received_by'),
                "remark"       => $this->input->post('remark')
            );      
            $options=array(
                'title' => "update",
                'emit'  => "Rent successfully updated!",
                'btn'   => true
            );
            $this->data['confirmation']     = message($this->action->update("rent",$data,array('id'=>$id)),$options);
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("income/income/allRent","refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/income/nav', $this->data);
        $this->load->view('components/income/edit_rent', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function delete_rent($id=NULL) {
        $where = array("id"     => $id);
        $options=array(
            'title' => 'delete',
            'emit'  => 'Rent successfully Deleted!',
            'btn'   => true
        );
        $this->data['confirmation']     = message($this->action->deletedata('rent', $where), $options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('income/income/allRent','refresh');
    }
}