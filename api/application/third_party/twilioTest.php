<?php 
include_once 'config/config.php';
error_reporting(E_ALL);
error_reporting(1);
function configTwilio( $txtEID, $Message ){
    global $tblEmployee;
    require "../../twilio/Services/Twilio.php";
    /* Live */
    define("TWILIO_ACC_SID","AC9aa699f97d108662ee11d4fecf32aa23");
    define("TWILIO_AUTH_TOKEN","b7e6935b8fca8c99778c87438ecf2ed3");
    //define("COUNTRY_CODE","+91");

    $AccountSid = TWILIO_ACC_SID;
    $AuthToken = TWILIO_AUTH_TOKEN;

    $client = new Services_Twilio($AccountSid, $AuthToken);

    $fetchEmployee = $tblEmployee->findOne( array("txtEID"=> new MongoDB\BSON\ObjectID($txtEID)) );
    
    if( $fetchEmployee > 0){
        if( isset($fetchEmployee["txtCell"]) && $fetchEmployee["txtCell"] != "" ){    
            $txtCell = '+' . preg_replace('/\D/', '', $fetchEmployee["txtCell"]);  
            //echo $txtCell;die();

            $message = $client->account->messages->create(array(
			            "From" => "+12625814998",
			            "To" => "+9190383754",
			            "Body" => $Message,
			));              
        }
    }   

}

configTwilio( $_REQUEST["txtEID"], "This is testing");

?>