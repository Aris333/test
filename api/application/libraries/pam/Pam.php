<?php


require_once(dirname(__FILE__)."/lib/ApiClient.php");
require_once(dirname(__FILE__)."/lib/apierror.class.php");
require_once(dirname(__FILE__)."/lib/apilist.class.php");
require_once(dirname(__FILE__)."/lib/errorcode.class.php");

class Pam
{
  public function credential($txtDeviceId=null){
         // $CI=& get_instance();
         // echo $CI->config->item('pamfax_username');  exit();

         
            if($txtDeviceId=="12345678"){
             $GLOBALS['PAMFAX_API_URL'] = "https://sandbox-api.pamfax.biz/"; //"https://api.pamfax.biz/";https://sandbox-api.pamfax.biz/
             $usename='hussain@technostacks.com'; // speedyfaxapp@gmail.com,hussain@technostacks.com
             $password='fixkociwepucor8573';   //015Annapolis,fixkociwepucor8573
             $GLOBALS['PAMFAX_API_APPLICATION'] = "hussainarif"; //hireoutinc,hussainarif
             $GLOBALS['PAMFAX_API_SECRET_WORD'] = "fixkociwepucor8573";//decaxujoogakeness6259,
            }else{
              $GLOBALS['PAMFAX_API_URL'] = "https://api.pamfax.biz/";
              $usename='speedyfaxapp@gmail.com'; // speedyfaxapp@gmail.com,hussain@technostacks.com
              $password='015Annapolis';   //015Annapolis,fixkociwepucor8573
              $GLOBALS['PAMFAX_API_APPLICATION'] = "hireoutinc"; //hireoutinc,hussainarif
              $GLOBALS['PAMFAX_API_SECRET_WORD'] = "decaxujoogakeness6259";//decaxujoogakeness6259,

            }
             
            

           // $GLOBALS['PAMFAX_API_APPLICATION'] = "technostyacks";
           // $GLOBALS['PAMFAX_API_SECRET_WORD'] = "teradooxificotion3556";
      
            // tell the API client to create objects from returned XML automatically
         $GLOBALS['PAMFAX_API_MODE'] = \ApiClient::API_MODE_JSON;
         
         $this->pamfax_use_static();

         $result = SessionApi::VerifyUser($usename,$password);
            //$result = SessionApi::VerifyUser('zaki@technostacks.com', 'teradooxificotion3556');
         $result = json_decode($result, TRUE);
         //echo "<pre>"; print_r($result); exit();
         return $result;

  }

  public function sendFax($filepath=array(),$txtDeviceId,$r_number) {
       
      
            $result=$this->credential($txtDeviceId); // call to credential funct.
       
            if (($result instanceof ApiError) // explicit error 
                    || !isset($result['UserToken']) || !isset($result['User'])) // implicit error 
                die("Unable to login");

            // set the global usertoken
            $GLOBALS['PAMFAX_API_USERTOKEN'] = $result['UserToken']['token'];
            $currentUser = $result['User'];
          

            if ($currentUser == true) 
            {

                // create a new fax and give the users IP, UserAgent and an origin
                FaxJobApi::Create($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], 'API Samples');
                // add a recipient to the fax
               $getreciptiantuuid=FaxJobApi::AddRecipient($r_number, 'TS testing'); 
               
               $reciptianuuid = json_decode($getreciptiantuuid,TRUE);
               
                if(isset($reciptianuuid['FaxRecipient']['uuid']) && !empty($reciptianuuid['FaxRecipient']['uuid']))
                {
                  $reciptian_uuid=$reciptianuuid['FaxRecipient']['uuid'];
                }else{
                  
                 return $return_array=array("state"=>"Error preparing the fax");

                }
                // +14109875496,+1410-969-8835,+18884732963,+14109698835
                // set the cover to template 1 and the text to some value
                //FaxJobApi::SetCover(1,'This is my test fax using the PamFax API');

                //FaxJobApi::AddFile("@" . $filepath); // for single
                // for multiple
                for($i=0;$i<count($filepath);$i++){
                FaxJobApi::AddFile($filepath[$i]);
                
                }
                
                // wait for the API to prepare the fax
                
                /* txtRequestedAt */
                $before_send_DateTime = date('Y-m-d H:i:s');
                $txtRequestedAt=$before_send_DateTime;

                $response_array=array();

                do {
                    
                    sleep(5);
                    $createResonse = FaxJobApi::GetFaxState();
                    $createResonse = json_decode($createResonse,TRUE);
                    array_push($response_array,$createResonse);
                    //echo "<pre>"; print_r($createResonse); 
                    if (($createResonse instanceof ApiError) // explicit error 
                            || !isset($createResonse['FaxContainer'])) // implicit error 
                        //die("Error preparing the fax"); 
                        return $return_array=array("state"=>"Error preparing the fax");
                }while ($createResonse['FaxContainer']['state']!= "ready_to_send"); //finally send it

             
                $sendResponse = FaxJobApi::Send();
                $sendResponse = json_decode($sendResponse,TRUE);

                 
                 /* txtCompletedAt */
                 $After_send_DateTime = date('Y-m-d H:i:s');
                 $txtCompletedAt=$After_send_DateTime;

                 /* txtStatus */
                 $txtStatus=$sendResponse['result']['code']; 

                 /* r_error_code */
                 $r_error_code=$sendResponse['result']['message'];
               
                 /* txtOrderNo */
                 // $current_array=current($response_array);
                 // $txtOrderNo=$current_array['FaxContainer']['uuid'];
                 $txtOrderNo=$reciptian_uuid;

                 /* txtCost */
                 $end_array=end($response_array);
                 $txtCost=$end_array['FaxContainer']['price'];

                 /* txtNoOfPage !! */
                 $txtNoOfPage=$end_array['FaxContainer']['pages'];

                 /* txtcurrency !! */
                 $txtCurrency=$end_array['FaxContainer']['currency'];

                 /* txtcurrency_rate !! */
                 $txtCurrency_rate=$end_array['FaxContainer']['currency_rate'];
                 
                 /* TotalDuration */
                 $date1=date_create($txtRequestedAt);
                 $date2=date_create($txtCompletedAt);
                 $diff=date_diff($date1,$date2);
                 $txtTotalDuration=$diff->format(" %i minutes %s seconds");
              
                 $return_array=array("txtRequestedAt"=>$txtRequestedAt,"txtCompletedAt"=>$txtCompletedAt,"txtStatus"=>$txtStatus,"r_error_code"=>$r_error_code,"txtOrderNo"=>$txtOrderNo,"txtCost"=>$txtCost,"txtNoOfPage"=>$txtNoOfPage,"txtCurrency"=>$txtCurrency,"txtCurrency_rate"=>$txtCurrency_rate,"txtTotalDuration"=>$txtTotalDuration,"send_response"=>$sendResponse);

                //echo "<pre>"; print_r($return_array); exit();
                 return $return_array;


             }

     
   } 

 public function pamfax_use_static(){ 

    foreach(glob(dirname(__FILE__)."/static/*") as $f) require_once($f); 
 }
 public function pamfax_use_instance(){

  foreach(glob(dirname(__FILE__)."/instance/*") as $f) require_once($f); 
}


 /* Returns the details of a fax in progress: */

 function getfaxdetails($uuid)
 {
 
          $result=$this->credential(); // call to credential funct.

          if (($result instanceof ApiError) // explicit error 
                    || !isset($result['UserToken']) || !isset($result['User'])) // implicit error 
                die("Unable to login");

          // set the global usertoken
          $GLOBALS['PAMFAX_API_USERTOKEN'] = $result['UserToken']['token'];
          // optionally remember the user for later use
          $currentUser = $result['User'];

          //Returns the details of a fax in progress.
         $GetFaxDetails=FaxHistoryApi::GetFaxDetails($uuid); 
         // echo "Returns the details of a fax in progress:-";
         // echo "<pre>"; print_r($GetFaxDetails);

         return $GetFaxDetails;
     
}

 

      /* list of All sent fax: */
 function list_sent_fax($uuid)
 {

    $this->pamfax_use_static();

    $ListSentFaxes=FaxhistoryApi::ListSentFaxes(); 

    return $ListSentFaxes;
     
 }

  /* Get PDF Report of sending fax: */
 function get_pdf_report($uuid)
 {
       
          $result=$this->credential(); // call to credential funct.

          if (($result instanceof ApiError) // explicit error 
                    || !isset($result['UserToken']) || !isset($result['User'])) // implicit error 
                die("Unable to login");

          // set the global usertoken
          $GLOBALS['PAMFAX_API_USERTOKEN'] = $result['UserToken']['token'];
          // optionally remember the user for later use
          $currentUser = $result['User'];

          //Returns the pdf a fax .
         $GetTransmissionReport = FaxhistoryApi::GetTransmissionReport($uuid);
         
          $filename=$uuid.".pdf";

          header("Content-type:application/pdf");
          header('Content-Disposition:attachment; filename="'.$filename.'"');
          print_r($GetTransmissionReport); exit();
          return $GetTransmissionReport;

 }

  function NumberInfo($number)
 {
    $result=$this->credential(); // call to credential funct.

    if (($result instanceof ApiError) // explicit error 
                    || !isset($result['UserToken']) || !isset($result['User'])) // implicit error 
                die("Unable to login");

    // set the global usertoken
    $GLOBALS['PAMFAX_API_USERTOKEN'] = $result['UserToken']['token'];
    // optionally remember the user for later use
    $currentUser = $result['User'];

    $this->pamfax_use_static();

    $NumberInfo = NumberInfoAPi::GetPagePrice($number);
    
     return $NumberInfo;

    // return $ListSentFaxes;
     
 }

 
}