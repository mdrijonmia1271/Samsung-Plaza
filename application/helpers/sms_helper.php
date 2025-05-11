<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );


 /*
  RESRT API
 *
 * MRAM Technologies Ltd.
 * send sms the application
 */
 

function send_sms($gsm, $txt) {
	
	
	
	$mobile  = '88' . str_replace('-', '', trim($gsm));
	$url = "https://sms.mram.com.bd/smsapi";
	$data = [
    "api_key" => "C300060764da21728a3f86.38597981",
    "type" => "text",
    "contacts" => $mobile,
    "senderid" => "8809601013183",
    "msg" => "$txt",
  ];
   
   //Getting SMS report Start here
    $CI            = & get_instance();
    $CI->load->model("action");
    $total_sms     = config_item("total_sms");
    $sent_sms_data = $CI->action->read_sum("sms_record","total_messages",array("delivery_report"=>"1"));
    $sent_sms      = $sent_sms_data[0]->total_messages;
   
  if ($sent_sms < $total_sms) {
	  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $contents = curl_exec($ch);
  curl_close($ch);
  
  if ($contents){
        	 return true;
        } else {
            return false;
        }
	
 } else {
            return false;
 }	
  //return $contents;
} 

?>