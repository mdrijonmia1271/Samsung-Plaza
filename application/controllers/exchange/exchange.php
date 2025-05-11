<?php
class Exchange extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title'] = 'Exchange';
        $this->data['active'] = 'data-target="exchange_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = $this->data['stock'] = null;
        
        $this->data['stock'] = $this->action->read("stock");
        
        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/exchange/nav', $this->data);
        $this->load->view('components/exchange/add', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

    public function newExchange() {  
        $this->data['confirmation'] = null;
        $data = array(
            'date'          => date('Y-m-d'),
            'receive_code'  => trim($this->input->post('receive')),
            'receiveqty'    => $this->input->post('receiveQty'),
            'given_code'    => trim($this->input->post('given')),
            'givenqty'      => $this->input->post('givenQty')
        );
        $msg_array = array(
            'title' => 'success',
            'emit'  => 'Exchange Product Successfully Saved!',
            'btn'   => true
        );
        // for code receive Quantity
        $where = array('code'=>trim($this->input->post('receive')));
        $receiveQuantity = $this->action->read('stock',$where);
        $calculateQuantity = $receiveQuantity[0]->quantity + $this->input->post('receiveQty');
       
        // for code given Quantity
        $where1 = array('code'=>trim($this->input->post('given')));
        $givenQuantity = $this->action->read('stock',$where1);
        $givenCalQuantity = $givenQuantity[0]->quantity - $this->input->post('givenQty');

        $receiveData = array(
            'quantity'=> $calculateQuantity
        );
        
        $givenData = array(
            'quantity'=> $givenCalQuantity
        );
        
        $this->data['confirmation'] = message($this->action->add('exchange',$data),$msg_array);
        
        $this->action->update('stock',$receiveData,$where);
        $this->action->update('stock',$givenData,$where1);
        
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('exchange/exchange','refresh');
    }


    public function all() {
        $this->data['meta_title'] = 'Exchange';
        $this->data['active'] = 'data-target="exchange_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        $this->data['exchange'] = $this->action->read("exchange");
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/exchange/nav', $this->data);
        $this->load->view('components/exchange/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

     public function editExchange($id = NULL) {       
        $this->data['active'] = 'data-target="exchange_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['category'] = null;
        
        $this->data['products'] = $this->action->read("products");
        $this->data['stock'] = $this->action->read("stock");

        $this->data['id'] = $id;
        $this->data['exchange'] = $this->action->read("exchange", array('id' => $id));
        
        
        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/exchange/nav', $this->data);
        $this->load->view('components/exchange/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function edit($id=NULL) {  
        
        $this->data['confirmation'] = null;
        $data = array(
            'receive_code'  => trim($this->input->post('receive')),
            'receiveqty'    => $this->input->post('receiveQty'),
            'given_code'    => trim($this->input->post('given')),
            'givenqty'      => $this->input->post('givenQty')
        );
        $options = array(
            'title' => 'update',
            'emit'  => 'Exchange Product Successfully Updated!',
            'btn'   => true
        );
        
        
        $exchange_data = $this->action->read("exchange", array('id' => $id));

        // for code receive Quantity
        $where = array('code'=>trim($this->input->post('receive')));
        
        $receiveQuantity = $this->action->read('stock',$where);
        
        
        if($this->input->post('receiveQty') >= $exchange_data[0]->receiveqty ){
            
           // $calculateQuantity = ($receiveQuantity[0]->quantity) - ($exchange_data[0]->receiveqty - $this->input->post('receiveQty'));
            $total = ($this->input->post('receiveQty') - $exchange_data[0]->receiveqty );
            $calculateQuantity = $receiveQuantity[0]->quantity + $total ;
        }
        else{
            $total = $exchange_data[0]->receiveqty - $this->input->post('receiveQty') ;
            $calculateQuantity = $receiveQuantity[0]->quantity - $total;
        }
        
        
        // for code given Quantity
        $where1 = array('code'=>trim($this->input->post('given')));
        $givenQuantity = $this->action->read('stock',$where1);
        
        
        if($exchange_data[0]->givenqty > $this->input->post('givenQty')){
            $givenCalQuantity = ($givenQuantity[0]->quantity) + ($exchange_data[0]->givenqty - $this->input->post('givenQty'));
        }
        elseif($exchange_data[0]->givenqty < $this->input->post('givenQty')){
            $subQantity = $this->input->post('givenQty') - ($exchange_data[0]->givenqty);
            $givenCalQuantity = ($givenQuantity[0]->quantity - $subQantity);
        }
        else{
            $givenCalQuantity = $givenQuantity[0]->quantity;
        }
        
        $receiveData = array(
            'quantity'=>$calculateQuantity
        );
        
        $givenData = array(
            'quantity'=>$givenCalQuantity
        );
        
        
        
        //update stock table data
        $this->action->update('stock',$receiveData,$where);
        $this->action->update('stock',$givenData,$where1);
       
       
        //update exchange table data
        $status = $this->action->update('exchange', $data, array('id' => $id));
        
        $this->data['confirmation'] = message($status, $options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('exchange/exchange/all','refresh');
    }

    public function delete($id=NULL) {  
        $this->data['confirmation'] = null;
        $msg_array=array(
            'title'=>'delete',
            'emit'=>'Exchange Product Successfully Deleted!',
            'btn'=>true
        );
        $this->data['confirmation']=message($this->action->deleteData('exchange',array('id'=>$id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('exchange/exchange/all','refresh');
    }
    
    private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
}