<?php

if (!defined('BASEPATH'))    exit('No direct script access allowed');

require_once(APPPATH . 'third_party/sendgrid-php/vendor/autoload.php');
class MY_Controller extends CI_Controller {


    function __construct() {
        parent::__construct();

        date_default_timezone_set('Asia/Calcutta'); 

    }

    public function _sendMail($to_email,$subject,$body){
    $email_from      = 'vijaydadhichbbfitest1@gmail.com';
    $from_name       = 'Speedy Fax App';
    $to_name         = 'User';
    $message_body    = $body;
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom($email_from, $from_name);
    $email->setSubject($subject);
    $email->addTo($to_email, $to_name);
    $email->addContent(
        "text/html", $message_body
    );
    $sendgrid = new \SendGrid("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");
    try {
        $response = $sendgrid->send($email);
        return ($response->statusCode() == '202') ? true : false;
    } catch (Exception $e) {
         echo 'Caught exception: '. $e->getMessage() ."\n";
        return false;
}
    }
 
}