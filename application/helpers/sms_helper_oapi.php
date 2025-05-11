<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );





// send sms the application
function send_sms($gsm, $txt) {

    //Getting SMS report Start here
    $CI = & get_instance();
    $CI->load->model("action");
    $sent_sms = 0;
    
    $total_sms = config_item("total_sms");
    $sent_sms_data = $CI->action->read("sms_record",array("delivery_report"=>"1"));
    foreach($sent_sms_data as $key=>$value){
      $sent_sms += $value->total_messages;
    }
    
    //Getting SMS report End here

    $username = "LogicPoint";
    $password = "LogicPoint123";
    $mobile = trim($gsm);
    $url = "https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl";

    if ($sent_sms < $total_sms) {
        //Sending Request Start here
        try{
            $soapClient = new SoapClient($url);
            $paramArray = array(
                'userName'		=> $username,
                'userPassword'	=> $password,
                'mobileNumber'	=> $mobile,
                'smsText'		=> $txt,
                'type'			=> "TEXT",
                'maskName'		=> "",
                'campaignName'	=> ""
            );
            $value = $soapClient->__call("OneToOne", array($paramArray));

            if($value->OneToOneResult == 1900){
                return true;
            }

            return false;
        } catch (Exception $e) {
            echo $e;
        }
        //Sending Request End here
    }else{
        return false;
    }
}





































/*

  RESRT API
 *
 * zaman-it
 * send sms the application
 *
 
function send_sms($gsm, $txt) {

    //Getting SMS report Start here
    $CI = & get_instance();
    $CI->load->model("action");
    $total_sms = config_item("total_sms");
    $sent_sms_data = $CI->action->read_sum("sms_record","total_messages",array("delivery_report"=>"1"));
    $sent_sms = $sent_sms_data[0]->total_messages;
    //Getting SMS report End here




    // application key
    $user = '01839973100'; // merchant account username
    $pass = 'im0aJ1Kh'; // merchant account password
    $sender = 'ndcm'; // characters
    $message = str_replace(' ', '%20', $txt);
    $mobile = '88' . trim($gsm);

    if ($sent_sms < $total_sms) {

    // for long text
    $url = "http://api.zaman-it.com/api/sendsms/plain?user=$user&password=$pass&sender=$sender&SMSText=$message&GSM=$mobile";

    $c = curl_init();

    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $url);
    // set the json header
    curl_setopt($c, CURLOPT_HTTPHEADER, array(
    	'Content-Type: application/json',
	'Accept: application/json'
    ));

    $contents = curl_exec($c);
    curl_close($c);

    if ($contents){
    	// json to php array
    	// $json = json_decode($contents, true);
    	// return $contents;

    	// without header xml data format
    	// $fileContents = str_replace(array("\n", "\r", "\t"), '', $contents);
    	// $fileContents = trim(str_replace('"', "'", $fileContents));
	// $simpleXml = simplexml_load_string($fileContents);
	// $json = json_encode($simpleXml);
    	// return $json;

    	return true;
     } else {
        return false;
     }
   }else{
        return false;
    }

    // return file_get_contents( $url );
}*/
