<?php

class DeleteSale extends Admin_Controller
{
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('action');
    }

    /**
    * Delete Sale and update stock
    * table : saprecords,sapitems,stock,partytransaction
    * Strategy:
    *   Update column trash 0 to 1
    *   Update Stock quantity by code
    *
    **/
    
    public function index()
    {
        
        $where = array('voucher_no' => $this->input->get('vno'));
        $saleInfo = $this->action->read('sapitems', $where);

        foreach ($saleInfo as $value) {
            // set condition for every item
           if($value->product_serial != ''){
                $stockWhere = array(
                    "code"           => $value->product_code,
                    "godown_code"    => $value->godown_code,
                    "product_serial" => $value->product_serial
                );
    
                // get stock information
                $stockInfo = $this->action->read('stock', $stockWhere);
    
                // caltulate new quantity
                if($stockInfo != null){
                    $quantity = $stockInfo[0]->quantity + $value->quantity;
                    $data = array('quantity' => $quantity);
    
                    // update the stock
                    $this->action->update('stock', $data, $stockWhere);
                }
           }
        }

        // Update row
        $data = array("trash" => 1);
        $response = $this->action->update('sapitems', $data, $where);
        $response = $this->action->update('saprecords', $data, $where);
        $response = $this->action->update('sapmeta', $data, $where);
        $this->action->update('partytransaction', $data, array("relation" => "sales:".$this->input->get('vno')));
        
        $options = array(
            'title' => 'delete',
            'emit'  => 'Sale delete successfully!',
            'btn'   => true
        );
        
        $this->session->set_flashdata('confirmation', message('danger', $options));
        redirect('sale/search_sale', 'refresh');
    }
}
