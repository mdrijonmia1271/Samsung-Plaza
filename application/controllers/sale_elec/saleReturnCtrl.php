<?php

class SaleReturnCtrl extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu_elec"';
        $this->data['subMenu']      = 'data-target="return"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        if(isset($_POST['change'])) {
            $this->session->set_flashdata('confirmation', $this->change());

            // Sending SMS Start
           /* $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
            $content = "Your balance has been updated, your current balance is ".$this->input->post("current_balance")."Tk ".$sign;
            $num = $this->input->post("party_mobile");
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'     => date('Y-m-d'),
                'delivery_time'     => date('H:i:s'),
                'mobile'            => $num,
                'message'           => $content,
                'total_characters'  => strlen($content),
                'total_messages'    => message_length(strlen($content)),
                'delivery_report'   => $message
            );

            if($message){
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }*/
            // Sending SMS End

            // redirect("sale_elec/saleReturnCtrl?vno=". $_POST['voucher_no'], 'refresh');
            // redirect("sale/search_sale", 'refresh');
            redirect('sale_elec/viewsaleReturnCtrl?vno=' . $this->data['voucher_no'], 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale_elec/nav', $this->data);
        $this->load->view('components/sale_elec/return-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function change(){
        // update purchase record
        $total_quantity = 0;
        foreach ($_POST['id'] as $key => $value) {
            $newQuantity = 0;
            $newQuantity = ($_POST['old_quantity'][$key] - $_POST['return_quantity'][$key]);
            $total_quantity += $newQuantity;
            $data = array();
            $where = array('id' => $_POST['id'][$key]);

            $data['sap_at']         = $this->input->post('date');
            $data['quantity']       = $newQuantity;
            
            if($this->action->update('sapitems', $data, $where)){
                $this->handelStock($key);
            }
        }

        // update bill record
        $data = array(
            'total_quantity'    => $total_quantity,
            'total_bill'        => $this->input->post('new_grand_total')
        );
        
        $where = array('voucher_no' => $this->input->get('vno'));
        $status = $this->action->update('saprecords', $data, $where);
        
        $returnData = array(
            'date'           => date('Y-m-d'),
            'voucher_no'     => $this->input->get('vno'),
            'quantity'       => $total_quantity,
            'return_amount'  => $this->input->post('new_grand_total'),
            'trash'          => 0
        );
        $this->data['sale_return'] = $this->action->add("sale_return",$returnData);

        $this->handelPartyTransaction();

        $options = array(
            'title' => 'Updated',
            'emit'  => 'Sale Product successfully Return!',
            'btn'   => true
        );

        return message($status, $options);
    }

    private function handelStock($index) {
        // get stock info
        $where         = array();
        $where['code'] = $_POST['product_code'][$index];
        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = $record[0]->quantity + $_POST['return_quantity'][$index];

        // update the stock
        $data = array();
        $data = array('quantity' => $quantity);
        
        $this->action->update('stock', $data, $where);
    }

    private function handelPartyTransaction(){
        $data = array(
            'change_at' => $this->input->post('date'),
            'debit'     => $this->input->post('new_grand_total')
        );
        $where = array('relation' => 'sales:' . $this->input->get('vno'));
        $this->action->update('partytransaction', $data, $where);
        return true;
    }

}
