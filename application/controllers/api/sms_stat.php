<?php
class Sms_stat extends APIController {
	
	private $sms_info = array();
	
	function __construct() {
	        parent::__construct();       
	}

	// get sms statistics
	public function get_sms_statistics() {	
	 $total_sms = $sent_sms = $remaining_sms = 0;	
	 
         $this->sms_info['total_sms']= $total_sms = config_item('total_sms');  
         
         $where = array("delivery_report"  => 1);
         $sms = $this->action->read("sms_record",$where);
         
         if($sms != NULL){
           foreach($sms as $key=> $value){
              $sent_sms += $value->total_messages;
           }
         }
         
         $this->sms_info['total_sent_sms'] = $sent_sms;
         $this->sms_info['remaining_sms']  =  $total_sms - $sent_sms;
         
	 $sms_statistics = json_encode($this->sms_info);
	
	 echo $sms_statistics;
	}	

}
