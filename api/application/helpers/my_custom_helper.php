<?php 
function DateFormat( $datetime ){
    $dateFormat = date( "m/d/Y", strtotime( $datetime ) );
    return $dateFormat;
}

function MysqliDateFormat( $datetime ){
    $dateFormat = date( "Y-m-d", strtotime( $datetime ) );
    return $dateFormat;
}

/* --------  TWILIO sms integration on failed fax or payment ------*/
function configTwilio( $admin_mobile_num=array(), $Message ){
   
   include APPPATH . 'third_party/twilio/Services/Twilio.php';
   /*note: use live credential & +14102165742 or test credential &  +15005550006
    /* JB for test */
    //define("TWILIO_ACC_SID","AC9aa699f97d108662ee11d4fecf32aa23");
    //define("TWILIO_AUTH_TOKEN","b7e6935b8fca8c99778c87438ecf2ed3");
     /* testing */
  // define("TWILIO_ACC_SID","ACa52d2d3aec211f0ac7d00868baac32bb");
  //  define("TWILIO_AUTH_TOKEN","0eeeaf22de40b957a34e14c38c38f146");
    /* Live */
   
   
   /*last Updated Auth token changed by Ishan */
    define("TWILIO_ACC_SID","ACe1750e49ffc2ad700c5ba17ea8296cf0");
    // define("TWILIO_AUTH_TOKEN","2ef466a50bfeb1b3b7d91519a082a354");
    define("TWILIO_AUTH_TOKEN","81bf3307a66113f5342f1e099dc404db");

    //define("COUNTRY_CODE","+91");
    

    $AccountSid = TWILIO_ACC_SID;
    $AuthToken = TWILIO_AUTH_TOKEN;

    $client = new Services_Twilio($AccountSid, $AuthToken);
   for($i=0;$i<count($admin_mobile_num);$i++)
   {
    $message = $client->account->messages->create(array(
             "From" => "+14102165742",   //put here number that is buy from twilio
             "To" => $admin_mobile_num[$i],
             "Body" => $Message,
         )); 
   }
  

}//end of function


/* --------  TWILIO sms integration on failed fax or payment ------*/
function configTwilioUser( $admin_mobile_num, $Message ){
   
   include APPPATH . 'third_party/twilio/Services/Twilio.php';
   /*note: use live credential & +14102165742 or test credential &  +15005550006
    /* JB for test */
    //define("TWILIO_ACC_SID","AC9aa699f97d108662ee11d4fecf32aa23");
    //define("TWILIO_AUTH_TOKEN","b7e6935b8fca8c99778c87438ecf2ed3");
     /* testing */
  // define("TWILIO_ACC_SID","ACa52d2d3aec211f0ac7d00868baac32bb");
  //  define("TWILIO_AUTH_TOKEN","0eeeaf22de40b957a34e14c38c38f146");
    /* Live */

       /*last Updated Auth token changed by Ishan */

    define("TWILIO_ACC_SID","ACe1750e49ffc2ad700c5ba17ea8296cf0");
    // define("TWILIO_AUTH_TOKEN","2ef466a50bfeb1b3b7d91519a082a354");
    define("TWILIO_AUTH_TOKEN","81bf3307a66113f5342f1e099dc404db");

    //define("COUNTRY_CODE","+91");
    

    $AccountSid = TWILIO_ACC_SID;
    $AuthToken = TWILIO_AUTH_TOKEN;

    $client = new Services_Twilio($AccountSid, $AuthToken);
//   for($i=0;$i<count($admin_mobile_num);$i++)
//   {
    $message = $client->account->messages->create(array(
             "From" => "+14102165742",   //put here number that is buy from twilio
             "To" => $admin_mobile_num,
             "Body" => $Message,
         )); 
//   }
  

}//end of function



?>
