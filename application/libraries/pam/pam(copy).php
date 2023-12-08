<?php


require_once(dirname(__FILE__)."/lib/ApiClient.php");
require_once(dirname(__FILE__)."/lib/apierror.class.php");
require_once(dirname(__FILE__)."/lib/apilist.class.php");
require_once(dirname(__FILE__)."/lib/errorcode.class.php");

class Pam
{
  

  public function sendFax($filepath=array(),$txtDeviceId,$r_number) {
       
      
         $GLOBALS['PAMFAX_API_URL'] = "https://api.pamfax.biz/"; //"https://api.pamfax.biz/";https://sandbox-api.pamfax.biz/
         $GLOBALS['PAMFAX_API_APPLICATION'] = "hussainarif";
         $GLOBALS['PAMFAX_API_SECRET_WORD'] = "fixkociwepucor8573";

           // $GLOBALS['PAMFAX_API_APPLICATION'] = "technostyacks";
           // $GLOBALS['PAMFAX_API_SECRET_WORD'] = "teradooxificotion3556";

            // tell the API client to create objects from returned XML automatically
            $GLOBALS['PAMFAX_API_MODE'] = \ApiClient::API_MODE_JSON;
            // tell the API client to use static wrapper classes

            $this->pamfax_use_static();


            // verify the PamFax user (this is the same as used on https://portal.pamfax.biz etc to login):
            $result = SessionApi::VerifyUser('hussain@technostacks.com','fixkociwepucor8573');
            //$result = SessionApi::VerifyUser('zaki@technostacks.com', 'teradooxificotion3556');
            $result = json_decode($result, TRUE);

            
             
            if (($result instanceof ApiError) // explicit error 
                    || !isset($result['UserToken']) || !isset($result['User'])) // implicit error 
                die("Unable to login");

            // set the global usertoken
            $GLOBALS['PAMFAX_API_USERTOKEN'] = $result['UserToken']['token'];
            // optionally remember the user for later use
            $currentUser = $result['User'];
          
           //echo "<pre>"; print_r($currentUser); exit();

            if ($currentUser == true) 
            {

                // create a new fax and give the users IP, UserAgent and an origin
                FaxJobApi::Create($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], 'API Samples');
                // add a recipient to the fax
                FaxJobApi::AddRecipient($r_number, 'TS testing'); // +14109875496,+1410-969-8835,+18884732963,+14109698835
                // set the cover to template 1 and the text to some value
                //FaxJobApi::SetCover(1,'This is my test fax using the PamFax API');

                //FaxJobApi::AddFile("@" . $filepath); // for single
                //echo "<pre>"; print_r($filepath); exit();
                for($i=0;$i<count($filepath);$i++){
                FaxJobApi::AddFile($filepath[$i]);
                
                }
                //FaxJobApi::AddFile($filepath);   // for multiple
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
                    echo "<pre>"; print_r($createResonse); 
                    if (($createResonse instanceof ApiError) // explicit error 
                            || !isset($createResonse['FaxContainer'])) // implicit error 
                        //die("Error preparing the fax"); 
                        return $return_array=array("state"=>"Error preparing the fax");
                }while ($createResonse['FaxContainer']['state']!= "ready_to_send"); //finally send it
                $sendResponse = FaxJobApi::Send();
                $sendResponse = json_decode($sendResponse,TRUE);

               echo "<pre>after send"; print_r($sendResponse);
               

                // $end_array=end($response_array);
                // $uuid=$end_array['FaxContainer']['uuid'];
         
         // Returns the details of a fax in progress.
        // $GetFaxDetails=FaxhistoryApi::GetFaxDetails($uuid); 
        // echo "Returns the details of a fax in progress:-";
        // echo "<pre>"; print_r($GetFaxDetails);

        //  exit;
                 
                 /* txtCompletedAt */
                 $After_send_DateTime = date('Y-m-d H:i:s');
                 $txtCompletedAt=$After_send_DateTime;

                 /* txtStatus */
                 $txtStatus=$sendResponse['result']['code']; 

                 /* r_error_code */
                 $r_error_code=$sendResponse['result']['message'];
               
                 /* txtOrderNo */
                 $current_array=current($response_array);
                 $txtOrderNo=$current_array['FaxContainer']['uuid'];

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
 
         $GLOBALS['PAMFAX_API_URL'] = "https://api.pamfax.biz/"; //"https://api.pamfax.biz/";https://sandbox-api.pamfax.biz/
         $GLOBALS['PAMFAX_API_APPLICATION'] = "hussainarif";
         $GLOBALS['PAMFAX_API_SECRET_WORD'] = "fixkociwepucor8573";

         // $GLOBALS['PAMFAX_API_APPLICATION'] = "technostyacks";
         // $GLOBALS['PAMFAX_API_SECRET_WORD'] = "teradooxificotion3556";

         // tell the API client to create objects from returned XML automatically
          $GLOBALS['PAMFAX_API_MODE'] = \ApiClient::API_MODE_JSON;
         // tell the API client to use static wrapper classes

          $this->pamfax_use_static();

          // verify the PamFax user (this is the same as used on https://portal.pamfax.biz etc to login):
          $result = SessionApi::VerifyUser('hussain@technostacks.com','fixkociwepucor8573');
          //$result = SessionApi::VerifyUser('zaki@technostacks.com', 'teradooxificotion3556');
          $result = json_decode($result, TRUE);

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
       
         $GLOBALS['PAMFAX_API_URL'] = "https://api.pamfax.biz/"; //"https://api.pamfax.biz/";https://sandbox-api.pamfax.biz/
         $GLOBALS['PAMFAX_API_APPLICATION'] = "hussainarif";
         $GLOBALS['PAMFAX_API_SECRET_WORD'] = "fixkociwepucor8573";

         // $GLOBALS['PAMFAX_API_APPLICATION'] = "technostyacks";
         // $GLOBALS['PAMFAX_API_SECRET_WORD'] = "teradooxificotion3556";

         // tell the API client to create objects from returned XML automatically
          $GLOBALS['PAMFAX_API_MODE'] = \ApiClient::API_MODE_JSON;
         // tell the API client to use static wrapper classes

          $this->pamfax_use_static();

          // verify the PamFax user (this is the same as used on https://portal.pamfax.biz etc to login):
          $result = SessionApi::VerifyUser('hussain@technostacks.com','fixkociwepucor8573');
          //$result = SessionApi::VerifyUser('zaki@technostacks.com', 'teradooxificotion3556');
          $result = json_decode($result, TRUE);

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

 
}