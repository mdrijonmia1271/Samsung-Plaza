<?php

class ChangeQuery extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action'); 
    }
    
    public function index() {
        die();
    	
    	echo "<pre>";
    	$records = custom_query("SELECT id, product_serial, quantity FROM `sapitems` WHERE status='purchase' AND trash=0 ");
    	
    	foreach($records as $row){
    	    
    	    $itemData = [];
    	    
    	    $stockInfo = custom_query("SELECT product_serial FROM stock WHERE item_id='$row->id'");
    	    if(!empty($stockInfo)){
    	        foreach($stockInfo as $item){
    	            array_push($itemData, $item->product_serial);
    	        }
    	    }
    	    
    	    $productSerial = implode(", ", $itemData);
    	    
    	    if($row->quantity == count($stockInfo)){
    	           save_data('sapitems', ['product_serial' => $productSerial], ['id' => $row->id]);
    	    }
    	}
    	
    	
    	print_r($records);
    	die();
    }

}
