<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



//Privilege Related functions Start here

function ck_menu($menu){
    $CI = & get_instance();
    $CI->load->model('action');
    $privilege = $CI->data["privilege"];
    $user_id = $CI->data["user_id"];

    if($privilege=="super"){
        return true;
    }

    $where = array(
        "privilege_name" => $privilege,
        "user_id" => $user_id
    );

    $data = $CI->action->read("privileges",$where);
    if($data==null){
        return false;
    }

    $access_array = json_decode($data[0]->access,true);
    $access_array = array_keys($access_array);

    if(in_array($menu,$access_array)){
        return true;
        //echo "Matched";
    }
    //return false;
}


function ck_action($menu,$action){
    $CI = & get_instance();
    $CI->load->model('action');
    $privilege = $CI->data["privilege"];
    $user_id = $CI->data["user_id"];

    if($privilege=="super"){
        return true;
    }

    $where = array(
        "privilege_name" => $privilege,
        "user_id"        => $user_id
    );

    $data = $CI->action->read("privileges",$where);
    
    if($data==null){
        return false;
    }

    $access_array = json_decode($data[0]->access,true);
    //return $access_array;

    if(!array_key_exists($menu,$access_array)){
        return false;
    }

    if(in_array($action,$access_array[$menu])){
        return true;
    }
    
    return false;
}

// genetate tender code
function generator($table, $prefix = '') {
    $CI = & get_instance();
    $CI->load->model('action');
    $code = '';
    // get codeigniter instanse
    // load model
    // use model method
    $val = $CI->action->forIdGenerator($table);

    if(!empty($val)){
        $id = intval($val[0]->id) + 1;
    } else {
        $id = 1;
    }

    if($prefix != ''){
        $code = $prefix.$id;
    } else {
        $code = $id;
    }

    return $code;
}


// Generate Customer code
function customerUniqueId($table) {
    $counter = 1;

    $CI = & get_instance();
    $CI->load->model('action');

    // use model method
    $length = 3;
    $sql = $CI->action->get_max_value($table,"code",$length);
    $val = $sql[0]->last_code;
    
    if($val!=null){
        $counter =$val+1;
    }
    $counter = str_pad($counter, 5, 0, STR_PAD_LEFT);
    return $counter;
}

// Generate supplier code
function supplierUniqueId($table, $length = 3) {
    $counter = 1;

    $CI = & get_instance();
    $CI->db->where('type', 'supplier');
    $val = $CI->db->count_all_results($table);
    
    if($val!=null){
        $counter =$val+1;
    }
    $counter =str_pad($counter,$length,0, STR_PAD_LEFT);
    return $counter;
}

//Generate client Unique ID
function clientUniqueId($table, $length = 4) {
    $counter = 1;

    $CI = & get_instance();
    
    $CI->db->where('type', 'client');
    $val = $CI->db->count_all_results($table);
    
    if($val!=null){
        $counter =$val+1;
    }
   
    $counter =str_pad($counter,$length,0, STR_PAD_LEFT);
    return $counter;
}


function generateUniqueId($table,$digit = 4) {
    $code = '';
    $counter = 1;

    // get codeigniter instanse
    $CI = & get_instance();

    // load model
    $CI->load->model('action');

    // use model method
    $val = $CI->action->maxId($table);


    if(is_array($val)){
        $counter = intval($val[0]->maxId) + 1;
    } else {
        $counter = 1;
    }
    $counter = str_pad($counter,$digit,0,STR_PAD_LEFT);
    return $counter;
}


// Installment Collection ID
function installmentCollectionId($table, $where=array()) {
    
    $code = '';
    $counter = 1;
    
    $CI = & get_instance();
    $CI->load->model('action');
    
    // use model method
    $val = $CI->action->read($table, $where, 'desc');    

    if($val != null){
        $counter = intval($val[0]->id) + 1; //count($val) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='0000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 3) {
        $counter ='00' . $counter;
    }  elseif(strlen($counter) == 4) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = 'INS-' .$counter;
    return $code;
}

// Installment Collection ID
function transactionCollectionId($table, $where=array()) {
    
    $code = '';
    $counter = 1;
    
    $CI = & get_instance();
    $CI->load->model('action');
    
    // use model method
    $val = $CI->action->read($table, $where, 'desc');

    if($val != null){
        $counter = intval($val[0]->id) + 1; //count($val) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='0000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 3) {
        $counter ='00' . $counter;
    }  elseif(strlen($counter) == 4) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = 'TRX-' .$counter;
    return $code;
}


// LPR ID
function lprId($table, $where=array()) {

    $code = '';
    $counter = 1;
    
    $CI = & get_instance();
    $CI->load->model('action');
    
    // use model method
    $val = $CI->action->read($table, $where, 'desc');    

    if($val != null){
        $counter = intval($val[0]->id) + 1; //count($val) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='0000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 3) {
        $counter ='00' . $counter;
    }  elseif(strlen($counter) == 4) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = 'LPR-' .$counter;
    return $code;
}



// genetate showroom id
function showroomId($table) {
    $code = '';
    $counter = 1;
    $CI = & get_instance();
    $CI->load->model('action');
    // use model method
    $val = $CI->action->maxId($table);


    if(is_array($val)){
        $counter = intval($val[0]->maxId) + 1;
    } else {
        $counter = 1;
    }

    if(strlen($counter) == 1) {
        $counter = '0' . $counter;
    } else {
        $counter =  $counter;
    }
    return $counter;
}


// genetate voucher no
function generate_voucher($table, $where=array(), $prefix = '') {
    $code = '';
    $counter = 1;
    $CI = & get_instance();
    $CI->load->model('action');
    // use model method
    $val = $CI->action->read($table, $where, 'desc');    
    

    if($val != null){
        $counter = count($val) + 1; //intval($val[0]->id) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='0000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 3) {
        $counter ='00' . $counter;
    }  elseif(strlen($counter) == 4) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = date('y') . date('m') .$counter;
    return $code;
}



// genetate invoice no
function generate_invoice($table, $where=array()) {
    $code = '';
    $counter = 1;
    $CI = & get_instance();
    $CI->load->model('action');
    // use model method
    $val = $CI->action->read($table, $where, 'desc');
    
    
   if($val != null){
        $counter =  count($val) + 1; //intval($val[0]->id) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='0000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 3) {
        $counter ='00' . $counter;
    } elseif(strlen($counter) == 4) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = $counter;
    return $code;
}


// genetate batch no
function generate_batch($table, $where=array(), $prefix = '') {
    $code = '';
    $counter = 1;
    $CI = & get_instance();
    $CI->load->model('retrieve');
    // use model method
    $val = $CI->retrieve->read($table, $where, 'desc');

    if($val != null){
        $counter = intval($val[0]->batch_no) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='0000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 3) {
        $counter ='00' . $counter;
    }  elseif(strlen($counter) == 4) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = $counter;
    return $code;
}



// genetate memo no
function memo_no($table, $where=array(), $prefix = '') {
    $code = '';
    $counter = 1;
    $CI = & get_instance();
    $CI->load->model('retrieve');
    // use model method
    $val = $CI->retrieve->readOrderby($table, "id", $where, 'desc');

    print_r($val);

    if($val != null){
        $counter = intval($val[0]->id) + 1;
    }

    if(strlen($counter) == 1) {
        $counter ='00000' . $counter;
    } elseif(strlen($counter) == 2) {
        $counter ='0000' . $counter;
    }elseif(strlen($counter) == 3) {
        $counter ='000' . $counter;
    } elseif(strlen($counter) == 4) {
        $counter ='00' . $counter;
    }elseif(strlen($counter) == 5) {
        $counter ='0' . $counter;
    }else {
         $counter = $counter;
    }

    $code = $prefix . date('Y') ."/" .$counter;
    return $code;
}

function age($date){
    list($year, $month, $day) = explode("-", $date);

    $doy = date('Y') - $year;
    $dom = date('m') - $month;
    $dod = date('d') - $day;

    if($dod < 0 || $dom < 0) $doy--;

    return $doy;
}

/*Maruf hasan's Helper*/
function custom_fetch($var,$field){
    if (isset($var)) {
        return $var[0]->$field;
    }
}

function v_check($value){
    if ($value!=null) {
        return $value;
    }else{
        return "N/A";
    }
}

function filter($value){
    $capitalize="";
    $rmv_scor=str_replace("_"," ", $value);
    if (mb_detect_encoding($rmv_scor)!='UTF-8') {
        $capitalize=ucwords($rmv_scor);
    }else{
        $capitalize=$rmv_scor;
    }

    return $capitalize;
}


function message_length($strlength, $message = NULL){
	$messLen = 0;
	
	if (strlen($message) != strlen(utf8_decode($message))) {
      if( $strlength <= 63){ $messLen = 1; }
		else if( $strlength <= 126){ $messLen = 2; }
		else if( $strlength <= 189){ $messLen = 3; }
		else if( $strlength <= 252){ $messLen = 4; }
		else if( $strlength <= 315){ $messLen = 5; }
		else if( $strlength <= 378){ $messLen = 6; }
		else if( $strlength <= 441){ $messLen = 7; }
		else if( $strlength <= 504){ $messLen = 8; }
		else { $messLen = "Equal to an MMS."; }		
        }else{
		if( $strlength <= 160){ $messLen = 1; }
		else if( $strlength <= 306){ $messLen = 2; }
		else if( $strlength <= 459){ $messLen = 3; }
		else if( $strlength <= 612){ $messLen = 4; }
		else if( $strlength <= 765){ $messLen = 5; }
		else if( $strlength <= 918){ $messLen = 6; }
		else if( $strlength <= 1071){ $messLen = 7; }
		else if( $strlength <= 1080){ $messLen = 8; }
		else { $messLen = "Equal to an MMS."; }
		
        }
        
        return $messLen;
	
}




/*
Two Mendatory agrument
1. Module
2. Access
Module means the module's name such as Showroom,godown,employee etc.
Access means the action's access such as Edit,Delete,Update,Return etc.
*/
function is_access($module, $access){
    $CI = & get_instance();
    $CI->load->model('action');
    $privilege = $CI->data["privilege"];
    if($privilege=="super"){
        return true;
    }

    $where = array(
        "privilege_name" => $privilege,
        "module_name"    => $module
    );
    $data = $CI->action->read("privileges",$where);
    if($data==null){
        return false;
    }
    $access_array = json_decode($data[0]->access);
    if(in_array($access,$access_array)){
        return true;
    }
    else{
        return false;
    }

}

    function selected($v1,$v2){
        if($v1==$v2){
            echo "selected";
        }
    }

    function checked($v1,$v2){
        if($v1==$v2){
            echo "checked";
        }
    }

    function valid_equal($v1,$v2){
        if($v1==$v2){
            return true;
        }
        return false;
    }

/**
 * get meta Information
 *
 */
function getPartyMeta($code, $field) {
    $CI = & get_instance();
    $CI->load->model('action');

    $where['party_code'] = $code;
    $where['meta_key'] = $field;

    $resultSet = $CI->action->read('partymeta', $where);

    if($resultSet){
    	return $resultSet[0]->meta_value;
    }

	return "";
}

function getPreviousInfo($from,$code){
    $CI = & get_instance();
    $CI->load->model('action');
    $result = $CI->action->previous_balance($from,$code);
    return $result;
}

function getPreviousInfoClient($from,$code,$brand){
    $CI = & get_instance();
    $CI->load->model('action');
    $result = $CI->action->previous_balance_client($from,$code,$brand);
    return $result;
}

function metadata($table, $where=array()) {
	$CI = & get_instance();
    $CI->load->model('action');

	$resultset = $CI->action->read($table, $where);
	if($resultset != null) {
		return $resultset[0]->meta_value;
	}

	return '';
}

//Get SAP Meta
function sap_meta($where) {
    $CI = & get_instance();
    $CI->load->model('action');

    $resultset = $CI->action->read("sapmeta", $where);
    if($resultset != null) {
        $data = array();
        foreach ($resultset as $key => $res) {
            $data[$res->meta_key] = $res->meta_value;
        }
        return (object)$data;
    }

    return array();
}

function getSiteMeta($field) {
	$CI = & get_instance();
    $CI->load->model('action');

	$where = array("meta_key" => $field);
	$resultset = $CI->action->read("sitemeta", $where);

	if($resultset != null) {
		return $resultset[0]->meta_value;
	}

	return '';
}

function f_number($data, $point=null){
    if (!empty($point)){
        return number_format($data, $point);
    }
    return number_format($data);
}


//Get sale quantity
function getSaleQuantity($year,$month,$party) {
    $CI = & get_instance();
    $CI->load->model('action');
    $quantity = 0;
    
    $where = array(
      "YEAR(sap_at)"   => $year,
      "MONTH(sap_at)"  => $month,
      "party_code"     => $party,
      "status"         => "sale",
      "trash"          => 0
    );
    
    $resultset = $CI->action->read("saprecords", $where);
    
    if($resultset != null) {        
        foreach ($resultset as $key => $value) {
          $quantity += $value->total_quantity;
        }       
    }

    return $quantity;
}


//Get Sale Amount
function getSaleAmount($year,$month,$party) {
    $CI = & get_instance();
    $CI->load->model('action');
    $totalBill = 0;
    
    $where = array(
      "YEAR(sap_at)"   => $year,
      "MONTH(sap_at)"  => $month,
      "party_code"     => $party,
      "status"         => "sale",
      "trash"          => 0
    );
    
     

    $resultset = $CI->action->read("saprecords", $where);
   
    
    
    if($resultset != null) {        
        foreach ($resultset as $key => $value) {
          $totalBill += $value->total_bill;
        }       
    }

    return $totalBill;
}
